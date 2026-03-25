<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('public.contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return redirect()->route('contact.thanks');
        }

        Contact::create($request->validated());

        return redirect()->route('contact.thanks');
    }

    public function thanks(): View|RedirectResponse
    {
        if (! url()->previous() || url()->previous() === url()->current()) {
            return redirect()->route('contact');
        }

        return view('public.contact-thanks');
    }
}
