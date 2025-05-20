<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function validatePermission($permission, $action = '')
    {
        // if (!env('VALIDATE_PERMISSION')) {
        //     return;
        // }

        // $permissionAction = $permission . ($action ? '.' . $action : '');
        // if (!auth()->user()->can($permissionAction)) {
        //     abort(404);
        // }
    }

    public function responseLivewire($status = 'success', $message, $data = [])
    {
        return [
            'status' => $status,
            'message' => $message ?? 'success',
            'data' => $data
        ];
    }
}
