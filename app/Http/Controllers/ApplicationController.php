<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


/**
 * APIs to manage applications
 */
class ApplicationController extends Controller
{
    /**
     * Display a listing of applications.
     *
     * Gets a list of applications.
     *
     * @queryParam page_size int Size per page. Defaults to 20. 
     * @queryParam page int Page to view. Example: 1
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->has('plan_type')) {
            $query = Application::whereRelation('plan', 'type', '=', $request->input('plan_type'));
        } else {
            $query = Application::query();
        }

        $applications = $query->orderBy('id', 'ASC')->paginate($request->page_size ?? 20);

        return ApplicationResource::collection($applications);
    }
}
