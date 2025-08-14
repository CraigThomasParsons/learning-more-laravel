<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\ViewModels\WebsiteViewModel;

/**
 * The reason I created this class is to make sure that
 * any view that is displayed that is including the main view.
 * filename: main.blade.php
 * passes the right information.
 */
class MainController extends Controller {

    protected $websiteViewModel;

    /**
     * The HomeController constructor.
     * Dependency anything required in all the controllers
     *
     * @param MenuRepository $menuRepository
     */
    public function __construct(
        WebsiteViewModel $websiteViewModel
    )
    {
        $this->websiteViewModel = $websiteViewModel;
    }
}
