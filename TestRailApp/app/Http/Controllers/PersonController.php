<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use App\ViewModels\WebsiteViewModel;
use App\API\TestRailClient;

use Illuminate\Http\Request;
use App\Models\Person;

class PersonController extends ProjectController
{
    /**
     * Show all users
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        $people = [];
        $users = $this->testRailClient->send_get('get_users');

        foreach ($users as $key => $arrUser) {
            $person = Person::firstOrNew([
                'user_id' => $arrUser['id']
            ]);
            $person->populateWithTestRailUserData($arrUser);
            $people[] = $person;
            $person->save();
        }

        // Render the template
        return view('user.people', [
            'viewModel' => $this->websiteViewModel,
            'navBarActive' => $this->arrNavBarActive,
            'list' => collect($users)
        ]);
    }

    /**
     * Show the profile for a given user.
     *
     * @param  int  $userId
     * @return \Illuminate\View\View
     */
    public function show($userId)
    {
        // Get person by user_id
        $person = Person::where('user_id', '=', $userId)->first();

        return view('user.details', [
            'person' => $person,
            'navBarActive' => $this->arrNavBarActive,
            'viewModel' => $this->websiteViewModel
        ]);
    }
}
