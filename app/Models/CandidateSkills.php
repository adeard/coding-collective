<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Candidate;

class CandidateSkills extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'name'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'id', 'candidate_id');
    }
}
