<div class="row p-0 m-0">
    <div class="col-4 mx-0 mt-2 p-0 px-1">
        <label for="select_esq">Selecione</label>
        <select class="form-select mx-0 _bg-danger" id="selcet_esq" wire:model='atividade_id'>
            <option selected>Selecione uma atividade</option>
            @foreach ($atividades_area as $atividade)
                <option value='{{ $atividade->id }}'>{{ $atividade->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-8 mx-0 mt-2 p-0 px-1">
        <label for="select_dir">Selecione</label>
        <select class="form-select mx-0 _bg-warning" id="select_dir" required >
            <option value='' selected>Escolha um problema</option>
            @foreach ($problemas as $problema)
                <option value='{{ $problema->id }}'>{{ $problema->descricao }}</option>
            @endforeach
        </select>
    </div>
</div>
