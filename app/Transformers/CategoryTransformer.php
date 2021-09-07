<?php

namespace App\Transformers;

use App\Models\Category;
use JetBrains\PhpStorm\ArrayShape;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @param Category $category
     * @return array
     */
    #[ArrayShape(['id' => "int", 'name' => "string"])]
    public function transform(Category $category): array
    {
        return [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }
}
