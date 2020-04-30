<?php

namespace Tests\Browser\Web;

use App\Store;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoriesTest extends DuskTestCase
{
    /**
     * A Dusk test Index.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/category')
                    ->assertSee('BROWSE BY POPULAR CATEGORIES');
        });
    }

    /**
     * A Dusk test Stores.
     *
     * @return void
     */
    public function testViewCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/categories/electronics')
                ->assertSee('About Electronics');
        });
    }

    /**
     * A Dusk test Stores.
     *
     * @return void
     */
    public function testStores()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/categories/clothing-and-accessories')
                ->assertSee('About Clothing');
        });
    }

    /**
     * A Dusk test View Stores.
     *
     * @return void
     */
    public function testViewStores()
    {
        $data = Store::CustomWhereBasedData(1)->get();

        if(COUNT($data)) {
            $data = $data->random(1)->first();
        } else {
            $data = [];
        }
        $this->browse(function (Browser $browser) use($data) {
            if(isset($data->slugs)) {
                $browser->visit('/us/'.$data->slugs->slug)
                    ->assertSee($data->name);
            }
        });

    }
}
