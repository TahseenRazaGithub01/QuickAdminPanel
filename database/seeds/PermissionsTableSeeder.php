<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'category_create',
            ],
            [
                'id'    => '18',
                'title' => 'category_edit',
            ],
            [
                'id'    => '19',
                'title' => 'category_show',
            ],
            [
                'id'    => '20',
                'title' => 'category_delete',
            ],
            [
                'id'    => '21',
                'title' => 'category_access',
            ],
            [
                'id'    => '22',
                'title' => 'blog_create',
            ],
            [
                'id'    => '23',
                'title' => 'blog_edit',
            ],
            [
                'id'    => '24',
                'title' => 'blog_show',
            ],
            [
                'id'    => '25',
                'title' => 'blog_delete',
            ],
            [
                'id'    => '26',
                'title' => 'blog_access',
            ],
            [
                'id'    => '27',
                'title' => 'site_create',
            ],
            [
                'id'    => '28',
                'title' => 'site_edit',
            ],
            [
                'id'    => '29',
                'title' => 'site_show',
            ],
            [
                'id'    => '30',
                'title' => 'site_delete',
            ],
            [
                'id'    => '31',
                'title' => 'site_access',
            ],
            [
                'id'    => '32',
                'title' => 'audit_log_show',
            ],
            [
                'id'    => '33',
                'title' => 'audit_log_access',
            ],
            [
                'id'    => '34',
                'title' => 'store_create',
            ],
            [
                'id'    => '35',
                'title' => 'store_edit',
            ],
            [
                'id'    => '36',
                'title' => 'store_show',
            ],
            [
                'id'    => '37',
                'title' => 'store_delete',
            ],
            [
                'id'    => '38',
                'title' => 'store_access',
            ],
            [
                'id'    => '39',
                'title' => 'coupon_create',
            ],
            [
                'id'    => '40',
                'title' => 'coupon_edit',
            ],
            [
                'id'    => '41',
                'title' => 'coupon_show',
            ],
            [
                'id'    => '42',
                'title' => 'coupon_delete',
            ],
            [
                'id'    => '43',
                'title' => 'coupon_access',
            ],
            [
                'id'    => '44',
                'title' => 'event_create',
            ],
            [
                'id'    => '45',
                'title' => 'event_edit',
            ],
            [
                'id'    => '46',
                'title' => 'event_show',
            ],
            [
                'id'    => '47',
                'title' => 'event_delete',
            ],
            [
                'id'    => '48',
                'title' => 'event_access',
            ],
            [
                'id'    => '49',
                'title' => 'page_create',
            ],
            [
                'id'    => '50',
                'title' => 'page_edit',
            ],
            [
                'id'    => '51',
                'title' => 'page_show',
            ],
            [
                'id'    => '52',
                'title' => 'page_delete',
            ],
            [
                'id'    => '53',
                'title' => 'page_access',
            ],
            [
                'id'    => '54',
                'title' => 'press_create',
            ],
            [
                'id'    => '55',
                'title' => 'press_edit',
            ],
            [
                'id'    => '56',
                'title' => 'press_show',
            ],
            [
                'id'    => '57',
                'title' => 'press_delete',
            ],
            [
                'id'    => '58',
                'title' => 'press_access',
            ],
            [
                'id'    => '59',
                'title' => 'tag_create',
            ],
            [
                'id'    => '60',
                'title' => 'tag_edit',
            ],
            [
                'id'    => '61',
                'title' => 'tag_show',
            ],
            [
                'id'    => '62',
                'title' => 'tag_delete',
            ],
            [
                'id'    => '63',
                'title' => 'tag_access',
            ],
            [
                'id'    => '64',
                'title' => 'product_category_create',
            ],
            [
                'id'    => '65',
                'title' => 'product_category_edit',
            ],
            [
                'id'    => '66',
                'title' => 'product_category_show',
            ],
            [
                'id'    => '67',
                'title' => 'product_category_delete',
            ],
            [
                'id'    => '68',
                'title' => 'product_category_access',
            ],
            [
                'id'    => '69',
                'title' => 'product_create',
            ],
            [
                'id'    => '70',
                'title' => 'product_edit',
            ],
            [
                'id'    => '71',
                'title' => 'product_show',
            ],
            [
                'id'    => '72',
                'title' => 'product_delete',
            ],
            [
                'id'    => '73',
                'title' => 'product_access',
            ],
            [
                'id'    => '74',
                'title' => 'addspace_store_create',
            ],
            [
                'id'    => '75',
                'title' => 'addspace_store_edit',
            ],
            [
                'id'    => '76',
                'title' => 'addspace_store_show',
            ],
            [
                'id'    => '77',
                'title' => 'addspace_store_delete',
            ],
            [
                'id'    => '78',
                'title' => 'addspace_store_access',
            ],
            [
                'id'    => '79',
                'title' => 'add_space_product_create',
            ],
            [
                'id'    => '80',
                'title' => 'add_space_product_edit',
            ],
            [
                'id'    => '81',
                'title' => 'add_space_product_show',
            ],
            [
                'id'    => '82',
                'title' => 'add_space_product_delete',
            ],
            [
                'id'    => '83',
                'title' => 'add_space_product_access',
            ],
            [
                'id'    => '84',
                'title' => 'banner_create',
            ],
            [
                'id'    => '85',
                'title' => 'banner_edit',
            ],
            [
                'id'    => '86',
                'title' => 'banner_show',
            ],
            [
                'id'    => '87',
                'title' => 'banner_delete',
            ],
            [
                'id'    => '88',
                'title' => 'banner_access',
            ],
            [
                'id'    => '89',
                'title' => 'network_create',
            ],
            [
                'id'    => '90',
                'title' => 'network_edit',
            ],
            [
                'id'    => '91',
                'title' => 'network_show',
            ],
            [
                'id'    => '92',
                'title' => 'network_delete',
            ],
            [
                'id'    => '93',
                'title' => 'network_access',
            ],
            [
                'id'    => '94',
                'title' => 'subscriber_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
