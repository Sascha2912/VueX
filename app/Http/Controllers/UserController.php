<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function index(){
        $users = User::paginate();

        return Inertia::render('Users/show', ['users' => $users]);
    }

    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        $data = $this->validate($request, User::validationRules());
        $user = $this->userRepository->updateOrCreate($data);

        if($request->expectsJson()){
            return response([
                'user' => $user,
                'success' => true,
            ]);
        }
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function show(Request $request, User $user){
        if($request->expectsJson()){
            return response(['user' => $user,]);
        }

        return Inertia::render('Users/show', ['user' => $user]);
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Profile/Edit', ['user' => $user]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, User::validationRules());
        $user = $this->userRepository->updateOrCreate($data, $user);

        return Inertia::render('User/show', ['user' => $user]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(User $user)
    {
        Auth::logout();
        $user->delete();

        return Redirect::to('/');
    }
}
