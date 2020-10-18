<?php

namespace Database\Factories\Bookkeeping;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bookkeeping\LedgerRecord;

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
            'date' => $this->faker->date(),
            'locate' => $this->faker->country,
            'total' => $this->faker->numerify('####.##'),
        ];
    }
}
