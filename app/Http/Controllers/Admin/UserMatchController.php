<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\UserMatch;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\UserLike;
use DB;

class UserMatchController extends Controller
{

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         // Get distinct pairs of matched users
    //         $uniqueMatches = UserMatch::select('user_id', 'match_user')
    //             ->distinct()
    //             ->get();

    //         // Initialize an empty array to store unique match IDs
    //         $uniqueMatchIds = [];

    //         // Loop through the distinct pairs and store the first match ID encountered
    //         foreach ($uniqueMatches as $match) {
    //             $matchId = UserMatch::where('user_id', $match->user_id)
    //                 ->where('match_user', $match->match_user)
    //                 ->orWhere('user_id', $match->match_user)
    //                 ->where('match_user', $match->user_id)
    //                 ->orderBy('created_at', 'asc') // Change this if you want to order by a different criteria
    //                 ->value('id');

    //             if (!in_array($matchId, $uniqueMatchIds)) {
    //                 $uniqueMatchIds[] = $matchId;
    //             }
    //         }

    //         // Get the matching records using the unique match IDs
    //         $matches = UserMatch::whereIn('id', $uniqueMatchIds)->get();

    //         return DataTables::of($matches)
    //             ->addIndexColumn()
    //             ->addColumn('user_id', function ($item) {
    //                 $userName = User::where('id', $item->user_id)->value('name');
    //                 return $userName;
    //             })
    //             ->addColumn('match_user', function ($item) {
    //                 $matchUserName = User::where('id', $item->match_user)->value('name');
    //                 return $matchUserName;
    //             })
    //             // ->addColumn('no_column', function ($item) {
    //             //     return 'no';
    //             // })
    //             ->addColumn('created_at', function ($item) {
    //                 return $item->created_at->format('d-m-Y,H:i:s');
    //             })
    //             ->addColumn('action', function ($item) {
    //                 $return = '';
    //                 $return .= '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove User" data-remove="' . url("/admin/match/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
    //                 return $return;
    //             })
    //             ->rawColumns(['user_id', 'match_user','created_at', 'action'])
    //             ->make(true);
    //     }

    //     return view('admin.user_match.index');
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get distinct pairs of matched users
            $uniqueMatches = UserMatch::select('user_id', 'match_user', 'created_at')
                ->distinct()
                ->orderBy('created_at', 'desc') // Ensure the order is applied here
                ->get();

            // Initialize an empty array to store unique match IDs
            $uniqueMatchIds = [];

            // Loop through the distinct pairs and store the first match ID encountered
            foreach ($uniqueMatches as $match) {
                $matchId = UserMatch::where(function ($query) use ($match) {
                    $query->where('user_id', $match->user_id)
                        ->where('match_user', $match->match_user);
                })
                    ->orWhere(function ($query) use ($match) {
                        $query->where('user_id', $match->match_user)
                            ->where('match_user', $match->user_id);
                    })
                    ->orderBy('created_at', 'desc') // Ensure the order is applied here
                    ->value('id');

                if (!in_array($matchId, $uniqueMatchIds)) {
                    $uniqueMatchIds[] = $matchId;
                }
            }

            // Get the matching records using the unique match IDs, ordered by creation date in descending order
            $matches = UserMatch::whereIn('id', $uniqueMatchIds)
                ->orderBy('created_at', 'desc') // Ensure the order is applied here
                ->get();

            return DataTables::of($matches)
                ->addIndexColumn()
                ->addColumn('user_id', function ($item) {
                    return User::where('id', $item->user_id)->value('name');
                })
                ->addColumn('match_user', function ($item) {
                    return User::where('id', $item->match_user)->value('name');
                })
                ->addColumn('created_at', function ($item) {
                    return $item->created_at->format('d-m-Y, H:i:s');
                })
                ->addColumn('action', function ($item) {
                    return '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove User" data-remove="' . url("/admin/match/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
                })
                ->rawColumns(['user_id', 'match_user', 'created_at', 'action'])
                ->make(true);
        }

        return view('admin.user_match.index');
    }



    public function destroy(Request $request, $id)
    {
        // dd('sss');
        $match = UserMatch::findOrFail($id);

        // Capture the current URL
        $currentUrl = url()->current();

        // Find and delete both entries based on conditions
        UserMatch::where(function ($query) use ($match) {
            $query->where(function ($query) use ($match) {
                $query->where('user_id', $match->user_id)
                    ->where('match_user', $match->match_user);
            })->orWhere(function ($query) use ($match) {
                $query->where('user_id', $match->match_user)
                    ->where('match_user', $match->user_id);
            });
        })->delete();

        // Delete associated like records
        UserLike::where(function ($query) use ($match) {
            $query->where(function ($query) use ($match) {
                $query->where('like_by', $match->user_id)
                    ->where('like_user', $match->match_user);
            })->orWhere(function ($query) use ($match) {
                $query->where('like_by', $match->match_user)
                    ->where('like_user', $match->user_id);
            });
        })->delete();

        // Additional deletion code for other related models...

        if ($request->ajax()) {
            if ($match->delete()) {
                // dd('sss');
                $data = 'Success';
            } else {
                // dd('pp');
                $data = 'Failed';
            }
            return response()->json($data);
        }

        // If it's not an AJAX request, redirect to the captured URL
        return redirect($currentUrl)->with('flash_message', 'Match deleted!');
    }
}
