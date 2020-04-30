<?php

namespace Tests\Browser\Admin;

use App\Coupon;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CouponsTest extends DuskTestCase
{
    /** @test */
    public function testCouponsIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'coupons' . $this->testId)
                ->pause(5999)
                ->assertSee('Coupon List');
        });
    }

    /** @test */
    public function testCouponsCreate()
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
                ->visit($this->adminPrefix . 'coupons/create' . $this->testId)
                ->waitFor('#couponsForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#storeId").html("")');
            $browser->script('$("#storeId").append(\'<input type="text" name="store_id" value="1" />\')');
            $browser->script('$("#couponsForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#couponsForm").append(\'<input type="text" name="image" />\')');
            $browser->script('$("#couponsForm").append(\'<input type="text" name="description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('custom_image_title', $faker->sentence(6))
                ->type('affiliate_url', 'https://www.lipsum.com/')
                ->type('code', $faker->randomNumber(6))
                ->type('sort', 1)
                ->type('date_available', Carbon::now()->format('Y-m-d'))
                ->type('date_expiry', Carbon::now()->addDays(3)->format('Y-m-d'))
                ->check('verified', 1)
                ->check('exclusive', 1)
                ->check('featured', 1)
                ->check('recommended', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->check('free_shipping', 1)
                ->type('special_event_sort', 1)
                ->type('image', $filename);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'coupons');

        });
    }

    /** @test */
    public function testCouponsUpdate()
    {
        $admin = User::find(1);
        $coupon = Coupon::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $coupon) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'coupons/' . $coupon->id . '/edit' . $this->testId)
                ->waitFor('#couponsForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#couponsForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#storeId").append(\'<input type="text" name="store_id" value="1" />\')');
            $browser->script('$("#couponsForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#couponsForm").append(\'<input type="text" name="description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#custom_image_title', $faker->sentence(6))
                ->value('#affiliate_url', 'https://www.lipsum.com/')
                ->value('#code', $faker->randomNumber(6))
                ->value('#sort', 1)
                ->value('#date_available', Carbon::now()->format('Y-m-d'))
                ->value('#date_expiry', Carbon::now()->addDays(3)->format('Y-m-d'))
                ->check('verified', 1)
                ->check('exclusive', 1)
                ->check('featured', 1)
                ->check('recommended', 1)
                ->check('popular', 1)
                ->check('publish', 1)
                ->check('free_shipping', 1)
                ->value('#special_event_sort', 1)
                ->value('#image', $filename);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'coupons');

        });
    }

    /** @test */
    public function testCouponsShow()
    {
        $admin = User::find(1);
        $data = Coupon::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'coupons/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Coupons');
        });
    }

    /** @test */
    public function testCouponsDelete()
    {
        $admin = User::find(1);
        $data = Coupon::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'coupons' . $this->testId . '&cid='.$data->id)
                ->waitFor('#coupons'.$data->id)
                ->click('#coupons'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Coupon List');
        });
    }
}
