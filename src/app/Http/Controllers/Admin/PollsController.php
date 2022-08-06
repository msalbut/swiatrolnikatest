<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Polls;

class PollsController extends Controller
{
    public function index()
    {
        $polls = Polls::with('creator')->with('lastEditor')->whereIn('published', [0,1])->latest()->get();
        // dd($polls[1]->creator->name);
        $title = 'Sondy';
        return view('admin.polls.polls', compact('polls', 'title'));
    }
    public function edit($id){
        $title = 'Edycja Sondy';
        $poll = Polls::findOrFail($id);
        return view('admin.polls.edit', compact('title', 'poll'));
    }
    public function update(Request $request, $id){
        $form = $request->all();
        $form['polls'] = json_encode($form['polls']);
        $form['alias'] = \Str::slug($form['title']);
        $poll = Polls::findOrFail($id);
        $poll->fill($form);
        // Helper::makerevision($content);
        $poll->save();
        return redirect()->back();
        // $title = 'Sonda';
        // return view('admin.polls.create', compact('title'));
    }
    public function create(){
        $title = 'Tworzenie sondy';
        return view('admin.polls.create', compact('title'));
    }
    public function store(Request $request){
        $form = $request->all();
        $form['polls'] = json_encode($form['polls']);
        $form['alias'] = \Str::slug($form['title']);
        Polls::create($form);
        return redirect()->back();
    }
    public function change(Request $request, $id)
    {
        $poll = Polls::findOrFail($id);
        if ($request->has('action')) {
            $action = $request->get('action');
            switch ($action) {
                case 'unpublish':
                    $poll->fill(['published' => 0]);
                    $poll->save();
                    return redirect()->back();
                    break;
                case 'publish':
                    $poll->fill(['published' => 1]);
                    $poll->save();
                    return redirect()->back();
                    break;
                case 'archive':
                    $poll->fill(['published' => 2]);
                    $poll->save();
                    return redirect()->back();
                    break;
                case 'delete':
                    $poll->fill(['published' => -2]);
                    $poll->save();
                    return redirect()->back();
                    break;
                default:
                    return redirect()->back();
            }
        }
    }
}
