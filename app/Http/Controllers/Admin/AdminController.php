<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMatch;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $user = User::where('is_verify', '=', '1')->count();
        // $userCount = $this->userMatchCount();

        return view('admin.dashboard', compact('user'));
    }

    public function login()
    {
        return view('admin.auth.login');
    }
    // public function userMatchCount()
    // {
    //     // Get distinct pairs of matched users
    //     $uniqueMatches = UserMatch::select('user_id', 'match_user')
    //         ->distinct()
    //         ->get();

    //     // Initialize an empty array to store unique match IDs
    //     $uniqueMatchIds = [];

    //     // Loop through the distinct pairs and store the first match ID encountered
    //     foreach ($uniqueMatches as $match) {
    //         $matchId = UserMatch::where('user_id', $match->user_id)
    //             ->where('match_user', $match->match_user)
    //             ->orWhere('user_id', $match->match_user)
    //             ->where('match_user', $match->user_id)
    //             ->orderBy('created_at', 'asc') // Change this if you want to order by a different criteria
    //             ->value('id');

    //         if (!in_array($matchId, $uniqueMatchIds)) {
    //             $uniqueMatchIds[] = $matchId;
    //         }
    //     }

    //     // Count the unique match IDs
    //     $userMatchCount = count($uniqueMatchIds);

    //     return $userMatchCount;
    // }
}
