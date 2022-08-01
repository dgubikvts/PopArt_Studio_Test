<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Advertisement;
use App\Models\User;
use App\Models\AdImage;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function new_ad(){
        $conditions = Condition::all();
        $categories = Category::with('getChildren')->whereNull('parent_id')->get();
        return view('create-ad', compact('conditions', 'categories'));
    }

    public function create_ad(Request $request, User $user){
        if(Auth::id() == $user->id || Auth::user()->isAdmin()){
            $request->validate([
                'title' => 'required',
                'desc' => 'required',
                'price' => 'required',
                'location' => 'required',
                'phone' => 'required',
                'category' => 'required',
                'condition' => 'required',
                'files.*' => 'mimetypes:image/gif,image/jpeg,image/png|max:20000'
            ]);
            $ad = new Advertisement;
            $ad->createAd(  $request->input('title'), 
                            $request->input('desc'), 
                            $request->input('price'), 
                            $request->input('location'), 
                            $request->input('phone'), 
                            $request->input('category'), 
                            $request->input('condition'), 
                            $user->id);
            if($ad->isDirty()) $ad->save();
    
            if($request->has('files')){
                foreach($request->file('files') as $file){
                    $file_name = $file->getClientOriginalName();
                    $file_size = $file->getSize();
                    $file_extension = $file->getClientOriginalExtension();
                    $path = 'storage/files/' . $ad->id . '/' . $file_name;
                    $file->storeAs('public/files/' . $ad->id, $file_name);
                    $new_image = new AdImage();
                    $new_image->create($file_name, $file_size, $path, $ad->id);
                }
            }
            return redirect()->route('view-ad', $ad->id);
        }
        else return abort(404);
    }

    public function edit_ad(Advertisement $ad_id){
        if(Auth::id() == $ad_id->user->id || Auth::user()->isAdmin()){
            $conditions = Condition::all();
            $categories = Category::with('getChildren')->whereNull('parent_id')->get();
            return view('edit-ad')->with('ad', $ad_id)->with('conditions', $conditions)->with('categories', $categories);
        }
        else return abort(404);
    }

    public function patch_ad(Request $request,Advertisement $ad){
        $ad->createAd(  $request->input('title'), 
                        $request->input('desc'), 
                        $request->input('price'), 
                        $request->input('location'), 
                        $request->input('phone'), 
                        $request->input('category'), 
                        $request->input('condition'),
                        $ad->user->id);
        if($ad->isDirty()) $ad->save();
        if($request->has('files')){
            foreach($request->file('files') as $file){
                $file_name = $file->getClientOriginalName();
                $file_size = $file->getSize();
                $file_extension = $file->getClientOriginalExtension();
                $path = 'storage/files/' . $ad->id . '/' . $file_name;
                $file->storeAs('public/files/' . $ad->id, $file_name);
                $new_image = new AdImage();
                $new_image->create($file_name, $file_size, $path, $ad->id);
            }
        }
        return redirect()->route('view-ad', $ad->id);
    }

    public function delete_img(Request $request){
        if($request->img_id){
            $img = AdImage::find($request->img_id);
            $img->delete();
            return response()->json(['img_id' => $request->img_id]);
        }
    }

    public function delete_ad(Request $request){
        if($request->ad_id && ($request->user_id == Auth::id() || Auth::user()->isAdmin())){
            $ad = Advertisement::find($request->ad_id);
            if(count($ad->images)){
                foreach($ad->images as $image){
                    $image->delete();
                }
            }
            $ad->delete();
            return response()->json(['ad_id' => $request->ad_id]);
        }
    }
}
