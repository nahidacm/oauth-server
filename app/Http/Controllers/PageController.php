<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Display all the static pages when authenticated
     *
     * @param string $page
     * @return \Illuminate\View\View
     */
    public function index(string $page)
    {

        if ($page == "client-management") {
            $data = DB::table('oauth_clients')->paginate(10);
            if (view()->exists("pages.{$page}")) {
                return view("pages.{$page}", [
                    'data' => $data
                ]);
            }
        }

        if ($page == "user-management") {
            $data = User::where('user_type', 'user')->paginate(10);
            if (view()->exists("pages.{$page}")) {
                return view("pages.{$page}", [
                    'data' => $data
                ]);
            }
        }


        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);
    }

    public function vr()
    {
        return view("pages.virtual-reality");
    }

    public function rtl()
    {
        return view("pages.rtl");
    }

    public function profile()
    {
        return view("pages.profile-static");
    }

    public function signin()
    {
        return view("pages.sign-in-static");
    }

    public function signup()
    {
        return view("pages.sign-up-static");
    }
}
