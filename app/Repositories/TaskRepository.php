<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

class TaskRepository extends Repository
{

    /**
     * @inheritDoc
     */
    protected function getModelClass(): string
    {
        return Task::class;
    }

    public function getUniqueTasks(User $user)
    {
        return $this->startConditions()
            ->select(['tasks.title', 'tasks.description',])
            ->get();
    }
}
