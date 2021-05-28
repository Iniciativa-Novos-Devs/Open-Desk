<div class="row">
    <div class="col-12 ">
        <div class="row">
            <div class="col-8">
                <select class="form-select" aria-label="Default select example" wire:model="selected_status">
                    <option value="">Todos os chamados</option>
                    @foreach (\App\Enums\StatusEnum::$humans as $enum => $status)
                    <option value="{{ $enum }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <input class="form-control" id="chamados_search" placeholder="Digite para pesquisar...">
            </div>
        </div>
    </div>

    <div class="col-12 mt-0">
        <hr class="w-100  mb-0">
    </div>

    <div class="col-12 mt-0">
        <table class="table">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Observação</th>
                    <th>Criação</th>
                    <th>Estado</th>
                </tr>

                @foreach ($chamados as $chamado)
                <tr>
                    <td>{{ $chamado->id}}</td>
                    <td>{{ $chamado->usuario_id}}</td>
                    <td title="{{ \Str::limit($chamado->observacao, 180, '...') }}">
                        {{ \Str::limit($chamado->observacao, 40, '...') }}
                    </td>
                    <td>{{ $chamado->created_at->format('d/m/Y H:i:s')}}</td>
                    <td>{{ \App\Enums\StatusEnum::getState( (int) $chamado->status)}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
