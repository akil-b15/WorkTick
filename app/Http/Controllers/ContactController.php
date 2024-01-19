<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){

        // $faqs = Faq::all();
        $contacts = Contact::where('deleted_at', '=', null)->get();
        return view('support.contact', compact('contacts', 'contacts'));
    }


    public function store(Request $request)
    {

            request()->validate([
                'name'           => 'required',
                'email'           => 'required',
                'phone'           => 'required',
            ]);

            Contact::create([
                'name'           => $request['name'],
                'email'           => $request['email'],
                'phone'           => $request['phone'],
            ]);

            return response()->json(['success' => true]);

    }

    public function update(Request $request, $id)
    {

            request()->validate([
                'name'           => 'required',
                'email'           => 'required',
                'phone'           => 'required',
            ]);

            Contact::whereId($id)->update([
                'name'           => $request['name'],
                'email'           => $request['email'],
                'phone'           => $request['phone'],
            ]);
        
            return response()->json(['success' => true]);

    }

    public function destroy($id)
    {       
            $delete = Contact::where('id',$id)->delete();

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
            Contact::whereId($id)->update([
                   'deleted_at' => Carbon::now(),
               ]);
           }
           return response()->json(['success' => true]);

    }
}
