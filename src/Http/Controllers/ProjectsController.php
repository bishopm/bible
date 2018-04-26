<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\ProjectsRepository;
use Bishopm\Bible\Repositories\IndividualsRepository;
use Auth;
use Bishopm\Bible\Models\Project;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateProjectRequest;
use Bishopm\Bible\Http\Requests\UpdateProjectRequest;

class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $project;
    private $individuals;
    private $user;

    public function __construct(ProjectsRepository $project, IndividualsRepository $individuals)
    {
        $this->project = $project;
        $this->individuals = $individuals;
    }

    public function index()
    {
        $projects = $this->project->all();
        return view('bible::projects.index', compact('projects'));
    }

    public function edit(Project $project)
    {
        $data['project'] = $project;
        $data['individuals'] = $this->individuals->all();
        return view('bible::projects.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        return view('bible::projects.create', $data);
    }

    public function show(Project $project)
    {
        $data['project']=$project;
        return view('bible::projects.show', $data);
    }

    public function store(CreateProjectRequest $request)
    {
        $project=$this->project->create(['description' => $request->description,'reminders' => $request->reminders]);
        $project->individuals()->sync($request->individual_id);
        return redirect()->route('admin.projects.index')
            ->withSuccess('New project added');
    }
    
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $this->project->update($project, ['description' => $request->description,'reminders' => $request->reminders]);
        $project->individuals()->sync($request->individual_id);
        return redirect()->route('admin.projects.index')->withSuccess('Project has been updated');
    }

    public function api_projects($indiv="")
    {
        if ($indiv) {
            return $this->project->allForApi($indiv);
        } else {
            return $this->project->all();
        }
    }

    public function api_project($id)
    {
        return $this->project->findForApi($id);
    }
}
