<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Représente un fichier attachée à une tâche par un utilisateur
 * 
 * @author Nicolas Faessel <nicolas.faessel@ynov.com>
 * 
 */
class Attachment extends Model
{
    use HasFactory;


    /**
     * Renvoi l'utilisateur qui a posé la pièce jointe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Renvoi la tâche à laquelle la pièce jointe est attachée
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
