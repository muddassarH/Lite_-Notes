<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $notes=  Note::whereBelongsTo(Auth::user())->latest('updated_at')->paginate(5);

    // $notes =Note::where('user_id',Auth::id())->latest('updated_at')->paginate(5);

return view("notes.index",compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('notes.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     $request->validate([
        'title'=>'required|max:120',
        'text'=>'required'
     ]);
Note::create([
    'uuid'=>Str::uuid(),
 'user_id'=>Auth::id(),
 'title'=>$request->title,
 'text'=>$request->text
]);
return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        if($note->user_id !=Auth::id()){
                    Return abort(403); }
        else{

        // $note = Note::where('uuid',$uuid)->where('user_id',Auth::id())->firstOrFail();
        return view('notes.show',compact('note'));
    }
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if($note->user_id !=Auth::id())
        {
            Return abort(403);
        }
        else
        {
        return view('notes.edit',compact('note'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if($note->user_id !=Auth::id())
        {
            Return abort(403);
        }
        else {
            $request->validate([
               'title'=>'required|max:120',
               'text'=>'required'
            ]);
            $note->update([
                'title'=>$request->title,
                'text'=>$request->text,
            ]);
            return to_route('notes.show',$note)->with('success','Note Updated Succesfully');
        }}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)

    {

        if($note->user_id !=Auth::id())
        {
            Return abort(403);
        }
        else
        {
    $note->delete();
    return to_route('notes.index')->with('success','Note MOved to Trash');
            }
         }
}
