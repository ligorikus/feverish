<?php


namespace App\Helpers;


use Illuminate\Pagination\LengthAwarePaginator;

class EloquentHelper
{
    /**
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    public static function extractPaginatorMeta(LengthAwarePaginator $paginator): array
    {
        return [
            'perPage' => (int)$paginator->perPage(),
            'currentPage' => (int)$paginator->currentPage(),
            'lastPage' => (int)$paginator->lastPage(),
            'total' => (int)$paginator->total()
        ];
    }

}
