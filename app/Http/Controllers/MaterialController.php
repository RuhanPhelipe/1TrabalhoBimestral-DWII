<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller {

    private $path = "fotos/materials";

    public function index() {
        $data = Material::orderBy('nome')->get();
        return view('material.index', compact('data'));
    }

    public function create() {
        return view('material.create');
    }

    public function store(Request $request) {
        $rules = [
            'nome' => 'required|max:100|min:10',
            'descricao' => 'required|max:500|min:20',
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('foto')) {

            $reg = new Material();
            $reg->nome = $request->nome;
            $reg->descricao = $request->descricao;
            $reg->save();

            $id = $reg->id;
            $extensao_arq = $request->file('foto')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('foto')->storeAs("public/$this->path", $nome_arq);
            $reg->foto = $this->path."/".$nome_arq;
            $reg->save();
            
        }

        return redirect()->route('material.index');
    }

    public function show($id) { }

    public function edit($id) {
        $data = Material::find($id);

        if(!isset($data)) { return "<h1> $id não encontrado </h1>"; }

        return view("material.edit", compact('data'));
    }

    public function update(Request $request, $id) {
        $obj = Material::find($id);

        if(!isset($obj)) { return "<h1> $id não encontrado </h1>"; }

        $rules = [
            'nome' => 'required|max:100|min:10',
            'descricao' => 'required|max:500|min:20',
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('foto')) {

            $obj->nome = $request->nome;
            $obj->descricao = $request->descricao;
            $obj->save();

            $id = $obj->id;
            $extensao_arq = $request->file('foto')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('foto')->storeAs("public/$this->path", $nome_arq);
            $obj->foto = $this->path."/".$nome_arq;
            $obj->save();
            
        }

        return redirect()->route("material.index");
    }

    public function destroy($id) {

        $obj = Material::find($id);

        if(!isset($obj)) { return "<h1> $id não encontrado </h1>"; }

        $obj->destroy($id);

        return redirect()->route("material.index");

    }
}
