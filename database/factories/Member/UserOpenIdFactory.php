<?php

namespace Database\Factories\Member;

use App\Models\Member\UserOpenId;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserOpenIdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserOpenId::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'provider' => 'facebook',
            'open_id' => '2259142200794542',
            'name' => 'ChenFeng Hsu',
            'avatar' => 'https://graph.facebook.com/1918911484817617/picture?width=150&height=150',
        ];
    }
}
