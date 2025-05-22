<?php

namespace App\Services\Admin;

use App\Contracts\Admin\UserServiceInterface;
use App\Models\Operation\CentroComercial;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function getAllActiveUsers(array $columns = ['*'])
    {
        // $query = User::where('active', 1)->with('roles:name')->with('mall'); //todo: check relation
        $query = User::where('active', 1);

        // If the user is not an SuperAdmin, only show users from the same mall
        // if (Auth::check() && !Auth::user()->hasRole('SuperAdmin')) { //todo: pending check
        //     $query = $query->where('id_centro_comercial', Auth::user()->id_centro_comercial);
        // }

        return $query->get();
    }

    public function createUser(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email', 'password' => 'required']);
        $request['password'] = Hash::make($request->password);

        // return User::create($request->only(['name', 'email', 'password', 'id_centro_comercial', 'role_id'])); //todo: check if id_centro_comercial is needed
        return User::create($request->only(['name', 'email', 'password', 'role_id']));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate(['name' => 'required']);
        $user->update($request->all());
        return $user;
    }

    public function deleteUser(User $user)
    {
        $user->active = 0;
        $user->save();
    }

    public function findById(int $id)
    {
        return User::where('id', $id)->where('active', 1)->first();
    }

    /**
     * Retorna los items paginadas
     * @param int $page
     * @param int $items
     * @param string $search
     */
    public function getPaginated($page, $items, $search = '')
    {
        $query = User::query();

        $query->where('active', 1);
        // $query->with('roles:name');
        // $query->with('mall'); //todo: check relation

        // Si el usuario no es SuperAdmin, solo mostrar usuarios del mismo centro comercial
        // if (Auth::check() && !Auth::user()->hasRole('SuperAdmin')) { //todo: pending check
        //     $query->where('id_centro_comercial', Auth::user()->id_centro_comercial);
        // }

        // buscador
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $query->orderBy('id', 'desc');
        return $query->paginate($items, ['*'], 'page', $page);
    }
}
