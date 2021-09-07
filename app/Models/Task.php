<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model Task
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 *
 * @property Category $category
 */
class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'completed'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_tasks');
    }


}
