<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MassiveImport
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $file_path
 * @property string $importer_class
 * @property string $start_class_method
 * @property string|null $started_at
 * @property string|null $finished_at
 * @property string|null $report_file
 * @property bool|null $success
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport query()
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereImporterClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereReportFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereStartClassMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MassiveImport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MassiveImport extends Model
{
    use HasFactory;

    protected $table = 'hd_massive_imports';

    protected $casts = [
        'success' => 'boolean',
    ];

    protected $fillable = [
        'file_path',
        'importer_class',
        'start_class_method',
        'started_at',
        'finished_at',
        'report_file',
        'success',
    ];

    public static function boot()
    {
        parent::boot(); // Colocar isso em um listener de model

        // before delete() method call this
        static::deleting(function ($item) {
            if ($item->file_path && file_exists(storage_path("app/{$item->file_path}"))) {
                unlink(storage_path("app/{$item->file_path}"));
            }
        });
    }
}
