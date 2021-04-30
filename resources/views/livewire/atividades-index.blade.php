<div>
    <label for="seletor_area" class="w-100"> Filtrar por área
        <select class="form-select" aria-label="Selecione uma Area" id='seletor_area'
            wire:model="area_atual"
        >
            <option value=''>Selecione uma Area</option>
            @foreach ( $areas as $area )
            <option value="{{ $area->id }}">
                {{ $area->sigla }} - {{ $area->nome }}
            </option>
            @endforeach
        </select>
    </label>

    @php
        $area_atual_nome = $atividades->first()->area->nome ?? '';
    @endphp

    <div>
        <h2>
            {{ $area_atual && $area_atual_nome ? 'Atividades de '. $area_atual_nome : 'Todas as Atividades' }}
            <a href="{{ route('atividades_add') }}" class="btn btn-sm btn-outline-info">Criar atividade</a>
        </h2>
    </div>

    @if($atividades)
    <div class="w-100">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('id')"
                    >#
                        {{ $order_by == 'id' ? '*' :''  }}
                    </th>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('nome')"
                    >Atividade
                        {{ $order_by == 'nome' ? '*' :''  }}
                    </th>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('created_at')"
                    >Data Cadastro
                        {{ $order_by == 'created_at' ? '*' :''  }}
                    </th>
                    <th>
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($atividades as $atividade )
                    <tr>
                        <td scope="row">{{ $atividade->id }}</td>
                        <td>{{ $atividade->nome }}</td>
                        <td>{{ $atividade->created_at }}</td>
                        <td>
                            <a href="{{ route('atividades_edit', $atividade->id) }}" class="btn btn-sm btn-outline-info">Editar</a>
                            <a href="{{ route('atividades_delete', $atividade->id) }}" class="btn btn-sm btn-outline-danger">Deletar</a>
                        </td>
                    </tr>
                    @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100%">
                        <div class="row m-0 p-0">
                            <div class="col-6 mt-3">
                                {{ $atividades->links('livewire::bootstrap') }}
                            </div>
                            <div class="col-4 align-middle mt-3">
                                <span class="w-100 align-middle">
                                    <strong>{{ $items_by_page >= $atividades->total() ? $atividades->total() : $items_by_page }}</strong>
                                    itens do total de
                                    <strong>{{ $atividades->total() }}</strong>
                                </span>
                            </div>
                            <div class="col-2 mt-3 text-right">
                                <select class="custom-select custom-select-sm m-1 p-1"
                                    wire:model="items_by_page"
                                >
                                @foreach ([ 10, 20, 30, 50, 100, ] as $qtd)
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
    @else
        Sem atividades para essa área.
    @endif
</div>
