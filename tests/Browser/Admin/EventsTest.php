<?php

namespace Tests\Browser\Admin;

use App\Event;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EventsTest extends DuskTestCase
{
    /** @test */
    public function testEventIndex()
    {
        $admin = User::find(1);
        $this->browse(function (Browser $browser) use ($admin) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'events' . $this->testId)
                ->pause($this->timer)
                ->assertSee('Event List');
        });
    }

    /** @test */
    public function testEventCreate()
    {
        $admin = User::find(1);

        $this->browse(function (Browser $browser) use($admin) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imagePath2);
            $info2 = pathinfo($url2);
            $contents2 = file_get_contents($url2);
            $filename2 = uniqid() . '_' . trim($info2['basename']);
            $file2 = storage_path('tmp/uploads/' . $filename2);
            file_put_contents($file2, $contents2);

            $url3 = url($this->imagePath3);
            $info3 = pathinfo($url3);
            $contents3 = file_get_contents($url3);
            $filename3 = uniqid() . '_' . trim($info3['basename']);
            $file3 = storage_path('tmp/uploads/' . $filename3);
            file_put_contents($file3, $contents3);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'events/create' . $this->testId)
                ->waitFor('#eventForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#stores\').val($(\'#stores option\').val() + 1).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val() + 1).trigger(\'change.select2\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="banner" id="banner" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="menu_icon" id="menu_icon" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->type('title', $faker->sentence(6))
                ->type('slug', $faker->slug)
                ->check('publish', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('top', 1)
                ->check('bottom', 1)
                ->type('image', $filename)
                ->type('meta_title', $faker->name)
                ->type('meta_keywords', $faker->sentence(6))
                ->type('meta_description', $faker->text(100))
                ->type('date', Carbon::now()->addDays(3)->format('Y-m-d'));

            $browser->press($this->saveBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'events');

        });
    }

    /** @test */
    public function testEventsUpdate()
    {
        $admin = User::find(1);
        $data = Event::orderBy('id', 'DESC')->first();

        $this->browse(function (Browser $browser) use($admin, $data) {

            $faker = $this->faker;

            $url = url($this->imagePath2);
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $filename = uniqid() . '_' . trim($info['basename']);
            $file = storage_path('tmp/uploads/' . $filename);
            file_put_contents($file, $contents);

            $url2 = url($this->imagePath2);
            $info2 = pathinfo($url2);
            $contents2 = file_get_contents($url2);
            $filename2 = uniqid() . '_' . trim($info2['basename']);
            $file2 = storage_path('tmp/uploads/' . $filename2);
            file_put_contents($file2, $contents2);

            $url3 = url($this->imagePath3);
            $info3 = pathinfo($url3);
            $contents3 = file_get_contents($url3);
            $filename3 = uniqid() . '_' . trim($info3['basename']);
            $file3 = storage_path('tmp/uploads/' . $filename3);
            file_put_contents($file3, $contents3);

            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'events/' . $data->id . '/edit' . $this->testId)
                ->waitFor('#eventForm');

            $browser->script('$(\'#sites\').val($(\'#sites option\').val()).trigger(\'change.select2\')');
            $browser->script('$(\'#stores\').val($(\'#stores option\').val() + 1).trigger(\'change.select2\')');
            $browser->script('$(\'#categories\').val($(\'#categories option\').val() + 1).trigger(\'change.select2\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="image" id="image" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="banner" id="banner" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="menu_icon" id="menu_icon" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="test_id" value="'.$this->testId.'" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="short_description" value="'.$faker->text(50).'" />\')');
            $browser->script('$("#eventForm").append(\'<input type="text" name="long_description" value="'.$faker->text(100).'" />\')');

            $browser
                ->value('#title', $faker->sentence(6))
                ->value('#slug', $faker->slug)
                ->check('publish', 1)
                ->check('featured', 1)
                ->check('popular', 1)
                ->check('top', 1)
                ->check('bottom', 1)
                ->value('#image', $filename)
                ->value('#meta_title', $faker->name)
                ->value('#meta_keywords', $faker->sentence(6))
                ->value('#meta_description', $faker->text(100))
                ->value('#date', Carbon::now()->addDays(3)->format('Y-m-d'));

            $browser->press($this->updateBttnText)
                ->pause($this->timer)
                ->assertPathIs($this->adminPrefix . 'events');

        });
    }

    /** @test */
    public function testEventsShow()
    {
        $admin = User::find(1);
        $data = Event::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'events/' . $data->id . $this->testId)
                ->pause($this->timer)
                ->assertSee('Show Events');
        });
    }

    /** @test */
    public function testEventsDelete()
    {
        $admin = User::find(1);
        $data = Event::orderBy('id', 'DESC')->first();
        $this->browse(function (Browser $browser) use ($admin, $data) {
            $browser
                ->loginAs($admin)
                ->visit($this->adminPrefix . 'events' . $this->testId . '&eid='.$data->id)
                ->waitFor('#events'.$data->id)
                ->click('#events'.$data->id)
                ->acceptDialog()
                ->pause($this->timer)
                ->assertSee('Event List');
        });
    }

}
