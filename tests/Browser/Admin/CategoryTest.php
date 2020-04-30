<?php

namespace Tests\Browser\Admin;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    /** @test */
    public function testCategoryIndex()
    {
        $admin = $this->user;

        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'categories' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Category List');
        });
    }

    /** @test */
    public function testCategoryCreate()
    {
        $admin = $this->user;

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imagePath3);
            $info2 = pathinfo($url2);
            $contents2 = file_get_contents($url2);
            $filename2 = uniqid() . '_' . trim($info2['basename']);
            $file2 = storage_path('tmp/uploads/' . $filename2);
            file_put_contents($file2, $contents2);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'categories/create' . $this->testId)
                ->waitFor('#categoryForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="icon" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('slug', $faker->slug)
                ->type('sort', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->type('image', $filename)
                ->type('icon', $filename2)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'categories');

        });
    }

    /** @test */
    public function testCategoryUpdate()
    {
        $admin = $this->user;
        $category = Category::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $category) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imagePath3);
            $info2 = pathinfo($url2);
            $contents2 = file_get_contents($url2);
            $filename2 = uniqid() . '_' . trim($info2['basename']);
            $file2 = storage_path('tmp/uploads/' . $filename2);
            file_put_contents($file2, $contents2);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'categories/'.$category->id.'/edit' . $this->testId)
                ->waitFor('#categoryForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="icon" id="icon" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#categoryForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#slug', $faker->slug)
                ->value('#sort', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->value('#image', $filename)
                ->value('#icon', $filename2)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'categories');

        });
    }

    /** @test */
    public function testCategoryShow()
    {
        $admin = $this->user;
        $category = Category::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $category) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'categories/' . $category->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Category');
        });
    }

    /** @test */
    public function testCategoryDelete()
    {
        $admin = $this->user;
        $data = Category::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'categories' . $this->testId . '&cid='.$data->id)
                ->waitFor('#categories'.$data->id)
                ->press('#categories'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Category List');
        });
    }
}
