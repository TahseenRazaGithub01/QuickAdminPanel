<?php

namespace Tests\Browser\Admin;

use App\Permission;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PermissionsTest extends DuskTestCase
{
    /** @test */
    public function testPermissionsIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'permissions' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Permission List');
        });
    }

    /** @test */
    public function testPermissionsCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'permissions/create' . $this->testId)
                ->waitFor('#permissionForm');

            $browser->script('$("#permissionForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser->type('title', $faker->sentence(6));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'permissions');

        });

    }

    /** @test */
    public function testPermissionsUpdate()
    {
        $admin = User::find(1);
        $data = Permission::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'permissions/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#permissionForm');

            $browser->script('$("#permissionForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser->type('title', $faker->sentence(6));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'permissions');

        });

    }

    /** @test */
    public function testPermissionsShow()
    {
        $admin = \App\User::find(1);
        $data = Permission::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'permissions/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Permissions');
        });
    }

    /** @test */
    public function testPermissionsDelete()
    {
        $admin = \App\User::find(1);
        $data = Permission::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'permissions' . $this->testId . '&pid='.$data->id)
                ->waitFor('#permissions'.$data->id)
                ->click('#permissions'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Permission List');
        });
    }
}
