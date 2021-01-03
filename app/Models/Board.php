<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;



    /**
     * Nous allons mettre ici les contraintes sur la création d'un board, à savoir que l'on ajoute le propriétaire à la table des participants (modèle BoardUser)
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($board) {
            $bu = new BoardUser(); 
            $bu->user_id =  $board->user_id;
            $bu->board_id = $board->id; 
            $bu->save();
        });
    }


    /**
     * Renvoie l'utilisateur propriétaire du board (celui qui l'a créé)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    } 


    /**
     * Renvoie tous les utilisateurs qui sont asssociés au board, c'est à dire les participants
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')
                    ->using("App\Models\BoardUser")
                    ->withPivot("id")
                    ->withTimestamps();
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

}
