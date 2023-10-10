<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\AtividadeIntegrates;
use App\Models\Integrante;
use App\Models\Reuniao;
use Illuminate\Http\Request;

class AtividadeController extends Controller {

    private $pathMaquete = "fotos/maquete";
    private $pathCadeia = "fotos/cadeia";
    private $pathReuniao = "fotos/reuniao";
    
    public function index() {
        $data = Atividade::with(['reuniao', 'integrante'])->get();
        return view('atividade.index', compact('data'));
    }

    public function create() {
        return view('atividade.create');
    }

    public function store(Request $request) {
        $rules = [
            'nome' => 'required|max:100|min:10',
            'descricao' => 'required|max:500|min:20',
            'data' => 'required',
            'fotoMaquete' => 'required',
            'fotoCadeia' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('fotoMaquete') && $request->hasFile('fotoCadeia')) {

            $reg = new Atividade();
            $reg->nome = $request->nome;
            $reg->descricao = $request->descricao;
            $reg->data = $request->data;
            $reg->save();

            $id = $reg->id;
            
            $extensao_arq = $request->file('fotoMaquete')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('fotoMaquete')->storeAs("public/$this->pathMaquete", $nome_arq);
            $reg->foto_maquete = $this->pathMaquete."/".$nome_arq;

            $extensao_arq = $request->file('fotoCadeia')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('fotoCadeia')->storeAs("public/$this->pathCadeia", $nome_arq);
            $reg->foto_cadeia = $this->pathCadeia."/".$nome_arq;
            $reg->save();
            
        }

        return redirect()->route('atividade.index');
    }

    public function addFotoReuniao($id){

        $data = Atividade::find($id);

        if(!isset($data)) { return "<h1> $id não encontrado </h1>"; }

        return view('atividade.addFotoReuniao', compact('data'));
    }

    public function storeFotoReuniao(Request $request, $atividade_id){
        
        $obj_atividade = Atividade::find($atividade_id);

        if(!isset($obj_atividade)) { return "<h1> $atividade_id não encontrado </h1>"; } 

        $rules = [
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('foto')) {

            $reg = new Reuniao();
            $reg->atividade()->associate($obj_atividade);
            $reg->save();

            $id = $reg->id;
            
            $extensao_arq = $request->file('foto')->getClientOriginalExtension();
            $nome_arq = $atividade_id.'_'.$id.'_'.time().'.'.$extensao_arq;
            $request->file('foto')->storeAs("public/$this->pathReuniao", $nome_arq);
            $reg->foto = $this->pathReuniao."/".$nome_arq;

            

            $reg->save();
        }

        return redirect()->route("atividade.index");

    }

    public function show($id) { }

    public function edit($id) {
        $data = Atividade::find($id);

        if(!isset($data)) { return "<h1> $id não encontrado </h1>"; }

        return view("atividade.edit", compact('data'));
    }

    public function update(Request $request, $id) {
        
        $obj = Atividade::find($id);

        if(!isset($obj)) { return "<h1> $id não encontrado </h1>"; }

        $rules = [
            'nome' => 'required|max:100|min:10',
            'descricao' => 'required|max:500|min:20',
            'data' => 'required',
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
        ];

        $request->validate($rules, $msgs);

        if($request->hasFile('fotoMaquete') && $request->hasFile('fotoCadeia')) {

            $obj->nome = $request->nome;
            $obj->descricao = $request->descricao;
            $obj->data = $request->data;
            $obj->save();

            $id = $obj->id;

            $extensao_arq = $request->file('fotoMaquete')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('fotoMaquete')->storeAs("public/$this->pathMaquete", $nome_arq);
            $obj->foto_maquete = $this->pathMaquete."/".$nome_arq;

            $extensao_arq = $request->file('fotoCadeia')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('fotoCadeia')->storeAs("public/$this->pathCadeia", $nome_arq);
            $obj->foto_cadeia = $this->pathCadeia."/".$nome_arq;
            
            $obj->save();
            
        }

        return redirect()->route("atividade.index");
    }

    public function destroy($id) {
        
        $obj = Atividade::find($id);

        if(!isset($obj)) { return "<h1> $id não encontrado </h1>"; }

        $obj->destroy($id);

        return redirect()->route("atividade.index");

    }
}
