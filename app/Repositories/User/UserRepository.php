<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserInterface{

    public function logout()
    {
        Auth::user()->token()->revoke();

        return ['message' => 'User log out'];
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:8'
            ]);

            if ($validator->fails()) {
                return response()->json([$validator->errors()], 422);
            }

            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)]
            ));

            return ['message' => 'User created successfully', 'user' => $user];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function profile()
    {
        return Auth::user();
    }

    public function update($request)
    {
        $userId = $request->route('id');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'role_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors(), 422);
        }

        $selectedUser = User::find($userId);
        $selectedUser->name = $request->name;
        $selectedUser->email = $request->email;
        $selectedUser->role_id = $request->role_id;

        if ($selectedUser->save()) {
            return $selectedUser;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fails to save user'
            ]);
        }
    }
}
