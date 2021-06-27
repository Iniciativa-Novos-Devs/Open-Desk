<div class="row">
    @if (env('APP_DEBUG', false))
        <div class="col-12">
            <h6>Preferencias do usuario</h6>
            <pre>
                {{ json_encode(session()->get('user_preferences', ''), 128) }}
            </pre>
        </div>
    @endif

    <div class="col-12">
        <a href="{{ route('chamados_add') }}">Adicionar chamado</a>
    </div>

    <div class="py-2 accordion col-12" id="accordion_chamados_table">
        <div class="accordion-item">
            <h2 class="accordion-header" id="chamados_table_headingThree">
                <button class="accordion-button {{ $keep_accordion_open ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse_chamados_table" aria-expanded="{{ $keep_accordion_open ? 'true' : 'false' }}"
                    aria-controls="collapse_chamados_table">
                    Lista de chamados
                </button>
            </h2>
            <div id="collapse_chamados_table" class="accordion-collapse collapse {{ $keep_accordion_open ? 'show' : '' }}"
                aria-labelledby="chamados_table_headingThree" data-bs-parent="#accordion_chamados_table" style="">
                <div class="accordion-body row">
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="keep_accordion_open">Manter aberto</label>
                            <input class="form-check-input" type="checkbox" id="keep_accordion_open"
                                wire:change="changeKeepAccordionOpenState()"
                                {{ $keep_accordion_open ? 'checked' : '' }}
                                value="1">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-8">
                                <select class="form-select" aria-label="Default select example"
                                    wire:model="selected_status">
                                    <option value="">Todos os chamados</option>
                                    @foreach (\App\Enums\StatusEnum::$humans as $enum => $status)
                                        <option value="{{ $enum }}">{{ $status }}</option>
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
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('title')">
                                        Observação
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer"
                                        wire:click="changeOrderBy('created_at')">
                                        Criação
                                    </th>
                                    <th scope="col" class="py-0 cursor-pointer" wire:click="changeOrderBy('status')">
                                        Estado
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
                                        <td class="py-0">{{ $chamado->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="py-0">{{ \App\Enums\StatusEnum::getState((int) $chamado->status) }}
                                        </td>
                                        <td class="py-0">
                                            <button class="p-0 px-1 btn btn-sm btn-success no-focus">Atender</button>
                                            <button class="p-0 px-1 btn btn-sm btn-warning no-focus">Transferir</button>
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
            <div class="col-12">
                <ul class="py-0 list-group list-group-flush">
                    <li class="py-0 list-group-item d-flex justify-content-start">
                        <strong>Chamado: </strong><span class="mx-1 text-left text-muted">xxxx</span>
                        <span class="mx-3"></span>
                        <strong>Unidade: </strong><span class="mx-1 text-left text-muted">zzzz</span>
                    </li>
                    <li class="py-0 list-group-item">

                        <div class="w-100">
                            <h6 class="mt-3 text-bold">Detalhes do chamado:</h6>
                            <div class="accordion" id="accordion_detalhe_chamado">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="detalhe_chamado_headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse_detalhe_chamado"
                                            aria-expanded="false" aria-controls="collapse_detalhe_chamado">
                                            Titulo do chamado | Solicitante | <span class="text-muted"> 2021-04-20
                                                10:31:00 </span>
                                        </button>
                                    </h2>
                                    <div id="collapse_detalhe_chamado" class="accordion-collapse collapse"
                                        aria-labelledby="detalhe_chamado_headingThree"
                                        data-bs-parent="#accordion_detalhe_chamado" style="">
                                        <div class="accordion-body">
                                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam amet
                                            impedit pariatur culpa possimus quidem fuga incidunt, cumque praesentium,
                                            dolorum totam repellendus quos in minima, magnam laudantium mollitia.
                                            Consequuntur, enim.
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
                    <label for="nota_atendimento">Observação do atendimento</label>
                    <textarea class="mb-3 form-control" id="nota_atendimento" cols="10" rows="3"
                        placeholder="Aqui vai sua observação..."
                        style="min-height: 6rem; max-height: 14rem; background-color: #211e1e21;"></textarea>
                </div>
            </div>
        </div>

        <div class="border col-2 d-flex justify-content-center" style="height: 14rem;">
            <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                <button type="button" class="my-1 rounded btn btn-secondary">Pausar</button>
                <button type="button" class="my-1 rounded btn btn-info">Compartilhar</button>
                <button type="button" class="my-1 rounded btn btn-warning">Transferir</button>
                <button type="button" class="my-1 rounded btn btn-danger">Encerrar</button>
            </div>
        </div>

        <div class="border col-4 table-responsive">
            <h6>Chamados Pausados</h6>
            <table class="table">
                <thead>
                    <tr class="py-0">
                        <th class="py-0" scope="col">#</th>
                        <th class="py-0" scope="col">Detalhes</th>
                        <th class="py-0" scope="col">Pausado em</th>
                        <th class="py-0" scope="col">-</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="py-0">
                        <th class="py-0" scope="row">xxxxx</th>
                        <td class="py-0">
                            <button data-toggle="tooltip" data-html="true" title="Unidade: xyz. Detal"
                                class="py-0 rounded-circle btn btn-sm btn-outline-info">!</button>
                        </td>
                        <td class="py-0">05/05/2021 10:25</td>
                        <td class="py-0">
                            <button class="p-0 px-1 btn btn-sm btn-success no-focus">Reabrir</button>
                            <button class="p-0 px-1 btn btn-sm btn-warning no-focus">Transferir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
