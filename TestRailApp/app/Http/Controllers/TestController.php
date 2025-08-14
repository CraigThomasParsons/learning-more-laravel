<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\ViewModels\WebsiteViewModel;
use App\API\TestRailClient;

use Illuminate\Http\Request;

class TestController extends ProjectController
{
    /**
     * Show the details of a single Test and results
     *
     * @param  int  $id Should be the id of the test.
     * @return \Illuminate\View\View
     */
    public function show($testId)
    {
        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;
        $client = $this->testRailClient;

        $test = $client->send_get(sprintf('get_test/%d', $testId));
        $results = $client->send_get(sprintf('get_results/%d', $testId));
    
        // Render the template
        return view('test', [
            'viewModel' => $viewModel,
            'navBarActive' => $this->arrNavBarActive,
            'test' => $test,
            'results' => $results
        ]);
    }
}
