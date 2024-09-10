<?php

namespace App\Http\Controllers\Api\arteTerapia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\arteTerapia\Brush;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrushController extends Controller
{
    public function index()
    {
        $brushes=Brush::all();
        //$brushes = Brush::included()->get();
        //$brushes= Brush::included()->filter();
        //$brushes=Brush::included()->filter()->sort()->get();
        //$brushes=Brush::included()->filter()->sort()->getOrPaginate();
        return response()->json($brushes);
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
            'nombre_Brush' => 'required|max:255',
            'textura' => 'required|max:255',
            'estilo_trazo' => 'required|max:255',
            
          
        ]);

        $brush = Brush::create($request->all());

        return response()->json($brush);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brush  $brush
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $brush= Brush::included()->findOrFail($id);
        return response()->json($brush);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brush  $brush
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brush $brush)
    {
        $request->validate([
           'nombre_Brush' => 'required|max:255',
            'textura' => 'required|max:255',
            'estilo_trazo' => 'required|max:255',
        ]);

        $brush->update($request->all());

        return response()->json($brush);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brush  $brush
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brush $brush)
    {
        $brush->delete();
        return response()->json($brush);
    }
}
