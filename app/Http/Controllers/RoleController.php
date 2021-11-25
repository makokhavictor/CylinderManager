<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index() {
        $roles = new Role();
        if (\request()->boolean('isSelfRegistrable')) {
            $roles = $roles->where('is_self_registrable', true);
        }

        return new RoleCollection($roles->paginate());
    }
}
