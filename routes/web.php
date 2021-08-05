<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\TalentListController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\CampaignController;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Default Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LeadController::class, 'index'])->middleware(['auth'])->name('leadsearch');

Route::get('/setup', [SetupController::class, 'index'])->middleware(['auth'])->name('setup.index');
Route::post('/setup/subscription', [SetupController::class, 'first_subscription'])->middleware(['auth'])->name('setup.first_subscription');
Route::get('/setup/app', [SetupController::class, 'app'])->middleware(['auth'])->name('setup.app');

Route::get('/appdash', [SchedulerController::class, 'appdash'])->name('appdash');






Route::get('/test', [TestController::class, 'test'])->middleware(['auth'])->name('test');
Route::get('/test2', [TestController::class, 'test2'])->middleware(['auth'])->name('test2');
Route::get('/export_test', function () { return view("leads.export"); });
Route::get('/version/', function () { return env('APP_VERSION'); });


/*
|--------------------------------------------------------------------------
| Admins Routes
|--------------------------------------------------------------------------
*/

Route::get('/admins', [AdminsController::class, 'index'])->middleware(['auth', 'adminonly'])->name('admins');
Route::get('/admins/add', [AdminsController::class, 'create'])->middleware(['auth', 'adminonly'])->name('admins.create');
Route::post('/admins/add', [AdminsController::class, 'store'])->middleware(['auth', 'adminonly'])->name('admins.store');
Route::get('/admins/edit/{id}', [AdminsController::class, 'edit'])->middleware(['auth', 'adminonly'])->name('admins.edit');
Route::post('/admins/edit/{id}', [AdminsController::class, 'update'])->middleware(['auth', 'adminonly'])->name('admins.update');
Route::get('/admins/enable/{id}', [AdminsController::class, 'enable'])->middleware(['auth', 'adminonly'])->name('admins.enable');
Route::get('/admins/disable/{id}', [AdminsController::class, 'disable'])->middleware(['auth', 'adminonly'])->name('admins.disable');


Route::get('/leadjoblist', [AdminsController::class, 'leadJobList'])->middleware(['auth', 'adminonly'])->name('leadJobList');
Route::get('/queue', [AdminsController::class, 'queueList'])->middleware(['auth', 'adminonly'])->name('queueList');
Route::get('/audit', [AdminsController::class, 'auditList'])->middleware(['auth', 'adminonly'])->name('auditList');



/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('/users', [UsersController::class, 'index'])->middleware(['auth', 'adminonly'])->name('users');
Route::get('/users/add', [UsersController::class, 'create'])->middleware(['auth', 'adminonly'])->name('users.create');
Route::post('/users/add', [UsersController::class, 'store'])->middleware(['auth', 'adminonly'])->name('users.store');
Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->middleware(['auth', 'adminonly'])->name('users.edit');
Route::post('/users/edit/{id}', [UsersController::class, 'update'])->middleware(['auth', 'adminonly'])->name('users.update');
Route::get('/users/enable/{id}', [UsersController::class, 'enable'])->middleware(['auth', 'adminonly'])->name('users.enable');
Route::get('/users/disable/{id}', [UsersController::class, 'disable'])->middleware(['auth', 'adminonly'])->name('users.disable');


/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/

Route::get('/clients', [ClientsController::class, 'index'])->middleware(['auth', 'adminonly'])->name('clients');
Route::get('/clients/add', [ClientsController::class, 'create'])->middleware(['auth', 'adminonly'])->name('clients.create');
Route::post('/clients/add', [ClientsController::class, 'store'])->middleware(['auth', 'adminonly'])->name('clients.store');
Route::get('/clients/edit/{id}', [ClientsController::class, 'edit'])->middleware(['auth', 'adminonly'])->name('clients.edit');
Route::post('/clients/edit/{id}', [ClientsController::class, 'update'])->middleware(['auth', 'adminonly'])->name('clients.update');
Route::get('/clients/enable/{id}', [ClientsController::class, 'enable'])->middleware(['auth', 'adminonly'])->name('clients.enable');
Route::get('/clients/disable/{id}', [ClientsController::class, 'disable'])->middleware(['auth', 'adminonly'])->name('clients.disable');


/*
|--------------------------------------------------------------------------
| Plans Routes
|--------------------------------------------------------------------------
*/

Route::get('/plans', [PlansController::class, 'index'])->middleware(['auth', 'adminonly'])->name('plans');
Route::get('/plans/add', [PlansController::class, 'create'])->middleware(['auth', 'adminonly'])->name('plans.create');
Route::post('/plans/add', [PlansController::class, 'store'])->middleware(['auth', 'adminonly'])->name('plans.store');
Route::get('/plans/edit/{id}', [PlansController::class, 'edit'])->middleware(['auth', 'adminonly'])->name('plans.edit');
Route::post('/plans/edit/{id}', [PlansController::class, 'update'])->middleware(['auth', 'adminonly'])->name('plans.update');
Route::get('/plans/delete/{id}', [PlansController::class, 'delete'])->middleware(['auth', 'adminonly'])->name('plans.delete');

Route::get('/trialplan', [PlansController::class, 'trial'])->middleware(['auth', 'adminonly'])->name('trialplan');
Route::post('/trialplan/edit', [PlansController::class, 'trial_edit'])->middleware(['auth', 'adminonly'])->name('trialplan.edit');


/*
|--------------------------------------------------------------------------
| My Account Routes
|--------------------------------------------------------------------------
*/

Route::get('/myaccount', [MyAccountController::class, 'index'])->middleware(['auth'])->name('myaccount');
Route::post('/myaccount/update', [MyAccountController::class, 'update'])->middleware(['auth'])->name('myaccount.update');
Route::post('/myaccount/linkedin', [MyAccountController::class, 'linkedin'])->middleware(['auth'])->name('myaccount.linkedin');
Route::get('/subscription/cancel', [MyAccountController::class, 'cancel_sub'])->middleware(['auth'])->name('myaccount.cancel_sub');


Route::get('/signup', [MyAccountController::class, 'signup'])->name('signup');
Route::post('/signup', [MyAccountController::class, 'signup_save'])->name('signup.save');





/*
|--------------------------------------------------------------------------
| Lead Routes
|--------------------------------------------------------------------------
*/

Route::get('/lead/search', [LeadController::class, 'index'])->middleware(['auth'])->name('leadsearch');
Route::post('/lead/search', [LeadController::class, 'search'])->middleware(['auth'])->name('leadsearch');
Route::get('/lead/list', [LeadController::class, 'list'])->middleware(['auth'])->name('leads.list');
Route::get('/lead/view/{id}', [LeadController::class, 'view'])->middleware(['auth'])->name('talentlist.view');
Route::get('/lead/export/{id}', [LeadController::class, 'export'])->middleware(['auth'])->name('talentlist.export');
Route::get('/lead/delete/{id}', [LeadController::class, 'delete'])->middleware(['auth'])->name('talentlist.delete');



/*
|--------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------
*/

Route::get('/company/search', [CompaniesController::class, 'index'])->middleware(['auth'])->name('companysearch');
Route::post('/company/search', [CompaniesController::class, 'search'])->middleware(['auth'])->name('companysearch');
Route::get('/company/list', [CompaniesController::class, 'list'])->middleware(['auth'])->name('company.list');
Route::get('/company/view/{id}', [CompaniesController::class, 'view'])->middleware(['auth'])->name('company.view');
Route::get('/company/export/{id}', [CompaniesController::class, 'export'])->middleware(['auth'])->name('company.export');
Route::get('/company/delete/{id}', [CompaniesController::class, 'delete'])->middleware(['auth'])->name('company.delete');



/*
|--------------------------------------------------------------------------
| Domain Routes
|--------------------------------------------------------------------------
*/

Route::get('/domain/search', [DomainController::class, 'index'])->middleware(['auth'])->name('domains.search');
Route::post('/domain/search', [DomainController::class, 'search'])->middleware(['auth'])->name('domains.search');
Route::get('/domain/list', [DomainController::class, 'list'])->middleware(['auth'])->name('domains.list');
Route::get('/domain/view/{id}', [DomainController::class, 'view'])->middleware(['auth'])->name('domains.view');
Route::get('/domain/export/{id}', [DomainController::class, 'export'])->middleware(['auth'])->name('domains.export');
Route::get('/domain/delete/{id}', [DomainController::class, 'delete'])->middleware(['auth'])->name('domains.delete');


/*
|--------------------------------------------------------------------------
| Campaign Routes
|--------------------------------------------------------------------------
*/
Route::get('/campaign/unsubscribe', [CampaignController::class, 'unsubscribe'])->name('campaign.unsubscribe');

Route::get('/campaign/list', [CampaignController::class, 'list'])->middleware(['auth'])->name('campaign.list');
Route::get('/campaign/view/{id}', [CampaignController::class, 'view'])->middleware(['auth'])->name('campaign.view');
Route::get('/campaign/disable/{type}/{id}', [CampaignController::class, 'disable'])->middleware(['auth'])->name('campaign.disable');
Route::get('/campaign/new', [CampaignController::class, 'create'])->middleware(['auth'])->name('campaign.create');
Route::post('/campaign/save-campaign', [CampaignController::class, 'save_campaign'])->middleware(['auth'])->name('campaign.save');
Route::get('/campaign/settings', [CampaignController::class, 'settings'])->middleware(['auth'])->name('campaign.settings');
Route::post('/campaign/schedule', [CampaignController::class, 'schedule'])->middleware(['auth'])->name('campaign.schedule');
Route::post('/campaign/config', [CampaignController::class, 'config'])->middleware(['auth'])->name('campaign.config');
Route::post('/campaign/manage-template', [CampaignController::class, 'manage_template'])->middleware(['auth'])->name('campaign.manage_template');
Route::post('/campaign/save-unsubscription-msg', [CampaignController::class, 'save_unsubscription_msg'])->middleware(['auth'])->name('campaign.save_unsubscription_msg');
Route::get('/campaign/add-template/{id?}', [CampaignController::class, 'add_template'])->middleware(['auth'])->name('campaign.add_template');
Route::get('/campaign/templates', [CampaignController::class, 'templates'])->middleware(['auth'])->name('campaign.templates');


require __DIR__.'/auth.php';
