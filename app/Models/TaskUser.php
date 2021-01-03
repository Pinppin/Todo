<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\{Task, User};

/**
 * Classe pivot qui met en relation les tâches et les utilisateurs
 * 
 * @author Nicolas Faessel <nicolas.faessel@ynov.com>
 * 
 */
class TaskUser extends Pivot
{
    //
    use HasFactory; 


    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @see https://laravel.com/docs/8.x/eloquent-relationships#defining-custom-intermediate-table-models
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted() {

        /**
         * 
         * @return boolean true if user is in the same board the task belongs to. 
         */
        // Si on renvoi faux dans cette fonction, la création n'est pas effectuée, sinon elle est effectuée
        static::creating(function ($task_user) {
            return !is_null($task_user->task->board->users->find($task_user->user_id));
        });
    }


    /**
     * Renvoi l'utilisateur lié à la tâche
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Renvoi la tâche liée à l'utilisateur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

 
}
