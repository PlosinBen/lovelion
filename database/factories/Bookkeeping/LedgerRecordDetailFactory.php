<?php

namespace Database\Factories\Bookkeeping;

use App\Models\Bookkeeping\LedgerRecordDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class LedgerRecordDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LedgerRecordDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $unit = $this->faker->numberBetween(100, 300);
        $quantity = $this->faker->numberBetween(1, 10);
        $other = $this->faker->numberBetween(-10, -50);

        return [
            'ledger_record_id' => 1,
            'name' => $this->faker->streetName,
            'unit' => $unit,
            'quantity' => $quantity,
            'other' => $other,
            'subtotal' => $unit * $quantity,
        ];
    }
}
