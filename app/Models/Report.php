<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'type',
        'province',
        'regency',
        'subdistrict',
        'village',
        'voting',
        'views',
        'image',
        'statement'
    ];

    protected $casts = [
        'voting' => 'array',
        'statement' => 'boolean'
    ];

    protected $attributes = [
        'voting' => '[]',
    ];

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function like($userId)
    {
        $voting = $this->voting ?? []; // Ambil nilai voting atau array kosong jika null
        if (!in_array($userId, $voting)) {
            $voting[] = $userId; // Tambahkan userId ke array
            $this->voting = $voting; // Set ulang nilai voting
            $this->save(); // Simpan ke database
        }
    }


    public function unlike($userId)
    {
        $voting = $this->voting ?? []; // Ambil nilai voting atau array kosong jika null

        if (($key = array_search($userId, $voting)) !== false) {
            unset($voting[$key]); // Hapus userId dari array
            $this->voting = array_values($voting); // Reset indeks array
            $this->save(); // Simpan ke database
        }
    }

    public function hasLiked($userId)
    {
        return in_array($userId, $this->voting);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class); // Assuming a report can have many comments
    }

    public function response()
    {
        return $this->hasOne(Response::class); // Assuming each report has one response
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'response_id');
    }
}
