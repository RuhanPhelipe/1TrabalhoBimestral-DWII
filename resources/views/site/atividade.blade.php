@extends('template.main', ['menu' => "home", "submenu" => "Atividades"])

@section('titulo') Desenvolvimento Web @endsection

@section('conteudo')

<div class="row mb-3">
    <div class="col">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach ($data as $item)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush_{{$item->id}}" aria-expanded="false" aria-controls="flush-collapseOne">
                            <span class="text-dark fs-5">{{ $item->nome }}</span>
                        </button>
                    </h2>
                    <div id="flush_{{$item->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="row">
                                <h3>Integrantes: @foreach($item->integrante as $integrante) {{ $integrante->nome }}@if($loop->last)@else,@endif  @endforeach</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-12 d-flex justify-content-evenly">
                                    <img src="{{ asset("storage/$item->foto_maquete"); }}" width="360" height="180" style="border-radius: 5px;"> 
                                </div>
                                <div class="col-md-6 col-xs-12 d-flex justify-content-evenly">
                                    <img src="{{ asset("storage/$item->foto_cadeia"); }}" width="360" height="180" style="border-radius: 5px;"> 
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-10 col-xs-12 d-flex align-items-center justify-content-center">
                                    <p class="text-dark fs-6">{{ $item->descricao }}</span>
                                </div>
                            </div>
                            <div class="row d-flex align-items-center justify-content-center">
                                <div id="carouselExampleAutoplaying" class="carousel slide col-9 " data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($item->reuniao as $foto)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img class="d-block w-100" src="{{ asset("storage/$foto->foto"); }}"> 
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection