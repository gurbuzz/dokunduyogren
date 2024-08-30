<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class AdminController extends Controller
{
    // Kullanıcıların listelendiği sayfa
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.index', compact('users'));
    }

    // Kullanıcı düzenleme sayfası
    public function edit(User $user)
    {
        $roles = Role::all(); // Tüm rolleri al
        return view('admin.edit', compact('user', 'roles'));
    }

    // Kullanıcı güncelleme işlemi
    public function update(Request $request, User $user)
    {
        $user->syncRoles($request->roles); // Kullanıcının rollerini güncelle
        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı rolleri başarıyla güncellendi.');
    }

    // Kullanıcı silme işlemi
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }
}
