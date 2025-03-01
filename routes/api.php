<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Genre routes
    Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
    Route::apiResource('/genres', GenreController::class)->except('update');

    // Director routes
    Route::put('/directors/{director}', [DirectorController::class, 'update'])->name('directors.update');
    Route::apiResource('/directors', DirectorController::class)->except(['update']);

    // Movie routes
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
    Route::get('/movies/search/auto-complete', [MovieController::class, 'autocomplete'])->name('movies.auto-complete');
    Route::apiResource('/movies', MovieController::class)->except(['update']);

    // Filtered movie routes
    Route::get('/movies/filters/directors', [MovieController::class, 'getDirectorsForFilter'])->name('movies.filters.directors');
    Route::get('/movies/filters/genres', [MovieController::class, 'getGenresForFilter'])->name('movies.filters.genres');
    Route::get('/movies/filters/years', [MovieController::class, 'getYears'])->name('movies.filters.years');

    // General reviews routes
    Route::get('/reviews', [ReviewController::class, 'general_index'])->name('reviews.general.index');
    Route::get('/reviews/{review}', [ReviewController::class, 'general_show'])->name('reviews.general.show');

    // Review routes
    Route::prefix('/reviews')->group(function () {
        Route::get('/movies/{movie}', [ReviewController::class, 'index'])->name('reviews.index');
        Route::post('/movies/{movie}', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/movies/{movie}/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

    // Notification routes
    Route::prefix('/notifications')->name('notifications.')->group(function () {
        Route::get('', [NotificationController::class, 'index'])->name('index');
        Route::put('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::put('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('', [NotificationController::class, 'destroyAll'])->name('destroyAll');
    });

    // Admin User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    // User Profile routes
    Route::get('/user-profile', [UserProfileController::class, 'index'])->name('user-profile');
    Route::get('/user-profile/{user}', [UserProfileController::class, 'show'])->name('user-profile.show');

    // Admin routes
    Route::middleware('role:admin')->prefix('/admin')->name('admin.')->group(function () {
        // Role routes
        Route::get('/roles', [RoleController::class, 'index'])->name('index');
        Route::put('/roles/{user}/assign-role', [RoleController::class, 'assignRole'])->name('assign-role');
        // Permission routes
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/{user}/list-permission', [PermissionController::class, 'getUserPermissions'])->name('permissions.list-permission');
        Route::post('/permissions/{user}/give-permission', [PermissionController::class, 'assignPermission'])->name('permissions.give-permission');
        Route::delete('/permissions/{user}/revoke-permission', [PermissionController::class, 'revokePermission'])->name('permissions.revoke-permission');

        // Dashboard routes
        Route::get('/dashboard/counts', [DashboardController::class, 'counts'])->name('counts');
        Route::get('/dashboard/top-rated-movies', [DashboardController::class, 'topRatedMovies'])->name('top-rated-movies');
        Route::get('/dashboard/top-users', [DashboardController::class, 'topUsers'])->name('top-users');
        Route::get('/dashboard/top-genres', [DashboardController::class, 'topGenres'])->name('top-genres');
        Route::get('/dashboard/top-directors', [DashboardController::class, 'topDirectors'])->name('top-directors');
        Route::get('/dashboard/recent-movies', [DashboardController::class, 'recentMovies'])->name('recent-movies');
        Route::get('/dashboard/recent-reviews', [DashboardController::class, 'recentReviews'])->name('recent-reviews');
        Route::get('/dashboard/recent-users', [DashboardController::class, 'recentUsers'])->name('recent-users');
    });
});
