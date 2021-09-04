<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService
{
    /**
     * @param string $className
     * @param array $data
     * @return Model
     */
    public function create($className, array $data): Model
    {
        return $className::create($data);
    }
}
