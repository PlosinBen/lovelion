<?php

namespace App\Service;

use App\Repository\Member\UserOpenIdRepository;
use App\Repository\Member\UserRepository;
use Laravel\Socialite\Contracts\User;

class UserService
{
    private UserRepository $userRepository;
    private UserOpenIdRepository $userOpenIdRepository;

    public function __construct(UserRepository $userRepository, UserOpenIdRepository $userOpenIdRepository)
    {
        $this->userRepository = $userRepository;
        $this->userOpenIdRepository = $userOpenIdRepository;
    }

    public function getBySocialUser(string $provider, User $user)
    {
        $userOpenIdEntity = $this->userOpenIdRepository
            ->with('User')
            ->fetchBySocialMedia($provider, $user->getId())
            ->first();

        if( $userOpenIdEntity === null ) {
            return null;
        }

        return $userOpenIdEntity->User;
    }
}
