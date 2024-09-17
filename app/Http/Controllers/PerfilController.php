<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
     // Obtener todos los perfiles
     public function index()
     {
         {
             //$categories=Category::all();
             // $perfil = Perfil::with(['estudios'])->get();
             //$categories=Category::included()->filter();
             $perfil= Perfil::included()->get();
              //$categories=Category::included()->filter()->sort()->get();
              //$categories=Category::included()->filter()->sort()->getOrPaginate();
              return response()->json($perfil);
          }
     }

     // Obtener un perfil por ID
     public function show($id)
     {
         return Perfil::findOrFail($id);
     }

    //  Crear un nuevo perfil
     public function store(Request $request)
     {
         $validated = $request->validate([
             'nombre' => 'required',
             'fecha_nacimiento'=>'required',
             'apellido' => 'required',
             'lugar_residencia'=>'required',
             'lugar_nacimiento'=>'required',
             'acerca_de_mi'=>'required',
             'id_usuario' => 'required|exists:usuarios,id_usuario',
             'tipo_perfil' => 'required|in:Normal,Profesional',
         ]);

         $perfil = Perfil::create($validated);
         return response()->json($perfil, 201);
     }


     // Actualizar un perfil
     public function update(Request $request, $id)
     {
         $perfil = Perfil::findOrFail($id);
         $perfil->update($request->all());
         return response()->json($perfil, 200);
     }

     // Eliminar un perfil
     public function destroy($id)
     {
         $perfil = Perfil

         ::findOrFail($id);
         $perfil->delete();
         return response()->json(null, 204);
     }
 }
