<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiAnalyses extends Model
{
    use SoftDeletes;

    protected $table = 'ai_analyses';

    protected $fillable = [
        'type',
        'input_json',
        'output_json',
        'cv_file_path',
        'cv_original_name',
        'model',
        'status',
        'error_message',
    ];

    protected $casts = [
        'input_json' => 'array',
        'output_json' => 'array',
        'deleted_at' => 'datetime',
    ];
}
