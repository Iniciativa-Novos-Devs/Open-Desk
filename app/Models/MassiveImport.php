<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        parent::boot();

        // before delete() method call this
        static::deleting(function ($item) {
            if ($item->file_path && file_exists(storage_path("app/{$item->file_path}"))) {
                unlink(storage_path("app/{$item->file_path}"));
            }
        });
    }
}
