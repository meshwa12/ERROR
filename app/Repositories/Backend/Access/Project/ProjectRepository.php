<?php

namespace App\Repositories\Backend\Access\Project;
namespace App\Repositories;

use App\Events\Backend\Access\Project\ProjectCreated;
use App\Events\Backend\Access\Project\ProjectDeactivated;
use App\Events\Backend\Access\Project\ProjectDeleted;
use App\Events\Backend\Access\Project\ProjectPermanentlyDeleted;
use App\Events\Backend\Access\Project\ProjectReactivated;
use App\Events\Backend\Access\Project\ProjectRestored;
use App\Events\Backend\Access\Project\ProjectUpdated;
use App\Exceptions\GeneralException;
use App\Models\Access\Project\Project;
use App\Notifications\Frontend\Auth\ProjectNeedsConfirmation;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository.
 */
class ProjectRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Project::class;

    /**
     * @var User Model
     */
    protected $model;


    /**
     * @param RoleRepository $role
     */
    public function __construct(User $model)
    {
        $this->model = $model;
        
    }

    /**
     * @param int  $status
     * @param bool $trashed
     *
     * @return mixed
     */
    public function getForDataTable($status = 1, $trashed = false)
    {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
        $dataTableQuery = $this->query()
            ->leftJoin('project', 'project.id', '=', 'users.id')
            ->leftJoin('technology', 'technology.tech_id', '=', 'project.tech_id')
            ->select([
                config('access.project_table').'.id',
                config('access.project_table').'.project_name',
                config('access.project_table').'.project_details',
                config('access.project_table').'.file',
                config('access.project_table').'.created_at',
                config('access.project_table').'.updated_at',
                config('access.project_table').'.deleted_at',
                DB::raw('GROUP_CONCAT(technology.name) as technology'),
            ])
            ->groupBy('project.id');

        if ($trashed == 'true') {
            return $dataTableQuery->onlyTrashed();
        }

        // active() is a scope on the UserScope trait
        return $dataTableQuery->active($status);
    }

}
