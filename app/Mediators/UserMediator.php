<?php

namespace App\Mediators;

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Transformers\APIFractalManager;
use App\Transformers\UserTransformer;

class UserMediator extends Mediator
{
    /**
     * UserMediator constructor.
     * @param APIFractalManager $fractalManager
     * @param UserTransformer $transformer
     * @param UserService $service
     */
    public function __construct(
        APIFractalManager $fractalManager,
        UserTransformer $transformer,
        UserService $service,
        UserRepository $repository
    )
    {
        $this->setFractalManager($fractalManager)
            ->setTransformer($transformer)
            ->setService($service)
            ->setRepository($repository);
    }
}
