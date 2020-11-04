<?php

namespace Database\Factories\Bookkeeping;

use App\Models\Bookkeeping\LedgerRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class LedgerRecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LedgerRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ledger_id' => 1,
            'date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'locate' => $this->faker->country,
            'total' => $this->faker->numerify('####.##'),
        ];
    }
}
