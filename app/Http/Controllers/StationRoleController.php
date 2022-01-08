<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class StationRoleController extends Controller
{
    /**
     * @param $station
     * @param $stationId
     * @return ModelNotFoundException|AnonymousResourceCollection|void
     */
    public function index($station, $stationId )
    {

        if($station === 'depots' || $station === 'transporters' || $station === 'dealers') {
            $className = 'App\\Models\\' . Str::studly(Str::singular($station));
            $model = new $className;
            $stationModel = $model->find($stationId);
            if($stationModel) {
                return RoleResource::collection(Role::find($stationModel->stationRoles->pluck('role_id')));
            } else {
                return new ModelNotFoundException('Invalid Model Id');
            }

        } else {
            abort(404, 'Resource not found');
        }
    }
}
