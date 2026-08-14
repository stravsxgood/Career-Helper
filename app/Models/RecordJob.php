<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class RecordJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'applied_at',
        'platform',
        'company_name',
        'position',
        'status',
        'salary',
        'job_url',
        'notes',
    ];

    protected $casts = [
        'applied_at' => 'date',
    ];

    /**
     * Accessor untuk mengubah nilai salary menjadi format Rupiah.
     * Dipanggil dengan: $recordJob->formatted_salary
     */
    protected function formattedSalary(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->salary ? 'Rp ' . number_format($this->salary, 0, ',', '.') : 'Rp 0'
        );
    }
}
