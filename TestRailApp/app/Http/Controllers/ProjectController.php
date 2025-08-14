<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Controllers\MainController;
use App\ViewModels\WebsiteViewModel;
use App\API\TestRailClient;
use App\Models\Person;
use Illuminate\Http\Request;

class ProjectController extends HomeController
{

    protected $arrNavBarActive;

    /**
     * Dependency inject anything required for this controller's actions.
     * And Intialize variables that are consistently the same on every function of this class
     * ex: arrNavBarActive will always have home as active.
     *
     * @param WebsiteViewModel $websiteViewModel
     * @param TestRailClient $testRailClient
     */
    public function __construct(
        WebsiteViewModel $websiteViewModel,
        TestRailClient $testRailClient
    )
    {
        $arrNavBarActive = array();
        Parent::__construct($websiteViewModel, $testRailClient);

        // Active nav bar set to projects
        $arrNavBarActive['home'] = true;
        $this->arrNavBarActive = $arrNavBarActive;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the details of a single project.
     *
     * @return \Illumina&te\View\View
     * @param int $projectId
     */
    public function showById($projectId)
    {
        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;
        $client = $this->testRailClient;

        // Grabbing the project details for extra information to show up on the page.
        $project = $client->send_get(sprintf('get_project/%d', $projectId));
        $allPlans = array();
        $resultsNotEmpty = true;

        for ($offset = 0; $resultsNotEmpty; $offset += 250) {
            $plans = $client->send_get(sprintf('get_plans/%d&offset=%d', $projectId, $offset));
            if (count($plans) <= 0) {
                $resultsNotEmpty = false;
            }
            $allPlans += $plans;
        }

        // Render the template
        return view('project.details', [
            'viewModel' => $viewModel,
            'navBarActive' => $this->arrNavBarActive,
            'project' => $project,
            'plans' => $allPlans
        ]);
    }

    public function fetchDataFromDatabase() {
    }

    /**
     * Show the details of a single project.
     *
     * @return \Illumina&te\View\View
     * @param  int  $id Should be the projectId
     */
    public function report(Request $request, $projectId)
    {
        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;
        $client = $this->testRailClient;

        // Grabbing the project details for extra information to show up on the page.
        $project = $client->send_get(sprintf('get_project/%d', $projectId));
        $viewModel->titleTag = $project['name'];
        $plans = $client->send_get(sprintf('get_plans/%d', $projectId));

        // echo '<pre>';
        // print_r($plans);
        // echo '</pre>';
        $statuses = $client->send_get('get_statuses');

        $suiteData = $client->send_get(sprintf('get_suites/%d', $projectId));
        $suites = [];

        $people = collect(Person::all());
        $selectedPeople = [];
        $selectedPeople = $request->selectedPeople;

        // Remove inactive from the filter. (multiselect dropdown)
        $peopleFilter = $people->filter(function($person, $key) {
            return ($person['active'] == 1);
        });

        // Reordering by id.
        foreach ($suiteData as $key => $suite) {
            $suite['assignedToName'] = '';
            if (isset($suite['assignedto_id']) && ($suite['assignedto_id'] > 0)) {
                $person =  $people->firstWhere('user_id', '=', $suite['assignedto_id']);
                if (($person != null) && isset($runs[$index]) && isset($runs[$index]['assignedToName'])) {
                    $suite['assignedToName'] = $person->fullName;
                }
            }
            $suites[$suite['id']] = $suite;
        }

        $runs = $client->send_get(sprintf('get_runs/%d', $projectId));

        $allRuns = $client->send_get(sprintf('get_runs/%d', $projectId));
        $resultsNotEmpty = true;

        for ($offset = 250; $resultsNotEmpty; $offset += 250) {
            $moreRuns = $client->send_get(sprintf('get_runs/%d&offset='.$offset, $projectId));
            if (count($moreRuns) <= 0) {
                // There are no more runs, stop looping
                $resultsNotEmpty = false;
            }

            $runs += $moreRuns;
        }

        if (isset($selectedPeople) && count($selectedPeople) > 0) {
            $runs = collect($runs)->filter(function($run, $key) use ($selectedPeople) {
                return in_array($run['assignedto_id'], $selectedPeople);
            })->toArray();
        }

        foreach ($runs as $index => $run) {
            $runs[$index]['assignedToName'] = "&nbsp;";
            $run['assignedToName'] = "&nbsp;";

            if (isset($run['assignedto_id']) && ($run['assignedto_id'] > 0)) {
                $person =  $people->firstWhere('user_id', '=', $run['assignedto_id']);
                $run['assignedToName'] = $person->fullName;
            }

            if (isset($run['suite_id']) && ($run['suite_id'] > 0)) {
                $suites[$run['suite_id']]['runs'][$run['id']] = $run;
            }
        }

        $viewModel->titleTag = $project['name'];

        // Render the template
        return view('project.report', [
            'navBarActive' => $this->arrNavBarActive,
            'peopleFilter' => $peopleFilter,
            'selectedPeople' => $selectedPeople,
            'plans' => $plans,
            'project' => $project,
            'runs' => $runs,
            'suites' => $suites,
            'statuses' => $statuses,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Return all Projects unfiltered
     *
     * @return \Illuminate\View\View
     */
    public function allProjects()
    {
        $projects = $this->testRailClient->send_get('get_projects');

        // The navBarActive variable tells main.blade.php which navbar to make active.
        return view('home', [
            'viewModel' => $this->websiteViewModel,
            'navBarActive' => $this->arrNavBarActive,
            'list' => $projects
        ]);
    }

    /**
     * Default view of projects page.
     *
     * @return \Illuminate\View\View
     */
    public function incompleteProjects()
    {
        $projectCollection = collect($this->testRailClient->send_get('get_projects'));

        $projects = $projectCollection->sort()->reject(function($project, $key) {
            return ($project['is_completed'] > 0);
        });

        // The navBarActive variable tells main.blade.php which navbar to make active.
        return view('home', [
            'viewModel' => $this->websiteViewModel,
            'navBarActive' => $this->arrNavBarActive,
            'list' => $projects
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}

