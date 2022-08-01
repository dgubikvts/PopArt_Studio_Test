<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Advertisement;
use App\Models\Category;


class GuestController extends Controller
{
    public function index()
    {
        $ads = Advertisement::with('images')->orderBy('created_at', 'desc')->paginate(10);
        return view('welcome')->with('ads', $ads);
    }

    public function view_ad($ad_id){
        $ad = Advertisement::find($ad_id);
        return view('view-ad')->with('ad', $ad);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query'=>'required'
        ]);
        $query = $request->input('query');
        $category = Category::where('name', 'like', $query)->first();
        $ads = Advertisement::where('title', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%")
                            ->orWhere('price', 'like', "%$query%")
                            ->orWhere('location', 'like', "%$query%")
                            ->orWhere('category', $category ? $category->id : '')
                            ->orderBy('created_at', 'desc')->paginate(10);
        return view('sortByCategory')->with('ads', $ads)->with('category', $query);
    }
}
