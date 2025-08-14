<?php
namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use View;

class GroupController extends MainController {

    /**
     * Groups Controller main view.
     *
     * @return view
     */
    public function getIndex()
    {
        // View name should be the same name as the template.
        $viewName = 'user.groups';

        // Let the view know which nav menu to show as active.
        $arrNavBarActive = array();
        $arrNavBarActive[$viewName] = true;

        // Used in main.blade.php. Sets the title of site.
        // Some templates may reuse it for a simple header title too.
        $viewModel = $this->websiteViewModel;

        // The navBarActive variable tells main.blade.php which navbar to make active.
        return view($viewName, [
            'viewModel' => $viewModel,
            'navBarActive' => $arrNavBarActive
        ]);
    }
}
