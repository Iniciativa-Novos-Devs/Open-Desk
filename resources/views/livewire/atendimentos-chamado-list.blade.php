<div class="row">
    <div class="col-12">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transferirChamadoModal">
            Transferir chamado
        </button>

        <!-- Modal -->
        <div class="modal fade" id="transferirChamadoModal" tabindex="-1" aria-labelledby="transferirChamadoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferirChamadoModalLabel">Transferir chamado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="w-100">
                            <h4 class="mb-3 text-center">Transferir para</h4>
                            <div class="mb-3 d-flex justify-content-center">

                                <div class="cursor-pointer f-style form-check form-check-inline">
                                    <label class="cursor-pointer form-check-label f-style" for="transferencia_por_area">
                                        <input class="form-check-input" type="radio" name="transferencia_para" value="area"
                                            wire:change="transferenciaPor('area')"
                                            {{ ($transferencia_para ?? null) == 'area' ? 'checked' : '' }}
                                            id="transferencia_por_area" value="area">
                                        Área</label>
                                </div>
                                <div class="cursor-pointer f-style form-check form-check-inline">
                                    <label class="cursor-pointer select-none form-check-label f-style force" for="transferencia_por_atendente">
                                        <input class="form-check-input" type="radio" name="transferencia_para" value="atendente"
                                            wire:change="transferenciaPor('atendente')"
                                            {{ ($transferencia_para ?? null) == 'atendente' ? 'checked' : '' }}
                                            id="transferencia_por_atendente" value="atendente">
                                        Atendente</label>
                                </div>
                            </div>

                            <div class="px-3 m-0">
                                @if ($transferencia_para && $transferencia_para_id)
                                <strong> Transferencia para </strong>
                                    {{ $transferencia_para }}
                                <strong>( ID: {{ $transferencia_para_id }})</strong>
                                @else
                                <br>
                                @endif
                            </div>

                            @if ($transferencia_para ?? null)
                            <div class="mb-3">
                                    <label for="option_transferencia_para_id" class="form-label w-100"  x-data="{ select_open: false }">

                                        @php
                                            $opcoesParaTranferencia = $this->getOpcoesParaTranferencia() ?? [];
                                        @endphp
                                        <div class="my-3 ml-1">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary"
                                                x-on:click="select_open = !select_open" >
                                                <span x-text="select_open ? 'Ocultar seletor' : 'Mostrar seletor'">Mostrar seletor</span>
                                            </button>
                                        </div>

                                        <select
                                            x-on:change="select_open = false"
                                            x-cloak x-show="select_open"
                                            {{ $transferencia_para_id && $transferencia_para ? "style=display:none;" : '' }}
                                            onclick="hideSelectTransfer()"
                                            name="transferencia_para_id" id="option_transferencia_para_id" wire:model="transferencia_para_id"
                                            wire:change="alterado()" class="form-control form-select">
                                            @if ($opcoesParaTranferencia['label'] ?? null)
                                                <option selecione_transferencia_para value="" {{ !($transferencia_para_id ?? null) ? 'selected' : '' }} >
                                                    {{ $opcoesParaTranferencia['label'] }}
                                                </option>
                                            @endif
                                            @foreach (($opcoesParaTranferencia["options"] ?? []) as $option)
                                                <option option
                                                    value="{{ $option['id'] }}"
                                                    {{ $transferencia_para_id == $option['id'] ? 'is_selected' : '' }}
                                                    >
                                                    {{ $option['label'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                            </div>

                            <div class="mb-3">
                                <label for="chamado_tags" class="col-form-label">Tags</label>
                                <input type="text" class="form-control" id="chamado_tags">
                            </div>

                            <div class="mb-3">
                                <label for="nota_transferencia" class="col-form-label">Nota</label>
                                <textarea class="form-control" id="nota_transferencia"></textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" wire:click="cancelaTranferencia()">Cancelar</button>

                        @if ($transferencia_para ?? null)
                            <button type="button" class="btn btn-success" wire:click="concluirTransferencia()">Transferir</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="backdrop_princial custom-backdrop" style="display: none;"></div>

    </div>

    <div class="col-12">
        <a href="{{ route('chamados_add') }}">Adicionar chamado</a>
        <button wire:click="clearCache()" class="btn btn-sm btn-danger" type="button">Limpar cache</button>
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
                                        Criação
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('status')">
                                        Estado
                                    </th>
                                    <th scope="col" class="py-0">
                                        Ações
                                    </th>
                                </tr>

                                @foreach ($chamados as $chamado)
                                    <tr class="py-0">
                                        <td class="py-0">{{ $chamado->id }}</td>
                                        <td class="py-0">
                                            <a href="#">{{ $chamado->usuario->name }}</a>
                                        </td>
                                        <td class="py-0"
                                            title="{{ \Str::limit(strip_tags(html_entity_decode($chamado->title)), 180, '...') }}">
                                            {{ \Str::limit(strip_tags(html_entity_decode($chamado->title)), 40, '...') }}
                                        </td>
                                        <td class="py-0">{{ $chamado->atendente->name ?? null }}</td>
                                        <td class="py-0">{{ $chamado->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="py-0">
                                            {{ \App\Enums\StatusEnum::getState((int) $chamado->status) }}
                                        </td>
                                        <td class="py-0">
                                            @if (!in_array($chamado->status, $this->cantOpenIfStatusIn()))
                                                <button class="p-0 px-1 btn btn-sm btn-success no-focus"
                                                    wire:click="atenderChamado({{ $chamado->id }})" type="button">
                                                    Atender
                                                </button>
                                                <button class="p-0 px-1 btn btn-sm btn-warning no-focus"
                                                    wire:click="tranferirChamado({{ $chamado->id }})" type="button">
                                                    Transferir
                                                </button>
                                            @endif
                                        </td>
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

    <div class="mt-0 col-12 row d-flex justify-content-between" id="detalhes_do_chamado">
        <div class="border col-6 row" style="min-height: 50vh;">

            @if ($this->em_atendimento ?? null)
                <div class="col-12">
                    <ul class="py-0 list-group list-group-flush">
                        <li class="py-0 list-group-item d-flex justify-content-start">
                            <strong>Chamado: </strong><span
                                class="mx-1 text-left text-muted">{{ $this->em_atendimento->id ?? null }}</span>
                            <span class="mx-3"></span>
                            @if ($this->em_atendimento->unidade->nome ?? null)
                                <strong>Unidade: </strong>
                                <span class="mx-1 text-left text-muted">
                                    {{ $this->em_atendimento->unidade->nome ?? null }}
                                </span>
                            @endif
                        </li>
                        <li class="py-0 list-group-item">

                            <div class="w-100">
                                <h6 class="mt-3 text-bold">Detalhes do chamado:</h6>
                                <div class="accordion" id="accordion_detalhe_chamado">

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="detalhe_chamado_headingThree">
                                            <h2 class="accordion-header" id="detalhe_chamado_headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse_detalhe_chamado"
                                                    aria-expanded="false" aria-controls="collapse_detalhe_chamado">
                                                    {{ $this->em_atendimento->title ?? null }}
                                                    | {{ $this->em_atendimento->usuario->name ?? null }}
                                                    | <span class="text-muted">
                                                        @if ($this->em_atendimento->created_at ?? null)
                                                            {!! '&nbsp;' . $this->em_atendimento->created_at->format('d/m/Y H:i:s') !!}
                                                        @endif
                                                    </span>
                                                </button>
                                            </h2>
                                            <div id="collapse_detalhe_chamado" class="accordion-collapse collapse"
                                                aria-labelledby="detalhe_chamado_headingThree"
                                                data-bs-parent="#accordion_detalhe_chamado" style="">
                                                <div class="accordion-body">
                                                    {!! '&nbsp;' . html_entity_decode($this->em_atendimento->observacao ?? null) !!}
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-2 btn btn-sm btn-info">Anexos</button>
                            <hr>
                        </li>
                    </ul>
                </div>

                <div class="pb-3 col-12">
                    <div class="form-group w-100">
                        <label for="nota_atendimento">Registro do atendimento</label>
                        <textarea class="mb-3 form-control" id="nota_atendimento" cols="10" rows="3"
                            {{ $this->em_atendimento ?? null ? '' : 'disabled' }}
                            placeholder="Aqui vai sua observação..."
                            style="min-height: 6rem; max-height: 14rem; background-color: #211e1e21;"
                            wire:model.lazy='log_message'></textarea>
                    </div>
                </div>
            @else
                <div class="pb-3 col-12">
                    <h6 class="my-3 text-center">Sem chamado em atendimento</h6>
                </div>
            @endif
        </div>

        <div class="border col-2 d-flex justify-content-center" style="height: 14rem;">
            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                <button class="my-1 rounded btn btn-secondary" wire:click="pauseCurrent()"
                    {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }} type="button">
                    Pausar
                </button>
                <button type="button" class="my-1 rounded btn btn-info">Compartilhar</button>
                <button class="my-1 rounded btn btn-warning" {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }}
                    wire:click="tranferirChamado()" type="button">
                    Transferir
                </button>
                <button class="my-1 rounded btn btn-danger" {{-- wire:click="closeCurrent()" --}}
                    wire:click="confirm('Deseja encerrar o chamado?', 'closeCurrent', '')"
                    {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }} type="button">Encerrar</button>
            </div>
        </div>

        <div class="border col-4 table-responsive">
            <h6>Chamados Pausados</h6>
            <table class="table">
                <thead>
                    <tr class="py-0">
                        <th class="py-0 small" scope="col"># | Título</th>
                        <th class="py-0 small" scope="col">Detalhes</th>
                        <th class="py-0 small" scope="col">Pausado em</th>
                        <th class="py-0 small" scope="col">-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chamados_pausados as $chamado_pausado)
                        @php
                            $title = strip_tags(html_entity_decode($chamado_pausado->observacao ?? ''));
                        @endphp
                        <tr class="py-0">
                            <td data-toggle="tooltip" data-html="true"
                                title="{{ \Str::limit(strip_tags(html_entity_decode($chamado_pausado->title)), 200, '...') }}"
                                class="py-0">
                                {{ $chamado_pausado->id }} |
                                {{ \Str::limit(strip_tags(html_entity_decode($chamado_pausado->title)), 15, '...') }}
                            </td>
                            <td class="py-0 small">
                                <button data-toggle="tooltip" data-html="true" title="
                                    {!! $chamado_pausado->unidade ? 'Unidade: ' . $chamado_pausado->unidade->nome : '' !!}
                                    {{ $chamado_pausado->paused_at ? 'Pausado em: ' . $chamado_pausado->paused_at->format('d/m/Y H:i:s') : '' }}
                                    " class="py-0 rounded-circle btn btn-sm btn-outline-info">!</button>
                            </td>
                            <td data-toggle="tooltip" data-html="true"
                                title="{{ $chamado_pausado->paused_at ? $chamado_pausado->paused_at->format('d/m/Y H:i:s') : '' }}"
                                class="py-0">
                                {{ $chamado_pausado->paused_at ? $chamado_pausado->paused_at->format('d/m H:i') : '' }}
                            </td>
                            <td class="py-0">
                                <button class="p-0 px-1 btn btn-sm btn-success no-focus"
                                    wire:click="atenderChamado({{ $chamado_pausado->id }})" type="button">
                                    Reabrir
                                </button>
                                <button class="p-0 px-1 btn btn-sm btn-warning no-focus">Transferir</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <script>
        function makeSelectItem(transferencia_para, options_data)
        {
            if(!window.isJson)
                return;

            if(!isJson(options_data))
                return;

            options_data = JSON.parse(options_data);

            console.log('aqui', typeof options_data, isJson(options_data), options_data);

            if(options_data.title)
                document.querySelectorAll('[transfer_target="title"]').forEach(function (el){
                    el.innerText = options_data.title;
                });

            if(options_data.label)
                document.querySelectorAll('[transfer_target="label"]').forEach(function (el){
                    el.innerText = options_data.label;
                });

            var select_element = document.querySelector('#option_transferencia_para_id');
            select_element = false;
            if(select_element && options_data.options && options_data.options.length > 0)
            {
                var label = options_data.label ? options_data.label : "Selecione um "+ transferencia_para +" para transferir";
                var _options = `<option value="" transfer_target="label">${label}</option>`;
                options_data.options.forEach(function(item, key){
                    _options = _options + `
                    <option value="${item.id}">${item.label}</option>`;
                })

                select_element.innerHTML = _options;
            }
        }

        function fakeCloseTransferenciaModal()
        {
            if(window.__transferModal && window.__transferModal._element )
            {
                window.__transferModal._element.classList.remove('show');
                window.__transferModal._element.style.display = 'none';
            }

            displayCustomBackdrop(false);
        }

        function fakeOpenTransferenciaModal()
        {
            if(window.__transferModal && window.__transferModal._element )
            {
                window.__transferModal._element.classList.add('show');
                window.__transferModal._element.style.display = 'unset';
            }
        }

        function removeExtraBackDrops(all = false)
        {
            // modal-backdrop fade show
            var backdrops           = document.querySelectorAll('div.modal-backdrop.show');
            var has_opended_modal   = window.__transferModal._element.classList.contains('show');

            if(backdrops.length > 0)
            {
                if(window.__transferModal && window.__transferModal._backdrop)
                {
                    if(has_opended_modal && document.querySelectorAll('div.modal-backdrop.show').length > 1)
                            document.querySelectorAll('div.modal-backdrop.show')[1].remove();

                    if(has_opended_modal == false)
                    {
                        if(document.querySelectorAll('div.modal-backdrop.show').length > 0)
                        {
                            backdrops.forEach(function (el, key){
                                        el.remove();
                            });
                        }

                    }
                }

            }
        }

        function displayCustomBackdrop(show = false)
        {
            show = typeof show == 'boolean' ? show : false;

            var backdrop_princial = document.querySelector('div.backdrop_princial.custom-backdrop');

            if(backdrop_princial)
            {
                if(show)
                    backdrop_princial.style.display = 'unset'
                else
                    backdrop_princial.style.display = 'none'
            }
        }

        function reOpenTransferirChamadoModal(remove_fade = false)
        {
            if(!window.__transferModal)
                return;

            if(window.removeExtraBackDrops)
                removeExtraBackDrops();

            if(window.createAndStartTransferirChamadoModal)
                createAndStartTransferirChamadoModal(remove_fade);
        }

        function createAndStartTransferirChamadoModal(remove_fade = false)
        {
            var modal_options = {
                backdrop: false,
                keyboard: false,
                focus: true,
            };

            window.__transferModalEl = document.getElementById('transferirChamadoModal');

            if(remove_fade)
                window.__transferModalEl.classList.remove('fade');

            window.__transferModalEl.addEventListener('shown.bs.modal', function(event) {

                removeExtraBackDrops(true);

                if(window.__show_logs)
                    console.log('shown');

                displayCustomBackdrop(true);

                if(window.removeExtraBackDrops)
                    removeExtraBackDrops();
            });
            window.__transferModalEl.addEventListener('show.bs.modal', function(event) {
                if(window.__show_logs)
                    console.log('show');

                displayCustomBackdrop(true);

                if(window.removeExtraBackDrops)
                    removeExtraBackDrops();
            });
            window.__transferModalEl.addEventListener('hidden.bs.modal', function(event) {
                if(window.__show_logs)
                    console.log('hidden');

                if(window.removeExtraBackDrops)
                    removeExtraBackDrops();
            });
            window.__transferModalEl.addEventListener('hide.bs.modal', function(event) {
                if(window.__show_logs)
                    console.log('hide');

                    if(window.__transferModal)
                        window.__transferModal.hide();

                // if(window.removeExtraBackDrops)
                //     removeExtraBackDrops();
            });

            window.__transferModal = new bootstrap.Modal(window.__transferModalEl, modal_options);
            displayCustomBackdrop(true);
            window.__transferModal.show();
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            createAndStartTransferirChamadoModal();

            if (window.Livewire)
            {
                Livewire.on('closeModalTransferenciaPorEvent', e => {
                    if(window.__transferModal)
                        fakeCloseTransferenciaModal();

                    removeExtraBackDrops();
                });

                Livewire.on('reOpenModalTransferenciaPorEvent', e => {

                    reOpenTransferirChamadoModal(true)
                });

                Livewire.on('tranferirChamadoEvent', e => {
                    console.log(e.value);
                    createAndStartTransferirChamadoModal();
                });

                Livewire.on('transferenciaPorEvent', e => {
                    console.log('transferencia_para', e.transferencia_para);
                    reOpenTransferirChamadoModal(true);
                    reOpenTransferirChamadoModal(true);

                    if(
                        document.querySelector('#option_transferencia_para_id') &&
                        !document.querySelector('#option_transferencia_para_id').value &&
                        document.querySelector('[selecione_transferencia_para]')
                    )
                        document.querySelector('[selecione_transferencia_para]').setAttribute('selected', '');

                        if(document.querySelector('[is_selected]'))
                            document.querySelector('[is_selected]').setAttribute('selected', '');

                    if(window.hideSelectTransfer)
                        hideSelectTransfer();

                    // if(window.makeSelectItem)//Remover isso? Ainda será usado???
                    //     makeSelectItem(e.transferencia_para, e.options_data)
                });
            }
        });

        function hideSelectTransfer()
        {
            if(document.querySelector('#option_transferencia_para_id'))
                document.querySelector('#option_transferencia_para_id').style.display = 'none';
        }
    </script>

</div>
<x-wire-confirm-alert />
