<?php

namespace App\Http\Controllers;
use App\Models\{Board, BoardUser};
use Illuminate\Http\Request;

class BoardUserController extends Controller
{
    //

    /**
     * Ajoute un utilisateur dans un board en utilisant le modèle pivot BoardUser
     *
     * @param Board $board le board pour lequel on ajoute l'utilisateur
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Board $board) {
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        // TODO il faudrait vérifier qu'il n'existe pas déjà dans le board
        $boardUser = new Boarduser(); 
        $boardUser->user_id = $validatedData['user_id']; 
        $boardUser->board_id = $board->id; 
        $boardUser->save(); 
        return redirect(route('boards.show', $board));
    }


    public function destroy(BoardUser $boardUser) { 
        $board = $boardUser->board;
        $boardUser->delete();
        return redirect(route('boards.show', $board));
    }

}
