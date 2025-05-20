<?php

namespace App\Contracts\Base;

use Illuminate\Http\Request;

interface BaseServiceInterface
{
    public function getAll();
    public function findById(int $id);
    public function create(array $request);
    public function update(array $request, int $id);
    public function delete(int $id);
}
