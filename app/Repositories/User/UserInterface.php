<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserInterface {
    public function register(Request $request);
    public function profile();
    public function update(Request $request);
    public function logout();
}
