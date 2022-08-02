<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anexo;
use Illuminate\Http\UploadedFile;
use Str;

class AnexoController extends Controller
{
    public static function storeMultiFiles(array $files, string $dir_to_store, array $options = [])
    {
        $new_files = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $new_file = self::storeSingleFile($file, $dir_to_store, $options);

                if ($new_file) {
                    $new_files[] = $new_file;
                }
            }
        }

        return $new_files ?? null;
    }

    public static function storeSingleFile(UploadedFile $file, string $dir_to_store, array $options = [])
    {
        if (strlen($dir_to_store) <= 1) {
            return null;
        }

        if (! $file->isValid()) {
            return null;
        }

        $prefix_name = is_string(($options['prefix_name'] ?? null)) ? ($options['prefix_name'] ?? null) : null;
        $accepted_extensions = is_array(($options['accepted_extensions'] ?? [])) ? ($options['accepted_extensions'] ?? []) : [];

        $original_name = $file->getClientOriginalName();
        $mime_type = $file->getMimeType();
        $size = $file->getSize();
        $original_extension = $file->getClientOriginalExtension();
        $original_name = str_replace('.'.$original_extension, '', $original_name);

        if ($accepted_extensions && ! in_array($original_extension, $accepted_extensions)) {
            return null;
        }

        $rand_number = '_'.rand(10, 1000).time().'_';
        $new_name = Str::slug($prefix_name.' '.$rand_number.$original_name).($original_extension ? '.'.$original_extension : '');
        $path = $file->storeAs($dir_to_store, $new_name);

        if ($path) {
            $options_to_store_on_db = [
                'size' => $size,
                'name' => $original_name ?? $new_name,
                'mime_type' => $mime_type,
                'extension' => $original_extension,
            ];

            $options_to_store_on_db = array_merge($options_to_store_on_db, $options);

            $on_data_base = self::storeOnDataBase($path, $options_to_store_on_db);

            if (! $on_data_base) {
                unlink($path);
            }

            return $on_data_base ?? null;
        }
    }

    public static function storeOnDataBase(string $file_path, array $options = [])
    {
        if (strlen($file_path) <= 1) {
            return null;
        }

        $anexo['extension'] = $options['extension'] ?? null;
        $anexo['mime_type'] = $options['mime_type'] ?? null;
        $anexo['restrito_a_grupos'] = $options['restrito_a_grupos'] ?? null;
        $anexo['restrito_a_usuarios'] = $options['restrito_a_usuarios'] ?? null;
        $anexo['temporario'] = $options['temporario'] ?? false;
        $anexo['destruir_apos'] = $options['destruir_apos'] ?? null;
        $anexo['created_by_id'] = $options['created_by_id'] ?? null;
        $anexo['size'] = $options['size'] ?? null;
        $anexo['name'] = $options['name'] ?? null;
        $anexo['path'] = $file_path;

        $novo_anexo = Anexo::updateOrCreate([
            'path' => $anexo['path'],
        ], $anexo);

        if ($novo_anexo) {
            return $novo_anexo;
        }

        return null;
    }
}
