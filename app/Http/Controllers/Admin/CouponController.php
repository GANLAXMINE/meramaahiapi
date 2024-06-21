<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $questions = Coupon::all();
    //         // $users = User::all();
    //         return DataTables::of($questions)
    //             ->addIndexColumn()
    //             ->addColumn('name', function ($item) {
    //                 $return = $item->name;
    //                 return $return;
    //             })->addColumn('description', function ($item) {
    //                 $return = $item->description;
    //                 return $return;
    //             })->addColumn('code', function ($item) {
    //                 $return = $item->code;
    //                 return $return;
    //             })->addColumn('type', function ($item) {
    //                 $return = $item->type;
    //                 return $return;
    //             })
    //             ->addColumn('start_date', function ($item) {
    //                 return \Carbon\Carbon::parse($item->start_date)->format('Y-m-d');
    //             })
    //             ->addColumn('end_date', function ($item) {
    //                 return \Carbon\Carbon::parse($item->end_date)->format('Y-m-d');
    //             })
    //             ->addColumn('status', function ($item) {

    //                 if ($item->status == 1) {

    //                     $return = '<label class="switch "><input type="checkbox" class="changeStatus" value="' . $item->id . '" data-status="0"  checked><span class="slider round"></span></label>';
    //                 } else {
    //                     $return = '<label class="switch"><input type="checkbox" class="changeStatus" value="' . $item->id . '" data-status="1" ><span class="slider round"></span></label>';
    //                 }

    //                 return $return;
    //             })

    //             ->addColumn('action', function ($item) {
    //                 $return = '';
    //                 $return .= '<a href="' . url("/admin/coupons/" . $item->id) . '" title="View Questions"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a> ';
    //                 $return .= '<a href="' . url("/admin/coupons/" . $item->id . "/edit") . '" title="Edit Questions"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a> ';
    //                 $return .= '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove Questions" data-remove="' . url("/admin/coupons/" . $item->id) . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
    //                 return $return;
    //             })

    //             ->rawColumns(['name', 'description', 'code', 'type', 'discount_amount', 'min_amount', 'start_date', 'end_date', 'action'])
    //             ->make(true);
    //     }
    //     return view('admin.coupons.index');
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $coupons = Coupon::all();

            return DataTables::of($coupons)
                ->addIndexColumn()
                ->addColumn('name', function ($coupon) {
                    return $coupon->name;
                })
                ->addColumn('description', function ($coupon) {
                    return $coupon->description;
                })
                ->addColumn('code', function ($coupon) {
                    return $coupon->code;
                })
                ->addColumn('type', function ($coupon) {
                    return $coupon->type;
                })
                ->addColumn('start_date', function ($coupon) {
                    return \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d H:i:s');
                })
                ->addColumn('end_date', function ($coupon) {
                    return \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d H:i:s');
                })
                ->addColumn('status', function ($coupon) {
                    $checked = $coupon->status == 1 ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" class="changeStatus" value="' . $coupon->id . '" data-status="' . $coupon->status . '" ' . $checked . '>
                                <span class="slider round"></span>
                            </label>';
                })

                ->addColumn('action', function ($coupon) {
                    $editUrl = url("/admin/coupons/" . $coupon->id . "/edit");
                    $viewUrl = url("/admin/coupons/" . $coupon->id);
                    $deleteUrl = url("/admin/coupons/" . $coupon->id);

                    $editBtn = '<a href="' . $editUrl . '" title="Edit Questions"><button class="btn btn-warning btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>';
                    $viewBtn = '<a href="' . $viewUrl . '" title="View Questions"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm btnDelete" type="submit" title="Remove Questions" data-remove="' . $deleteUrl . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';

                    return $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.coupons.index');
    }


    public function create()
    {
        $types = [
            'fixed' =>  'fixed',
            'percent' => 'percent'
        ];

        return view('admin.coupons.create', ['types' => $types]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'description' => '',
                'code' => 'required|unique:coupons',
                'type' => 'required',
                'discount_amount' => '',
                'min_amount' => '',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'usage_limit' => 'numeric|nullable',
                'usage_count' => 'numeric|nullable',
                'status' => 'nullable'
            ],
            [
                'end_date.after' => 'The end date must be after the start date.'
            ]
        );

        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'code' => $request->input('code'),
            'type' => $request->input('type'),
            'discount_amount' => $request->input('discount_amount'),
            'min_amount' => $request->input('min_amount'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'usage_limit' => $request->input('usage_limit'),
            'usage_count' => $request->input('usage_count'),
        ];

        $store =  Coupon::create($data);
        //   dd($store);

        return redirect('admin/coupons')->with('flash_message', 'Coupon added!');
    }

    public function edit($id)
    {

        $types = [
            'fixed' =>  'fixed',
            'percent' => 'percent'
        ];
        $coupons = Coupon::findOrFail($id);

        return view('admin.coupons.edit', ['types' => $types, 'coupons' => $coupons]);
    }

    public function show($id)
    {
        try {
            $coupons = Coupon::findOrFail($id);
            return view('admin.coupons.show', compact('coupons'));
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', "coupon doesn't Exist!");
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => '',
            'code' => 'required|unique:coupons,code,' . $id,
            'type' => 'required',
            'discount_amount' => '',
            'min_amount' => '',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'numeric|nullable',
            'usage_count' => 'numeric|nullable',
            'status' => 'nullable'
        ], [
            'end_date.after' => 'The end date must be after the start date.'
        ]);

        try {
            $coupon = Coupon::findOrFail($id);

            $data = $request->only(['name', 'description', 'code', 'type', 'discount_amount', 'min_amount', 'start_date', 'end_date', 'usage_limit', 'usage_count', 'status']);

            $coupon->update($data);

            return redirect('admin/coupons')->with('flash_message', 'Coupon updated!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'Failed to update coupon: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {

        $coupons = Coupon::find($id);
        if ($request->ajax()) {
            if (Coupon::destroy($id)) {
                $data = 'Success';
            } else {
                $data = 'Failed';
            }
            return response()->json($data);
        }
        Coupon::destroy($id);
        return redirect('admin/coupons')->with('flash_message', ' Coupon deleted!');
    }

    public function updateStatus(Request $request)
    {
        $couponId = $request->id;
        $coupon = Coupon::find($couponId);

        if (!$coupon) {
            // Handle case where coupon with the given ID is not found
            return response()->json(["success" => false, 'message' => 'Coupon not found.']);
        }

        $newStatus = $request->status;

        // Update coupon status
        $coupon->status = $newStatus;
        $coupon->save();

        return redirect('admin/coupons')->with('flash_message','Coupon status updated successfully.');
    }
}
