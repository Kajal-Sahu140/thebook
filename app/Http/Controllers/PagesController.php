<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pages;
use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function aboutus()
{
    $lang = request()->query('lang', 'en'); // Get 'lang' from URL, default to 'en'
    $page = Pages::where('slug', 'about-us-home-page')->first();
    
    return view('pages.aboutus', compact('page', 'lang'));
}

    public function privacypolicy()
    {
         $lang = request()->query('lang', 'en');
        $page=Pages::where('slug','privacy_policy')->first();
         return view('pages.privacy',compact('page','lang'));
    }
    public function tremscondition()
    {
         $lang = request()->query('lang', 'en');
        $page=Pages::where('slug','terms-and-conditions')->first();
         return view('pages.trems',compact('page','lang'));
    }
    public function faq()
    {
         $lang = request()->query('lang', 'en');
        $page=Faq::where('status','active')->get();
         return view('pages.faq',compact('page','lang'));
    }
}
