<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controllers;
use App\Models\Drawing;
use Illuminate\Http\Request;

class DrawingController extends Controller
{
    //
    public function index()
    {
        //$drawings=Drawing::all();
        $drawings = Drawing::included()->get();
        //$drawings=Drawing::included()->filter();
        //$drawings=Drawing::included()->filter()->sort()->get();
        //$drawings=Drawing::included()->filter()->sort()->getOrPaginate();
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
<<<<<<< HEAD:app/Http/Controllers/Api/DibujoController.php
            'user_id'=> 'required|exists:users,id',
            'nombre_dibujo' => 'required|max:255',
            'contenido_dibujo' => 'required|max:255',
            'carpeta_id'=> 'required|exists:carpetas,id',
=======
            'user_id' => 'required|exists:users,id',
            'gallery_id' => 'required|exists:galleries,id',
            'drawing_name'=>'required|max:100',
            'drawing_url'=>'required|max:100',
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Http/Controllers/Api/DrawingController.php

        ]);

        $drawing = Drawing::create($request->all());

        return response()->json($drawing);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $drawing = Drawing::included()->findOrFail($id);
        return response()->json($drawing);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drawing $drawing)
    {
        $request->validate([
<<<<<<< HEAD:app/Http/Controllers/Api/DibujoController.php
            'user_id'=> 'required|exists:users,id',
            'nombre_dibujo' => 'required|max:255',
            'contenido_dibujo' => 'required|max:255',
            'carpeta_id'=> 'required|exists:carpetas,id',
=======
            'user_id' => 'required|exists:users,id',
            'gallery_id' => 'required|exists:galleries,id',
            'drawing_name'=>'required|max:100',
            'drawing_url'=>'required|max:100',
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Http/Controllers/Api/DrawingController.php

        ]);

        $drawing->update($request->all());

        return response()->json($drawing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drawing $drawing)
    {
        $drawing->delete();
        return response()->json($drawing);
    }
}
