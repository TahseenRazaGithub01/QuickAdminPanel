<?php

namespace Tests\Browser\Web;

use App\Blog;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BlogTest extends DuskTestCase
{
    /**
     * A Dusk test Blog Index.
     *
     * @return void
     */
    public function testWebBlogIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/blog')
                ->assertSee('THE LATEST');
        });
    }

    /**
     * A Dusk test Blog Categories.
     *
     * @return void
     */
    public function testWebBlogCategories()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/us/blog?category=categories/automotive')
                ->assertSee('AUTOMOTIVE');
        });
    }

    /**
     * A Dusk test Blog Detail.
     *
     * @return void
     */
    public function testWebBlogDetail()
    {
        $data = Blog::CustomWhereBasedData(1)->orderBy('id', 'desc')->first();

        $this->browse(function (Browser $browser)  use ($data) {
            if(isset($data->slugs)) {
                $browser->visit('/us/'.$data->slugs->slug)
                    ->assertSee('TRENDING');
            }
        });
    }

    /**
     * A Dusk test Blog Author.
     *
     * @return void
     */
    public function testWebBlogAuthor()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use($user) {
            $browser->visit('/us/blog/author/'.$user->name)
                ->assertSee($user->name);
        });
    }

}
