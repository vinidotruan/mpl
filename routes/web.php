<?php

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function() {
    return Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect();
})->name('login');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::updateOrCreate([
        'github_id' => $user->id
    ], [
        'name' => $user->name,
        'github_token' => $user->token,
        'github_refresh_token' => $user->refreshToken,
        'github_pfp' => $user->avatar,
    ]);

    Auth::login($user, false);
    return redirect('/');
});
Route::get('/', [DashboardController::class, 'index']);
Route::get('/repo-settings', [DashboardController::class, 'repoSettings']);

