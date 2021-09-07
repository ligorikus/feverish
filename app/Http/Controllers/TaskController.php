<?php

namespace App\Http\Controllers;

use App\Mediators\TaskMediator;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * @var TaskMediator $taskMediator
     */
    private TaskMediator $taskMediator;

    /**
     * @param TaskMediator $taskMediator
     */
    public function __construct(TaskMediator $taskMediator)
    {
        $this->taskMediator = $taskMediator;
    }

    /**
     *
     */
    public function makeCompilation()
    {
        /** @var User $user */
        $user = auth()->user();


    }

    public function markCompleted(Task $task)
    {
        /** @var User $user */
        $user = auth()->user();
        $this->taskMediator->service->markCompleted($user, $task);

    }
}
