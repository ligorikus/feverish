<?php


namespace App\Mediators;


use App\Repositories\Repository;
use App\Services\Service;
use App\Transformers\APIFractalManager;
use League\Fractal\TransformerAbstract;

/**
 * Class Mediator
 * @package App\Mediators
 *
 * @property APIFractalManager $fractalManager
 * @property Repository $repository
 * @property TransformerAbstract $transformer
 * @property Service $service
 */
abstract class Mediator implements MediatorInterface
{
    /**
     * @var APIFractalManager
     */
    public APIFractalManager $fractalManager;

    /**
     * @var Repository
     */
    public Repository $repository;

    /**
     * @var TransformerAbstract
     */
    public TransformerAbstract $transformer;

    /**
     * @var Service
     */
    public Service $service;

    /**
     * @param APIFractalManager $fractalManager
     * @return $this
     */
    public function setFractalManager(APIFractalManager $fractalManager): Mediator
    {
        $this->fractalManager = $fractalManager;
        return $this;
    }

    /**
     * @param Repository $repository
     * @return $this
     */
    public function setRepository(Repository $repository): Mediator
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @param TransformerAbstract $transformer
     * @return $this
     */
    public function setTransformer(TransformerAbstract $transformer): Mediator
    {
        $this->transformer = $transformer;
        return $this;
    }

    public function setService(Service $service): Mediator
    {
        $this->service = $service;
        return $this;
    }
}
