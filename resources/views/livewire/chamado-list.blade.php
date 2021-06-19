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

    <div class="mt-0 col-12">
        <hr class="mb-0 w-100">
    </div>

    <div class="mt-0 col-12">
        <table class="table">
            <tbody>
                <tr>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('id')" >
                    #
                    </th>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('usuario_id')" >
                    Usuario
                    </th>
                    <th scope="col" class="cursor-pointer" wire:click="changeOrderBy('title')" >
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
                    <td>
                        <a href="#">{{ $chamado->usuario->name }}</a>
                    </td>
                    <td title="{{ \Str::limit(strip_tags(html_entity_decode($chamado->title)), 180, '...') }}">
                        {{ \Str::limit(strip_tags(html_entity_decode($chamado->title)), 40, '...') }}
                    </td>
                    <td>{{ $chamado->created_at->format('d/m/Y H:i:s')}}</td>
                    <td>{{ \App\Enums\StatusEnum::getState( (int) $chamado->status)}}</td>
                    <td>
                        <a href="{{ route('chamados_show', [$chamado->id, \Str::slug(strip_tags(html_entity_decode($chamado->title)))]) }}"
                            class="btn btn-sm btn-outline-info"> Ver chamado
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100%">
                        <div class="p-0 m-0 row">
                            <div class="mt-3 col-6">
                                {{ $chamados->links('livewire::bootstrap') }}
                            </div>
                            <div class="mt-3 align-middle col-4">
                                <span class="align-middle w-100">
                                    <strong>{{ $items_by_page >= $chamados->total() ? $chamados->total() : $items_by_page }}</strong>
                                    itens do total de
                                    <strong>{{ $chamados->total().'' }} </strong>
                                </span>
                            </div>
                            <div class="mt-3 text-right col-2">
                                <select class="p-1 m-1 custom-select custom-select-sm"
                                    wire:model="items_by_page"
                                >
                                @foreach ([ 5, 10, 20, 30, 50, 100, ] as $qtd)
                                    <option value="{{ $qtd }}">{{ $qtd }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
