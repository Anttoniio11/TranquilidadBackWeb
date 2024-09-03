<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LienzoDibujo;
use Illuminate\Http\Request;

class LienzoDibujoController extends Controller
{
    public function index()
    {
        //$shared=Compartido::all();
        $canvasD = LienzoDibujo::included()->get();
        //$shared=Compartido::included()->filter();
        //$shared=Compartido::included()->filter()->sort()->get();
        //$shared=Compartido::included()->filter()->sort()->getOrPaginate();
        return response()->json($canvasD);
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
            'pincel_id'=> 'required|exists:pincels,id',
            'forma_id'=> 'required|exists:formas,id',
            'herramienta_color_id'=> 'required|exists:herramienta_colors,id',
            'dibujo_id'=> 'required|exists:dibujos,id',
        ]);

        $canvasD = LienzoDibujo::create($request->all());

        return response()->json($canvasD);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LienzoDibujo $canvasD
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $canvasD = LienzoDibujo::included()->findOrFail($id);
        return response()->json($canvasD);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compartido  $shared
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,LienzoDibujo $canvasD)
    {
        $request->validate([
            'pincel_id'=> 'required|exists:pincels,id',
            'forma_id'=> 'required|exists:formas,id',
            'herramienta_color_id'=> 'required|exists:herramienta_colors,id',
            'dibujo_id'=> 'required|exists:dibujos,id',

        ]);

        $canvasD->update($request->all());

        return response()->json($canvasD);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compartido  $shared
     * @return \Illuminate\Http\Response
     */
    public function destroy(LienzoDibujo $canvasD)
    {
        $canvasD->delete();
        return response()->json($canvasD);
    }
}
