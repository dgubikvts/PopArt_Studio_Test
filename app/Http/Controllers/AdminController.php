<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Condition;

class AdminController extends Controller
{
    public function index(User $user){
        if(Auth::user()->isAdmin()){
            $ads = Advertisement::with('images')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.index')->with('ads', $ads);
        }
        else return abort(404);
    }

    public function users(User $user){
        if(Auth::user()->isAdmin()){
            $users = User::paginate(20);
            return view('admin.users')->with('users', $users);
        }
        else return abort(404);
    }

    public function categories(){
        if(Auth::user()->isAdmin()){
            $categories = Category::with('getChildren')->whereNull('parent_id')->get();
            return view('admin.categories')->with('categories', $categories);
        }
        else return abort(404);
    }

    public function conditions(){
        $conditions = Condition::all();
        return view('admin.conditions')->with('conditions', $conditions);
    }

    public function delete_user(Request $request){
        if($request->user && Auth::user()->isAdmin()){
            $user = User::find($request->user);
            if(count($user->advertisements)){
                foreach($user->advertisements as $ad){
                    $ad->delete();
                    if(count($ad->images)){
                        foreach($ad->images as $image){
                            $image->delete();
                        }
                    }
                }
            }
            $user->delete();
            return response()->json();
        }
    }

    public function add_category(Request $request, $parent_id){
        if(Auth::user()->isAdmin()){
            $category = new Category;
            if($parent_id == -1) $category->addCategory($request->newCategory);
            else $category->addCategory($request->newCategory, $parent_id);
            return redirect()->back();
        }
        else return abort(404);
    }

    public function edit_category(Request $request, Category $id){
        if(Auth::user()->isAdmin()){
            $id->name = $request->editCategory;
            if($id->isDirty()) $id->save();
            return redirect()->back();
        }
        else return abort(404);
    }

    public function delete_category(Category $category){
        if(Auth::user()->isAdmin()){
            if(count($category->children)){
                foreach($category->children as $child){
                    $this->delete_category_children($child);
                }
                foreach(Advertisement::where('category', $category->id)->get() as $ad){
                    $ad->delete();
                }
                $category->delete();
            }
            else {
                foreach(Advertisement::where('category', $category->id)->get() as $ad){
                    $ad->delete();
                }
                $category->delete();
            }
            return redirect()->back();
        }
        else return abort(404);
    }

    public function delete_category_children(Category $child){
        if(count($child->children)) {
            foreach($child->children as $grandchild){
                $this->delete_category_children($grandchild);
            }
            foreach(Advertisement::where('category', $child->id)->get() as $ad){
                $ad->delete();
            }
            $child->delete();
        }
        else {
            foreach(Advertisement::where('category', $child->id)->get() as $ad){
                $ad->delete();
            }
            $child->delete();
        }
    }

    public function delete_condition(Condition $condition){
        if(Auth::user()->isAdmin()){
            foreach(Advertisement::where('condition', $condition->id)->get() as $ad){
                $ad->delete();
            }
            $condition->delete();
            return redirect()->back();
        }
        else return abort(404);
    }

    public function add_condition(Request $request){
        if(Auth::user()->isAdmin()){
            $condition = new Condition;
            $condition->newCondition($request->newCondition);
            return redirect()->back();
        }
        else return abort(404);
    }

    public function edit_condition(Request $request, Condition $id){
        if(Auth::user()->isAdmin()){
            $id->name = $request->editCondition;
            if($id->isDirty()) $id->save();
            return redirect()->back();
        }
        else return abort(404);
    }
}