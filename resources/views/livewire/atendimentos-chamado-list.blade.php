<div class="row">
    <div class="col-12 border border-1 rounded-1 py-3 my-1">
        @livewire('chamado-list', ['items_by_page' => 5, 'show_action_buttons' => true])
    </div>

    <div class="col-12 border border-1 rounded-1 py-0 my-1" id="detalhes_do_chamado">
        <div class="row">
            <div class="col-12 col-md-6 px-0" style="min-height: 50vh;">
                <div class="row">
                    <div class="col-12">
                        <nav class="navbar navbar-expand navbar-dark bg-primary py-1">
                            <div class="container-fluid d-flex justify-content-center">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-primary dropdown-toggle px-5"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        @lang('Actions')
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark py-0">
                                        <li class="px-1 py-0">
                                            <button
                                                class="rounded btn btn-secondary w-100 px-1 btn-sm my-1"
                                                wire:click="pauseCurrent()"
                                                {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }} type="button"
                                            >
                                                <i class="bi bi-pause-fill"></i>
                                                @lang('Pause')
                                            </button>
                                        </li>

                                        <li class="px-1 py-0">
                                            <button
                                                type="button btn-sm"
                                                class="rounded btn btn-info w-100 px-1 btn-sm my-1"
                                                {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }} type="button"
                                            >
                                                <i class="bi bi-share-fill"></i>
                                                @lang('Share')
                                            </button>
                                        </li>

                                        <li class="px-1 py-0">
                                            <button
                                                class="rounded btn btn-warning w-100 px-1 btn-sm my-1"
                                                wire:click="tranferirChamado()" type="button"
                                                {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }}
                                            >
                                                <i class="bi bi-arrow-left-right"></i>
                                                @lang('Transfer')
                                            </button>
                                        </li>

                                        <li><hr class="dropdown-divider my-0"></li>

                                        <li class="px-1 py-0">
                                            <button
                                                class="rounded btn btn-danger w-100 px-1 btn-sm my-1"
                                                {{-- wire:click="closeCurrent()" --}}
                                                wire:click="confirm('Deseja encerrar o chamado?', 'closeCurrent', '')"
                                                {{ !($this->em_atendimento ?? null) ? 'disabled' : '' }} type="button"
                                            >
                                                <i class="bi bi-clipboard-check"></i>
                                                @lang('Close ticket')
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="row">
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

                                    <div class="row">
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

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4">
                                                    <button class="mt-2 btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalAnexosDoChamado">
                                                        Anexos
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade"
                                                        id="modalAnexosDoChamado"
                                                        data-bs-backdrop="static"
                                                        data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="modalAnexosDoChamadoLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="modalAnexosDoChamadoLabel">
                                                                @lang('Atachments')
                                                            </h5>
                                                            <button type="button"
                                                                class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="@lang('Close')">
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="p-2 my-3 border rounded border-dark w-100">
                                                                    <h6>Anexos {{ $this->em_atendimento->anexos ? '(' . count($this->em_atendimento->anexos) . ')' : '' }}</h6>
                                                                    @if ($this->em_atendimento->anexos)
                                                                        <table class="table table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">#</th>
                                                                                    <th scope="col">Anexo</th>
                                                                                    <th scope="col">Tipo / mime</th>
                                                                                    <th scope="col">Tamanho</th>
                                                                                    <th scope="col">Ações</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($this->em_atendimento->anexos as $index => $anexo)
                                                                                    <tr>
                                                                                        <th scope="row">{{ $index +1 }}</th>
                                                                                        <td>{{ $anexo['name'] ?? null }}</td>
                                                                                        <td>
                                                                                            {{ ($anexo['extension'] ?? null) . ' | ' . ($mime_type = $anexo['mime_type'] ?? null) }}
                                                                                        </td>
                                                                                        <td>{{ humanFileSize($anexo['size'] ?? null) }}</td>
                                                                                        <td>
                                                                                            <a href="{{ asset($anexo['path']) }}" target="_blank" class="btn btn-sm btn-info">Ver</a>
                                                                                            <a href="{{ asset($anexo['path']) }}" target="_blank" download="" class="btn btn-sm btn-info">Baixar</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                @lang('Close')
                                                            </button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-8">
                                                    <div class="input-group input-group-sm mt-2">
                                                        <label class="input-group-text select-none" for="origem_da_ocorrencia">Origem da ocorrência</label>
                                                        <select class="form-select form-select-sm" id="origem_da_ocorrencia" required>
                                                            <option selected disabled>Origem da ocorrência</option>
                                                            @foreach (\App\Enums\OrigemDoProblemaEnum::$humans as $enum => $value)
                                                                <option value="{{ $enum }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                            </ul>
                        </div>

                        <div class="pb-3 col-12">
                            <div class="form-group w-100">
                                <label for="nota_atendimento">Registro do atendimento</label>
                                <textarea id="nota_atendimento"
                                class="mb-3 form-control {{ (!$this->log_message || strlen($this->log_message) < 10) ? 'border border-danger' : '' }}"
                                cols="10" rows="3"
                                    {{ $this->em_atendimento ?? null ? '' : 'disabled' }}
                                    placeholder="Aqui vai sua observação..."
                                    style="min-height: 6rem; max-height: 14rem; background-color: #211e1e21;"
                                    wire:model.lazy='log_message'></textarea>
                            </div>

                            <hr>

                            <h6>Histórico:</h6>
                            <div class="w-100">
                                <div class="accordion" id="accordionChamadoLogs">
                                    @foreach ($this->em_atendimento->logs as $log)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_{{ $log->id }}"
                                                    aria-expanded="{{ $log->id == 1 ? 'true' : 'false' }}"
                                                    aria-controls="collapse_{{ $log->id }}">
                                                    <span class="text-muted px-1">
                                                        {{ \App\Enums\ChamadoLogTypeEnum::getValue($log->type) }}
                                                    </span>
                                                    <span class="text-muted px-1">
                                                        {{ $log->usuario ? $log->usuario ->name : null }}
                                                    </span>
                                                    <span class="text-muted px-1">
                                                        {{ $log->created_at ?? null }}
                                                    </span>
                                                </button>
                                            </h2>
                                            <div id="collapse_{{ $log->id }}"
                                                class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionChamadoLogs">
                                                <div class="accordion-body">
                                                    {!! html_entity_decode($log->content ?? null) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if ($this->em_atendimento && $this->em_atendimento->logs)
                                <div class="w-100 mb-3 p-3 d-flex justify-content-center">
                                    <a href="@route('chamados_show', $this->em_atendimento->id)" class="btn btn-sm btn-outline-secondary">Mais...</a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="pb-3 col-12">
                            <h6 class="my-3 text-center">Sem chamado em atendimento</h6>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-md-6 px-0 border-start table-responsive">
                <h6 class="mb-1 px-1">@lang('Paused tickets')</h6>
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
                                        " class="rounded-circle btn btn-sm btn-outline-info py-0 px-2">!</button>
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
                                    <button
                                        class="p-0 px-1 btn btn-sm btn-warning no-focus"
                                        wire:click="flowTransferirChamado({{ $chamado_pausado->id }})"
                                        {{-- wire:click="$emitTo('atendimentos-chamado-list', 'emmitFlowTransferirChamado', {{ $chamado_pausado->id }})" --}}
                                        type="button">
                                        Transferir
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
            // createAndStartTransferirChamadoModal();//Está aqui [DURANTE O DEV] apenas para já abrir a modal quando carregar a página

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

    <div class="col-12 border border-1 rounded-1 py-3 my-1">
        <!-- Modal -->
        <div class="modal fade" id="transferirChamadoModal" tabindex="-1" aria-labelledby="transferirChamadoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transferirChamadoModalLabel">Transferir chamado</h5>
                        <button type="button" class="btn-close" wire:click="cancelaTranferencia()" aria-label="Close"></button>
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
                                @if ($transferencia_para && $transferencia_para_id && $transferencia_para_nome)
                                Transferir para:
                                <strong> {{ $transferencia_para_nome ?? null}} </strong> ({{ $transferencia_para }})
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
                                <label for="nota_transferencia" class="col-form-label">Registro de atendimento <strong class="text-muted">(leitura)</strong></label>
                                <textarea id="nota_transferencia"
                                    placeholder="Informe um registro de atendimento"
                                    class="form-control {{ (!$this->log_message || !strlen($this->log_message) > 5) ? 'border border-danger' : '' }}"
                                    disabled readonly>{{ $log_message ?? null}}</textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" wire:click="cancelaTranferencia(true)">Cancelar</button>

                        @if ($transferencia_para ?? null)
                            <button type="button" class="btn btn-success" wire:click="concluirTransferencia()">Transferir</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="backdrop_princial custom-backdrop" style="display: none;"></div>
    </div>
</div>
<x-wire-confirm-alert />
