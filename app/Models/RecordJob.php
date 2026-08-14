<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'applied_at' => 'date',
        ];
    }

    protected function formattedSalary(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->salary ? 'Rp '.number_format($this->salary, 0, ',', '.') : 'Rp 0',
        );
    }
}
