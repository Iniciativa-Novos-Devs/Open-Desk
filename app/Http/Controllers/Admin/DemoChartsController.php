<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\Helpers\ColorGenerator;

class DemoChartsController extends Controller
{

    public function demoCharts(Request $request)
    {
        $charts['line'] = [
            'title' => 'Line Chart',
            'class' => 'col-md-6 col-sm-12',
            'chart' => $this->fakeChart('line')
        ];

        $charts['bar'] = [
            'title' => 'Bar Chart',
            'class' => 'col-md-6 col-sm-12',
            'chart' => app()->chartjs
                ->name('barChartTest')
                ->type('bar')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Label x', 'Label y'])
                ->datasets([
                    [
                        "label" => "My First dataset",
                        'backgroundColor' => $colors = ColorGenerator::generateArrayOfColors(2),
                        'data' => [69, 59]
                    ],
                    [
                        "label" => "My First dataset",
                        'backgroundColor' => $colors,
                        'data' => [65, 12]
                    ]
                ])
                ->options([])
        ];
        $charts['radar'] = [
            'title' => 'Radar Chart',
            'class' => 'col-md-4 col-sm-12',
            'chart' => $this->fakeChart('radar')
        ];

        $charts['pie'] = [
            'title' => 'Pie Chart',
            'class' => 'col-md-4 col-sm-12',
            'chart' => app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Label x', 'Label y'])
                ->datasets([
                    [
                        'backgroundColor' => ['#FF6384', '#36A2EB'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                        'data' => [69, 59]
                    ]
                ])
                ->options([])
        ];

        $charts['doughnut'] = [
            'title' => 'Doughnut Chart',
            'class' => 'col-md-4 col-sm-12',
            'chart' => app()->chartjs
                ->name('doughnutChart')
                ->type('doughnut')
                ->size(['width' => 400, 'height' => 200])
                ->labels(['Label x', 'Label y'])
                ->datasets([
                    [
                        'backgroundColor' => ['#FF6384', '#36A2EB'],
                        'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                        'data' => [69, 59]
                    ]
                ])
                ->options([])
        ];

        return view('dashboard.demo_charts', [
            'charts' => $charts,
        ]);
    }

    /**
     * function fakeChart
     *
     * @return
     */
    protected function fakeChart(string $type = 'line')
    {
        return app()->chartjs
            ->name(\Str::random(15))
            ->type($type)
            ->size(['width' => 400, 'height' => 200])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => $color1 = ColorGenerator::randomColor(),
                    'borderColor' => $color1,
                    "pointBorderColor" => $color1,
                    "pointBackgroundColor" => $color1,
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                ],
                [
                    "label" => "My Second dataset",
                    'backgroundColor' => $color2 = ColorGenerator::randomColor(),
                    'borderColor' => $color2,
                    "pointBorderColor" => $color2,
                    "pointBackgroundColor" => $color2,
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [12, 33, 44, 44, 55, 23, 40],
                ]
            ])
            ->options([]);
    }
}
