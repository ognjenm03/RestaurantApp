<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::all();

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function create(Request $request): View
    {
        return view('user.create');
    }

    public function store(UserStoreRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        /** @var \Illuminate\Session\Store $session */
        $session = $request->session();
        $session->flash('user.id', $user->id);

        return redirect()->route('users.index');    
    }

    public function show(Request $request, User $user): View
    {
        return view('user.show', [
            'user' => $user,
        ]);
    }

    public function edit(Request $request, User $user): View
    {
        return view('user.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        /** @var \Illuminate\Session\Store $session */
        $session = $request->session();
        $session->flash('user.id', $user->id);

        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
