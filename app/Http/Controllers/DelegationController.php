<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delegation;
use App\Models\Ratification;
use App\Models\DelegationType;

class DelegationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $delegations = Delegation::getAllDelegation();
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
        return view('backend.delegation.edit')
            ->with('delegation',$delegation)
            ->with('ratifications',$ratifications);
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
        $status=$delegation->fill($data)->save();
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
