<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaskService extends BaseService
{
    /**
     * @param User $user
     * @param Task $task
     * @return int
     */
    public function markCompleted(User $user, Task $task)
    {
        return DB::table('user_tasks')
            ->where('user_id', $user->id)
            ->where('task_id', $task->id)
            ->update(['is_completed' => true]);
    }

    /**
     * @param User $user
     * @param Collection $tasks
     * @return bool
     */
    public function createUserTasks(User $user, Collection $tasks): bool
    {
        $userTasksToStore = $tasks->map(function ($item) use ($user) {
            return [
                'user_id' => $user->id,
                'task_id' => $item->id,
                'is_completed' => false,
                'date' => Carbon::today()
            ];
        })->toArray();
        return DB::table('user_tasks')->insert($userTasksToStore);
    }
}
