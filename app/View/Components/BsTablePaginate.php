<?php

namespace App\View\Components;

use Arr;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class BsTablePaginate extends Component
{
    public LengthAwarePaginator $paginated_data;

    public array $columns;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(LengthAwarePaginator $data, array $columns, array $actions = [])
    {
        $this->paginated_data = $data;
        $this->actions = $actions;

        if (! $columns || ! Arr::isAssoc($columns)) {
            throw new \Exception(__('Columns must be an associative array'));
        }

        $this->columns = $columns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.bs-table-paginate');
    }

    /**
     * function actions
     *
     * @param Type type
     * @return
     */
    public function actions(): array
    {
        $actions = $this->actions ?? [
            [
                'label' => __('View'),
                'icon' => 'fas fa-eye',
                'class' => 'btn-primary',
                'route' => 'view',
                'route_params' => ['id' => 'id'],
            ],
            [
                'label' => __('Edit'),
                'icon' => 'fas fa-edit',
                'class' => 'btn-info',
                'route' => 'edit',
                'route_params' => ['id' => 'id'],
            ],
        ];

        return [
            'label' => __('Actions'),

            'actions' => $actions,
        ];
    }
}
