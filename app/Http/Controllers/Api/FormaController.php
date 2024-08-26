<?php

namespace App\Http\Controllers;

use App\Models\Forma;
use Illuminate\Http\Request;

class FormaController extends Controller
{
    //
    public function index()
    {
        $shapes=Forma::all();
        //$shapes = Forma::included()->get();
        //$shapes= Forma::included()->filter();
        //$shapes=Forma::included()->filter()->sort()->get();
        //$shapes=Forma::included()->filter()->sort()->getOrPaginate();
        return response()->json($shapes);
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
            'tipo_forma' => 'required|max:255',
            'x' => 'required|max:255',
            'y' => 'required|max:255',
            'ancho' => 'required|max:255',
            'alto' => 'required|max:255',
          
        ]);

        $shape = Forma::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forma  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Forma::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forma  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forma $shape)
    {
        $request->validate([
            'tipo_forma' => 'required|max:255',
            'x' => 'required|max:255',
            'y' => 'required|max:255',
            'ancho' => 'required|max:255',
            'alto' => 'required|max:255',

        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forma  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forma $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
