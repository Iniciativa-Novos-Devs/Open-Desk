<div class="row">

    <div class="mt-0 col-12">
        <hr class="mb-0 w-100">
    </div>


    <div class="py-2 accordion col-12" id="accordion_chamados_table">
        <div class="accordion-item">
            <h2 class="select-none accordion-header" id="chamados_table_headingThree">
                <button class="select-none accordion-button {{ $keep_accordion_open ? '' : 'collapsed' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse_chamados_table"
                    aria-expanded="{{ $keep_accordion_open ? 'true' : 'false' }}"
                    aria-controls="collapse_chamados_table">
                    Lista de chamados
                </button>
            </h2>
            <div id="collapse_chamados_table"
                class="accordion-collapse collapse {{ $keep_accordion_open ? 'show' : '' }}"
                aria-labelledby="chamados_table_headingThree" data-bs-parent="#accordion_chamados_table" style="">
                <div class="accordion-body row">
                    <div class="col-12">
                        <div class="cursor-pointer select-none form-check form-switch">
                            <label class="cursor-pointer select-none form-check-label" for="keep_accordion_open">Manter
                                aberto</label>
                            <input class="cursor-pointer select-none form-check-input" type="checkbox"
                                id="keep_accordion_open" wire:change="changeChamadosAccordionOpenState()"
                                {{ $keep_accordion_open ? 'checked' : '' }} value="1">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-8">
                                <select class="form-select" aria-label="Default select example"
                                    wire:model="selected_status">
                                    <option value="">Sem filtro</option>
                                    @foreach (\App\Enums\StatusEnum::$humans as $enum => $status)
                                        <option value="{{ $enum }}">{{ \Str::plural($status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 d-none">
                                <input class="form-control" id="chamados_search" placeholder="Digite para pesquisar...">
                            </div>
                        </div>
                    </div>

                    <div class="mt-0 col-12">
                        <hr class="mb-0 w-100">
                    </div>

                    <div class="mt-0 col-12 table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="py-0">
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('id')">
                                        #
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer"
                                        wire:click="changeOrderBy('usuario_id')">
                                        Usuario
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('id')">
                                        Observação
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('id')">
                                        Atendente
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer"
                                        wire:click="changeOrderBy('created_at')">
                                        Abertura
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('status')">
                                        Estado
                                    </th>
                                    @if ($show_action_buttons)
                                        <th scope="col" class="py-0 cursor-pointer">
                                            Ações
                                        </th>
                                    @endif
                                </tr>

                                @foreach ($chamados as $chamado)
                                    @php
                                        $color_by_status = '';
                                        $color_by_status = $chamado->status == \App\Enums\StatusEnum::ENCERRADO     ? 'text-muted'  : $color_by_status;
                                        $color_by_status = $chamado->status == \App\Enums\StatusEnum::TRANSFERIDO   ? 'text-warning': $color_by_status;
                                        $color_by_status = $chamado->status == \App\Enums\StatusEnum::ABERTO        ? 'text-success': $color_by_status;
                                        $color_by_status = $chamado->status == \App\Enums\StatusEnum::PENDENTE      ? 'text-success': $color_by_status;
                                    @endphp
                                    <tr class="py-0 {{ $color_by_status }} ">
                                        <td class="py-0">
                                            <a href="@route('chamados_show', $chamado->id)">
                                            {{ $chamado->id }}
                                            </a>
                                        </td>
                                        <td class="py-0">
                                            {{ $chamado->usuario->name }}
                                        </td>
                                        <td class="py-0"
                                            title="{{ \Str::limit(strip_tags(html_entity_decode($chamado->title)), 180, '...') }}">
                                            <a href="@route('chamados_show', $chamado->id)">
                                                {{ \Str::limit(strip_tags(html_entity_decode($chamado->title)), 20, '...') }}
                                            </a>
                                        </td>
                                        <td class="py-0">{{ $chamado->atendente->name ?? null }}</td>
                                        <td class="py-0">{{ $chamado->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="py-0">

                                            @if ($chamado->status == \App\Enums\StatusEnum::EM_HOMOLOGACAO && $apenas_chamados_do_usuario)
                                                <a href="@route('homologacao_show', $chamado->id)" class="btn btn-sm btn-outline-info">
                                                    {{ \App\Enums\StatusEnum::getValue((int) $chamado->status) }}
                                                </a>
                                            @else
                                            {{ \App\Enums\StatusEnum::getValue((int) $chamado->status) }}
                                            @endif

                                            @if ($chamado->status == \App\Enums\StatusEnum::ENCERRADO)
                                                @if ($chamado->homologado_em)
                                                    <button type="button" class="py-0 btn btn-sm btn-success rounded-circle"
                                                    data-toggle="tooltip" data-html="true" title="Homologado"
                                                    aria-disabled="true">!</button>
                                                @else
                                                    <button type="button" class="py-0 btn btn-sm btn-danger rounded-circle"
                                                    data-toggle="tooltip" data-html="true" title="Não homologado"
                                                    aria-disabled="true">!</button>
                                                @endif
                                            @else
                                                @if ($chamado->homologacao_observacao_back)
                                                    <button type="button" class="py-0 btn btn-sm btn-danger rounded-circle"
                                                    data-toggle="tooltip" data-html="true" title="Chamado reaberto"
                                                    aria-disabled="true">!</button>
                                                @endif
                                            @endif

                                        </td>
                                        @if ($show_action_buttons)
                                            <td class="py-0">
                                                @php
                                                    $pode_ser_atendido = $this->chamadoPodeSerAtendido($chamado->status) &&
                                                    (!$chamado->atendente_id || $chamado->atendente_id == $this->usuario->id);
                                                @endphp

                                                <button class="p-0 px-1 btn btn-sm btn-success no-focus"
                                                    @if ($pode_ser_atendido)
                                                    wire:click="emmitAtenderChamado({{ $chamado->id }})"
                                                    @else
                                                    disabled
                                                    @endif
                                                    type="button"
                                                    onclick="Loader.open()">
                                                    Atender
                                                </button>

                                                <button
                                                    class="p-0 px-1 btn btn-sm btn-warning no-focus"
                                                    @if ($pode_ser_atendido)
                                                    wire:click="emmitFlowTransferirChamado({{ $chamado->id }})"
                                                    @else
                                                    disabled
                                                    @endif
                                                    type="button">
                                                    Transferir
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot class="m-0">
                                <tr>
                                    <td colspan="100%">
                                        <div class="p-0 m-0 row">
                                            <div class="mt-0 col-6">
                                                {{ $chamados->links('livewire::bootstrap') }}
                                            </div>
                                            <div class="mt-0 align-middle col-4">
                                                <span class="align-middle w-100">
                                                    <strong>{{ $items_by_page >= $chamados->total() ? $chamados->total() : $items_by_page }}</strong>
                                                    itens do total de
                                                    <strong>{{ $chamados->total() . '' }} </strong>
                                                </span>
                                            </div>
                                            <div class="mt-0 text-right col-2">
                                                <select class="p-1 m-1 custom-select custom-select-sm"
                                                    wire:model="items_by_page">
                                                    @foreach ([5, 10, 20, 30, 50, 100] as $qtd)
                                                        <option value="{{ $qtd }}">{{ $qtd }}
                                                        </option>
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
            </div>
        </div>
    </div>
</div>
