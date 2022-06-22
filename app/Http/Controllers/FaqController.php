<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faq = Faq::orderBy("id", 'DESC')->where('status', 1)->get();
        return view('web.faq.index', compact('faq'));
    }
}
