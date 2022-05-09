<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{

    public function index()
    {
        return Inertia::render('Users', [
            // 'users' => cache()->rememberForever('users', function() {
            'users' => User::all(),
            // })
        ]);
    }

    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }


    public function update(Request $request, User $user)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'. $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'img_url' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        if($request->password)
            $userData['password'] = Hash::make($request->password);
        

        if($request->img_url) {
            $image_path = $this->setImage($request);
            $userData['img_url'] = $image_path;
        }

        if($request->is_active) {
            $userData['is_active'] = $request->is_active;
        }


        $user->update($userData);

        return Redirect::back();
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'img_url' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'is_active' => 'nullable|boolean'
        ]);
        
        
        $image_path = '';
        if ($request->hasFile('img_url')) {
            $image_path = $request->img_url->store('images/users', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img_url' => $image_path,
            'is_active' => $request->is_active,
        ]);

        event(new Registered($user)); // !!!!!!! burayı unutma

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return Redirect::back();
    }


    private function setImage(Request $request){
        if ($request->hasFile('img_url')) {
            return $request->img_url->store('images/users', 'public');
        }
    }
}
