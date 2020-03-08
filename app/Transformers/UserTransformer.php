<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */

    protected $defaultIncludes = [
        'vendors',
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'avatar' => $user->avatarUrl(),
            'name' => $user->name,
            'email' => $user->email,
            'is_suspended' => $user->is_suspended,
        ];
    }

    public function includeVendors(User $user)
    {
        return $this->collection($user->vendors ,new VendorTransformer());
    }
}
