<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  
    public function dashboard()
    {
        dd('here');
        return view('backend.user.dashboard');
    }
}
