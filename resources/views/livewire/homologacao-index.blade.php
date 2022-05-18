@inject('status_enum', 'App\Enums\StatusEnum')

<div class='w-100'>
    <div class="w-100">
        {{-- <h2>
            {{ $area_atual && $filtro ? 'Atividades de '. $filtro : 'Todas as Atividades' }}
            <a href="{{ route('homologacao_add') }}" class="btn btn-sm btn-outline-info">Criar atividade</a>
        </h2> --}}
    </div>

    <div class="w-100">
        <label for="seletor_area" class="w-100"> Filtrar por
            <select class="form-select" aria-label="Selecione uma Area" id='seletor_area'
                wire:model="filtro">
                <option value=''>Todos</option>
                @foreach ( $this->getFiltros() as $_filtro )
                <option value="{{ $_filtro }}" {{ $filtro_input == $_filtro ? 'selected' : '' }}> {{ $_filtro }} </option>
                @endforeach
            </select>
        </label>
    </div>

    @if($chamados)
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
                        wire:click="changeOrderBy('title')"
                    >Chamado
                        {{ $order_by == 'title' ? '*' :''  }}
                    </th>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('status')"
                    >Status
                        {{ $order_by == 'status' ? '*' :''  }}
                    </th>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('atendente_id')"
                    >Atendente
                        {{ $order_by == 'atendente_id' ? '*' :''  }}
                    </th>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('finished_at')"
                    >Fechado em
                        {{ $order_by == 'finished_at' ? '*' :''  }}
                    </th>
                    <th scope="col" class="cursor-pointer"
                        wire:click="changeOrderBy('created_at')"
                    >Aberto em
                        {{ $order_by == 'created_at' ? '*' :''  }}
                    </th>
                    <th>
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($chamados as $chamado )
                    <tr>
                        <td scope="row">{{ $chamado->id }}</td>
                        <td>{{ $chamado->title }}</td>
                        <td>{{ $status_enum->getValue($chamado->status) }}</td>
                        <td>{{ $chamado->atendente->name ?? null }}</td>
                        <td>{{ $chamado->finished_at ?? null }}</td>
                        <td>{{ $chamado->created_at }}</td>
                        <td>
                            <a href="@route('homologacao_show', $chamado->id)" class="btn btn-sm btn-outline-info">Ver resolução</a>
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
                                    <strong>{{ $chamados->total() }}</strong>
                                </span>
                            </div>
                            <div class="mt-3 text-right col-2">
                                <select class="p-1 m-1 custom-select custom-select-sm form-select cursor-pointer"
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
