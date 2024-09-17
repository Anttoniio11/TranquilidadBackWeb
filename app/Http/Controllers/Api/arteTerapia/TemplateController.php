<?php

namespace App\Http\Controllers\Api\arteTerapia;

use App\Http\Controllers\Controller;
use App\Models\arteTerapia\Template;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use GuzzleHttp\Psr7\Response;

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
                'folder' => 'resources',
                'resources_type' => 'auto'
            ]);
                $data['template_url'] = $uploadedFile->getSecurePath();
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
    // Buscar la plantilla por su ID
    $template = Template::find($id);

    // Verificar si la plantilla existe
    if (!$template) {
        return response()->json(['message' => 'Template not found']);
    }
    // Validar los datos del request
    $validatedData = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'template_name' => 'required|string',
        'template' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,png|max:2048',
    ]);
    return 'hola';

    // Manejar la carga de archivos con Cloudinary si se proporciona un archivo
    if ($request->hasFile('template_url')) {
        // Eliminar el archivo anterior si existe
        if ($template->template_url) {
            $publicId = basename(parse_url($template->template_url, PHP_URL_PATH));
            Cloudinary::destroy($publicId);
        }

        $file = $request->file('template_url');
        $uploadedFile = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'templates',
            'resource_type' => 'auto',
        ]);
        $data['template_url'] = $uploadedFile->getSecurePath();
    }

    // Actualizar la plantilla con los nuevos datos
    $template->update($data);

    // Devolver la respuesta en formato JSON con la plantilla actualizada
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
