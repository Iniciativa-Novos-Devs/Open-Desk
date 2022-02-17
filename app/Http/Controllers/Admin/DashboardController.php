<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;

class DashboardController extends Controller
{
    public static function routes()
    {
        Route::get('/dashboard', [self::class, 'index'])->name('dashboard');
    }

    public function index(Request $request)
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
                        'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                        'data' => [69, 59]
                    ],
                    [
                        "label" => "My First dataset",
                        'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
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

        return view('dashboard.index', [
            'charts' => $charts,
        ]);
    }

    /**
     * function fakeChart
     *
     * @return
     */
    public function fakeChart(string $type = 'line')
    {
        return app()->chartjs
            ->name(\Str::random(15))
            ->type($type)
            ->size(['width' => 400, 'height' => 200])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "My First dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 59, 80, 81, 56, 55, 40],
                ],
                [
                    "label" => "My Second dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [12, 33, 44, 44, 55, 23, 40],
                ]
            ])
            ->options([]);
    }
}
