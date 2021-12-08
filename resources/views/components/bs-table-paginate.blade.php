<table class="table table-responsive">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th>@lang($column)</th>
            @endforeach

            <th>@lang($actions()['label'])</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($paginated_data as $item )
        <tr>

            @foreach ($columns as $key => $column)
                <td scope="row">{{ $item->{$key} ?? null}}</td>
            @endforeach

            <td>
                @foreach ($actions()['actions'] as $action)

                <?php
                    $route_params = [];
                    foreach ($action['route_params'] ?? [] as $attr):
                        $route_params[] = $item->{$attr};
                    endforeach;
                ?>

                @if ($route_params)
                    <a class="btn btn-sm {{ $action['class'] ?? '' }}" href="@route($action['route'], $route_params)">
                        @lang($action['label'] ?? '')
                        <i class="bi {{ $action['icon'] ?? '' }}"></i>
                    </a>
                @else
                    <a class="btn btn-sm {{ $action['class'] ?? '' }}" href="@route($action['route'])">
                        @lang($action['label'] ?? '')
                        <i class="bi {{ $action['icon'] ?? '' }}"></i>
                    </a>
                @endif

                @endforeach
            </td>
        </tr>
        @endforeach

    </tbody>
    <tfoot>
        <tr>
            <td colspan="100%">
                <div class="row m-0 p-0">
                    <div class="col-6 mt-3">
                        {{ $paginated_data->links('pagination::bootstrap-4') }}
                    </div>
                    <div class="col-4 align-middle mt-3">
                        <span class="w-100 align-middle">
                            <strong>
                                {{ $paginated_data->count()  }}
                            </strong>
                            itens do total de
                            <strong>{{ $paginated_data->total() }}</strong>
                        </span>
                    </div>
                    <div class="col-2 mt-3 text-right">

                    </div>
                </div>
            </td>
        </tr>
    </tfoot>
</table>
