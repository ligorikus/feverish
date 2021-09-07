<?php

namespace App\Http\Controllers;

use App\Mediators\TaskMediator;
use App\Mediators\UserMediator;
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
     * @var UserMediator $userMediator
     */
    private UserMediator $userMediator;

    /**
     * @param TaskMediator $taskMediator
     */
    public function __construct(TaskMediator $taskMediator, UserMediator $userMediator)
    {
        $this->taskMediator = $taskMediator;
        $this->userMediator = $userMediator;
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

    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function markCompleted(Task $task): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $this->taskMediator->service->markCompleted($user, $task);
        $userTask = $this->userMediator->repository->getUserTaskById($user, $task);
        return $this->respondWithSuccess($this->taskMediator->fractalManager->item(
            $userTask, new UserTasksTransformer
        ));
    }
}
