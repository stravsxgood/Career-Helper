<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiAnalyses extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'input_json' => 'array',
            'output_json' => 'array',
        ];
    }
}
