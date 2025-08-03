<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\NoteStoreRequest;
use App\Http\Requests\NoteUpdateRequest;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request): View
{
    $search = $request->input('search');

    $notes = Note::when($search, function ($query, $search) {
        return $query->where('title', 'like', "%{$search}%")
                     ->orWhere('content', 'like', "%{$search}%");
    })
    ->latest()
    ->paginate(5)
    ->withQueryString();

    return view('notes.index', compact('notes', 'search'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
        Note::create($request->validated());
           
        return redirect()->route('notes.index')
                         ->with('success', 'Note created successfully.');
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
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();
           
        return redirect()->route('notes.index')
                        ->with('success', 'Note deleted successfully');
    }

    public function trash()
    {
    $notes = Note::onlyTrashed()->paginate(5);
    return view('notes.trash', compact('notes'));
    }

    public function restore($id)
    {
    $note = Note::onlyTrashed()->findOrFail($id);
    $note->restore();

    return redirect()->route('notes.trash')->with('success', 'restore succed');
    }

    public function forceDelete($id)
    {
    $note = Note::onlyTrashed()->findOrFail($id);
    $note->forceDelete();

    return redirect()->route('notes.trash')->with('success', 'final deletion succed');
    }
}
