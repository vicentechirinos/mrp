<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return $this->responseFormat($users);
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
            'email' => 'required|email|unique|max:150',
            'password' => 'required|string|min:8',
            'status' => 'required|boolean',
            'root' => 'required|boolean',
            'role_id' => 'required|numeric|integer|exists:roles,id'
        ]);

        $user = User::create($validated);

        return $this->responseFormat($user, 'Usuario agregado éxitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->responseFormat($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'string|min:2|max:150',
            'email' => 'email|max:150',
            'password' => 'string|min:8',
            'root' => 'boolean',
            'role_id' => 'numeric|integer|exists:roles,id'
        ]);

        if ($user->isDirty())
            $user->update($validated);

        return $this->responseFormat($user, 'Usuario actualizado éxitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->trashed())
            return $this->responseFormat(true, 'Usuario eliminado éxitosamente');

        return $this->responseFormat(null, 'Ocurrio un error, vuelve a intentarlo nuevamente', 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getParents(User $user)
    {
        $parents = $user->parents();

        return $this->responseFormat($parents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeParent(Request $request, User $user)
    {
        $validated = $request->validate([
            'parent_id' => 'required|numeric|exists:users,id'
        ]);

        $parent = $user->parents()->create([
            'parent_id' => $validated['parent_id'],
        ]);

        return $this->responseFormat($parent, 'Tutor agregado éxitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function getChilds(User $user)
    {
        $childs = $user->childs();

        return $this->responseFormat($childs);
    }
}
