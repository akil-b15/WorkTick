<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\Policy;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class PoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_auth = auth()->user();
		if ($user_auth->can('policy_view')){
                $policies = Policy::where('deleted_at', '=', null)->orderBy('id', 'desc')->get();
                return view('core_company.policy.policy_list', compact('policies'));
        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_auth = auth()->user();
		if ($user_auth->can('policy_add')){

            $companies = Company::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','name']);
            return response()->json([
                'companies' =>$companies,
            ]);

        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_auth = auth()->user();
		if ($user_auth->can('policy_add')){

            $request->validate([
                'title'        => 'required|string|max:255',
                'company_id'   => 'required',
                'description'  => 'required',
            ]);

            Policy::create([
                'title'        => $request['title'],
                'company_id'   => $request['company_id'],
                'description'  => $request['description'],
            ]);

            return response()->json(['success' => true]);

        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        return view('core_company.policy.policy', compact('policy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_auth = auth()->user();
		if ($user_auth->can('policy_edit')){

            $companies = Company::where('deleted_at', '=', null)->orderBy('id', 'desc')->get(['id','name']);
            return response()->json([
                'companies' =>$companies,
            ]);

        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_auth = auth()->user();
		if ($user_auth->can('policy_edit')){

            $request->validate([
                'title'        => 'required|string|max:255',
                'company_id'   => 'required',
                'description'  => 'required|string',
            ]);

            Policy::whereId($id)->update([
                'title'        => $request['title'],
                'company_id'   => $request['company_id'],
                'description'  => $request['description'],
            ]);

            return response()->json(['success' => true]);

        }
        return abort('403', __('You are not authorized'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_auth = auth()->user();
		if ($user_auth->can('policy_delete')){

            Policy::whereId($id)->update([
                'deleted_at' => Carbon::now(),
            ]);

            return response()->json(['success' => true]);

        }
        return abort('403', __('You are not authorized'));
    }

       //-------------- Delete by selection  ---------------\\

       public function delete_by_selection(Request $request)
       {
          $user_auth = auth()->user();
          if($user_auth->can('policy_delete')){
              $selectedIds = $request->selectedIds;
      
              foreach ($selectedIds as $policy_id) {
                Policy::whereId($policy_id)->update([
                    'deleted_at' => Carbon::now(),
                ]);
              }
              return response()->json(['success' => true]);
          }
          return abort('403', __('You are not authorized'));
       }

    public function mark_seen(Policy $policy) : RedirectResponse {
        $policy->noticeStatus()->updateOrCreate([
            'user_id' => auth()->id(),
        ],[
            'status' => 1
        ]);

        return back();
    }
}
