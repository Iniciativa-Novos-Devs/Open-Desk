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
            {{-- <div class="col-4">
                <input class="form-control" id="chamados_search" placeholder="Digite para pesquisar...">
            </div> --}}
        </div>
    </div>

    <div class="col-12 mt-0">
        <hr class="w-100  mb-0">
    </div>

    <div class="col-12 mt-0">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('id')" >
                    #
                    </th>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('usuario_id')" >
                    Usuario
                    </th>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('observacao')" >
                    Observação
                    </th>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('created_at')" >
                    Criação
                    </th>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('status')" >
                    Estado
                    </th>
                </tr>

                @foreach ($chamados as $chamado)
                <tr>
                    <td>{{ $chamado->id}}</td>
                    <td>{{ $chamado->usuario->name }}</td>
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
