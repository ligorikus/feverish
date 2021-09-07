<?php

namespace App\Mediators;

use App\Repositories\TaskRepository;
use App\Services\TaskService;
use App\Transformers\APIFractalManager;
use App\Transformers\TaskTransformer;

class TaskMediator extends Mediator
{
    /**
     * UserMediator constructor.
     * @param APIFractalManager $fractalManager
     * @param TaskTransformer $transformer
     * @param TaskService $service
     * @param TaskRepository $repository
     */
    public function __construct(
        APIFractalManager $fractalManager,
        TaskTransformer $transformer,
        TaskService $service,
        TaskRepository $repository
    )
    {
        $this->setFractalManager($fractalManager)
            ->setTransformer($transformer)
            ->setService($service)
            ->setRepository($repository);
    }
}
