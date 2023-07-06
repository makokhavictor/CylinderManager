<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use App\Models\Role;

class RoleController extends Controller
{
    public function index() {
        $roles = new Role();
        return new RoleCollection($roles->paginate());
    }
}
