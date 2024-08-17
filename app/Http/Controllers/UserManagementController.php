<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;

        if (!empty($request->search)) {
            $users = User::filter()->orderBy('id', 'desc')->paginate($perPage);
            $users->appends(['search' => $request->search]);
        } else {
            $users = User::orderBy('id', 'desc')->paginate($perPage);
        }
        $users->load('roles');
        $users->appends(['perPage' => $perPage]);

        return view('dashboard.user-management.index', [
            'users' => $users,
            'roles' => Role::all(),
            'role' => 'All',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $user = $user->load('roles');

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|string|exists:roles,id',
        ]);

        $validatedData = $validator->validated();

        $role = Role::findOrFail($validatedData['role']);
        $user = User::findOrFail($id);
        $user->syncRoles($role);

        return redirect()->back()->with('success', 'Role "' . $user->name . '" has been updated to "' . $role->name . '".');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User "' .  $user->name . '" has been deleted.');
    }

    /**
     * Get users by role.
     */
    public function getUsersByRole($role, Request $request)
    {
        $perPage = is_numeric($request->perPage) ? $request->perPage :  10;

        // Periksa apakah role yang diberikan ada
        if (!Role::where('name', $role)->exists()) {
            abort(404);
        }

        if (!empty($request->search)) {
            $users = User::role($role)->filter()->orderBy('id', 'desc')->paginate($perPage);
            $users->appends(['search' => $request->search]);
        } else {
            $users = User::role($role)->orderBy('id', 'desc')->paginate($perPage);
        }
        $users->load('roles');
        $users->appends(['perPage' => $perPage]);

        return view('dashboard.user-management.index', [
            'users' => $users,
            'roles' => Role::all(),
            'role' => $role,
        ]);
    }
}
