<?php

namespace Tests\Browser\Web;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SitemapTest extends DuskTestCase
{
    /**
     * A Dusk test Sitemap Index.
     *
     * @return void
     */
    public function testSitemapIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/sitemap')
                    ->assertSee('Browse Coupons by Store');
        });
    }
}
