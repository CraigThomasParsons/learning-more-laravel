<?php

namespace App\Http\Controllers;

use App\Models\Suite;
use Illuminate\Http\Request;

class SuiteController extends HomeController
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
     * Display the specified resource.
     *
     * @param  \App\Models\Suite  $suite
     * @return \Illuminate\Http\Response
     */
    public function show(Suite $suite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suite  $suite
     * @return \Illuminate\Http\Response
     */
    public function edit(Suite $suite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suite  $suite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suite $suite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suite  $suite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suite $suite)
    {
        //
    }
}
