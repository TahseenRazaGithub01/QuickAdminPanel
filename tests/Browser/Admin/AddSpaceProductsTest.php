<?php

namespace Tests\Browser\Admin;

use App\AddSpaceProduct;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddSpaceProductsTest extends DuskTestCase
{
    /** @test */
    public function testSpaceProductsIndex()
    {
        $admin = $this->user;
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'add-space-products' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Add Space for Product List');
        });
    }

    /** @test */
    public function testSpaceProductsCreate()
    {
        $admin = $this->user;

        $this->browse(function (Browser $browser) use($admin) {

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'add-space-products/create' . $this->testId)
                ->waitFor('#spaceForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#products\').val($(\'#products option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#spaceForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('horizontal_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>')
                ->type('vertical_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>');

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'add-space-products');

        });
    }

    /** @test */
    public function testSpaceProductsUpdate()
    {
        $admin = $this->user;
        $data = AddSpaceProduct::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'add-space-products/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#spaceForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#products\').val($(\'#products option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#spaceForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('horizontal_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap2/4.4.1/js/bootstrap.min.js"></script>')
                ->type('vertical_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap2/4.4.1/js/bootstrap.min.js"></script>');

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'add-space-products');

        });
    }

    /** @test */
    public function testSpaceProductsShow()
    {
        $admin = $this->user;
        $data = AddSpaceProduct::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'add-space-products/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Add Space for Products');
        });
    }

    /** @test */
    public function testSpaceProductsDelete()
    {
        $admin = $this->user;
        $data = AddSpaceProduct::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'add-space-products' . $this->testId . '&aid='.$data->id)
                ->waitFor('#add-space-products'.$data->id)
                ->click('#add-space-products'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Add Space for Product List');
        });
    }
}
