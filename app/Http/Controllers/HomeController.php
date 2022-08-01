<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Advertisement;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function profile($id)
    {
        $user = User::where('id', $id)->with('advertisements')->first();
        $advertisements = Advertisement::where('user_id', $user->id)->with('images')->orderBy('created_at', 'desc')->paginate(10);
        return view('profile')->with('user', $user)->with('advertisements', $advertisements);
    }
}
