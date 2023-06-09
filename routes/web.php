<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Project\ProjectInvitationsController;
use App\Http\Controllers\Project\ProjectTaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    Route::post('/projects/{project}/task', [ProjectTaskController::class, 'store'])->name('projects.tasks.store');
    Route::delete('/projects/{project}/task', [ProjectTaskController::class, 'destroy'])->name('projects.tasks.delete');
    Route::patch('/projects/{project}/task/{task}', [ProjectTaskController::class, 'update'])->name('projects.tasks.update');

    Route::post('/projects/{project}/invitations', [ProjectInvitationsController::class, 'store'])->name('projects.invitations.store');
    Route::delete('/projects/{project}/invitations', [ProjectInvitationsController::class, 'destroy'])->name('projects.invitations.destroy');

});

require __DIR__ . '/auth.php';
