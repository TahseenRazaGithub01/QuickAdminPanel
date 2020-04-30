<?php

namespace Tests\Browser\Web;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExtraTest extends DuskTestCase
{
    /**
     * A Dusk test Subscriber.
     *
     * @return void
     */
    public function testSubscriber()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us')
                    ->waitFor('#subBox')
                    ->type('subBoxEmail', $this->faker->email)
                    ->press('Subscribe')
                    ->assertSee('Top Stores');
        });
    }

    /**
     * A Dusk test Contact Us.
     *
     * @return void
     */
    public function testContactUs()
    {
        $this->browse(function (Browser $browser) {
            $faker = $this->faker;
            $browser->visit('/us/contact_us')
                    ->waitFor('#contactBox')
                    ->type('name', $faker->name)
                    ->type('email', $faker->email)
                    ->type('contact', $faker->phoneNumber )
                    ->type('subject', $faker->sentence(6))
                    ->type('message', $faker->sentence(20))
                    ->press('Send Message')
                    ->assertSee('Contact Us');
        });
    }
}
