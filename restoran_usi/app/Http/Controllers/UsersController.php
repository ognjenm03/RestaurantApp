<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Models\UserType;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create(Request $request): View
    {
        $userTypes = UserType::all()->pluck('type_name', 'user_type_id')->toArray();

        return view('users.create', compact('userTypes'));
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        // Ručna validacija podataka iz forme
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'user_type_id' => 'required|in:1,2',
        ]);

        // Hash lozinke pre snimanja
        $validated['password'] = bcrypt($validated['password']);

        // Kreiranje korisnika u bazi
        User::create($validated);

        // Flash poruka o uspehu
        $request->session()->flash('success', 'Korisnik je uspešno dodat.');

        // Redirekcija na listu korisnika
        return redirect()->route('users.index');
    }

    public function show(Request $request, User $user): View
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request, User $user): View
    {
         $userTypes = UserType::all()->pluck('type_name', 'user_type_id')->toArray();

        return view('users.edit', compact('user', 'userTypes'));
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'unique:users,username,' . $user->user_id . ',user_id',
            'full_name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
            'user_type_id' => 'required|in:1,2',
        ]);

        // Ako je password unet, hashiraj ga, inače nemoj menjati
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        $request->session()->flash('success', 'Korisnik uspešno izmenjen.');

        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    
}
