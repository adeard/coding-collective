<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Candidate\CandidateInterface;

class CandidateResumeController extends Controller
{
    public function __construct(CandidateInterface $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function store(Request $request)
    {
        try {
            $result = $this->candidateRepository->updateResume($request);

            return $this->generateResponse($result, 201);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }
}
