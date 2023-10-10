<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\AtividadeIntegrates;
use App\Models\Integrante;
use Illuminate\Http\Request;

class AtividadeIntegranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($atividade_id){
        $obj_atividade_integrantes =  AtividadeIntegrates::all()->where('atividade_id', '==', $atividade_id);

        $obj_atividade = Atividade::find($atividade_id);
        
        if(!isset($obj_atividade)) { return "<h1> $atividade_id não encontrado </h1>"; }

        $obj_integrantes = [];
        
        $obj_all_integrantes = Integrante::all();
        foreach ($obj_all_integrantes as $i) {
            $t = 0;
            foreach ($obj_atividade_integrantes as $item) {
                if($item->integrante_id === $i->id){
                    $t+=1;
                }
            }
            if($t === 0){
                array_push($obj_integrantes, $i);
            }
        }

        $data = [$obj_atividade,$obj_integrantes];

        // return $obj_integrantes;
       
        return view('atividade_integrante.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $atividade_id){
        $obj_atividade = Atividade::find($atividade_id);

        if(!isset($obj_atividade)) { return "<h1> $atividade_id não encontrado </h1>"; }

        $integrante_id = $request->integrante_id;
        
        $rules = [
            'integrante_id' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
        ];

        $request->validate($rules, $msgs);

        $obj_integrante = Integrante::find($integrante_id);

        if(!isset($obj_integrante)) { return "<h1> $integrante_id não encontrado </h1>"; }

        // return [$obj_atividade, $obj_integrante];

        $reg = new AtividadeIntegrates();

        $reg->atividade_id = $atividade_id;
        $reg->integrante_id = $request->integrante_id;

        $reg->save();

        return redirect()->route("atividade.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
