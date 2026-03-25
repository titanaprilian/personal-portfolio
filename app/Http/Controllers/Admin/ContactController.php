<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::query()
            ->orderByRaw('read_at IS NOT NULL')
            ->orderByDesc('created_at')
            ->paginate(25);

        $unreadCount = Contact::whereNull('read_at')->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function markRead(Request $request, Contact $contact): RedirectResponse|JsonResponse
    {
        $contact->update(['read_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message marked as read.');
    }

    public function markUnread(Request $request, Contact $contact): RedirectResponse|JsonResponse
    {
        $contact->update(['read_at' => null]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message marked as unread.');
    }

    public function destroy(Request $request, Contact $contact): RedirectResponse|JsonResponse
    {
        $contact->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted.');
    }
}
