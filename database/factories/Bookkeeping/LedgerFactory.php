<?php

namespace Database\Factories\Bookkeeping;

use App\Models\Bookkeeping\Ledger;
use Illuminate\Database\Eloquent\Factories\Factory;

class LedgerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ledger::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->userName,
            'currency_code' => $this->faker->currencyCode,
        ];
    }
}
