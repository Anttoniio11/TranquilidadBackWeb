<?php

namespace App\Http\Controllers\Api\arteTerapia;

use App\Http\Controllers\Controller;
use App\Models\arteTerapia\Template;
use Illuminate\Http\Request;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

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
            'template' => 'required|file|mimes:jpg,png|max:2048'
        ]);

        $url=null;
        $public_id=null;
        
        if($request->hasFile('template')) {
            $template=$request->file('template');
            
            //subir el archivo resources/template
            $cloudinaryImage=Cloudinary::upload($template->getRealPath(),[
                'folder' => 'resources/templates',
                'resource_type' => 'image',
            ]);
            

            //Obtener la URL y el ID público de la imagen
            $url=$cloudinaryImage->getSecurePath();
            $public_id=$cloudinaryImage->getPublicId();
            } else {
                return response()->json(['message' => 'template is required'],400);
            }

        //obtener todos los datos menos el template
        $templateData=$request->except('template');
        //añadir url de cloudinary a los datos
        $templateData['template_url']=$url;
        $templateData['template_public_id']=$public_id;

        //crear la template con el array de datos completos
        $newTemplate=Template::create($templateData);

        return response()->json($newTemplate, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $Template
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        
        $Template = Template::find($id);
        //$Gallery = Gallery::included()->findOrFail($id);
        if(!$Template){
            return response()->json(['message'=>'recurso no encontrado']);
        }

        return response()->json($Template);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $Template
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $template = Template::find($id);
        
        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }
        // Validación de los datos
        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'template_name' => 'nullable|string|max:100',
            'template' => 'nullable|file|mimes:jpg,png|max:2048' // Validación del archivo
        ]);
        //return response()->json($template->template_public_id);
        DB::beginTransaction();
        try{
        //verificar nueva img
        if($request->hasFile('template')){
            
            if($template->template_public_id){
            //eliminar la imagen anterior
            Cloudinary::destroy($template->template_public_id);
            }

            //subir nueva img
            $uploadedTemplate=$request->file('template');
            $cloudinaryImage=Cloudinary::upload($uploadedTemplate->getRealPath(),[
                'folder' => 'resources/templates',
                'resource_type' => 'image',
            ]);

            //obtener url y id publico 
            $url=$cloudinaryImage->getSecurePath();
            $public_id=$cloudinaryImage->getPublicId();
            
            //actualizar las datos de la img de template
            $template->template_url=$url;
            $template->template_public_id=$public_id;
        }
        
        //Obtener todos los datos y eliminar la imagen del array
        $templateData=$request->all();
        unset($templateData['template']);
        
        //actualizar otros campos
        $template->update(array_merge($templateData, [
            'template_url' => $url ?? $template->template_url,
            'template_public_id' => $public_id ?? $template->template_public_id,
        ]));
        //return response()->json($request->all(), 200);
        DB::commit();
        
        return response()->json([
            'message' => 'template update',
            'template' => $template
        ], 200);        
    } catch(\Exception $e){
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Error updating product: ' . $e->getMessage()
        ], 500);
    }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $Template
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = Template::find($id);

        if(!$template){
            return response()->json([
                'status' => 'error',
                'message' => 'template not found'
            ],400);
        }

        DB::beginTransaction();
        try{
            //eliminar de cloud
            Cloudinary::destroy($template->template_public_id);

            //eliminar de la DB
            $template->delete();

            DB::commit();
            
            return response()->json([
                'status' => 'success',
                'message' => 'template deleted successfully'
            ],200);
        } catch (\Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting template: ' . $e->getMessage()
            ], 500);
        }
    }
}
