<?php


namespace App\Http\Controllers\Backend\Access\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Project\CreateProjectRequest;
use App\Http\Requests\Backend\Access\Project\DeleteProjectRequest;
use App\Http\Requests\Backend\Access\Project\EditProjectRequest;
use App\Http\Requests\Backend\Access\Project\ManageProjectRequest;
use App\Http\Requests\Backend\Access\Project\ShowProjectRequest;
use App\Http\Requests\Backend\Access\Project\StoreProjectRequest;
use App\Http\Requests\Backend\Access\Project\UpdateProjectRequest;
use App\Http\Responses\Backend\Access\Project\CreateResponse;
use App\Http\Responses\Backend\Access\Project\EditResponse;
use App\Http\Responses\Backend\Access\Project\ShowResponse;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Project\Project;
//use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\Backend\Access\Project\ProjectRepository;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
       
    }
    public function index()
    {
        $projects=project::find($proj_id);
          return  ViewResponse('backend.access.projects.index')->with('projects',$projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('backend.access.projects.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
