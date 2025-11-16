<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
public function profile()
{
    $user = User::findOrFail(Auth::id());

    return view('profile', compact('user'));
}

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Username berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        // Simpan password baru
        $user = User::findOrFail(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function destroy()
    {
        $user = User::findOrFail(Auth::id());
        Auth::logout();

        $user->delete();

        return redirect('/')->with('success', 'Akun anda telah dihapus.');
    }
}
