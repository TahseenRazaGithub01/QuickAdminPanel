<?php

namespace Tests\Browser\Admin;

use App\ProductCategory;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductCategoryTest extends DuskTestCase
{
    /** @test */
    public function testProductCategoryIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'product-categories' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Product Category List');
        });
    }

    /** @test */
    public function testProductCategoryCreate()
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

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'product-categories/create' . $this->testId)
                ->waitFor('#productCategoryForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="about_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('name', $faker->sentence(6))
                ->type('title_heading', $faker->sentence(6))
                ->type('sub_heading', $faker->sentence(6))
                ->type('sort', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->type('image', $filename)
                ->type('old_url', $faker->url)
                ->type('new_url', $faker->url)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'product-categories');

        });
    }

    /** @test */
    public function testProductCategoryUpdate()
    {
        $admin = User::find(1);
        $data = ProductCategory::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;
            $url = url($this->imagePath);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'product-categories/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#productCategoryForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');
            $browser->script('$("#productCategoryForm").append(\'<input type="text" name="about_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#name', $faker->sentence(6))
                ->value('#title_heading', $faker->sentence(6))
                ->value('#sub_heading', $faker->sentence(6))
                ->value('#sort', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->value('#image', $filename)
                ->value('#old_url', $faker->url)
                ->value('#new_url', $faker->url)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'product-categories');

        });
    }

    /** @test */
    public function testProductCategoryShow()
    {
        $admin = User::find(1);
        $data = ProductCategory::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'product-categories/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Product Category');
        });
    }

    /** @test */
    public function testProductCategoryDelete()
    {
        $admin = User::find(1);
        $data = ProductCategory::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'product-categories' . $this->testId . '&pcid='.$data->id)
                ->waitFor('#product-categories'.$data->id)
                ->click('#product-categories'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Product Category List');
        });
    }
}
