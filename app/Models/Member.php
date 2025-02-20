<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'member_projects')
                    ->withPivot('assigned_at');
    }
}
