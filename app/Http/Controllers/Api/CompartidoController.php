<?php

namespace App\Http\Controllers;

use App\Models\Compartido;
use Illuminate\Http\Request;

class CompartidoController extends Controller
{
    //
    public function index()
    {
        $shared=Compartido::all();
        //$shared = Compartido::included()->get();
        //$shared=Compartido::included()->filter();
        //$shared=Compartido::included()->filter()->sort()->get();
        //$shared=Compartido::included()->filter()->sort()->getOrPaginate();
        return response()->json($shared);
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
            'red_social' => 'required|max:255',
           

        ]);

        $shared = Compartido::create($request->all());

        return response()->json($shared);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compartido $shared
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shared = Compartido::included()->findOrFail($id);
        return response()->json($shared);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compartido  $shared
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Compartido $shared)
    {
        $request->validate([
            'red_social' => 'required|max:255'. $shared->id,

        ]);

        $shared->update($request->all());

        return response()->json($shared);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compartido  $shared
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compartido $shared)
    {
        $shared->delete();
        return response()->json($shared);
    }
}
