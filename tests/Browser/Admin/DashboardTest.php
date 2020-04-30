<?php

namespace Tests\Browser\Admin;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DashboardTest extends DuskTestCase
{
    /**
     * A Dusk test Dashboard.
     *
     * @return void
     */
    public function testDashboardIndex()
    {
        $admin = \App\User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin);
            $browser->visit('/admin');
            $browser->assertPathIs('/admin');
        });
    }

    /**
     * A Dusk test Dashboard Set ID.
     *
     * @return void
     */
    public function testDashboardSetSiteId()
    {
        $admin = \App\User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin);
            $browser->visit('/admin?id=1');
            $browser->assertPathIs('/admin');
        });
    }
}
