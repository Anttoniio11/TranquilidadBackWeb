<?php

namespace App\Http\Controllers\Api;
use App\Models\LienzoPintura;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LienzoPinturaController extends Controller
{
    public function index()
    {
        $canvases=LienzoPintura::all();
        //$canvases= LienzoPintura::included()->get();
        //$canvases= LienzoPintura::included()->filter();
        //$canvases=LienzoPintura::included()->filter()->sort()->get();
        //$canvases=LienzoPintura::included()->filter()->sort()->getOrPaginate();
        return response()->json($canvases);
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

        $canvas = LienzoPintura::create($request->all());

        return response()->json($canvas);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LienzoPintura  $canvas
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $canvas = LienzoPintura::included()->findOrFail($id);
        return response()->json($canvas);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LienzoPintura  $canvas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LienzoPintura $canvas)
    {
        $request->validate([
           
        ]);

        $canvas->update($request->all());

        return response()->json($canvas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LienzoPintura  $canvas
     * @return \Illuminate\Http\Response
     */
    public function destroy(LienzoPintura $canvas)
    {
        $canvas->delete();
        return response()->json($canvas);
    }
}
