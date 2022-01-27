<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Role\RoleInterface;

class RoleController extends Controller
{
    public function __construct(RoleInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        try {
            $result = $this->roleRepository->getAll();

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->roleRepository->findById($id);

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function store(Request $request)
    {
        try {
            $result = $this->roleRepository->create($request);

            return $this->generateResponse($result, 201);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $result = $this->roleRepository->update($request, $role);

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }

    public function destroy(Role $role)
    {
        try {
            $result = $this->roleRepository->delete($role);

            return $this->generateResponse($result);
        } catch (\Throwable $th) {
            return $this->generateErrorResponse($th);
        }
    }
}
