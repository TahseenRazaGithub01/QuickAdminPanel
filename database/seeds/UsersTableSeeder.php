<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$b5JXNEC3AxZsKOtSJnBZ0eoDL0V69X1B13Ggqs/OCWMy3nogdFKHq',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
