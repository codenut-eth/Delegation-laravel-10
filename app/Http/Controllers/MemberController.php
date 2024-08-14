<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Delegation;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::getAllMember();
        return view('backend.member.index')->with('members', $members);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $delegations = Delegation::getAllDelegation();
        return view('backend.member.create')->with('delegations', $delegations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'name'=>'string|required',
            'dele_id'=>'required|exists:delegations,id',
            'start_date'=>'date|required',
            'end_date'=>'date|required',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
            'work_results'=>'string|nullable',
        ]);

        $data=$request->all();
        // dd($data['work_results']);
        // Encode the work_results array as JSON
        $data['work_results'] = $request->input('work_results');

        $status=Member::create($data);
        if($status){
            request()->session()->flash('success','Member Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('member.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $delegations = Delegation::getAllDelegation();
        $member = Member::findOrFail($id);
        $workResults = json_encode($member->work_results);
        return view('backend.member.edit')->with('member', $member)->with('delegations', $delegations)->with('workResults', $workResults);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name'=>'string|required',
            'dele_id'=>'required|exists:delegations,id',
            'start_date'=>'date|required',
            'end_date'=>'date|required',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
            'work_results'=>'string|nullable',
        ]);
    
        $member = Member::findOrFail($id);
        $data = $request->all();
        $data['work_results'] = $request->input('work_results');
    
        $member->fill($data);
        $status = $member->save();
    
        if ($status) {
            request()->session()->flash('success', 'Member Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('member.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
