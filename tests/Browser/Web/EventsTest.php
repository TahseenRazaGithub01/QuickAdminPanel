<?php

namespace Tests\Browser\Web;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EventsTest extends DuskTestCase
{
    /**
     * A Dusk test Black Friday.
     *
     * @return void
     */
    public function testBlackFriday()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/black-friday')
                ->assertSee('Black Friday');
        });
    }

    /**
     * A Dusk test Cyber Monday.
     *
     * @return void
     */
    public function testCyberMonday()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/event/cyber-monday')
                ->assertSee('Cyber Monday');
        });
    }

}
