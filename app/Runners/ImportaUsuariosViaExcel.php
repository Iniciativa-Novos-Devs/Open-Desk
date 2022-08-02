<?php

namespace App\Runners;

use App\Models\Area;
use App\Models\AreasUsuario;
use App\Models\Unidade;
use App\Models\Usuario;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ImportaUsuariosViaExcel
{
    /**
     * processFile method
     */
    public static function processFile(string $pathToFile)
    {
        $extension = pathinfo($pathToFile, PATHINFO_EXTENSION);

        if (! $pathToFile || ! in_array($extension, ['csv', 'xlsx'])) {
            return null;
        }

        $requiredHeaders = [
            'email', 'nome', 'area', 'atendente', 'unidade', 'papel', 'cpf',
        ];

        $init = SimpleExcelReader::create($pathToFile)->headersToSnakeCase();

        $headers = $init->getHeaders();

        $valid_data = ($headers == $requiredHeaders);

        $createdUsers = [];
        $init->getRows()
            ->each(function (array $rowProperties) use (&$createdUsers) {
                $usuarioCreation = static::getOrCreateUsuario($rowProperties);
                $usuario = $usuarioCreation['usuario'] ?? null;
                $password = $usuarioCreation['password'] ?? null;

                if (! $usuario) {
                    return;
                }

                $createdUsers[] = [
                    'email' => $usuario->email ?? null,
                    'password' => $password,
                    'date' => date('Y-m-d H:i:s'),
                ];

                if ($rowProperties['area'] && is_string($rowProperties['area'])) {
                    static::insertUsuarionOnArea($usuario->id, $rowProperties['area']);
                }

                if (
                    $rowProperties['atendente'] &&
                    is_string($rowProperties['atendente']) &&
                    in_array(
                        strtolower($rowProperties['atendente']),
                        ['sim', 'yes', '1', 'true']
                    )
                ) {
                    static::assignRole($usuario, 'atendente');
                }

                static::assignRole($usuario, 'usuario');

                if ($rowProperties['papel'] && is_string($rowProperties['papel'])) {
                    static::assignRole($usuario, $rowProperties['papel']);
                }

                if ($rowProperties['unidade'] && is_string($rowProperties['unidade'])) {
                    static::insertUsuarionOnUnidade($usuario, $rowProperties['unidade']);
                }
            });

        $reportFile = static::generateSheet($createdUsers, storage_path(
            'logs/usuarios_cadastrados.xlsx'
        ));

        unlink($pathToFile);

        return [
            'success' => true,
            'report_file' => $reportFile,
        ];
    }

    /**
     * generateSheet method
     */
    public static function generateSheet(array $data, string $outputFilePath)
    {
        $extension = pathinfo($outputFilePath, PATHINFO_EXTENSION);

        if (! $outputFilePath || ! in_array($extension, ['csv', 'xlsx'])) {
            return null;
        }

        SimpleExcelWriter::create($outputFilePath)
            ->addRows($data);
    }

    /**
     * getOrCreateUsuario method
     */
    protected static function getOrCreateUsuario(array $usuarioData, bool $return_error_line = false)
    {
        if (
            ! ($usuarioData['nome'] ?? null) ||
            ! ($usuarioData['email'] ?? null) ||
            ! filter_var($usuarioData['email'], FILTER_VALIDATE_EMAIL)
        ) {
            return $return_error_line ? __FILE__.':'.__LINE__ : false;
        }

        $randPassword = \Str::random(7);
        $ecryptedPassword = \Hash::make($randPassword);

        $usuario = Usuario::where('email', $usuarioData['email'])->first();

        if ($usuario) {
            $usuario->update(['password' => $ecryptedPassword]);

            return [
                'usuario' => $usuario,
                'password' => $randPassword,
            ];
        }

        $usuario = Usuario::create([
            'name' => $usuarioData['nome'] ?? null,
            'email' => $usuarioData['email'] ?? null,
            'telefone_1' => $usuarioData['telefone_1'] ?? null,
            'telefone_1_wa' => $usuarioData['telefone_1_wa'] ?? null,
            'ue' => null,
            'versao' => 'v1',
            'app_admin' => false,
            'email_verified_at' => $usuarioData['email_verified_at'] ?? null,
            'password' => $ecryptedPassword,
        ]);

        if ($usuario) {
            return [
                'usuario' => $usuario,
                'password' => $randPassword,
            ];
        }

        return $return_error_line ? __FILE__.':'.__LINE__ : false;
    }

    /**
     * assignRole method
     */
    protected static function assignRole(Usuario $usuario, string $roleName)
    {
        if (! $roleName) {
            return false;
        }

        $role = \Role::where('name', $roleName)->first();

        if (! $role) {
            return false;
        }

        $usuario->assignRole($role);
    }

    /**
     * insertUsuarionOnArea method
     */
    protected static function insertUsuarionOnArea(int $usuarioId, string $nomeArea)
    {
        if (! $usuarioId || ! $nomeArea) {
            return false;
        }

        $area = Area::where('nome', $nomeArea)->first();

        if (! $area) {
            return false;
        }

        AreasUsuario::create(['usuario_id' => $usuarioId, 'area_id' => $area->id]);
    }

    /**
     * insertUsuarionOnUnidade method
     */
    protected static function insertUsuarionOnUnidade(Usuario $usuario, string $nomeUnidade)
    {
        if (! $usuario || ! $nomeUnidade) {
            return false;
        }

        $unidade = Unidade::where('nome', $nomeUnidade)->first();

        if (! $unidade) {
            return false;
        }

        $usuario->update(['unidade_id' => $unidade->id]);
    }
}
