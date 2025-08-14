<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\ViewModels\WebsiteViewModel;
use App\API\TestRailClient;
use App\Models\Run;
use Illuminate\Http\Request;

class RunController extends HomeController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
     * @param  \App\Models\Run  $run
     * @return \Illuminate\Http\Response
     */
    public function show(Run $run)
    {
        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;

        $viewModel->titleTag = $run['name'];

        // Render the template
        return view('run', [
            'viewModel' => $viewModel,
            'navBarActive' => $this->arrNavBarActive,
            'run' => $run
        ]);
    }

    /**
     * Show the details of a single test run.
     *
     * @param  int  $id Should be the runId
     * @return \Illuminate\View\View
     */
    public function showById($runId)
    {
        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;
        $client = $this->testRailClient;

        $run = $client->send_get(sprintf('get_run/%d', $runId));
        $tests = $client->send_get(sprintf('get_tests/%d', $runId));
        $results = $client->send_get(sprintf('get_results_for_run/%d', $runId));

        $viewModel->titleTag = $run['name'];

        // Render the template
        return view('run', [
            'viewModel' => $viewModel,
            'navBarActive' => $this->arrNavBarActive,
            'run' => $run,
            'tests' => $tests,
            'results' => $results
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Run  $run
     * @return \Illuminate\Http\Response
     */
    public function edit(Run $run)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Run  $run
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Run $run)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Run  $run
     * @return \Illuminate\Http\Response
     */
    public function destroy(Run $run)
    {
    }
}