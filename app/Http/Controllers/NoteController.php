<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource (main list page with optional search).
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $notes = Note::where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "{$search}%");
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('notes.index', compact('notes', 'search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Live search endpoint for AJAX requests.
     */
    public function liveSearch(Request $request)
    {
        $search = $request->input('search');

        $notes = Note::where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "{$search}%");
            })
            ->latest()
            ->paginate(5);

        if ($request->ajax()) {
            return view('notes.table', compact('notes'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteStoreRequest $request): RedirectResponse
    {
        auth()->user()->notes()->create($request->validated());

        return redirect()->route('notes.index')
                         ->with('success', 'true');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note): View
    {
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note): View
    {
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteUpdateRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        return redirect()->route('notes.index')
                         ->with('success', 'Note updated successfully');
    }

    /**
     * Remove the specified resource (soft delete).
     */
    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('notes.index')
                         ->with('success', 'Note deleted successfully');
    }

    // --------------------- Trash Management ---------------------

    /**
     * Display soft deleted notes (trash bin).
     */
    public function trash()
    {
        $notes = auth()->user()->notes()
            ->onlyTrashed()
            ->latest()
            ->paginate(5);

        return view('notes.trash', compact('notes'));
    }

    /**
     * Restore a single soft deleted note.
     */
    public function restore($id)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        $note->restore();

        return redirect()->route('notes.trash')
                         ->with('success', 'Restore succeeded');
    }

    /**
     * Restore all soft deleted notes for current user.
     */
    public function restoreAll()
    {
        auth()->user()->notes()
            ->onlyTrashed()
            ->restore();

        return redirect()->route('notes.trash')
                         ->with('success', 'All notes restored successfully!');
    }

    /**
     * Permanently delete a soft deleted note.
     */
    public function forceDelete($id)
    {
        $note = Note::onlyTrashed()->findOrFail($id);
        $note->forceDelete();

        return redirect()->route('notes.trash')
                         ->with('success', 'Final deletion succeeded');
    }
}