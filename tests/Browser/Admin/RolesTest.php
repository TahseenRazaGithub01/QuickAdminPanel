<?php

namespace Tests\Browser\Admin;

use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RolesTest extends DuskTestCase
{
    /** @test */
    public function testRolesIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'roles' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Role List');
        });
    }

    /** @test */
    public function testRolesCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'roles/create' . $this->testId)
                ->waitFor('#roleForm');

            $browser->script('$("#roleForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$(\'#permissions\').val($(\'#permissions option\').val()).trigger(\'change.select2\')');

            $browser->type('title', $faker->sentence(6));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'roles');

        });

    }

    /** @test */
    public function testRolesUpdate()
    {
        $admin = User::find(1);
        $data = Role::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'roles/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#roleForm');

            $browser->script('$("#roleForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$(\'#permissions\').val($(\'#permissions option\').val()).trigger(\'change.select2\')');

            $browser->type('title', $faker->sentence(6));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'roles');

        });

    }

    /** @test */
    public function testRolesShow()
    {
        $admin = User::find(1);
        $data = Role::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'roles/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Roles');
        });
    }

    /** @test */
    public function testRolesDelete()
    {
        $admin = User::find(1);
        $data = Role::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'roles' . $this->testId . '&rid='.$data->id)
                ->waitFor('#roles'.$data->id)
                ->click('#roles'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Role List');
        });
    }
}
