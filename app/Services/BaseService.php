<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class BaseService
 * @package App\Services
 */
abstract class BaseService implements ServiceInterface
{
    /**
     * Конструктор
     */
    public function __construct()
    {

    }


}
