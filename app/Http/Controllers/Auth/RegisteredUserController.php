<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{

    public function index()
    {
        if(Auth::user()->notPermittedTo('view users')) abort(403);

        return Inertia::render('Users', [
            // 'users' => User::with(['roles:id,name'])->withCount('customers')->get(),
            'users' => User::withCount('customers')->with('roles:id,name')->paginate(20),
        ]);
    }


    
    public function UsersList() 
    {
        if(Auth::user()->notPermittedTo('view users')) abort(403);

        $users = User::get(['id', 'name']);
        return $users;
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
        if(Auth::user()->notPermittedTo('edit users') && Auth::user()->id != $user->id) abort(403);

        if($user->isAdmin() && Auth::user()->isNotAdmin()) {
            return back()->with('error', 'Bu işlemi yalnızca admin kullanıcılar yapabilir!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'. $user->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'nullable|integer|min:1',
            'img_url' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'is_active' => 'required|boolean'
        ], [], [
            'name' => 'Ad',
            'email' => 'E-posta',
            'role_id' => 'Rol',
            'img_url' => 'Resim',
            'password' => 'Şifre',
        ]);

        
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // kullanıcı kendi kendini disaktif edemez
        if(Auth::user()->id != $user->id)
            $userData['is_active'] = $request->is_active;
        
        if($request->password)
            $userData['password'] = Hash::make($request->password);
        

        if($request->img_url) {
            $image_path = $this->setImage($request);
            $userData['img_url'] = $image_path;
            
            User::removeOldPic($user);
            // Storage::disk('public')->delete(str_replace('/storage/', '', $obj->img_url));
        }

        $user->update($userData);
        $this->syncRoleIfApplicable($request, $user);
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
        if(!FacadesRequest::is('register')) {
            if(Auth::user()->notPermittedTo('edit users')) abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'nullable|integer|min:1',
            'img_url' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:2048',
            'is_active' => 'nullable|boolean'
        ], [], [
            'name' => 'Ad',
            'email' => 'E-posta',
            'role_id' => 'Rol',
            'img_url' => 'Resim',
            'password' => 'Şifre',
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

        $this->syncRoleIfApplicable($request, $user);

        event(new Registered($user));

        if(FacadesRequest::is('register')) {
            Auth::login($user);
            return redirect(RouteServiceProvider::HOME);
        }

        return Redirect::back();
    }



    // süper admin kullanıcısı seed edilecek ve atanacak. Sonradan bu rol atanamaz
    private function syncRoleIfApplicable(Request $request, User $user)
    {
        if(!$request->role_id) return;
        $requestRole = Role::find($request->role_id);
        if($requestRole->name != 'super admin') {
            $user->syncRoles($request->role_id);
        }
    }



    public function destroy(User $user)
    {
        if(Auth::user()->notPermittedTo('edit users')) abort(403);

        if($user->id == Auth::user()->id) {
            return back()->with('error', 'Kendi kendinizi silemezsiniz!');
        }

        if($user->isAdmin() && Auth::user()->isNotAdmin()) {
            return back()->with('error', 'Admin kullanıcıları yalnızca adminler siler!');
        }

        if($user->isLastAdmin())
            return back()->with('error', 'Sistemde kayıtlı son admin kullanıcı silinemez!');
            
        $user->delete();
        // $user->roles()->detach();
        return Redirect::back();
    }



    private function setImage(Request $request)
    {
        if ($request->hasFile('img_url')) {
            return $request->img_url->store('images/users', 'public');
        }
    }
}
