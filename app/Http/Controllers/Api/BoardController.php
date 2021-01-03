<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\{Board, User};
use App\Policies\BoardPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BoardController extends Controller
{



    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* 
            Cette fonction gère directement les autorisations pour chacune des méthodes du contrôleur 
            en fonction des méthodes de BoardPolicy(viewAny, view, update, ....)
            https://laravel.com/docs/8.x/authorization#authorizing-resource-controllers
        */
        $this->authorizeResource(Board::class, 'board'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Renvoi une vue à laquelle on transmet les boards de l'utilisateurs (ceux auxquels il participe)
        //$user = Auth::user();
        return Board::all();

    }


    /**
     * Store a newly created resource in storage.
     *
     * Permet de stocker un nouveau board pour l'utilisateur dans la base de données
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', 
            'description' => 'max:4096'
        ]);
        $board = new Board(); 
        $board->title = $validatedData['title'];
        $board->description = $validatedData['description'];
        $board->user_id = Auth::user()->id; 

        $board->save(); 
        return $board->toJson();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {

        //$this->authorize('view', $board);

        // On récupère les ids des utilisateurs de la board : 
        $boardUsersIds = $board->users->pluck('id'); 
        // on récupère ici tous les utilisateurs qui ne sont pas dans la board. 
        // Notez le get, qui permet d'obtenir la collection (si on ne le met pas, on obtient un query builder mais la requête n'est pas executée)
        $usersNotInBoard  = User::whereNotIn('id', $boardUsersIds)->get();
        return $board->toJson(); 
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
        //$this->authorize('update', $board);
        $validatedData = $request->validate([
                'title' => 'required|string|max:255', 
                'description' => 'max:4096'
            ]
        );
        $board->title = $validatedData['title']; 
        $board->description = $validatedData['description']; 
        $board->update(); 

        return $board->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        //
        $b = $board;
        $board->delete();
        return $board->toJson();
    }
}
