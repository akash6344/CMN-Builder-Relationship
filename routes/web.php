<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\ProjectApprovalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    Route::get('/builders', [BuilderController::class, 'index'])->name('builders.index');

    Route::get('/project-approvals', [ProjectApprovalController::class, 'index'])->name('project-approvals.index');
    Route::patch('/project-approvals/{project}/approve', [ProjectApprovalController::class, 'approve'])->name('project-approvals.approve');
    Route::patch('/project-approvals/{project}/reject', [ProjectApprovalController::class, 'reject'])->name('project-approvals.reject');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::patch('/documents/{document}/verify', [DocumentController::class, 'verify'])->name('documents.verify');
    Route::patch('/documents/{document}/reject', [DocumentController::class, 'reject'])->name('documents.reject');

    Route::get('/analytics', AnalyticsController::class)->name('analytics.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{type}/{format}', [ReportController::class, 'export'])->name('reports.export');

    Route::get('/builder-leads', [LeadController::class, 'index'])->name('builder-leads.index');
    Route::get('/subscriptions', fn () => app(PlaceholderController::class)('subscriptions'))->name('subscriptions.index');
    Route::get('/site-visits', fn () => app(PlaceholderController::class)('site-visits'))->name('site-visits.index');
    Route::get('/builder-support', fn () => app(PlaceholderController::class)('builder-support'))->name('builder-support.index');
    Route::get('/payments', fn () => app(PlaceholderController::class)('payments'))->name('payments.index');
    Route::get('/builder-performance', fn () => app(PlaceholderController::class)('builder-performance'))->name('builder-performance.index');
    Route::get('/marketing', [MarketingController::class, 'campaigns'])->name('marketing.index');
    Route::get('/marketing/promote', [MarketingController::class, 'landing'])->name('marketing.promote');
    Route::get('/marketing/wizard', [MarketingController::class, 'wizard'])->name('marketing.wizard');
    Route::get('/notifications', fn () => app(PlaceholderController::class)('notifications'))->name('notifications.index');
});
