<?php


namespace App\Mediators;


use App\Repositories\Repository;
use App\Services\BaseService;
use App\Transformers\APIFractalManager;
use League\Fractal\TransformerAbstract;

/**
 * Interface MediatorInterface
 * @package App\Mediators
 */
interface MediatorInterface
{
    public function setFractalManager(APIFractalManager $fractalManager): Mediator;

    public function setRepository(Repository $repository): Mediator;

    public function setTransformer(TransformerAbstract $transformer): Mediator;

    public function setService(BaseService $service): Mediator;
}
