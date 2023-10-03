<?php

namespace App\Http\Controllers;

use App\Models\Integrante;
use Illuminate\Http\Request;

class IntegranteController extends Controller {
    
    private $path = "fotos/integrantes";

    public function index() {
        
        $data = Integrante::orderBy('nome')->get();
        return view('integrante.index', compact('data'));
    }

    public function create() {
        return view('integrante.create');
    }

    public function store(Request $request) {
        
        // php artisan storage:link
        // Colocar os arquivos de imagem dentro da pasta "/storage/app/public"

        $rules = [
            'nome' => 'required|max:100|min:10',
            'biografia' => 'required|max:1000|min:20',
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('foto')) {

            // Insert no Banco
            $reg = new Integrante();
            $reg->nome = $request->nome;
            $reg->biografia = $request->biografia;
            $reg->save();    

            // Upload da Foto
            $id = $reg->id;
            $extensao_arq = $request->file('foto')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('foto')->storeAs("public/$this->path", $nome_arq);
            $reg->foto = $this->path."/".$nome_arq;
            $reg->save();
        }
        
        return redirect()->route('integrante.index');
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $data = Integrante::find($id);
        return view('integrante.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $obj = Integrante::find($id);

        if(!isset($obj)) { return "<h1> $id não encontrado </h1>"; }

        $rules = [
            'nome' => 'required|max:100|min:10',
            'biografia' => 'required|max:1000|min:20',
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('foto')) {

            // Insert no Banco
            $obj = new Integrante();
            $obj->nome = $request->nome;
            $obj->biografia = $request->biografia;
            $obj->save();    

            // Upload da Foto
            $id = $obj->id;
            $extensao_arq = $request->file('foto')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('foto')->storeAs("public/$this->path", $nome_arq);
            $obj->foto = $this->path."/".$nome_arq;
            $obj->save();
        }

        return redirect()->route("integrante.index");
    }

    public function destroy($id) {
        $obj = Integrante::find($id);

        if(!isset($obj)) { return "<h1> $id não encontrado </h1>"; }

        $obj->destroy($id);

        return redirect()->route("integrante.index");
    }
}
