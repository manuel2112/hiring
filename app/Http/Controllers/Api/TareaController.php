<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TareaResource::collection(Tarea::paginate(20)->where('realizada', false));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TareaRequest $request)
    {
        try {
            return 'pasa';
            // $tarea = Tarea::create($request->validated());    
            // return new TareaResource($tarea);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        return new TareaResource($tarea);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TareaRequest $request, Tarea $tarea)
    {
        $tarea->update($request->validated());

        return new TareaResource($tarea);
    }

    public function confirmTarea($id)
    {
        Tarea::where('id', $id)->update(array('realizada' => true));
        
        // Mail::to('manuel2112@hotnail.com')->send(new TareaAviso($id));
    }
       

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        $tarea->delete($tarea);

        return response()->noContent();
    }
}
