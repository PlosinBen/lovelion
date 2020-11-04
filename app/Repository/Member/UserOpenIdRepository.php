<?php

namespace App\Repository\Member;

use App\Models\Member\UserOpenId;
use App\Repository\Repository;

class UserOpenIdRepository extends Repository
{
    public function __construct(UserOpenId $userOpenId)
    {
        $this->Model = $userOpenId;
    }

    public function fetchBySocialMedia(string $provider, string $open_id)
    {
        return $this->fetch([
            'provider' => $provider,
            'open_id' => $open_id,
        ])->first();
    }
}
