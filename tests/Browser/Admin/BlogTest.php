<?php

namespace Tests\Browser\Admin;

use App\Blog;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BlogTest extends DuskTestCase
{
    /** @test */
    public function testBlogIndex()
    {
        $admin = $this->user;

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'blogs' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Blog List');
        });
    }

    /** @test */
    public function testBlogCreate()
    {
        $admin = $this->user;

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
                ->visit($this->adminPrefix . 'blogs/create' . $this->testId)
                ->waitFor('#blogForm');

            $browser->script('$("#blogForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$(\'#tags\').val($(\'#tags option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="banner_image" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('slug', $faker->slug)
                ->check('publish', 1)
                ->type('image', $filename)
                ->type('banner_image', $filename2)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100))
                ->type('sort', 1);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'blogs');

        });
    }

    /** @test */
    public function testBlogUpdate()
    {
        $admin = $this->user;
        $data = Blog::orderBy('id', 'DESC')->first();

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
                ->visit($this->adminPrefix . 'blogs/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#blogForm');

            $browser->script('$(\'#tags\').val($(\'#tags option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#blogForm").append(\'<input type="text" id="image" name="image" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" id="banner_image" name="banner_image" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#blogForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#slug', $faker->slug)
                ->check('publish', 1)
                ->value('#image', $filename)
                ->value('#banner_image', $filename2)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100))
                ->value('#sort', 1);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'blogs');

        });
    }

    /** @test */
    public function testBlogShow()
    {
        $admin = $this->user;
        $data = Blog::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'blogs/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Blog');
        });
    }

    /** @test */
    public function testBlogDelete()
    {
        $admin = $this->user;
        $data = Blog::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'blogs' . $this->testId . '&bid='.$data->id)
                ->waitFor('#blogs'.$data->id)
                ->click('#blogs'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Blog List');

        });
    }
}
