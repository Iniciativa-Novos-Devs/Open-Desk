@extends('layouts.page')


@section('title', 'Unidades')
@section('title_header', 'Unidades')

@section('content')
<div class="row">
    <div class="col-12">
        <h1> Criar unidade</h1>
    </div>

    <div class="col-12">
        <form action="{{ route('unidades.store') }}" method="POST">
            @csrf
            <div class="mb-3"><input type="text" name="ue" value="{{ old("ue") }}" placeholder="UE*" class="form-control" minlength="3" maxlength="3" required></div>
            <div class="mb-3"><input type="text" name="nome" value="{{ old("nome") }}" placeholder="Nome*"    class="form-control" minlength="10" maxlength="150" required></div>
            <div class="mb-3"><input type="text" name="cidade" value="{{ old("cidade") }}" placeholder="Cidade"  class="form-control" minlength="3" maxlength="100"> </div>
            <div class="mb-3"><input type="text" name="diretor" value="{{ old("diretor") }}" placeholder="Diretor" class="form-control"></div>
            <div class="mb-3"><input type="text" name="dir_adm" value="{{ old("dir_adm") }}" placeholder="Diretor administrativo" class="form-control"></div>
            <div class="mb-3"><button class="btn btn-success">Criar</button></div>
        </form>
    </div>
</div>

@endsection
