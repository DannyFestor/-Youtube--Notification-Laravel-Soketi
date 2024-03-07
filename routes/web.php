<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
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
    $user = Auth::user();
    $notifications = $user->notifications()->whereNull('seen_at')->get();
    $eventName = (new \ReflectionClass(\App\Events\UserNotificationEvent::class))->getShortName();

    return view('dashboard', [
        'user' => $user,
        'notifications' => $notifications,
        'eventName' => $eventName,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/notifications', function (Request $request) {
        \App\Models\NotificationUser::query()
            ->where('user_id', $request->user()->id)
            ->update(['seen_at' => now()]);

        return 'ok';
    })->name('notifications');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
