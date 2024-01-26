<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){

        // $contacts = Contact::where('deleted_at', '=', null)->get();
        return view('help.feedback');
    }

    public function store(Request $request){

        request()->validate([
            'title'           => 'required',
            'feedback'           => 'required',
        ]);

        Feedback::create([
            'title'           => $request['title'],
            'feedback'           => $request['feedback'],
        ]);

        return redirect()->back()->withSuccess('Thanks!');

    }
}
