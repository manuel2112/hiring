<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use App\Mail\TareaAviso;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            return DB::table('tareas')
            ->where('realizada', '=', false)
            ->where('user_id', '=', $user_id)
            ->paginate(5);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TareaRequest $request)
    {
        try {
            $tarea = Tarea::create($request->validated());
            return new TareaResource($tarea);
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
        try {
            Tarea::where('id', $id)->update(array('realizada' => true));
            $tarea = Tarea::findOrFail($id);
            $user  = User::findOrFail($tarea->user_id);
            Mail::to($user->email)->send(new TareaAviso($tarea, $user));
            return response()->noContent();
        } catch (\Throwable $th) {
            return $th;
        }
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
