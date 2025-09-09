<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\Task\TaskExportStatus;

class TaskExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'filename',
        'file_path',
        'filters',
        'status',
        'error_message',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'status' => TaskExportStatus::class,
        'filters' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
