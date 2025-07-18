<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleAssignmentController extends Controller
{
    // Assign a role to a user by ID
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::where('name', $request->role_name)->first();

        // Avoid duplicate roles
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role->id);
        }

        return response()->json([
            'message' => "Role '{$role->name}' assigned to user '{$user->name}'."
        ]);
    }
}
