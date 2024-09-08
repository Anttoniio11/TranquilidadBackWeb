<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controllers;
use App\Models\Shared;
use Illuminate\Http\Request;

class SharedController extends Controller
{
    //
    public function index()
    {
<<<<<<< HEAD:app/Http/Controllers/Api/CompartidoController.php
        //$shared=Compartido::all();
        $shared = Compartido::included()->get();
        //$shared=Compartido::included()->filter();
        //$shared=Compartido::included()->filter()->sort()->get();
        //$shared=Compartido::included()->filter()->sort()->getOrPaginate();
=======
        $shared=Shared::all();
        //$shared = Shared::included()->get();
        //$shared=Shared::included()->filter();
        //$shared=Shared::included()->filter()->sort()->get();
        //$shared=Shared::included()->filter()->sort()->getOrPaginate();
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Http/Controllers/Api/SharedController.php
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
            'user_id'=> 'required|exists:users,id',
            'publicacion_id'=> 'required|exists:publicacions,id',
            'red_social' => 'required|max:255',
        ]);

        $shared = Shared::create($request->all());

        return response()->json($shared);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shared $shared
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shared = Shared::included()->findOrFail($id);
        return response()->json($shared);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shared  $shared
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Shared $shared)
    {
        $request->validate([
            'user_id'=> 'required|exists:user,id',
            'publicacion_id'=> 'required|exists:publicacion,id',
            'red_social' => 'required|max:255'

        ]);

        $shared->update($request->all());

        return response()->json($shared);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shared  $shared
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shared $shared)
    {
        $shared->delete();
        return response()->json($shared);
    }
}
