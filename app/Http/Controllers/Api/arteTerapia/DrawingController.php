<?php

namespace App\Http\Controllers\Api\arteTerapia;
use App\Http\Controllers\Controller;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use App\Models\arteTerapia\Drawing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrawingController extends Controller
{
    //
    public function index()
    {
        $drawings=Drawing::all();
        //$drawings = Drawing::included()->get();
        //$drawings=Drawing::included()->filter();
        //$drawings=Drawing::included()->filter()->sort()->get();
        //$drawings=Drawing::included()->filter()->sort()->getOrPaginate();
        return response()->json($drawings);
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
            'user_id' => 'required|exists:users,id',
            'gallery_id' => 'required|exists:galleries,id',
            'drawing_name'=>'required|max:100',
            'drawing'=>'required|file|mimes:jpg,png|max:2048',
        ]);
        
        $url=null;
        $public_id=null;

        if ($request->hasFile('drawing')) {
            $drawing=$request->file('drawing');

            //subir archivo resources/painting/painting
            $cloudinaryImage=Cloudinary::upload($drawing->getRealPath(),[
                'folder' => 'resources/template/drawing',
                'resources_type' => 'image'
            ]);

            //obtener la url y el id public de la imagen
            $url=$cloudinaryImage->getSecurePath();
            $public_id=$cloudinaryImage->getPublicId();
            } else {
                return response()->json([
                    'message' => 'drawing is required'
                ],400);
            }
        
        //obtener todos los datos menos painting
        $drawingData=$request->except('painting');
        //añadir url y public_id de cloud
        $drawingData['drawing_url']=$url;
        $drawingData['draing_public_id']=$public_id;

        //crear painting con datos completos
        $newDrawing=Drawing::create($drawingData);

        return response()->json($newDrawing,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $drawing = Drawing::find($id);
        //$drawing = Drawing::included()->findOrFail($id);
        if(!$drawing){
            return response()->json(['message'=>'recurso no encontrado']);
        }
        return response()->json($drawing);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drawing $drawing)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'gallery_id' => 'required|exists:galleries,id',
            'drawing_name'=>'required|max:100',
            'drawing'=>'required|file|mimes:jpg,png|max:2048',
        ]);

        DB::beginTransaction();
        try{
        //verificar nueva img
        if($request->hasFile('drawing')){
            
            if($drawing->drawing_public_id){
            //eliminar la imagen anterior
            Cloudinary::destroy($drawing->drawing_public_id);
            }

            //subir nueva img
            $uploadedpainting=$request->file('drawing');
            $cloudinaryImage=Cloudinary::upload($uploadedpainting->getRealPath(),[
                'folder' => 'resources/template/drawing',
                'resource_type' => 'image',
            ]);

            //obtener url y id publico 
            $url=$cloudinaryImage->getSecurePath();
            $public_id=$cloudinaryImage->getPublicId();
            
            //actualizar las datos de la img de painting
            $drawing->drawing_url=$url;
            $drawing->drawing_public_id=$public_id;
        }
        
        //Obtener todos los datos y eliminar la imagen del array
        $drawingData=$request->all();
        unset($drawingData['drawing']);
        
        //actualizar otros campos
        $drawing->update(array_merge($drawingData, [
            'drawing_url' => $url ?? $drawing->drawing_url,
            'drawing_public_id' => $public_id ?? $drawing->drawing_public_id,
        ]));
        //return response()->json($request->all(), 200);
        DB::commit();
        
        return response()->json([
            'message' => 'drawing update',
            'painting' => $drawing
        ], 200);        
    } catch(\Exception $e){
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Error updating drawing: ' . $e->getMessage()
        ], 500);
    }
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drawing = Drawing::find($id);

        if(!$drawing){
            return response()->json([
                'status' => 'error',
                'message' => 'drawing not found'
            ],400);
        }

        DB::beginTransaction();
        try{
            //eliminar de cloud
            Cloudinary::destroy($drawing->drawing_public_id);

            //eliminar de la DB
            $drawing->delete();

            DB::commit();
            
            return response()->json([
                'status' => 'success',
                'message' => 'drawing deleted successfully'
            ],200);
        } catch (\Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting painting: ' . $e->getMessage()
            ], 500);
        }
    }
}
