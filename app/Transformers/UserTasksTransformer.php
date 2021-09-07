<?php

namespace App\Transformers;

use App\Models\Task;
use JetBrains\PhpStorm\ArrayShape;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class UserTasksTransformer extends TransformerAbstract
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'task'
    ];

    /**
     * @param Task $task
     * @return array
     */
    public function transform(Task $task): array
    {
        return [
            'isCompleted' => (bool)$task->pivot->is_completed,
            'date' => $task->pivot->date
        ];
    }

    /**
     * @param Task $task
     * @return Item
     */
    public function includeTask(Task $task): Item
    {
        return $this->item($task, new TaskTransformer);
    }
}
