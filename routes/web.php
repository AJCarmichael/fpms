<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentResultController;
use App\Http\Controllers\PlacementDriveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AnalyticsController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('password/change', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('password/change', [ChangePasswordController::class, 'update'])->name('password.change.post');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Student Results Routes
    Route::prefix('student-results')->group(function () {
        Route::get('/upload', [StudentResultController::class, 'showUploadForm'])->name('student_results.upload');
        Route::post('/process', [StudentResultController::class, 'processCSV'])->name('student_results.process');
        Route::post('/apply', [StudentResultController::class, 'applyResults'])->name('student_results.apply');
        Route::get('/view', [StudentResultController::class, 'viewResults'])->name('student_results.view');
        Route::delete('/clear', [StudentResultController::class, 'clearAllResults'])->name('student_results.clear');
        Route::get('/edit', [StudentResultController::class, 'editResults'])->name('student_results.edit');
        Route::put('/update', [StudentResultController::class, 'updateResults'])->name('student_results.update');
        Route::get('/delete/{id}', [StudentResultController::class, 'deleteResult'])->name('student_results.delete');
        Route::get('/', [StudentResultController::class, 'index'])->name('student_results.index'); // Added index route
    });

    Route::get('/student_results', [StudentResultController::class, 'index'])->name('student_results.index');

    // Placement Drives Routes
    Route::get('/placements', [PlacementDriveController::class, 'index'])->name('placements.index');
    Route::get('/placements/create', [PlacementDriveController::class, 'create'])->name('placements.create');
    Route::post('/placements', [PlacementDriveController::class, 'store'])->name('placements.store');
    Route::get('/placements/{placementDrive}', [PlacementDriveController::class, 'show'])->name('placements.show');
    Route::get('/placements/{placementDrive}/export', [PlacementDriveController::class, 'exportCsv'])->name('placements.export');
    Route::post('placements/{placementDrive}/update-placed-students', [PlacementDriveController::class, 'updatePlacedStudents'])->name('placements.updatePlacedStudents');
    Route::delete('/placements/{id}', [PlacementDriveController::class, 'destroy'])->name('placements.destroy');

    // User management (for additional admin users)
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/batch-create', [UserController::class, 'batchCreate'])->name('users.batchCreate');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

    // Student Dashboard Route
    Route::get('/studentdashboard', [StudentController::class, 'dashboard'])->name('studentdashboard');

    // Student Profile Route
    Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');

    // Analytics Route
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Placement Groups Routes
    Route::resource('placementGroups', App\Http\Controllers\PlacementGroupController::class);
});