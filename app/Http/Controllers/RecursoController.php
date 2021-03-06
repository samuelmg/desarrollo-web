<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Recurso;
use Illuminate\Http\Request;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recursos = Recurso::with('categoria')->get();

        return view('recursos.recursoIndex', compact('recursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Recurso::class);
        $categorias = Categoria::pluck('categoria', 'id')->toArray();
        return view('recursos.recursoForm', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recurso = new Recurso();
        $recurso->categoria_id = $request->categoria_id;
        $recurso->user_id = \Auth::id();
        $recurso->url = $request->url;
        $recurso->titulo = $request->titulo;
        $recurso->descripcion = $request->descripcion;
        $recurso->save();

        return redirect()->route('recurso.index')
            ->with([
                'mensaje' => 'Recurso creado con éxito',
                'alert-type' => 'alert-success',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show(Recurso $recurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit(Recurso $recurso)
    {
        $this->authorize('update', $recurso);
        $categorias = Categoria::pluck('categoria', 'id')->toArray();
        return view('recursos.recursoForm', compact('categorias', 'recurso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recurso $recurso)
    {
        $recurso->categoria_id = $request->categoria_id;
        $recurso->url = $request->url;
        $recurso->titulo = $request->titulo;
        $recurso->descripcion = $request->descripcion;
        $recurso->aprovado = $request->aprovado ?? 0;
        $recurso->save();

        return redirect()->route('recurso.index')
            ->with([
                'mensaje' => 'Recurso actualizado con éxito',
                'alert-type' => 'alert-success',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recurso $recurso)
    {
        //
    }
}
