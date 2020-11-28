<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;
use App\Http\Resources\SavedCatResource;
use Illuminate\Support\Facades\Validator;

class SavedCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtengo los gatos desde la
        $cats = Cat::all();
        //respondo la lista de gatos en un array
        return response([ 
            'cats' => SavedCatResource::collection($cats), 
            'message' => 'Recuperado exitosamente'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //optengo la campos desde la request
        $data = $request->all();
        //Valido los campos con las siguientes reglas
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|max:500'
        ]);
        //Si falla respondo el error
        if ($validator->fails()) {
            return response([
                'error' => $validator->errors(), 'Error de validación'
            ]);
        }
        //guardo la raza en el historial
        $cat = Cat::create($data);
        //Respondo el la raza almacenada
        return response([
            'cat' => new SavedCatResource($cat), 
            'message' => 'Recuperado exitosamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function show(Cat $cat)
    {
        return response([
            'cat' => new SavedCatResource($cat), 
            'message' => 'Recuperado exitosamente'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cat $cat)
    {
        $cat->update($request->all());

        return response([
            'cat' => new SavedCatResource($cat), 
            'message' => 'Actualizado satisfactoriamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cat  $cat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cat $cat)
    {
        $cat->delete();
        return response(['message' => 'Eliminado']);
    }
}
