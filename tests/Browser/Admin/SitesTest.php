<?php

namespace Tests\Browser\Admin;

use App\Site;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SitesTest extends DuskTestCase
{
    /** @test */
    public function testSitesIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'sites' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Site List');
        });
    }

    /** @test */
    public function testSitesCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $url = url($this->imagePath4);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imageLogo);
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
                ->visit($this->adminPrefix . 'sites/create' . $this->testId)
                ->waitFor('#siteSubmit');

            $browser->script('$("#langCode").html("")');
            $browser->script('$("#langCode").append(\'<input type="text" name="language_code" id="language_code" value="uk" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="flag" id="flag" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="logo" id="logo" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="favicon" id="favicon" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('name', 'Ukrainian')
                ->type('country_name', 'Ukrainian')
                ->type('country_code', 'UK')
                ->type('url', url('/uk'))
                ->check('publish', 1)
                ->type('flag', $filename)
                ->type('logo', $filename2)
                ->type('favicon', $filename3)
                ->type('html_tags', '<script src="https://cdnjs.cloudflare.com/ajax/libs/BigVideo.js/1.1.5/lib/bigvideo.min.js"></script>')
                ->type('javascript_tags', '<script src="https://cdnjs.cloudflare.com/ajax/libs/BigVideo.js/1.1.5/lib/bigvideo.min.js"></script>')
                ->type('twitter', 'https://www.lipsum.com/')
                ->type('linked_in', 'https://www.lipsum.com/')
                ->type('facebook', 'https://www.lipsum.com/')
                ->type('youtube', 'https://www.lipsum.com/')
                ->type('instagram', 'https://www.lipsum.com/')
                ->type('pinterest', 'https://www.lipsum.com/');

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'sites');

        });
    }

    /** @test */
    public function testSitesUpdate()
    {
        $admin = User::find(1);
        $data = Site::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $url = url($this->imagePath4);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imageLogo);
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
                ->visit($this->adminPrefix . 'sites/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#siteSubmit');

            $browser->script('$("#langCode").html("")');
            $browser->script('$("#langCode").append(\'<input type="text" name="language_code" id="language_code" value="uk" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="flag" id="flag" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="logo" id="logo" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="favicon" id="favicon" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#siteSubmit").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#name', 'Ukrainian')
                ->value('#country_name', 'Ukrainian')
                ->value('#country_code', 'UK')
                ->value('#url', url('/uk'))
                ->check('publish', 1)
                ->value('#flag', $filename)
                ->value('#logo', $filename2)
                ->value('#favicon', $filename3)
                ->value('#html_tags', '<script src="https://cdnjs.cloudflare.com/ajax/libs/BigVideo.js/1.1.5/lib/bigvideo.min.js"></script>')
                ->value('#javascript_tags', '<script src="https://cdnjs.cloudflare.com/ajax/libs/BigVideo.js/1.1.5/lib/bigvideo.min.js"></script>')
                ->value('#twitter', 'https://www.lipsum2.com/')
                ->value('#linked_in', 'https://www.lipsum2.com/')
                ->value('#facebook', 'https://www.lipsum2.com/')
                ->value('#youtube', 'https://www.lipsum2.com/')
                ->value('#instagram', 'https://www.lipsum2.com/')
                ->value('#pinterest', 'https://www.lipsum2.com/');

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'sites');

        });
    }

    /** @test */
    public function testSiteShow()
    {
        $admin = User::find(1);
        $data = Site::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'sites/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Sites');
        });
    }

    /** @test */
    public function testSiteDelete()
    {
        $admin = User::find(1);
        $data = Site::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'sites' . $this->testId . '&sit_id='.$data->id)
                ->waitFor('#sites'.$data->id)
                ->click('#sites'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Site List');
        });
    }
}
