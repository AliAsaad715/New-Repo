<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Mail\JobPosted;
use Illuminate\Support\Facades\Route;
use App\Models\Job;
use Illuminate\Support\Facades\Mail;

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

// Route::get('/test', function() {
//     Mail::to('asdl87997@gmail.com')->send(
//         new JobPosted()
//     );

//     return 'Done';
//     // return new JobPosted();
// });

Route::get('/test', function () {
    dispatch(function () {
        logger('Hello from the queue!');
    })->delay(5);
});
// ->delay(5);

Route::view('/', 'home');
Route::view('/contact', 'contact');
// Route::resource('jobs', JobController::class, [
//     // 'only' => ['index', 'show', 'create', 'store']
//     // 'exepct' => ['edit']
// ]);
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::get('/logout', [SessionController::class, 'destroy']);

Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index');
    Route::get('/jobs/create', 'create');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store')->middleware('auth:sanctum');
    Route::get('/jobs/{job}/edit', 'edit')->middleware('auth:sanctum')->can('edit', 'job');
    Route::patch('/jobs/{job}', 'update');
    Route::delete('/jobs/{job}', 'destroy');
});

// Route::get('/', function () {
//     return view('home');

//     // $jobs = Job::all();
//     // dd($jobs[0]->title);
// }); ==>

// Route::get('/contact', function () {
//     return view('contact');
// });=>