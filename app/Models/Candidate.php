<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CandidateSkills;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'education',
        'birth_date',
        'experience',
        'last_position',
        'role_id',
        'email',
        'phone',
        'resume',
    ];

    public function candidateSkills()
    {
        return $this->hasMany(CandidateSkills::class, 'candidate_id', 'id');
    }

    public function appliedRoles()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
}
