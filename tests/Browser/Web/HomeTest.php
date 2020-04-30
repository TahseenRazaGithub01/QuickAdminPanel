<?php


namespace Tests\Browser\Web;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeTest extends DuskTestCase
{
    /**
     * A Dusk test Index.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('home'));
            $browser->assertRouteIs('home');
        });
    }
}
