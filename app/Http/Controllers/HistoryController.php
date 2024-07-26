<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index() {
        $history=History::first();
        return view('backend.history.index')->with('history', $history);
    }

    public function update(Request $request) {
        $this->validate($request,[
            'content'=>'required|string',
        ]);
        $data=$request->all();
        $history=History::first();
        // return $settings;
        $status=$history->fill($data)->save();
        if($status){
            request()->session()->flash('success','History successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again');
        }
        return redirect()->route('admin');
    }
}
