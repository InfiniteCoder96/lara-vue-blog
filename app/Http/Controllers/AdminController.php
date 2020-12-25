<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    public function uploadCategoryImage(Request $request){

        $this->validate($request, [
            'file' => 'required|mimes:jpeg,png,jpg'
        ]);

        $image = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads/categories'), $image);
        return $image;
    }

    public function deleteCategoryImage(Request $request){

        $this->validate($request, [
            'imageName' => 'required'
        ]);

        /*if($request->edit==true){
            $category = Category::where('iconImage', $request->imageName)->first();

            $pos = strrpos($category->iconImage, '/');
            $image = $pos === false ? $category->iconImage : substr($category->iconImage, $pos + 1);

            $this->deleteImageFromServer($image, $category->iconImage);
        }
        else{*/
            $image = $request->imageName;
            $imagePath = public_path().'/uploads/categories/'.$image;
            $this->deleteImageFromServer($image, $imagePath);
        //}
        
        return response()->json([
            'msg' => 'file deleted successfully'
        ]);
    }

    private function deleteImageFromServer($fileName, $filePath){
        $image = $fileName;
        $imagePath = $filePath;
        
        if(file_exists($imagePath)){
            @unlink($imagePath);
        }
        
        return;
    }

    /*
    * Categories
    */
    public function addCategory(Request $request){
        $this->validate($request, [
            'iconImage'=> 'required',
            'categoryName' => 'required'
        ]);
        return Category::create([
            'categoryName' => $request->categoryName,
            'iconImage'=> $request->iconImage
        ]);
    }
    
    public function getCategories(){
        return Category::orderBy('id', 'desc')->get();
    }

    public function editCategory(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'iconImage' => 'required',
            'categoryName' => 'required'
        ]);

        Category::where('id', $request->id)->update([
            'iconImage' => $request->iconImage,
            'categoryName' => $request->categoryName
        ]);
        return Category::orderBy('id', 'desc')->get();
    }

    public function deleteCategory(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);

        $category = Category::where('id', $request->id)->first();

        $pos = strrpos($category->iconImage, '/');
        $image = $pos === false ? $category->iconImage : substr($category->iconImage, $pos + 1);

        $this->deleteImageFromServer($image, $category->iconImage);

        Category::where('id', $request->id)->delete();
        return Category::orderBy('id', 'desc')->get();
    }    

}
