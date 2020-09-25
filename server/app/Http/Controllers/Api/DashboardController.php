<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Auth;

class DashboardController extends Controller
{
    //Get Employerr Jobs
    public function index(Request $request){
    	$search  = $request->keyword;

    	$query   = $request->user()->jobs();

    	if($search){
    		$query = $query->where('name', 'LIKE', '%'.$search.'%');
    	}

    	return $query
                    ->paginate(5)
                    ->appends(request()->query());
    }
}
