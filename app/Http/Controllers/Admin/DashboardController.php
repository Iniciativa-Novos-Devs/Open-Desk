<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\Helpers\ColorGenerator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Route;
use DB;
use Str;
use Auth;

class DashboardController extends Controller
{
    public static function routes()
    {
        Route::get('/dashboard', [self::class, 'index'])->name('dashboard');

        Route::get('/demoCharts', [DemoChartsController::class, 'demoCharts'])->name('demoCharts');
    }

    public function index(Request $request)
    {
        $dataGeral = $this->getProblemas();
        $dataUser  = $this->getProblemas(Auth::user()->id);

        if($dataGeral->count())
        {
            $charts[] = [
                'title' => 'Problemas - Geral',
                'class' => 'col-md-4 col-sm-12',
                'chart' => app()->chartjs
                    ->name('problemas_geral')
                    ->type('pie')
                    ->size(['width' => 400, 'height' => 200])
                    ->labels($dataGeral->pluck('descricao')->all())
                    ->datasets([
                        [
                            'backgroundColor'       => $colors = ColorGenerator::generateArrayOfColors($dataGeral->count()),
                            'hoverBackgroundColor'  => $colors,
                            'data' => $dataGeral->pluck('count')->all()
                        ]
                    ])
                    ->options([])
            ];
        }

        if($dataUser->count())
        {
            $charts[] = [
                'title' => 'Problemas - Usuário',
                'class' => 'col-md-4 col-sm-12',
                'chart' => app()->chartjs
                    ->name('problemas_user')
                    ->type('pie')
                    ->size(['width' => 400, 'height' => 200])
                    ->labels($dataUser->pluck('descricao')->all())
                    ->datasets([
                        [
                            'backgroundColor'       => $colors = ColorGenerator::generateArrayOfColors($dataUser->count()),
                            'hoverBackgroundColor'  => $colors,
                            'data' => $dataUser->pluck('count')->all()
                        ]
                    ])
                    ->options([])
            ];
        }

        return view('dashboard.index', [
            'charts' => $charts ?? [],
        ]);
    }

    /**
     * function getProblemas
     *
     * @param int|null $usuarioId = null
     * @return
     */
    public function getProblemas(int|null $usuarioId = null) :Collection
    {
        $cacheKey = Str::slug('getProblemas_' . $usuarioId);

        $data =  Cache::remember($cacheKey, 60 /*secs*/, function ()  use ($usuarioId) {
            $query = DB::table('hd_chamados as c')
            ->join('hd_problemas as hp', 'c.problema_id', '=', 'hp.id')
            ->select('hp.descricao', 'c.problema_id', DB::raw('COUNT( c.problema_id )'))
            ->groupBy('c.problema_id', 'hp.descricao')
            ->havingRaw('COUNT( c.problema_id )> 1')
            ->orderBy('c.problema_id');

            if($usuarioId)
            {
                $query->where('c.usuario_id', $usuarioId);
            }

            return $query->get();
        });

        if (!$data->count())
        {
            Cache::forget($cacheKey);
            return collect([]);
        }

        return $data;
    }
}
