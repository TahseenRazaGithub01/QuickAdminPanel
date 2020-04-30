<?php

namespace Tests\Browser\Admin;

use App\AddSpaceProduct;
use App\AddspaceStore;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AddspaceStoresTest extends DuskTestCase
{
    /** @test */
    public function testSpaceStoresIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'addspace-stores' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Addspace for Store List');
        });
    }

    /** @test */
    public function testSpaceStoresCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'addspace-stores/create' . $this->testId)
                ->waitFor('#spaceForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#stores\').val($(\'#stores option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#spaceForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('horizontal_add_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>')
                ->type('vertical_add_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>');

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'addspace-stores');

        });
    }

    /** @test */
    public function testSpaceStoresUpdate()
    {
        $admin = User::find(1);
        $data = AddspaceStore::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'addspace-stores/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#spaceForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#stores\').val($(\'#stores option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#spaceForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('horizontal_add_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap2/4.4.1/js/bootstrap.min.js"></script>')
                ->type('vertical_add_script', '<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap2/4.4.1/js/bootstrap.min.js"></script>');

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'addspace-stores');

        });
    }

    /** @test */
    public function testSpaceStoresShow()
    {
        $admin = User::find(1);
        $data = AddspaceStore::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'addspace-stores/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Addspace for Stores');
        });
    }

    /** @test */
    public function testSpaceStoresDelete()
    {
        $admin = User::find(1);
        $data = AddspaceStore::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'addspace-stores' . $this->testId . '&aid='.$data->id)
                ->waitFor('#addspace-stores'.$data->id)
                ->click('#addspace-stores'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Addspace for Store List');
        });
    }
}
