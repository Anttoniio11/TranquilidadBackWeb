<?php

namespace App\Http\Controllers\Api\arteTerapia;

use App\Http\Controllers\Controller;
use App\Models\arteTerapia\Painting;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;

class PaintingController extends Controller
{
    
    public function index()
    {
        $paintings=Painting::all();
        //$paintings = Painting::included()->get();
        //$paintings=Painting::included()->filter();
        //$paintings=Painting::included()->filter()->sort()->get();
        //$paintings=Painting::included()->filter()->sort()->getOrPaginate();
        return response()->json($paintings);
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
            'user_id'=> 'required|exists:users,id',
            'gallery_id'=>'required|exists:galleries,id',
            'painting_id'=>'required|exists:paintings,id',
            'painting_name'=> 'required|max:100',
            'painting'=>'required|file|mimes:jpg,png|max:2048'

        ]);

        $url=null;
        $public_id=null;

        if ($request->hasFile('painting')) {
            $painting=$request->file('painting');

            //subir archivo resources/painting/painting
            $cloudinaryImage=Cloudinary::upload($painting->getRealPath(),[
                'folder' => 'resources/template/painting',
                'resources_type' => 'image'
            ]);

            //obtener la url y el id public de la imagen
            $url=$cloudinaryImage->getSecurePath();
            $public_id=$cloudinaryImage->getPublicId();
            } else {
                return response()->json([
                    'message' => 'painting is required'
                ],400);
            }
        
        //obtener todos los datos menos painting
        $paintingData=$request->except('painting');
        //añadir url y public_id de cloud
        $paintingData['painting_url']=$url;
        $paintingData['painting_public_id']=$public_id;

        //crear painting con datos completos
        $newPainting=Painting::create($paintingData);

        return response()->json($newPainting,201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Painting  $Painting
     * @return \Illuminate\Http\Response
     */
    public function show($id) //si se pasa $id se utiliza la comentada
    {  
        $painting = Painting::find($id);
        //$Gallery = Gallery::included()->findOrFail($id);
        if(!$painting){
            return response()->json(['message'=>'recurso no encontrado']);
        }

        return response()->json($painting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Painting  $Painting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $painting = painting::find($id);
        
        if (!$painting) {
            return response()->json(['message' => 'painting not found'], 404);
        }
        // Validación de los datos
        $request->validate([
            'user_id'=> 'required|exists:users,id',
            'gallery_id'=>'required|exists:galleries,id',
            'painting_id'=>'required|exists:paintings,id',
            'painting_name'=> 'required|max:100',
            'painting'=>'required|file|mimes:jpg,png|max:2048'

        ]);
        //return response()->json($painting->painting_public_id);
        DB::beginTransaction();
        try{
        //verificar nueva img
        if($request->hasFile('painting')){
            
            if($painting->painting_public_id){
            //eliminar la imagen anterior
            Cloudinary::destroy($painting->painting_public_id);
            }

            //subir nueva img
            $uploadedpainting=$request->file('painting');
            $cloudinaryImage=Cloudinary::upload($uploadedpainting->getRealPath(),[
                'folder' => 'resources/template/paintings',
                'resource_type' => 'image',
            ]);

            //obtener url y id publico 
            $url=$cloudinaryImage->getSecurePath();
            $public_id=$cloudinaryImage->getPublicId();
            
            //actualizar las datos de la img de painting
            $painting->painting_url=$url;
            $painting->painting_public_id=$public_id;
        }
        
        //Obtener todos los datos y eliminar la imagen del array
        $paintingData=$request->all();
        unset($paintingData['painting']);
        
        //actualizar otros campos
        $painting->update(array_merge($paintingData, [
            'painting_url' => $url ?? $painting->painting_url,
            'painting_public_id' => $public_id ?? $painting->painting_public_id,
        ]));
        //return response()->json($request->all(), 200);
        DB::commit();
        
        return response()->json([
            'message' => 'painting update',
            'painting' => $painting
        ], 200);        
    } catch(\Exception $e){
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Error updating painting: ' . $e->getMessage()
        ], 500);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Painting  $Painting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $painting = Painting::find($id);

        if(!$painting){
            return response()->json([
                'status' => 'error',
                'message' => 'painting not found'
            ],400);
        }

        DB::beginTransaction();
        try{
            //eliminar de cloud
            Cloudinary::destroy($painting->painting_public_id);

            //eliminar de la DB
            $painting->delete();

            DB::commit();
            
            return response()->json([
                'status' => 'success',
                'message' => 'painting deleted successfully'
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
