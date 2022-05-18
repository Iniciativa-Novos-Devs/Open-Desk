<div class="row p-0 m-0">
    <div class="col-md-4 col-sm-12 mx-0 mt-2 p-0 px-1">
        <label for="select_esq">Selecione uma atividade</label>
        <select class="form-select mx-0 _bg-danger" id="selcet_esq"
            wire:model='atividade_id'
            name="atividade_id">
            <option value=''>Selecione uma atividade</option>
            @foreach ($atividades_area as $atividade)
                <option value='{{ $atividade->id }}'>{{ $atividade->nome }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-8 col-sm-12 mx-0 mt-2 p-0 px-1">
        <label for="select_dir">Escolha um problema</label>
        <select class="form-select mx-0 _bg-warning" id="select_dir"
            name="problema_id"
            {{-- wire:model="problema_id" --}}
            required >
            <option value=''>Escolha um problema</option>
            @foreach ($problemas as $problema)
                <option value='{{ $problema->id }}' {{ $problema_id == $problema->id ? 'selected' : '' }}>{{ $problema->descricao }}</option>
            @endforeach
        </select>
    </div>
</div>
