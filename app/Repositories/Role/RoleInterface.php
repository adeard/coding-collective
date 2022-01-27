<?php

namespace App\Repositories\Role;

use App\Models\Role;
use Illuminate\Http\Request;

interface RoleInterface {
    public function getAll();
    public function findById($id);
    public function create(Request $request);
    public function update(Request $request, Role $role);
    public function delete(Role $role);
}
