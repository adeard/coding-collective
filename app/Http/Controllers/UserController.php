<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserInterface;

class UserController extends Controller
{
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        try {
            $result = $this->userRepository->register($request);

            return $this->generateResponse($result, 201);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function logout()
    {
        try {
            $result = $this->userRepository->logout();

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function profile()
    {
        try {
            $result = $this->userRepository->profile();

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function update(Request $request)
    {
        try {
            $result = $this->userRepository->update($request);

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }
}
