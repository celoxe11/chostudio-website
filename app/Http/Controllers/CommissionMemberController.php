<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommissionMemberController extends Controller
{
    public function index()
    {
        return view('member.commission_type');
    }

    public function form(Request $request)
    {
        $category = $request->query('type', null);
        return view('member.commission_form', compact('category'));
    }
}
