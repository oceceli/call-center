<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        if(Auth::user()->notPermittedTo('view roles')) abort(403);
        
        $roles = Role::allExceptUntouchables();
        return Inertia::render('Roles', [
            'roles' => $roles,
        ]);
    }

    
    public function store(Request $request)
    {
        if(Auth::user()->notPermittedTo('edit roles')) abort(403);


        $data = $this->validatedData($request);
        $role = Role::create($data);

        $this->setPermissions($request, $role);

        return Redirect::back();
    }


    public function update(Request $request, Role $role)
    {
        if(Auth::user()->notPermittedTo('edit roles')) abort(403);

        if(in_array(strtolower($role->name), Role::$untouchables))
            return redirect()->back();

        $data = $this->validatedData($request, $role->id);
        $role->update($data);
        $this->setPermissions($request, $role);
        return Redirect::back();
    }


    private function setPermissions(Request $request, Role $role)
    {
        if(Auth::user()->notPermittedTo('edit roles')) abort(403);

        $selectedPerms = $request->selectedPerms;

        if ($selectedPerms) {
            // izin atamadan önce gönderdiğim izinlerle gelen izinler aynı mı diye bi bakıyorum, aynı olanları kabul ediyorum. nolur nolmaz 
            if (is_array($selectedPerms) && count($selectedPerms) > 0) {
                $availablePerms = array_column(Role::getAvailablePerms(), 'value');
                $acceptablePerms = array_intersect($availablePerms, $selectedPerms);
                $role->syncPermissions($acceptablePerms);
            }
        } else {
            $role->permissions()->detach();
        }
    }


    public function destroy(Role $role)
    {
        if(Auth::user()->notPermittedTo('edit roles')) abort(403);

        if(in_array(strtolower($role->name), Role::$untouchables))
            return Redirect::back();
            // return Redirect::back()->with('error', 'Admin rolü silinemez!');

        $role->permissions()->detach();
        $role->delete();
        return Redirect::back();
        // return Redirect::back()->with('success', 'Rol kaldırıldı...');
    }


    public function availablePerms()
    {
        if(Auth::user()->notPermittedTo('view roles')) return;

        return Role::getAvailablePerms();
    }
    

    public function availableRoles()
    {
        if(Auth::user()->notPermittedTo('view roles')) return;

        return Role::all();
    }


    private function validatedData(Request $request, $roleId = null)
    {
        return $request->validate([
            'name' => 'required|unique:roles,name,' . $roleId . '|max:255',
        ], [], ['name' => 'Rol']);
    }
}
