<?php

namespace App\Http\Controllers\Api;
use App\Models\Reaccion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReaccionController extends Controller
{
    public function index()
    {
        $reactions=Reaccion::all();
        //$reactions = Reaccion::included()->get();
        //$reactions= Reaccion::included()->filter();
        //$reactions=Reaccion::included()->filter()->sort()->get();
        //$reactions=Reaccion::included()->filter()->sort()->getOrPaginate();
        return response()->json($reactions);
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
            'reaccion_id'=> 'required|exists:reaccions,id',
            'tipo_reaccion' => 'required|max:255',
            
            
          
        ]);

        $reaction = Reaccion::create($request->all());

        return response()->json($reaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reaccion  $reaction
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $reaction= Reaccion::included()->findOrFail($id);
        return response()->json($reaction);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reaccion  $reaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reaccion $reaction)
    {
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'reaccion_id'=> 'required|exists:reaccions,id',
            'tipo_reaccion' => 'required|max:255',
            
        ]);

        $reaction->update($request->all());

        return response()->json($reaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reaccion  $reaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reaccion $reaction)
    {
        $reaction->delete();
        return response()->json($reaction);
    }
}
