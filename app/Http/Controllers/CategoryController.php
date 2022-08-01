<?php

namespace App\Http\Controllers;
use App\Models\Advertisement;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function items_by_category($category){
        $ctg = Category::where('slug', $category)->first();
        $ads = Advertisement::where('category', $ctg->id)->with('images')->orderBy('created_at', 'desc')->paginate(10);
        return view('sortByCategory')->with('ads', $ads)->with('category', $ctg);
    }
}
