<?php

namespace App\Http\Controllers\Api;
use App\Models\Pintura;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PinturaController extends Controller
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
            'nombre_Pintura' => 'required|max:255',
            'contenido_pintura' => 'required|max:255',
          
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
           'nombre_Pintura' => 'required|max:255',
            'contenido_pintura' => 'required|max:255',
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
