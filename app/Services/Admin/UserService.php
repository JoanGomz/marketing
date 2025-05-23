<?php

namespace App\Services\Admin;

use App\Contracts\Admin\UserServiceInterface;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function getAllActiveUsers(array $columns = ['*'])
    {
        $query = User::where('active', 1)->with('role')->with('park');

        return $query->get();
    }

    public function createUser(Request $request)
    {
        $request->validate(['name' => 'required', 'email' => 'required|email', 'password' => 'required']);
        $request['password'] = Hash::make($request->password);

        return User::create($request->only(['name', 'email', 'password', 'role_id', 'parks_id']));
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
        $query->with('role');
        $query->with('park');

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
