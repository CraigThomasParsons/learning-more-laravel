<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\ViewModels\WebsiteViewModel;
use App\API\TestRailClient;
use App\Models\Plan;

use Illuminate\Http\Request;

class PlanController extends HomeController
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
     * Show the details of a single test plan.
     *
     * @param  int  $id Should be the planId
     * @return \Illuminate\View\View
     */
    public function showById($planId)
    {
        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;
        $client = $this->testRailClient;

        $plan = $client->send_get(sprintf('get_plan/%d', $planId));

        $viewModel->titleTag = $plan['name'];

        // Render the template
        return view('plan', [
            'viewModel' => $viewModel,
            'navBarActive' => $this->arrNavBarActive,
            'plan' => $plan
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
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
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
