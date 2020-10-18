<?php

namespace Database\Factories\Bookkeeping;

use App\Models\Bookkeeping\LedgerRecordAttach;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LedgerRecordAttachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LedgerRecordAttach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ledger_record_id' => 1,
            'name' => Str::random(10),
            'amount' => $this->faker->numberBetween(-100, 100),
        ];
    }
}
