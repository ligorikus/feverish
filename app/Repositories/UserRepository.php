<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param User $user
     * @param Task $task
     * @return Builder|Model|object|null
     */
    public function getUserTaskById(User $user, Task $task)
    {
        return $this->startConditions()
            ->with(['tasks' => function ($query) use ($task) {
                $query->where('task_id', '=', $task->id);
            }])
            ->where('id', $user->id)
            ->first()
            ->tasks
            ->first();
    }
}
