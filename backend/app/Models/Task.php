<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\Task\TaskPriority;
use App\Enums\Task\TaskStatus;
use App\Traits\HasCompanyScope;

class Task extends Model
{
    use HasFactory, HasCompanyScope;

    protected $fillable = [
        'company_id',
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'priority' => TaskPriority::class,
        'status' => TaskStatus::class,
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
