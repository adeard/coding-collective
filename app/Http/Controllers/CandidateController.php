<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Candidate\CandidateInterface;

class CandidateController extends Controller
{
    public function __construct(CandidateInterface $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function index()
    {
        try {
            $result = $this->candidateRepository->getAll();

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->candidateRepository->findById($id);

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->candidateRepository->create($request);

            return $this->generateResponse($result, 201);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function update(Request $request)
    {
        try {
            $result = $this->candidateRepository->update($request);

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }
}
