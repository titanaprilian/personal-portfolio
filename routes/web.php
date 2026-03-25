<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\AboutController as PublicAboutController;
use App\Http\Controllers\Public\BlogController as PublicBlogController;
use App\Http\Controllers\Public\ContactController as PublicContactController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProjectController as PublicProjectController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [PublicProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [PublicProjectController::class, 'show'])->name('projects.show');
Route::get('/blog', [PublicBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [PublicBlogController::class, 'show'])->name('blog.show');
Route::get('/about', [PublicAboutController::class, 'index'])->name('about');
Route::get('/contact', [PublicContactController::class, 'index'])->name('contact');
Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');
Route::get('/contact/thanks', [PublicContactController::class, 'thanks'])->name('contact.thanks');

Route::get('/resume/download', function () {
    $resume = \App\Models\Resume::where('is_active', true)->first();

    if (! $resume) {
        abort(404, 'No active resume available.');
    }

    return Storage::disk('public')->download(
        $resume->file_path,
        Str::slug($resume->label).'.pdf'
    );
})->name('resume.download');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::post('/admin/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::put('/admin/projects/{project}', [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::patch('/admin/projects/{project}/order', [ProjectController::class, 'updateOrder'])->name('admin.projects.updateOrder');
    Route::delete('/admin/projects/{project}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');

    Route::get('/admin/blog', [BlogController::class, 'index'])->name('admin.blog.index');
    Route::post('/admin/blog', [BlogController::class, 'store'])->name('admin.blog.store');
    Route::put('/admin/blog/{post}', [BlogController::class, 'update'])->name('admin.blog.update');
    Route::delete('/admin/blog/{post}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');

    Route::get('/admin/skills', [SkillController::class, 'index'])->name('admin.skills.index');
    Route::post('/admin/skills', [SkillController::class, 'store'])->name('admin.skills.store');
    Route::put('/admin/skills/{skill}', [SkillController::class, 'update'])->name('admin.skills.update');
    Route::delete('/admin/skills/{skill}', [SkillController::class, 'destroy'])->name('admin.skills.destroy');
    Route::resource('/admin/experiences', ExperienceController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.experiences');
    Route::get('/admin/contacts', [ContactController::class, 'index'])->name('admin.contacts.index');
    Route::patch('/admin/contacts/{contact}/read', [ContactController::class, 'markRead'])->name('admin.contacts.markRead');
    Route::patch('/admin/contacts/{contact}/unread', [ContactController::class, 'markUnread'])->name('admin.contacts.markUnread');
    Route::delete('/admin/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/admin/resume', [ResumeController::class, 'index'])->name('admin.resume.index');
    Route::post('/admin/resume', [ResumeController::class, 'store'])->name('admin.resume.store');
    Route::patch('/admin/resume/{resume}/set-active', [ResumeController::class, 'setActive'])->name('admin.resume.setActive');
    Route::delete('/admin/resume/{resume}', [ResumeController::class, 'destroy'])->name('admin.resume.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
