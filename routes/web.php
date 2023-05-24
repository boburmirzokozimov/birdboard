<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Project\ProjectController;
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
    Route::resource('projects', ProjectController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/projects/{project}/task', [ProjectTaskController::class, 'store'])->name('projects.tasks.store');
    Route::delete('/projects/{project}/task', [ProjectTaskController::class, 'destroy'])->name('projects.tasks.delete');
    Route::patch('/projects/{project}/task/{task}', [ProjectTaskController::class, 'update'])->name('projects.tasks.update');

});

require __DIR__ . '/auth.php';
