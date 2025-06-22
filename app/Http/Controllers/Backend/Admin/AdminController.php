<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
         $data['admins'] = Admin::latest()->get();
        return view('backend.admin.index',$data);
    }
}
