<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'desc')->get();

        return $this->responseFormat($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:150',
        ]);

        $validated['slug'] = Str::slug($request->name);

        $role = Role::create($validated);

        return $this->responseFormat($role, 'Elemento agregado éxitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->responseFormat($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'string|min:2|max:150',
        ]);

        $validated['slug'] = Str::slug($request->name);

        if ($role->isDirty())
            $role->update($validated);

        return $this->responseFormat($role, 'Elemento actualizado éxitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();

        if ($deleted) return $this->responseFormat(true, 'Elemento eliminado éxitosamente');

        return $this->responseFormat(false, 'Ocurrio un error, vuelva a intentarlo nuevamente', 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function permission(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'numeric|integer|exists:action_modules,id',
        ]);

        $permissions = $role->actionModules()->sync($validated['permissions']);

        return $this->responseFormat($permissions, 'Elemento almacenado éxitosamente');
    }
}
