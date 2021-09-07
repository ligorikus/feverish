<?php

namespace App\Http\Controllers;

use App\Mediators\TaskMediator;
use App\Models\Task;
use App\Models\User;
use App\Transformers\UserTasksTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function makeCompilation(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $todayTasks = $this->taskMediator->repository->getTodayTasks($user);
        if ($todayTasks->count() === 0) {
            $uniqueTasks = $this->taskMediator->repository->getUniqueTasks($user, 7);
            $this->taskMediator->service->createUserTasks($user, $uniqueTasks);

        }

        $userTasks = $user->tasks;
        return $this->respondWithSuccess($this->taskMediator->fractalManager->collection(
            $userTasks, new UserTasksTransformer
        ));
    }

    public function markCompleted(Task $task)
    {
        /** @var User $user */
        $user = auth()->user();
        $this->taskMediator->service->markCompleted($user, $task);

    }
}
