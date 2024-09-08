<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    //
    public function index()
    {
        //$templates=Template::all();
        $templates = Template::included()->get();
        //$templates=Template::included()->filter();
        //$templates=Template::included()->filter()->sort()->get();
        //$templates=Template::included()->filter()->sort()->getOrPaginate();
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
            'category_id'=> 'required|exists:categories,id',
            'template_name'=> 'required|max:100',
            'template_url'=>'required|max:100'

        ]);

        $Template = Template::create($request->all());

        return response()->json($Template);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $Template
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $Template = Template::included()->findOrFail($id);
        return response()->json($Template);
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $Template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $Template)
    {
        $request->validate([
            'category_id'=> 'required|exists:categories,id',
            'template_name'=> 'required|max:100',
            'template_url'=>'required|max:100'
        ]);

        $Template->update($request->all());

        return response()->json($Template);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $Template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $Template)
    {
        $Template->delete();
        return response()->json($Template);
    }
}
