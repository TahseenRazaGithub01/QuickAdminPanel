<?php

namespace Tests\Browser\Admin;

use App\Press;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PressTest extends DuskTestCase
{
    /** @test */
    public function testPressIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'presses' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Press List');
        });
    }

    /** @test */
    public function testPressCreate()
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
                ->visit($this->adminPrefix . 'presses/create' . $this->testId)
                ->waitFor('#pressForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="related_links" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('image', $filename)
                ->type('slug', $faker->slug)
                ->type('sort', 1)
                ->check('featured', 1)
                ->check('publish', 1)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'presses');

        });
    }

    /** @test */
    public function testPressUpdate()
    {
        $admin = User::find(1);
        $data = Press::orderBy('id', 'DESC')->first();

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
                ->visit($this->adminPrefix . 'presses/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#pressForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');
            $browser->script('$("#pressForm").append(\'<input type="text" name="related_links" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#image', $filename)
                ->value('#slug', $faker->slug)
                ->value('#sort', 1)
                ->check('featured', 1)
                ->check('publish', 1)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'presses');

        });
    }

    /** @test */
    public function testPressShow()
    {
        $admin = User::find(1);
        $data = Press::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'presses/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Press');
        });
    }

    /** @test */
    public function testPressDelete()
    {
        $admin = User::find(1);
        $data = Press::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'presses' . $this->testId . '&pid='.$data->id)
                ->waitFor('#presses'.$data->id)
                ->click('#presses'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Press List');
        });
    }

}
