<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delegation;
use App\Models\Ratification;
use App\Models\DelegationType;
use App\Models\Member;

class DelegationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delegations = Delegation::getAllDelegation();
        foreach ($delegations as $delegation) {
            $typeIds = explode(',', $delegation->type);
            $type_str = DelegationType::whereIn('id', $typeIds)->orderBy('id', 'desc')->pluck('name');
            $type = implode(', ', json_decode($type_str));
            $delegation->type = $type;
        }
        return view('backend.delegation.index')->with('delegations', $delegations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ratifications = Ratification::getAllRatification();
        $types = DelegationType::getAllType();
        return view('backend.delegation.create')->with('ratifications', $ratifications)->with('types', $types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'string|required',
            'ratification'=>'required|exists:ratifications,id',
            'type'=>'array|required',
            'number'=>"required|numeric",
            'status'=>'required|in:active,inactive',
            'work_content'=>'string|nullable'
        ]);

        $data=$request->all();
        $type=$request->input('type');
        $data['rat_id'] = $request->input('ratification');
        if($type){
            $data['type']=implode(',', $type);
        }
        else{
            $data['type']='';
        }
        // dd($data);
        $status=Delegation::create($data);
        if($status){
            request()->session()->flash('success','Delegation Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('delegation.index');
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
    public function edit(string $id)
    {
        $delegation=Delegation::findOrFail($id);
        $ratifications=Ratification::getAllRatification();
        $types = DelegationType::getAllType();
        $members = Member::where('dele_id', $delegation->id)->get();
        return view('backend.delegation.edit')
            ->with('delegation',$delegation)
            ->with('ratifications',$ratifications)
            ->with('types', $types)
            ->with('members', $members);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delegation = Delegation::findOrFail($id);
        $this->validate($request, [
            'name'=>'string|required',
            'ratification'=>'required|exists:ratifications,id',
            'type'=>'array|required',
            'number'=>"required|numeric",
            'status'=>'required|in:active,inactive',
            'work_yeaer'=>'required||date_format:Y',
            'work_content'=>'nullable|string',
        ]);

        $delegation->name = $request->name;
        $delegation->rat_id = $request->ratification;
        $delegation->number = $request->number;
        $delegation->type = implode(',', $request->type);
        $delegation->status = $request->status;
        $delegation->work_content = $request->work_content;

        $status=$delegation->save();

        $work_results = $request->work_results;
        $work_year = $request->work_year;
        
        foreach ($work_results as $member_id => $results) {
            $member = Member::findOrFail($member_id);
            $existing_work_results = json_decode($member->work_results, true);
    
            // Find or create the work result for the specified year
            $yearly_result_index = array_search($work_year, array_column($existing_work_results, 'year'));
    
            if ($yearly_result_index === false) {
                $yearly_result = [
                    'year' => $work_year,
                    'months' => array_fill(0, 12, 0),
                ];
            } else {
                $yearly_result = $existing_work_results[$yearly_result_index];
            }
    
            // Update the monthly results
            foreach ($results['months'] as $index => $month_result) {
                $yearly_result['months'][$index] = $month_result;
            }
    
            // Replace or add the yearly result
            if ($yearly_result_index === false) {
                $existing_work_results[] = $yearly_result;
            } else {
                $existing_work_results[$yearly_result_index] = $yearly_result;
            }
    
            $member->work_results = json_encode($existing_work_results);
            $member->save();
        }
        if($status){
            request()->session()->flash('success','Delegation Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('delegation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delegation=Delegation::findOrFail($id);
        $status=$delegation->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting delegation');
        }
        return redirect()->route('delegation.index');
    }

}
