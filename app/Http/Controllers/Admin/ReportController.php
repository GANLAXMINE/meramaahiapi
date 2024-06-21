<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReasonReport;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Check if the request is AJAX
        if ($request->ajax()) {
            // Retrieve all reasons along with their related models
            $reasons = ReasonReport::with(['user', 'reasonQuestion', 'reportBy', 'reasonSubquestion'])->orderBy('created_at', 'desc')->get();

            // Return the data in DataTables format
            return DataTables::of($reasons)
                ->addIndexColumn()
                // Column: Report By (Reported By User)
                ->addColumn('report_by', function ($reason) {
                    return $reason->reportBy->name ?? '';
                })
                // Column: User (Reported User)
                ->addColumn('user_id', function ($reason) {
                    return $reason->user->name ?? '';
                })
                // Column: Reason Question (Reason for Report)
                ->addColumn('reason_question_id', function ($reason) {
                    return $reason->reasonQuestion->answer ?? '';
                })
                // Column: Reason Subquestion (Additional Reason Details)
                ->addColumn('reason_subquestion_id', function ($reason) {
                    return $reason->reasonSubquestion->reason_subquestion ?? '';
                })
                // Column: Message (Additional Message)
                ->addColumn('message', function ($reason) {
                    $message = $reason->message ?? 'N/A';
                    if ($message === 'N/A') {
                        return $message; // If message is 'N/A', return directly
                    }
                    $words = explode(' ', $message);

                    if (count($words) > 10) {
                        $limitedMessage = implode(' ', array_slice($words, 0, 5));
                        $return = '<span class="limited-message">' . $limitedMessage . '...</span>';
                        $return .= '<span class="full-message" style="display:none;">' . $message . '</span>';
                        $return .= '<button class="see-more-btn" onclick="showFullMessage(this)">See More</button>';
                    } else {
                        $return = $message;
                    }

                    return $return;
                })
                // Column: Created At (Date and Time of Report)
                ->addColumn('created_at', function ($reason) {
                    return \Carbon\Carbon::parse($reason->created_at)->format('Y-m-d H:i:s');
                })
                // Define raw columns
                ->rawColumns(['status', 'report_by', 'user_id', 'reason_question_id', 'reason_subquestion_id', 'created_at', 'message'])
                // Make the DataTables instance and return the data
                ->make(true);
        }

        // If the request is not AJAX, render the view
        return view('admin.reasons.index');
    }
}
