<?php
namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\ViewModels\WebsiteViewModel;
use App\API\TestRailClient;

use View;

class HomeController extends MainController {

    protected $websiteViewModel;
    protected $testRailClient;

    /**
     * The HomeController constructor.
     * Dependency inject anything required for this controllers actions.
     *
     * @param WebsiteViewModel $websiteViewModel
     * @param TestRailClient $testRailClient
     */
    public function __construct(
        WebsiteViewModel $websiteViewModel,
        TestRailClient $testRailClient
    )
    {
        Parent::__construct($websiteViewModel);
        $this->testRailClient = $testRailClient;
    }

    /**
     * Home Controller main view.
     *
     * @return view
     */
    public function getIndex()
    {
        // View name should be the same name as the template.
        $viewName = 'home';
        $arrNavBarActive = array();
        $arrNavBarActive[$viewName] = true;

        $projectCollection = collect($this->testRailClient->send_get('get_projects'));
        $projects = $projectCollection->sort()->reject(function($project, $key) {
            return ($project['is_completed'] > 0);
        });

        // Used in main.blade.php.
        $viewModel = $this->websiteViewModel;

        // The navBarActive variable tells main.blade.php which navbar to make active.
        return view($viewName, [
            'viewModel' => $viewModel,
            'navBarActive' => $arrNavBarActive,
            'list' => $projects
        ]);
    }
}
