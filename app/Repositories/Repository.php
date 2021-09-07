<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * Текушая модель.
     *
     * @var Model
     */
    protected mixed $model;

    /**
     * Конструктор CoreRepository.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * Возращает текущую модель.
     *
     * @return mixed
     */
    abstract protected function getModelClass(): string;

    /**
     * Возращает клон текущей модели.
     *
     * @return Model
     */
    protected function startConditions(): Model
    {
        return clone $this->model;
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->startConditions()
            ->where('id', $id)
            ->first();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getByIdWithTrashed(int $id): Model
    {
        return $this->startConditions()
            ->withTrashed()
            ->where('id', $id)
            ->first();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->startConditions()->all();
    }

    /**
     * @param array $filterParams
     * @return Collection
     */
    public function getAllFiltered(array $filterParams): Collection
    {
        return $this->startConditions()
            ->filter($filterParams)
            ->get();
    }

    /**
     * @param int $page
     * @param int|null $limit
     * @param array $filterParams
     * @param array $sortParams
     * @return LengthAwarePaginator
     */
    public function getFilteredPaginator(int $page = 1, int $limit = null, array $filterParams = [], array $sortParams = []): LengthAwarePaginator
    {
        $modelHasScopeOfJoin = method_exists($this->startConditions(), 'scopeOfJoin');

        $totalRecords = $this->startConditions()
            ->when($modelHasScopeOfJoin, function ($q) {
                $q->scopes('ofJoin')
                    ->applyScopes();
            })->filter($filterParams)
            ->get()
            ->count();

        $limit = (int)$limit < $totalRecords ? (int)$limit : $totalRecords;

        if($limit === 0) {
            if($totalRecords === 0) {
                $limit = 1;
            } else {
                $limit = $totalRecords;
            }
        }

        $pageRecords = $this->startConditions()
            ->when($modelHasScopeOfJoin, function ($q) {
                $q->scopes('ofJoin')
                    ->applyScopes();
            })->filter($filterParams)
            ->skip(($page - 1) * $limit)
            ->when($limit, function ($q) use ($limit) {
                $q->take($limit);
            })
            ->when($sortParams, function($q) use ($sortParams) {
                $q->ofSort($sortParams);
            })->get();

        return new LengthAwarePaginator($pageRecords, $totalRecords, $limit, $page);
    }

    /**
     * @return int
     */
    public function getNextId(): int
    {
        $self = $this->startConditions();

        $sequenceName = "{$self->getTable()}_id_seq";

        return DB::selectOne("select last_value from {$sequenceName} as val")->last_value + 1;
    }

    /**
     * @param array|string $ids
     * @return Collection
     */
    public function getByIds(array|string $ids): Collection
    {
        if(!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        return $this->startConditions()
            ->whereIn('id', $ids)
            ->get();
    }
}
