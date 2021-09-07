<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaskRepository extends Repository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Task::class;
    }

    /**
     * @param User $user
     * @param int $limit
     * @return Collection
     */
    public function getUniqueTasks(User $user, int $limit = 10): Collection
    {
        return $this->startConditions()
            ->whereDoesntHave('users', function (Builder $query) use ($user) {
                $query->where('user_id', '=', $user->id);
            })
            ->orderBy(DB::raw('RAND()'))
            ->limit($limit)
            ->get();
    }

    public function getTodayTasks(User $user)
    {
        return $this->startConditions()
            ->whereHas('users', function (Builder $query) use ($user) {
                $query->where('user_id', '=', $user->id)
                    ->whereDate('date', Carbon::today());
            })
            ->get();
    }
}
