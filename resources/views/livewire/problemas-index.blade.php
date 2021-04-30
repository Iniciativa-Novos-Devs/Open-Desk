<div>
    <label for="seletor_atividade" class="w-100"> Filtrar por área
        <select class="form-select" aria-label="Selecione uma Atividade" id='seletor_atividade'
            wire:model="atividade_atual"
        >
            <option value=''>Selecione uma Atividade</option>
            @foreach ( $atividades as $atividade )
            <option value="{{ $atividade->id }}">
                {{ $atividade->sigla }} - {{ $atividade->nome }}
            </option>
            @endforeach
        </select>
    </label>

    @php
        $atividade_atual_nome = $problemas->first()->atividade->nome ?? '';
    @endphp

    <div>
        <h2>
            {{ $atividade_atual && $atividade_atual_nome ? 'Problemas de '. $atividade_atual_nome : 'Todas as Problemas' }}
            <a href="{{ route('problemas_add') }}" class="btn btn-sm btn-outline-info">Criar problema</a>
        </h2>
    </div>

    @if($problemas)
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
                    >Problema
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
                    @foreach ($problemas as $problema )
                    <tr>
                        <td scope="row">{{ $problema->id }}</td>
                        <td>{{ $problema->nome }}</td>
                        <td>{{ $problema->created_at }}</td>
                        <td>
                            <a href="{{ route('problemas_edit', $problema->id) }}" class="btn btn-sm btn-outline-info">Editar</a>
                            <a href="{{ route('problemas_delete', $problema->id) }}" class="btn btn-sm btn-outline-danger">Deletar</a>
                        </td>
                    </tr>
                    @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100%">
                        <div class="row m-0 p-0">
                            <div class="col-6 mt-3">
                                {{ $problemas->links('livewire::bootstrap') }}
                            </div>
                            <div class="col-4 align-middle mt-3">
                                <span class="w-100 align-middle">
                                    <strong>{{ $items_by_page >= $problemas->total() ? $problemas->total() : $items_by_page }}</strong>
                                    itens do total de
                                    <strong>{{ $problemas->total() }}</strong>
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
        Sem problemas para essa área.
    @endif
</div>
