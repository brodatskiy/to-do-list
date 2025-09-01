<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    /**
     * @throws Exception
     */
    public function updateStatus(TaskStatus $newStatus): void
    {
        if (!$this->status->isValidTransition($newStatus)) {
            throw new Exception("Unable to update task state from {$this->status->value} to $newStatus->value");
        }

        $this->status = $newStatus;
        $this->save();
    }
}
