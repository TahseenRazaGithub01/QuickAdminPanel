<?php

namespace Tests\Browser\Admin;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UsersTest extends DuskTestCase
{
    /** @test */
    public function testUsersIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'users' . $this->testId)
                ->pause($this->timer)
                ->assertSee('User List');
        });
    }

    /** @test */
    public function testUsersCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $url = url($this->imagePath);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'users/create' . $this->testId)
                ->waitFor('#userForm');

            $browser->script('$(\'#roles\').val($(\'#roles option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#userForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#userForm").append(\'<input type="text" id="image" name="image" />\')');
            $browser->script('$("#userForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');

            $browser
                ->type('name', $faker->sentence(6))
                ->type('email', $faker->email)
                ->type('password', str_random(10))
                ->value('#image', $filename);

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'users');

        });

    }

    /** @test */
    public function testUsersUpdate()
    {
        $admin = User::find(1);
        $data = User::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $url = url($this->imagePath);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'users/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#userForm');

            $browser->script('$(\'#roles\').val($(\'#roles option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#userForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#userForm").append(\'<input type="text" id="image" name="image" />\')');
            $browser->script('$("#userForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');

            $browser
                ->type('name', $faker->sentence(6))
                ->type('email', $faker->email)
                ->type('password', str_random(10))
                ->value('#image', $filename);

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'users');

        });

    }

    /** @test */
    public function testUsersShow()
    {
        $admin = User::find(1);
        $data = User::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'users/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Users');
        });
    }

    /** @test */
    public function testUsersDelete()
    {
        $admin = User::find(1);
        $data = User::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'users' . $this->testId . '&uid='.$data->id)
                ->waitFor('#users'.$data->id)
                ->click('#users'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('User List');
        });
    }
}
