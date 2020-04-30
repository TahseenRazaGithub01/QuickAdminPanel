<?php

namespace Tests\Browser\Admin;

use App\Network;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NetworkTest extends DuskTestCase
{
    /** @test */
    public function testNetworkIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'networks' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Network List');
        });
    }

    /** @test */
    public function testNetworkCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'networks/create' . $this->testId)
                ->waitFor('#networkForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#networkForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('name', $faker->sentence(6))
                ->type('api_key', str_random(15))
                ->type('secret_key', str_random(15))
                ->type('affiliate', $faker->randomNumber(3))
                ->check('publish', 1);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'networks');

        });
    }

    /** @test */
    public function testNetworkUpdate()
    {
        $admin = User::find(1);
        $data = Network::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'networks/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#networkForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#networkForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('name', $faker->sentence(6))
                ->type('api_key', str_random(15))
                ->type('secret_key', str_random(15))
                ->type('affiliate', $faker->randomNumber(3))
                ->check('publish', 1);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'networks');

        });
    }

    /** @test */
    public function testNetworkShow()
    {
        $admin = User::find(1);
        $data = Network::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'networks/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Network');
        });
    }

    /** @test */
    public function testNetworkDelete()
    {
        $admin = User::find(1);
        $data = Network::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'networks' . $this->testId . '&nid='.$data->id)
                ->waitFor('#networks'.$data->id)
                ->click('#networks'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Network List');
        });
    }
}
