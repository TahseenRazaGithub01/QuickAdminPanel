<?php

namespace Tests\Browser\Admin;

use App\Store;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class StoresTest extends DuskTestCase
{
    /** @test */
    public function testStoreIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'stores' . $this->testId)
                ->pause(5999)
                ->assertSee('Store List');
        });
    }

    /** @test */
    public function testStoreCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'stores/create' . $this->testId)
                ->waitFor('#storesForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="faq" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('store_url', 'https://www.lipsum.com/')
                ->type('affiliate_url', 'https://www.lipsum2.com/')
                ->type('name', $faker->sentence(6))
                ->type('slug', $faker->slug)
                ->check('popular', 1)
                ->check('featured', 1)
                ->check('publish', 1)
                ->type('image', $filename)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100))
                ->type('html_tags', $faker->text(100))
                ->type('script_tags', $faker->text(100))
                ->type('sort', 1);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'stores');

        });
    }

    /** @test */
    public function testStoreUpdate()
    {
        $admin = User::find(1);
        $data = Store::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'stores/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#storesForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');
            $browser->script('$("#storesForm").append(\'<input type="text" name="faq" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#store_url', 'https://www.new_lipsum.com/')
                ->value('#affiliate_url', 'https://www.new_lipsum2.com/')
                ->value('#name', $faker->sentence(6))
                ->value('#slug', $faker->slug)
                ->check('popular', 1)
                ->check('featured', 1)
                ->check('publish', 1)
                ->value('#image', $filename)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100))
                ->value('#html_tags', $faker->text(100))
                ->value('#script_tags', $faker->text(100))
                ->value('#sort', 1);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'stores');

        });
    }

    /** @test */
    public function testStoreShow()
    {
        $admin = User::find(1);
        $data = Store::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'stores/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Stores');
        });
    }

    /** @test */
    public function testStoreDelete()
    {
        $admin = User::find(1);
        $data = Store::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'stores' . $this->testId . '&stid='.$data->id)
                ->waitFor('#stores'.$data->id)
                ->click('#stores'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Store List');
        });
    }
}
