<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Database\Seeders\RolePermissionSeeder;

class RoleController extends Controller
{
    private function enforceViewPermission($perm, $userPerms): array
    {
        // any non-view requires view for that resource
        $byResource = [];
        foreach ($userPerms as $p) {
            [$res,$act] = explode('.', $p, 2);
            $byResource[$res][] = $act;
        }
        $expanded = $userPerms;
        foreach ($byResource as $res => $acts) {
            if (count(array_filter($acts, fn($a)=>$a!=='view'))>0 && !in_array("$res.view",$expanded)) {
                $expanded[] = "$res.view";
            }
        }
        return array_values(array_unique($expanded));
    }

    public function index()
    {
        $this->authorize('roles.view');
        $roles = Role::withCount('users')->with('permissions')->orderBy('name')->get();
        $allPerms = RolePermissionSeeder::allPermissions();
        $totalPerms = count($allPerms);
        // count per role
        return view('system.roles.index', compact('roles','totalPerms'));
    }

    public function create()
    {
        $this->authorize('roles.create');
        $groups = config('permissions.groups');
        $actionLabels = config('permissions.action_labels');
        $allActions = array_keys($actionLabels);
        $selected = [];
        return view('system.roles.form', compact('groups','actionLabels','allActions','selected') + ['role'=>null,'isEdit'=>false]);
    }

    public function store(Request $request)
    {
        $this->authorize('roles.create');
        $request->validate([
            'name' => ['required','string','max:255','unique:roles,name'],
            'permissions' => ['nullable','array'],
            'permissions.*' => ['string','exists:permissions,name'],
        ], [
            'name.required'=>'Nama role wajib diisi.',
            'name.unique'=>'Nama role sudah digunakan.',
        ]);

        $perms = $this->enforceViewPermission($request->input('permissions', []), $request->input('permissions', []));

        $role = Role::create(['name'=>$request->input('name'), 'guard_name'=>'web']);
        $role->syncPermissions($perms);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('system.roles')->with('success','Role berhasil disimpan.');
    }

    public function edit(Role $role)
    {
        $this->authorize('roles.update');
        if ($role->name==='Owner' && !auth()->user()->hasRole('Owner')) abort(403);

        $groups = config('permissions.groups');
        $actionLabels = config('permissions.action_labels');
        $allActions = array_keys($actionLabels);
        $selected = $role->permissions->pluck('name')->toArray();
        return view('system.roles.form', compact('groups','actionLabels','allActions','selected','role') + ['isEdit'=>true]);
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('roles.update');
        if ($role->name==='Owner' && !auth()->user()->hasRole('Owner')) abort(403);

        // seeded roles cannot be renamed
        $isSeeded = in_array($role->name, RolePermissionSeeder::SEEDED_ROLES);

        $rules = [
            'permissions' => ['nullable','array'],
            'permissions.*' => ['string','exists:permissions,name'],
        ];
        if (! $isSeeded) {
            $rules['name'] = ['required','string','max:255', Rule::unique('roles','name')->ignore($role->id)];
        } elseif ($request->has('name') && $request->input('name') !== $role->name) {
            return back()->withErrors(['name'=>'Role sistem tidak dapat diganti namanya.'])->withInput();
        }

        $messages = ['name.required'=>'Nama role wajib diisi.','name.unique'=>'Nama role sudah digunakan.'];
        $request->validate($rules, $messages);

        if ($role->name==='Owner') {
            // Owner immutable — keep all perms
            return redirect()->route('system.roles')->with('success','Role Owner tidak dapat diubah.');
        }

        $perms = $this->enforceViewPermission($request->input('permissions', []), $request->input('permissions', []));

        if (! $isSeeded && !empty($request->input('name'))) {
            $role->name = $request->input('name');
            $role->save();
        }
        $role->syncPermissions($perms);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('system.roles')->with('success','Role berhasil disimpan.');
    }

    public function destroy(Role $role)
    {
        $this->authorize('roles.update');
        if (in_array($role->name, RolePermissionSeeder::SEEDED_ROLES)) {
            return back()->withErrors(['role'=>'Role sistem tidak dapat dihapus.']);
        }
        if ($role->users()->count() > 0) {
            return back()->withErrors(['role'=>'Role masih digunakan oleh pengguna dan tidak dapat dihapus.']);
        }
        $role->delete();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        return redirect()->route('system.roles')->with('success','Role berhasil dihapus.');
    }
}
