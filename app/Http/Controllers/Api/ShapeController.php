<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controllers;
use App\Models\Shape;
use Illuminate\Http\Request;

class ShapeController extends Controller
{
    //
    public function index()
    {
        $shapes=Shape::all();
        //$shapes = Shape::included()->get();
        //$shapes= Shape::included()->filter();
        //$shapes=Shape::included()->filter()->sort()->get();
        //$shapes=Shape::included()->filter()->sort()->getOrPaginate();
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
            'tipo_Shape' => 'required|max:255',
            'x' => 'required|max:255',
            'y' => 'required|max:255',
            'ancho' => 'required|max:255',
            'alto' => 'required|max:255',
          
        ]);

        $shape = Shape::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Shape::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shape $shape)
    {
        $request->validate([
            'tipo_Shape' => 'required|max:255',
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
     * @param  \App\Models\Shape  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shape $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
