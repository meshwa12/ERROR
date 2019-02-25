<?php

namespace App\Http\Controllers\Backend\Access\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Project\DeleteProjectRequest;
use App\Http\Requests\Backend\Access\Project\EditProjectRequest;
use App\Http\Requests\Backend\Access\Project\ManageDeactivatedRequest;
use App\Http\Requests\Backend\Access\Project\ManageDeletedRequest;
use App\Models\Access\Project\Project;
use App\Repositories\Backend\Access\Project\ProjectRepository;

/**
 * Class UserStatusController.
 */
class ProjectStatusController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $projects;

    /**
     * @param UserRepository $users
     */
    public function __construct(ProjectRepository $users)
    {
        $this->projects = $projects;
    }

    /**
     * @param ManageDeactivatedRequest $request
     *
     * @return mixed
     */
    public function getDeactivated(ManageDeactivatedRequest $request)
    {
        return view('backend.access.projects.deactivated');
    }

    /**
     * @param ManageDeletedRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageDeletedRequest $request)
    {
        return view('backend.access.projects.deleted');
    }

    /**
     * @param User $user
     * @param $status
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function mark(Project $project, $status, EditProjectRequest $request)
    {
        $this->projects->mark($project, $status);

        return redirect()->route($status == 1 ? 'admin.access.project.index' : 'admin.access.project.deactivated')->withFlashSuccess(trans('alerts.backend.projects.updated'));
    }

    /**
     * @param Project             $deletedProject
     * @param DeleteProjectRequest $request
     *
     * @return mixed
     */
    public function delete(Project $deletedProject, DeleteProjectRequest $request)
    {
        $this->projects->forceDelete($deletedProject);

        return redirect()->route('admin.access.project.deleted')->withFlashSuccess(trans('alerts.backend.projects.deleted_permanently'));
    }

    /**
     * @param User              $deletedUser
     * @param DeleteUserRequest $request
     *
     * @return mixed
     */
    public function restore(Project $deletedProject, DeleteProjectRequest $request)
    {
        $this->projects->restore($deletedProject);

        return redirect()->route('admin.access.project.index')->withFlashSuccess(trans('alerts.backend.projects.restored'));
    }
}
