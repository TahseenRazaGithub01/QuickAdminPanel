<?php

namespace Tests\Browser\Admin;

use App\Page;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PagesTest extends DuskTestCase
{
    /** @test */
    public function testPagesIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'pages' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Page List');
        });
    }

    /** @test */
    public function testPagesCreate()
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

            $url3 = url($this->imagePath);
            $info3 = pathinfo($url3);
            $contents3 = file_get_contents($url3);
            $filename3 = uniqid() . '_' . trim($info3['basename']);
            $file3 = storage_path('tmp/uploads/' . $filename3);
            file_put_contents($file3, $contents3);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'pages/create' . $this->testId)
                ->waitFor('#pageForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="banner_image" id="banner_image" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="additional_image" id="additional_image" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('slug', $faker->slug)
                ->check('publish', 1)
                ->check('top', 1)
                ->check('bottom', 1)
                ->type('banner_image', $filename)
                ->type('image', $filename2)
                ->type('additional_image', $filename3)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'pages');

        });
    }

    /** @test */
    public function testPagesUpdate()
    {
        $admin = User::find(1);
        $data = Page::orderBy('id', 'DESC')->first();

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

            $url3 = url($this->imagePath);
            $info3 = pathinfo($url3);
            $contents3 = file_get_contents($url3);
            $filename3 = uniqid() . '_' . trim($info3['basename']);
            $file3 = storage_path('tmp/uploads/' . $filename3);
            file_put_contents($file3, $contents3);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'pages/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#pageForm');

            $browser->script('$("#pageForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="banner_image" id="banner_image" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="additional_image" id="additional_image" />\')');
            $browser->script('$("#pageForm").append(\'<input type="text" name="description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#slug', $faker->slug)
                ->check('publish', 1)
                ->check('top', 1)
                ->check('bottom', 1)
                ->value('#banner_image', $filename)
                ->value('#image', $filename2)
                ->value('#additional_image', $filename3)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'pages');

        });
    }

    /** @test */
    public function testPagesShow()
    {
        $admin = User::find(1);
        $data = Page::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'pages/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Pages');
        });
    }

    /** @test */
    public function testPagesDelete()
    {
        $admin = User::find(1);
        $data = Page::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'pages' . $this->testId . '&pid='.$data->id)
                ->waitFor('#pages'.$data->id)
                ->click('#pages'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Page List');
        });
    }
}
