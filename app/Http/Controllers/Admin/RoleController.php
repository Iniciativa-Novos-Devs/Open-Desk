<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\CacheManagers\RoleCache;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Role;
use Permission;
use Auth;

class RoleController extends Controller
{
    public static function routes()
    {
        Route::prefix('papeis')->group(function () {
            Route::get('/', [self::class, 'index'])->name('roles.index');
            Route::get('/show/{usuario_id}',    [self::class, 'show'])->name('roles.show');
            Route::get('/edit/{usuario_id}',    [self::class, 'edit'])->name('roles.edit');
            Route::get('/delete/{usuario_id}',  [self::class, 'destroy'])->name('roles.delete');
            Route::post('/update/{usuario_id}', [self::class, 'update'])->name('roles.update');
            Route::post('/store',               [self::class, 'store'])->name('roles.store');
        });
    }

    public function __construct()
    {
        $this->middleware(['role:super-admin|admin', 'permission:roles-all|roles-create|roles-read|roles-update|roles-delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $actions = [
            'view' => [
                'label' => __('Show'),
                'icon' => 'bi-eye-fill',
                'class' => 'btn-primary',
                'route' => 'roles.show',
                'route_params' => ['id' => 'id'],
            ],
            'edit' => [
                'label' => __('Edit'),
                'icon' => 'bi-pencil-fill',
                'class' => 'btn-info',
                'route' => 'roles.edit',
                'route_params' => ['id' => 'id'],
            ],
        ];

        return view('admin.roles.index', [
            'roles'  => Role::paginate(10),
            'columns'   => [
                'id' => 'ID',
                'name' => 'Nome',
            ],
            'actions'   => $actions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function show($role_id)
    {
        if (!is_numeric($role_id))
        {
            return redirect()->route('roles.index')->with('error', __('Invalid :item', ['item' => __('Role')]));
        }

        $role = RoleCache::getById((int) $role_id);

        if (!$role)
        {
            return redirect()->route('roles.index')->with('error', __(':item not found', ['item' => __('Role')]));
        }

        $role_permissions   = $role->permissions->pluck('name');
        $permissions        = Permission::select('id', 'name')->get();

        $items = [];
        foreach($permissions as $permission)
        {
            $sufixo = explode('-', $permission->name)[0] ?? null;

            $f_permission = [
                'id' => $permission->id,
                'name' => $permission->name,
                'checked' => $role_permissions->contains($permission->name)
            ];

            if($sufixo)
                $items[$sufixo][] = $f_permission;
            else
                $items[$permission][] = $f_permission;
        }

        return view('admin.roles.show', [
            'role'      => $role,
            'items'     => $items,
            'role_show' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function edit($role_id)
    {
        if (!is_numeric($role_id))
        {
            return redirect()->route('roles.index')->with('error', __('Invalid :item', ['item' => __('Role')]));
        }

        $role = RoleCache::getById((int) $role_id);

        if (!$role)
        {
            return redirect()->route('roles.index')->with('error', __(':item not found', ['item' => __('Role')]));
        }

        $role_permissions   = $role->permissions->pluck('name');
        $permissions        = Permission::select('id', 'name')->get();

        $items = [];
        foreach($permissions as $permission)
        {
            $sufixo = explode('-', $permission->name)[0] ?? null;

            $f_permission = [
                'id' => $permission->id,
                'name' => $permission->name,
                'checked' => $role_permissions->contains($permission->name)
            ];

            if($sufixo)
                $items[$sufixo][] = $f_permission;
            else
                $items[$permission][] = $f_permission;
        }

        return view('admin.roles.form', [
            'role'  => $role,
            'items' => $items,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role_id)
    {
        $role = Role::where('id', $role_id)->first();

        if (!$role)
        {
            return redirect()->route('roles.index')->with('error', __(':item not found', ['item' => __('Role')]));
        }

        $permisssions = $request->input('permissions');

        if($permisssions && is_array($permisssions))
        {
            $permisssions = Permission::whereIn('name', $permisssions)->select('id', 'name')->get();

            $role->syncPermissions($permisssions->pluck('name')->all());
        }

        $saved          = $role->save();

        RoleCache::getById((int) $role_id, true, true);

        if ($saved)
        {
            return redirect()->route('roles.index')->with('success', __(':item updated successfully', ['item' => __('Role')]));
        }

        return redirect()->route('roles.index')->with('error', __(':item not updated', ['item' => __('Role')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $role_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($role_id)
    {
        $role = Usuario::find($role_id);
        if (!$role)
        {
            return redirect()->route('roles.index')->with('error', __('User not found'));
        }

        if($role->hasAnyRole(['admin', 'super-admin']))
            return redirect()->route('roles.index')->with('error', __('Admin user can not be deleted'));

        if (\Auth::user()->id != $role->id)
            return redirect()->route('roles.index')->with('error', __('The logged user can not be deleted'));

        $role->delete();

        return redirect()->route('roles.index')->with('success', __('User deleted successfully'));
    }
}
