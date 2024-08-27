<?php

namespace App\Http\Controllers\Api;
use App\Models\Reaccion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReaccionController extends Controller
{
    public function index()
    {
        $shapes=Reaccion::all();
        //$shapes = Reaccion::included()->get();
        //$shapes= Reaccion::included()->filter();
        //$shapes=Reaccion::included()->filter()->sort()->get();
        //$shapes=Reaccion::included()->filter()->sort()->getOrPaginate();
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
            'tipo_reaccion' => 'required|max:255',
            
            
          
        ]);

        $shape = Reaccion::create($request->all());

        return response()->json($shape);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reaccion  $shape
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $shape = Reaccion::included()->findOrFail($id);
        return response()->json($shape);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reaccion  $shape
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reaccion $shape)
    {
        $request->validate([
           'tipo_reaccion' => 'required|max:255',
            
        ]);

        $shape->update($request->all());

        return response()->json($shape);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reaccion  $shape
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reaccion $shape)
    {
        $shape->delete();
        return response()->json($shape);
    }
}
