<?php

namespace App\Http\Controllers\Api\arteTerapia;

use App\Http\Controllers\Controller;
use App\Models\arteTerapia\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function index()
    {
       // $reaction =Reaction::all();
        $reaction = Reaction::included()->get();
        //$reaction = Reaction::included()->filter();
        //$reaction =Reaction::included()->filter()->sort()->get();
        //$reaction =Reaction::included()->filter()->sort()->getOrPaginate();
        return response()->json($reaction);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'nombre_Reaction' => 'required|max:255',
            'contenido_Reaction' => 'required|max:255',
            'carpeta_id'=> 'required|exists:carpetas,id',
            'plantilla_id'=> 'required|exists:plantillas,id'
          
        ]);

        $reaction = Reaction::create($request->all());

        return response()->json($reaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reaction  $paint
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $reaction = Reaction::included()->findOrFail($id);
        return response()->json($reaction);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reaction $reaction)
    {
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'nombre_Reaction' => 'required|max:255',
            'contenido_Reaction' => 'required|max:255',
            'carpeta_id'=> 'required|exists:carpetas,id',
            'plantilla_id'=> 'required|exists:plantillas,id'
        ]);

        $reaction->update($request->all());

        return response()->json($reaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reaction  $paint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reaction $reaction)
    {
        $reaction->delete();
        return response()->json($reaction);
    }
}
