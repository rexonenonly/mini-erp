<?php
namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\StoreUserRequest;
use App\Http\Requests\System\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('users.view');

        $q = $request->input('q');
        $roleFilter = $request->input('role');
        $statusFilter = $request->input('status');

        $users = User::with('roles')
            ->when($q, fn($query) => $query->where(fn($qq) => $qq->where('name','like',"%$q%")->orWhere('email','like',"%$q%")))
            ->when($roleFilter, fn($query) => $query->whereHas('roles', fn($qq) => $qq->where('name', $roleFilter)))
            ->when($statusFilter === 'aktif', fn($query) => $query->where('is_active', true))
            ->when($statusFilter === 'nonaktif', fn($query) => $query->where('is_active', false))
            ->orderBy('name')
            ->paginate(10)->withQueryString();

        $total = User::count();
        $roles = Role::orderBy('name')->pluck('name');

        return view('system.users.index', compact('users','total','roles','q','roleFilter','statusFilter'));
    }

    public function create()
    {
        $this->authorize('users.create');
        $roles = Role::orderBy('name')->get();
        return view('system.users.form', ['user' => new User(['is_active'=>true]), 'roles'=>$roles, 'isEdit'=>false]);
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('users.create');
        $data = $request->validated();

        if ($data['role'] === 'Owner' && ! $request->user()->hasRole('Owner')) {
            abort(403, 'Hanya Owner yang dapat menetapkan role Owner.');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'is_active' => $request->boolean('is_active', true),
        ]);
        $user->syncRoles([$data['role']]);

        return redirect()->route('system.users')->with('success', 'Pengguna berhasil disimpan.');
    }

    public function edit(User $user)
    {
        $this->authorize('users.update');
        $roles = Role::orderBy('name')->get();
        return view('system.users.form', ['user'=>$user->load('roles'), 'roles'=>$roles, 'isEdit'=>true]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('users.update');
        $data = $request->validated();
        $actor = $request->user();

        // rule 1: cannot change own role
        if ($actor->id === $user->id && $data['role'] !== $user->getRoleNames()->first()) {
            return back()->withErrors(['role'=>'Anda tidak dapat mengubah role akun sendiri.'])->withInput();
        }

        // rule 3: only Owner can assign Owner or edit Owner users
        $targetIsOwner = $user->hasRole('Owner');
        $wantsOwner = $data['role'] === 'Owner';
        if (($targetIsOwner || $wantsOwner) && ! $actor->hasRole('Owner')) {
            abort(403, 'Hanya Owner yang dapat mengubah pengguna Owner.');
        }

        // rule 2: last active Owner cannot be moved
        if ($targetIsOwner && $data['role'] !== 'Owner') {
            $activeOwners = User::where('is_active', true)->whereHas('roles', fn($q)=>$q->where('name','Owner'))->count();
            if ($activeOwners <= 1) {
                return back()->withErrors(['role'=>'Tidak dapat memindahkan Owner terakhir ke role lain.'])->withInput();
            }
        }

        // rule on is_active change via form
        $wantsInactive = ! $request->boolean('is_active', true);
        if ($wantsInactive) {
            if ($actor->id === $user->id) {
                return back()->withErrors(['is_active'=>'Anda tidak dapat menonaktifkan akun sendiri.'])->withInput();
            }
            if ($targetIsOwner) {
                if (! $actor->hasRole('Owner')) abort(403);
                $activeOwners = User::where('is_active', true)->whereHas('roles', fn($q)=>$q->where('name','Owner'))->count();
                if ($activeOwners <= 1) {
                    return back()->withErrors(['is_active'=>'Tidak dapat menonaktifkan Owner terakhir.'])->withInput();
                }
            }
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }
        $user->is_active = $request->boolean('is_active', true);
        $user->save();
        $user->syncRoles([$data['role']]);

        return redirect()->route('system.users')->with('success', 'Pengguna berhasil disimpan.');
    }

    public function toggleStatus(Request $request, User $user)
    {
        $this->authorize('users.update');
        $actor = $request->user();

        if ($actor->id === $user->id) {
            return back()->withErrors(['status'=>'Anda tidak dapat menonaktifkan akun sendiri.']);
        }
        $targetIsOwner = $user->hasRole('Owner');
        if ($targetIsOwner && ! $actor->hasRole('Owner')) {
            abort(403);
        }
        if ($user->is_active) {
            if ($targetIsOwner) {
                $activeOwners = User::where('is_active', true)->whereHas('roles', fn($q)=>$q->where('name','Owner'))->count();
                if ($activeOwners <= 1) {
                    return back()->withErrors(['status'=>'Tidak dapat menonaktifkan Owner terakhir.']);
                }
            }
            $user->update(['is_active'=>false]);
        } else {
            $user->update(['is_active'=>true]);
        }
        return back()->with('success', 'Status pengguna diperbarui.');
    }
}
