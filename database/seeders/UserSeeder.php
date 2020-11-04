<?php

namespace Database\Seeders;

use App\Models\Member\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Ben',
            'avatar' => '',
        ]);
    }
}
