<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //Member
        $this->call([
            UserSeeder::class
        ]);

        //ledger
        \App\Models\Bookkeeping\Ledger::factory(2)->create();
        \App\Models\Bookkeeping\LedgerRecord::factory(10)->create();


    }
}
