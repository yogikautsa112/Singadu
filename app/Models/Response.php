<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'user_id',
        'staff_id',
        'response_status',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'response_id');
    }
}
