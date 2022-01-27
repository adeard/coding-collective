<?php
namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\Role\RoleInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleRepository implements RoleInterface{

    protected $role;

    public function __construct(Role $role)
	{
        $this->role = $role;
    }

    public function getAll()
    {
        return $this->role->get();
    }

    public function findById($id)
    {
        return $this->role->find($id);
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors(), 422);
        }

        $role = new Role();
        $role->name = $request->name;

        return $role->save();
    }

    public function update($request, $todo)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors(), 422);
        }

        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;

        if ($this->user->todos()->save($todo)) {
            return response()->json([
                'status' => true,
                'todo' => $todo
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fails to save todo'
            ]);
        }
    }

    public function delete($todo)
    {
        if ($todo->delete()) {
            return response()->json([
                'status' => true,
                'todo' => $todo
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Fails to save todo'
            ]);
        }
    }
}
