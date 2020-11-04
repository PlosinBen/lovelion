<?php

namespace Database\Factories\Member;

use App\Models\Member\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Ben',
            //            'email' => 'PlosinBen@gmail.com',
            'avatar' => 'https://graph.facebook.com/1918911484817617/picture?width=150&height=150',
        ];
    }
}
