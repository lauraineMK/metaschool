<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(['role' => 'required|in:student,teacher,admin']);
        $user->role = $request->role;
        $user->save();
        return redirect()->back()->with('success', 'Rôle mis à jour.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Impossible de supprimer un admin.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }
}
