<?php

namespace App\Http\Controllers\Backend\Access\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Project\ManageUserRequest;
use App\Repositories\Backend\Access\Project\UserRepository;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class UserTableController.
 */
class ProjectTableController extends Controller
{
    /**
     * @var \App\Repositories\Backend\Access\User\UserRepository
     */
    protected $projects;

    /**
     * @param \App\Repositories\Backend\Access\User\UserRepository $users
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
    }

    /**
     * @param \App\Http\Requests\Backend\Access\Project\ManageProjectRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageProjectRequest $request)
    {
        return Datatables::make($this->projects->getForDataTable($request->get('status'), $request->get('trashed')))
            ->escapeColumns(['project_name', 'project_details'])
           /* ->editColumn('', function ($project) {
                return $project->confirmed_label;
            })*/
            
            ->addColumn('created_at', function ($project) {
                return Carbon::parse($project->created_at)->toDateString();
            })
            ->addColumn('updated_at', function ($project) {
                return Carbon::parse($project->updated_at)->toDateString();
            })
            ->addColumn('actions', function ($project) {
                return $project->action_buttons;
            })
            ->make(true);
    }
}
