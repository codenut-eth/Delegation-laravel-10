<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ratification;

class RatificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratification = Ratification::getAllRatification();
        return view('backend.ratification.index')->with('ratifications', $ratification);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.ratification.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'date'=>'date|required',
            'content'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        // return $data;   
        $status=Ratification::create($data);
        if($status){
            request()->session()->flash('success','Ratification successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('ratification.index');
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
        $ratification=Ratification::findOrFail($id);
        return view('backend.ratification.edit')->with('ratification',$ratification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request->all();
        $ratification=Ratification::findOrFail($id);
        $this->validate($request,[
            'date'=>'date|required',
            'content'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        // return $data;
        $status=$ratification->fill($data)->save();
        if($status){
            request()->session()->flash('success','Ratification successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('ratification.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ratification=Ratification::findOrFail($id);
        $status=$ratification->delete();
        
        if($status){
            request()->session()->flash('success','Ratification successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting ratification');
        }
        return redirect()->route('ratification.index');
    }
}
