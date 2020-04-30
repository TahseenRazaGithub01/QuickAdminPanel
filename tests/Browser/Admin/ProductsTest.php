<?php

namespace Tests\Browser\Admin;

use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductsTest extends DuskTestCase
{
    /** @test */
    public function testProductIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'products' . $this->testId)
                ->pause(5999)
                ->assertSee('Product List');
        });
    }

    /** @test */
    public function testProductCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $url = url($this->imagePath);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imagePath);
            $info2 = pathinfo($url2);
            $contents2 = file_get_contents($url2);
            $filename2 = uniqid() . '_' . trim($info2['basename']);
            $file2 = storage_path('tmp/uploads/' . $filename2);
            file_put_contents($file2, $contents2);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'products/create' . $this->testId)
                ->waitFor('#productForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#product_categories\').val($(\'#product_categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="additional_image" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $price = $faker->randomNumber(3);

            $browser
                ->type('title', $faker->sentence(6))
                ->type('rating', 9)
                ->type('affiliate_url', $faker->url)
                ->type('price', $faker->url)
                ->type('date', Carbon::now()->addDays(3)->format('Y-m-d'))
                ->type('price', $price)
                ->type('discount_price', $price / 10)
                ->type('discount_percent', 10)
                ->type('sort', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->type('image', $filename)
                ->type('additional_image', $filename2);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'products');

        });
    }

    /** @test */
    public function testProductUpdate()
    {
        $admin = User::find(1);
        $data = Product::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $url = url($this->imagePath);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imagePath);
            $info2 = pathinfo($url2);
            $contents2 = file_get_contents($url2);
            $filename2 = uniqid() . '_' . trim($info2['basename']);
            $file2 = storage_path('tmp/uploads/' . $filename2);
            file_put_contents($file2, $contents2);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'products/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#productForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#product_categories\').val($(\'#product_categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="additional_image" id="additional_image" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#productForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $price = $faker->randomNumber(3);

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#rating', 9)
                ->value('#affiliate_url', $faker->url)
                ->value('#price', $faker->url)
                ->value('#date', Carbon::now()->addDays(3)->format('Y-m-d'))
                ->value('#price', $price)
                ->value('#discount_price', $price / 10)
                ->value('#discount_percent', 10)
                ->value('#sort', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->value('#image', $filename)
                ->value('#additional_image', $filename2);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'products');

        });
    }

    /** @test */
    public function testProductShow()
    {
        $admin = User::find(1);
        $data = Product::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'products/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Products');
        });
    }

    /** @test */
    public function testProductDelete()
    {
        $admin = User::find(1);
        $data = Product::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'products' . $this->testId . '&pid='.$data->id)
                ->waitFor('#products'.$data->id)
                ->click('#products'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Product List');
        });
    }
}
