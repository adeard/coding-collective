<?php

namespace App\Repositories\Candidate;

use Illuminate\Http\Request;

interface CandidateInterface {
    public function getAll();
    public function findById($id);
    public function create(Request $request);
    public function update(Request $request);
    public function updateResume(Request $request);
}
