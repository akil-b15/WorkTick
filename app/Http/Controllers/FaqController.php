<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(){

        // $faqs = Faq::all();
        $faqs = Faq::where('deleted_at', '=', null)->get();
        return view('support.faqs', compact('faqs', 'faqs'));
    }


    public function store(Request $request)
    {

            request()->validate([
                'question'           => 'required',
                'answer'           => 'required',
            ]);

            Faq::create([
                'question'           => $request['question'],
                'answer'           => $request['answer'],
            ]);

            return response()->json(['success' => true]);

    }

    public function update(Request $request, $id)
    {

            request()->validate([
                'question'           => 'required',
                'answer'           => 'required',
            ]);

            Faq::whereId($id)->update([
                'question'           => $request['question'],
                'answer'           => $request['answer'],
            ]);
        
            return response()->json(['success' => true]);

    }

    public function destroy($id)
    {       
            $delete = Faq::where('id',$id)->delete();

            // Faq::whereId($id)->update([
            //     'deleted_at' => Carbon::now(),
            // ]);

            return response()->json(['success' => true]);        
    }

    //-------------- Delete by selection  ---------------\\

    public function delete_by_selection(Request $request)
    {

           $selectedIds = $request->selectedIds;
   
           foreach ($selectedIds as $id) {
               Faq::whereId($id)->update([
                   'deleted_at' => Carbon::now(),
               ]);
           }
           return response()->json(['success' => true]);

    }
}
