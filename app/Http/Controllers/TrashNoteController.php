<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashNoteController extends Controller
{
    Public Function index(){
        $notes = Note::where('user_id', Auth::user()->id)
        ->onlyTrashed()
        ->latest('updated_at')
        ->paginate(5);


    return view("notes.index",compact('notes'));
    }
    public function show(Note $note) {
        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }

        return view('notes.show')->with('note', $note);
    }
    public function update(Note $note){
        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }
        $note->restore();
        return to_route('notes.show',$note)->with('success','NOte Restored');
    }
    public function destroy(Note $note){
        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }
        $note->forceDelete();
        return to_route('trashed.index')->with('success','NOte Deleted Forever');
    }
}


