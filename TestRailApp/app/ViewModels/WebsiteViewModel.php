<?php
namespace App\ViewModels;

use Config;

/**
 * Created this class to contain information like the title of the website.
 */
class WebsiteViewModel
{
    public $titleTag;

    /**
     * Build values for the website by the config file.
     */
    public function __construct()
    {
        $this->titleTag = Config::get('app.title_tag');
    }
}