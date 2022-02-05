<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MassiveImport extends Model
{
    use HasFactory;

    protected $table     = 'hd_massive_imports';

    protected $casts        = [
        'success' => 'boolean',
    ];

    protected $fillable     = [
        'file_path',
        'importer_class',
        'start_class_method',
        'started_at',
        'finished_at',
        'report_file',
        'success',
    ];
}
