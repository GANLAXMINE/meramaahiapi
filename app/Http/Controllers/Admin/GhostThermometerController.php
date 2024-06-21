<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GhostThermometer;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class GhostThermometerController extends Controller
{
    public function index(Request $request)
    {
        // Check if the request is AJAX
        if ($request->ajax()) {
            // Retrieve all reasons along with their related models
            $reasons = GhostThermometer::with(['user', 'receiver'])
                ->select('id', 'user_id', 'receiver_id')
                ->distinct()
                ->get();

            // Return the data in DataTables format
            return DataTables::of($reasons)
                ->addIndexColumn()
                // Column: Report By (Reported By User)
                ->addColumn('user_id', function ($reason) {
                    return $reason->user->name ?? '';
                })
                // Column: User (Reported User)
                ->addColumn('receiver_id', function ($reason) {
                    return $reason->receiver->name ?? '';
                })
                ->addColumn('action', function ($item) {
                    $button = '<a href="' . url("/admin/ghost/thermometer/" . $item->user_id . '/' . $item->receiver_id) . '" class="btn btn-info btn-sm" title="View"><i class="fas fa-eye" aria-hidden="true"></i> View</a>';
                    return $button;
                })



                // Define raw columns
                ->rawColumns(['user_id', 'receiver_id', 'action'])
                // Make the DataTables instance and return the data
                ->make(true);
        }

        // If the request is not AJAX, render the view
        return view('admin.ghost_therometers.index');
    }
    public function showUserGhostMeter($user_id, $receiver_id)
    {
        // Fetch the user names
        $user = User::find($user_id);
        $receiver = User::find($receiver_id);

        // Fetch the GhostThermometer data based on user_id and receiver_id
        $ghostThermometer = GhostThermometer::where('user_id', $user_id)
            ->where('receiver_id', $receiver_id)
            ->first();

        // Fetch the GhostThermometer data based on receiver_id and user_id (swapped)
        $oppositeGhostThermometer = GhostThermometer::where('user_id', $receiver_id)
            ->where('receiver_id', $user_id)
            ->first();

        // Pass the data to the view
        return view('admin.ghost_therometers.show', [
            'user_name' => $user->name,
            'receiver_name' => $receiver->name,
            'date' => $ghostThermometer ? $ghostThermometer->date : null,
            'rating' => $ghostThermometer ? $ghostThermometer->rating : null,
            'answer' => $ghostThermometer ? $ghostThermometer->answer : null,
            'oppositeDate' => $oppositeGhostThermometer ? $oppositeGhostThermometer->date : null,
            'oppositeRating' => $oppositeGhostThermometer ? $oppositeGhostThermometer->rating : null,
            'oppositeAnswer' => $oppositeGhostThermometer ? $oppositeGhostThermometer->answer : null
        ]);
    }
}
