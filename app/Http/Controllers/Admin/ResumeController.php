<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreResumeRequest;
use App\Models\Resume;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResumeController extends Controller
{
    public function index(): View
    {
        $resumes = Resume::query()
            ->orderByDesc('is_active')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.resume.index', compact('resumes'));
    }

    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $path = $request->file('resume_file')
            ->store('resumes', 'public');

        Resume::create([
            'label' => $request->validated()['label'],
            'file_path' => $path,
            'is_active' => false,
        ]);

        return redirect()->route('admin.resume.index')
            ->with('success', 'Resume uploaded successfully.');
    }

    public function setActive(Resume $resume): RedirectResponse
    {
        DB::transaction(function () use ($resume) {
            Resume::query()->update(['is_active' => false]);
            $resume->update(['is_active' => true]);
        });

        return redirect()->route('admin.resume.index')
            ->with('success', "\"{$resume->label}\" is now the active resume.");
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        if ($resume->is_active) {
            return redirect()->route('admin.resume.index')
                ->with('error', 'Cannot delete the active resume. Set another resume as active first.');
        }

        Storage::disk('public')->delete($resume->file_path);
        $resume->delete();

        return redirect()->route('admin.resume.index')
            ->with('success', 'Resume deleted.');
    }
}
