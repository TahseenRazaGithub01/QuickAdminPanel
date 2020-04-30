<?php

use Illuminate\Database\Seeder;
use App\Site;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site = [
            [
                'name'              => 'example.com',
                'country_name'      => 'United States',
                'country_code'      => 'us',
                'url'               => 'https://example.com/',
            ],
        ];

        Site::insert($site);
    }
}
