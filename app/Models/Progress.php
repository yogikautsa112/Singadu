<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $table = 'response_progress'; // Nama tabel di database

    protected $fillable = [
        'response_id',
        'histories',
    ];

    protected $casts = [
        'histories' => 'array', // Otomatis ubah JSON ke array saat diakses
    ];

    public function response()
    {
        return $this->belongsTo(Response::class, 'response_id');
    }
}
