<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function edit_user(Request $req, $id)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if (!User::find($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'user_id' => $id,
            ]);
        }

        $user = User::where('id', $id)->update([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function get_users($id = null)
    {
        if ($id) {
            return response()->json([
                'status' => 'success',
                'message' => 'user by id',
                'user' => User::find($id),
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'list of all users',
                'users' => User::get(),
            ]);
        }
    }

    public function delete_user($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'User_id' => $id,
            ]);
        }
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'user deleted',
            'user' => $user,
        ]);
    }
}
