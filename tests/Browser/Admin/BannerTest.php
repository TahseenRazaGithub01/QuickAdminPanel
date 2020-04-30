<?php

namespace Tests\Browser\Admin;

use App\Banner;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BannerTest extends DuskTestCase
{
    /** @test */
    public function testBannerIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'banners' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Banner List');
        });
    }

    /** @test */
    public function testBannerCreate()
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

            $url3 = url($this->imagePath3);
            $info3 = pathinfo($url3);
            $contents3 = file_get_contents($url3);
            $filename3 = uniqid() . '_' . trim($info3['basename']);
            $file3 = storage_path('tmp/uploads/' . $filename3);
            file_put_contents($file3, $contents3);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'banners/create' . $this->testId)
                ->waitFor('#bannerForm');

            $browser->script('$("#bannerForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="store_image" />\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="mobile_image" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('link', $faker->url)
                ->type('sort', 1)
                ->type('image', $filename)
                ->type('store_image', $filename2)
                ->type('mobile_image', $filename3);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'banners');

        });
    }

    /** @test */
    public function testBannerUpdate()
    {
        $admin = User::find(1);
        $data = Banner::orderBy('id', 'DESC')->first();

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

            $url3 = url($this->imagePath3);
            $info3 = pathinfo($url3);
            $contents3 = file_get_contents($url3);
            $filename3 = uniqid() . '_' . trim($info3['basename']);
            $file3 = storage_path('tmp/uploads/' . $filename3);
            file_put_contents($file3, $contents3);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'banners/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#bannerForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="store_image" id="store_image" />\')');
            $browser->script('$("#bannerForm").append(\'<input type="text" name="mobile_image" id="mobile_image" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#link', $faker->url)
                ->value('#sort', 1)
                ->value('#image', $filename)
                ->value('#store_image', $filename2)
                ->value('#mobile_image', $filename3);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'banners');

        });
    }

    /** @test */
    public function testBannerShow()
    {
        $admin = User::find(1);
        $data = Banner::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'banners/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Banner');
        });
    }

    /** @test */
    public function testBannerDelete()
    {
        $admin = User::find(1);
        $data = Banner::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'banners' . $this->testId . '&bid='.$data->id)
                ->waitFor('#banners'.$data->id)
                ->click('#banners'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Banner List');
        });
    }
}
