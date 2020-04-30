<?php

namespace Tests\Browser\Admin;

use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TagsTest extends DuskTestCase
{
    /** @test */
    public function testTagsIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'tags' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Tag List');
        });
    }

    /** @test */
    public function testTagsCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'tags/create' . $this->testId)
                ->waitFor('#tagForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#tagForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('title', $faker->sentence(6));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'tags');

        });
    }

    /** @test */
    public function testTagsUpdate()
    {
        $admin = User::find(1);
        $data = Tag::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'tags/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#tagForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$("#tagForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');

            $browser
                ->type('title', $faker->sentence(6));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'tags');

        });
    }

    /** @test */
    public function testTagsShow()
    {
        $admin = User::find(1);
        $data = Tag::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'tags/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Tags');
        });
    }

    /** @test */
    public function testTagsDelete()
    {
        $admin = User::find(1);
        $data = Tag::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'tags' . $this->testId . '&tid='.$data->id)
                ->waitFor('#tags'.$data->id)
                ->click('#tags'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Tag List');
        });
    }
}
