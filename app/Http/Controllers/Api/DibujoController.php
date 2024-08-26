<?php

namespace App\Http\Controllers;

use App\Models\Dibujo;
use Illuminate\Http\Request;

class DibujoController extends Controller
{
    //
    public function index()
    {
        $drawings=Dibujo::all();
        //$drawings = Dibujo::included()->get();
        //$drawings=Dibujo::included()->filter();
        //$drawings=Dibujo::included()->filter()->sort()->get();
        //$drawings=Dibujo::included()->filter()->sort()->getOrPaginate();
        return response()->json($drawings);
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
            'nombre_dibujo' => 'required|max:255',
            'contenido_dibujo' => 'required|max:255',

        ]);

        $drawing = Dibujo::create($request->all());

        return response()->json($drawing);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dibujo  $drawing
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $drawing = Dibujo::included()->findOrFail($id);
        return response()->json($drawing);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dibujo  $drawing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dibujo $drawing)
    {
        $request->validate([
            'nombre_dibujo' => 'required|max:255',
            'contenido_dibujo' => 'required|max:255' . $drawing->id,

        ]);

        $drawing->update($request->all());

        return response()->json($drawing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dibujo  $drawing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dibujo $drawing)
    {
        $drawing->delete();
        return response()->json($drawing);
    }
}
