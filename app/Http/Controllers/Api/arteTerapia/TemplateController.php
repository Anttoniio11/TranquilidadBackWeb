<?php

namespace App\Http\Controllers\Api\arteTerapia;

use App\Http\Controllers\Controller;
use App\Models\arteTerapia\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

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
            'template' => 'nullable|file|mimes:jpg,png|max:2048'
        ]);

        $data = $request->only(['category_id', 'template_name']);
        
        if($request->hasFile('template')) {
            $template = $request->file('template');
            $uploadedFile = Cloudinary::upload($template->getRealPath(),[
                'folder' => 'resources/templates',
                'resources_type' => 'auto'
            ]);
                $data['template_url'] = $uploadedFile->getSecurePath();
            } else {
                $data['template_url']=null;
            }

        $Template = Template::create($data);

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
        
        $Template = Template::find($id);

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
    //dd($request->all());
    
    // Capturar solo los campos que necesitamos
    $data = $request->only(['category_id', 'template_name']);
    //return response()->json($request->all());

    if ($request->hasFile('template')) {
        // Elimina el archivo anterior si existe
        if ($template->template_url) {
            // Extrae el ID público del archivo actual
            $publicId = basename(parse_url($template->template_url, PHP_URL_PATH));
            Cloudinary::destroy($publicId);
        }

        // Sube el nuevo archivo a Cloudinary
        $file = $request->file('template');
        $uploadedFile = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'resources/templates',
            'resource_type' => 'auto' // Permite subir imágenes y otros tipos de archivos
        ]);
        // Guarda la nueva URL del archivo
        $data['template_url'] = $uploadedFile->getSecurePath();
    }

    // Actualiza los datos del template en la base de datos
    $template->update($data);
    
    // Retorna el template actualizado
    return response()->json($template);
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
