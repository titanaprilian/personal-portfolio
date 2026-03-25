<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExperienceRequest;
use App\Http\Requests\Admin\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::query()
            ->orderByDesc('is_current')
            ->orderByDesc('start_date')
            ->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['is_current'])) {
            $data['end_date'] = null;
        }

        Experience::create($data);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience added successfully.');
    }

    public function update(UpdateExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['is_current'])) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience deleted successfully.');
    }
}
