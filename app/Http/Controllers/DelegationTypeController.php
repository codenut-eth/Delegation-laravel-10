<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DelegationType;

class DelegationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = DelegationType::getAllType();
        return view('backend.delegationType.index')->with('types', $types);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.delegationType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        // $short = $this->getFirstLetter($request->name);
        // $count=DelegationType::where('short',$short)->count();
        // if($count>0){
        //     $short=$short.'-'.date('ymdis').'-'.rand(0,999);
        // }
        // $data['short']=$short;
        // return $data;   
        $status=DelegationType::create($data);
        if($status){
            request()->session()->flash('success','Delegation type successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('type.index');
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
        $type=DelegationType::findOrFail($id);
        return view('backend.delegationType.edit')->with('type',$type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type=DelegationType::findOrFail($id);
        $this->validate($request,[
            'name'=>'string|required',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        // return $data;
        $status=$type->fill($data)->save();
        if($status){
            request()->session()->flash('success','Delegation type successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type=DelegationType::findOrFail($id);
        $status=$type->delete();
        
        if($status){
            request()->session()->flash('success','Delegation type successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting delegation type');
        }
        return redirect()->route('type.index');
    }
}
