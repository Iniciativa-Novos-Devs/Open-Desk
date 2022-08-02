<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Chamado;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Str;

class ChamadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = Usuario::select('id')->limit(5)->get()->pluck('id');

        if (! $usuarios->toArray()) {
            echo 'Sem usuários cadastrados';

            return null;
        }

        $atendentes = Usuario::select('id')->role('atendente')->limit(5)->get()->pluck('id');

        if (! $atendentes) {
            echo 'Sem atendente cadastrados';

            return null;
        }

        $problemas = \App\Models\TipoProblema::select('id')->limit(5)->get()->pluck('id');

        if (! $problemas) {
            echo 'Sem problemas cadastrados';

            return null;
        }

        $chamado_data = [
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
            'tipo_problema_id' => null,
            'problema_id' => $problemas->random(),
            'usuario_id' => $usuarios->random(),
            'anexos' => null,
            'status' => 1,
            'versao' => '1',
            'unidade_id' => null,
            'atendente_id' => null,
            'paused_at' => null,
            'finished_at' => null,
            'transferred_at' => null,
            'conclusion' => null,
            'area_id' => null,
            'homologado_por' => null,
            'homologado_em' => null,
            'homologacao_avaliacao' => null,
            'homologacao_observacao_fim' => null,
            'homologacao_observacao_back' => null,
        ];

        // Abertos
        foreach (range(1, 10) as $_i) {
            $chamado_data['observacao'] = '&lt;p&gt;'.'Observação do chamado '.Str::random(10).'&lt;/p&gt;';
            $chamado_data['title'] = 'Titulo do chamado '.Str::random(10);
            $chamado_data['status'] = StatusEnum::ABERTO;
            Chamado::create($chamado_data);
        }

        // Em atendimento
        foreach (range(1, 10) as $_i) {
            $chamado_data['observacao'] = '&lt;p&gt;'.'Observação do chamado '.Str::random(10).'&lt;/p&gt;';
            $chamado_data['title'] = 'Titulo do chamado '.Str::random(10);
            $chamado_data['status'] = StatusEnum::EM_ATENDIMENTO;
            Chamado::create($chamado_data);
        }

        if (! $atendentes) {
            print_r("Não foi possível encontrar o perfil de atendente para criar chamados.\n");

            return;
        }

        $chamado_data['atendente_id'] = $atendentes->random();
        $chamado_data['finished_at'] = now();

        // Em homologação
        foreach (range(1, 10) as $_i) {
            $chamado_data['observacao'] = '&lt;p&gt;'.'Observação do chamado '.Str::random(10).'&lt;/p&gt;';
            $chamado_data['title'] = 'Titulo do chamado '.Str::random(10);
            $chamado_data['status'] = StatusEnum::EM_HOMOLOGACAO;
            Chamado::create($chamado_data);
        }

        // Em homologados
        foreach (range(1, 10) as $_i) {
            $chamado_data['observacao'] = '&lt;p&gt;'.'Observação do chamado '.Str::random(10).'&lt;/p&gt;';
            $chamado_data['title'] = 'Titulo do chamado '.Str::random(10);
            $chamado_data['status'] = StatusEnum::HOMOLOGADO;
            $chamado_data['homologacao_avaliacao'] = rand(1, 5);
            $chamado_data['homologado_por'] = $chamado_data['usuario_id'];
            $chamado_data['homologado_em'] = now();
            $chamado_data['homologacao_observacao_fim'] = Str::random(20);

            Chamado::create($chamado_data);
        }
    }
}
