<?php

namespace App\Http\Controllers\Api;
use App\Models\LienzoPintura;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LienzoPinturaController extends Controller
{
    public function index()
    {
        $shapes=LienzoPintura::all();
        //$shapes = LienzoPintura::included()->get();
        //$shapes= LienzoPintura::included()->filter();
        //$shapes=LienzoPintura::included()->filter()->sort()->get();
        //$shapes=LienzoPintura::included()->filter()->sort()->getOrPaginate();
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
           
        ]);

        $shape = LienzoPintura::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LienzoPintura  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = LienzoPintura::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LienzoPintura  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LienzoPintura $shape)
    {
        $request->validate([
           
        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LienzoPintura  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(LienzoPintura $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
