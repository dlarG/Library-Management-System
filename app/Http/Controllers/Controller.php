<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function dashboard() {
        $recentUsers = User::orderBy('created_at', 'desc')
                      ->limit(3)
                      ->get();
    
        return view('admin.dashboard', compact('recentUsers'));
    }
}
