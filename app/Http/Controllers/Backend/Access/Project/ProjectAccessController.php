<?php

namespace App\Http\Controllers\Backend\Access\Project;

use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Project\ManageProjectRequest;
use App\Models\Access\Project\Project;

/**
 * Class UserAccessController.
 */
class ProjectAccessController extends Controller
{
    /**
     * @param Project              $project
     * @param ManageProjectRequest $request
     *
     * @throws GeneralException
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(Project $project, ManageProjectRequest $request)
    {
        // Overwrite who we're logging in as, if we're already logged in as someone else.
        if (session()->has('admin_project_id') && session()->has('temp_project_id')) {
            // Let's not try to login as ourselves.
            if (access()->id() == $project->id || session()->get('admin_project_id') == $user->id) {
                throw new GeneralException('Do not try to login as yourself.');
            }

            // Overwrite temp user ID.
            session(['temp_user_id' => $user->id]);

            // Login.
            access()->loginUsingId($user->id);

            // Redirect.
            return redirect()->route('frontend.index');
        }

        app()->make(Auth::class)->flushTempSession();

        // Won't break, but don't let them "Login As" themselves
        if (access()->id() == $user->id) {
            throw new GeneralException('Do not try to login as yourself.');
        }

        // Add new session variables
        session(['admin_user_id' => access()->id()]);
        session(['admin_user_name' => access()->user()->first_name]);
        session(['temp_user_id' => $user->id]);

        // Login user
        access()->loginUsingId($user->id);

        // Redirect to frontend
        return redirect()->route('frontend.index');
    }
}
