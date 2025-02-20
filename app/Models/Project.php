<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_projects')
                    ->withPivot('assigned_at');
    }
}
