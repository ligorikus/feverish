<?php

namespace App\Transformers;

use App\Models\Task;
use JetBrains\PhpStorm\ArrayShape;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'category'
    ];

    /**
     * @param Task $task
     * @return array
     */
    #[ArrayShape(['id' => "int", 'title' => "string", 'description' => "string"])]
    public function transform(Task $task): array
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
        ];
    }

    /**
     * @param Task $task
     * @return Item
     */
    public function includeRole(Task $task): Item
    {
        return $this->item($task->category, new CategoryTransformer);
    }
}
