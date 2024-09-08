<?php

namespace App\Http\Controllers\Api;
<<<<<<< HEAD:app/Http/Controllers/Api/PinturaController.php
use App\Models\Pintura;
use App\Http\Controllers\Controller;
=======

use App\Http\Controllers\Controllers;
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Http/Controllers/Api/ReactionController.php
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function index()
    {
       // $paints =Pintura::all();
        $paints = Pintura::included()->get();
        //$paints = Pintura::included()->filter();
        //$paints =Pintura::included()->filter()->sort()->get();
        //$paints =Pintura::included()->filter()->sort()->getOrPaginate();
        return response()->json($paints);
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
            'nombre_pintura' => 'required|max:255',
            'contenido_pintura' => 'required|max:255',
            'carpeta_id'=> 'required|exists:carpetas,id',
            'plantilla_id'=> 'required|exists:plantillas,id'
          
        ]);

        $paint = Pintura::create($request->all());

        return response()->json($paint);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pintura  $paint
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $paint = Pintura::included()->findOrFail($id);
        return response()->json($paint);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pintura  $paint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pintura $paint)
    {
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'nombre_Pintura' => 'required|max:255',
            'contenido_pintura' => 'required|max:255',
            'carpeta_id'=> 'required|exists:carpetas,id',
            'plantilla_id'=> 'required|exists:plantillas,id'
        ]);

        $paint->update($request->all());

        return response()->json($paint);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pintura  $paint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pintura $paint)
    {
        $paint->delete();
        return response()->json($paint);
    }
}
