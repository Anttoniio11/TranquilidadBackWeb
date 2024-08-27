<?php

namespace App\Http\Controllers\Api;
use App\Models\Plantilla;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlantillaController extends Controller
{
    public function index()
    {
        //$templates=Plantilla::all();
        $templates = Plantilla::included()->get();
        //$templates= Plantilla::included()->filter();
        //$templates=Plantilla::included()->filter()->sort()->get();
        //$templates=Plantilla::included()->filter()->sort()->getOrPaginate();
        return response()->json($templates);
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
            'categoria_id' => 'required|exists:categorias,id',
            'nombre_plantilla' => 'required|max:255',
            'contenido_plantilla' => 'required|max:255',
        ]);

        $template = Plantilla::create($request->all());

        return response()->json($template);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plantilla  $template
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $template = Plantilla::included()->findOrFail($id);
        return response()->json($template);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plantilla  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plantilla $template)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre_Plantilla' => 'required|max:255',
            'contenido_plantilla' => 'required|max:255',
            
        ]);

        $template->update($request->all());

        return response()->json($template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plantilla  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plantilla $template)
    {
        $template->delete();
        return response()->json($template);
    }
}
