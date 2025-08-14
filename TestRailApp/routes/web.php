<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RunController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PersonController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/person/{id}', [
    PersonController::class,
    'show'
])->name('person');

Route::get('/people', [
    PersonController::class,
    'list'
])->name('people');

Route::get('/projects/incompleted', [
    ProjectController::class,
    'incompleteProjects'
])->name('incompleteProjects');

Route::get('/projects', [
    ProjectController::class,
    'allProjects'
])->name('allProjects');

Route::get('/project/report/{projectId}', [
    ProjectController::class,
    'report'
])->name('project');

Route::get('/project/{projectId}', [
    ProjectController::class,
    'show'
])->name('showProject');

Route::get('/plan/{planId}', [
    PlanController::class,
    'showById'
])->name('plan');

Route::get('/run/{runId}', [
    RunController::class,
    'showById'
])->name('run');

Route::get('/test/{testId}', [
    TestController::class,
    'showById'
])->name('test');

Route::get('/', [
    HomeController::class,
    'getIndex',
])->name('start');

Route::get('/home', [
    HomeController::class,
    'getIndex',
])->name('home');

Route::get('/groups', [
    GroupController::class,
    'getIndex',
])->name('groups');