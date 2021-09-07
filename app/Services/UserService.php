<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    /**
     * @param string $className
     * @param array $data
     * @return Model
     */
    public function create($className, array $data): Model
    {
        $data['password'] = Hash::make($data['password']);
        return $className::create($data);
    }
}
