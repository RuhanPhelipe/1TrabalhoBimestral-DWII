<?php

namespace App\Http\Controllers;

use App\Models\Integrante;
use Illuminate\Http\Request;

class IntegranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Integrante::all();
        return view('integrantes.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('integrantes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nome' => 'required|max:100|min:10',
            'biografia' => 'required|max:500|min:20',
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "unique" => "Já existe um endereço cadastrado com esse [:attribute]!"
        ];

        $request->validate($rules, $msgs);

        Integrante::create([
            'nome' => $request->nome,
            'biografia' => $request->biografia,
        ]);

        return redirect()->route("integrantes.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) { }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Integrante::find($id);

        if (!isset($data)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view("integrantes.edit", compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj = Integrante::find($id);

        if (!isset($obj)) { return "<h1>ID: $id não encontrado!</h1>"; }

        $obj->fill([
            'nome' => $request->nome,
            'biografia' => $request->biografia,
        ]);

        $obj->save();

        return redirect()->route("integrantes.index");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = Integrante::find($id);

        if (!isset($obj)) { return "<h1>ID: $id não encontrado!</h1>"; }
        
        $obj->destroy();

        return redirect()->route("integrantes.index");
    }
}
