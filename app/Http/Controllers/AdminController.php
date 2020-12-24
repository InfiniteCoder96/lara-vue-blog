<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addTag(Request $request){
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getTags(){
        return Tag::orderBy('id', 'desc')->get();
    }

    public function editTag(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'tagName' => 'required'
        ]);
        Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
        ]);
        return Tag::orderBy('id', 'desc')->get();
    }

    public function deleteTag(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        Tag::where('id', $request->id)->delete();
        return Tag::orderBy('id', 'desc')->get();
    }
}
