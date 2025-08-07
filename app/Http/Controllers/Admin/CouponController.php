<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Validator;
class CouponController extends Controller
{
    public function index(Request $request)
{
    $recordsPerPage = config('app.admin_record_per_page', 10);
    $currentPage = $request->input('page', 1);
    $query = Coupon::orderBy('coupon_id', 'desc');
    if ($search = $request->input('search')) {
        $query->where('coupon_code', 'like', '%' . $search . '%');
    }
    $startingIndex = ($currentPage - 1) * $recordsPerPage + 1;

    try {
        $coupons = $query->paginate($recordsPerPage);
    } catch (\Exception $e) {
        \Log::error('Error retrieving coupons: ' . $e->getMessage());
        return redirect()->route('admin.coupon.index')
                         ->with('error', 'Failed to retrieve coupons.');
    }
    return view('admin.coupon.index', compact('coupons', 'startingIndex'));
}
/////////////////////////////////////////////////////////////////////////////////
public function create()
{
    return view('admin.coupon.create');
}
/////////////////////////////////////////////////////////////////////////////////
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
    'code_format' => 'required|in:numeric,alphanumeric,alphabetical',
    'usage_limit_per_coupon' => 'required|integer|min:1|max:100000', // Set max limit here
    'usage_limit_per_customer' => 'required|integer|min:1|max:100',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
    'discount_type' => 'required|in:percentage,flat',
    'discount_value' => 'required|numeric|min:0|max:99',
    'min_purchase_amount' => 'nullable|numeric|min:0',
    'max_discount_amount' => 'nullable|numeric|min:0',
]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $couponCode =$this->generateCouponCode($request->input('code_format'), 10); // Default length = 10
            $coupon = new Coupon();
            $coupon->coupon_code = $couponCode;
            $coupon->code_format = $request->input('code_format');
            $coupon->usage_limit_per_coupon = $request->input('usage_limit_per_coupon');
            $coupon->usage_limit_per_customer = $request->input('usage_limit_per_customer');
            $coupon->start_date = $request->input('start_date');
            $coupon->end_date = $request->input('end_date');
            $coupon->discount_type = $request->input('discount_type');
            $coupon->discount_value = $request->input('discount_value');
            $coupon->min_purchase_amount = $request->input('min_purchase_amount') ?? 0;
            $coupon->max_discount_amount = $request->input('max_discount_amount') ?? null;
            $coupon->save();
            return redirect()->route('admin.coupon')->with('success', 'Coupon created successfully.');
        } catch (\Exception $e) {
            dd($e);
            \Log::error('Error creating coupon: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create coupon.')->withInput();
        }
    }
   private function generateCouponCode($format = 'alphanumeric', $length = 10)
{
    $numeric = '0123456789';
    $alphabetical = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $alphanumeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    switch ($format) {
        case 'numeric':
            $characters = $numeric;
            break;
        case 'alphabetical':
            $characters = $alphabetical;
            break;
        case 'alphanumeric':
        default:
            $characters = $alphanumeric;
            break;
    }

    return substr(str_shuffle(str_repeat($characters, ceil($length / strlen($characters)))), 0, $length);
}
/////////////////////////////////////////////////////////////////////
    public function destroy($id)
    {
        $decodedId = base64_decode($id);
        try {
            $category = Coupon::findOrFail($decodedId);
            $category->delete();
            return redirect()->route('admin.coupon')->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.coupon')->with('error', 'Failed to delete Coupon.');
        }
    }
    //////////////////////////////////////////////////
     public function edit($id)
    {
        $decodedId = base64_decode($id);
        try {
            $coupon = Coupon::findOrFail($decodedId);
            return view('admin.coupon.edit', compact('coupon'));
        } catch (\Exception $e) {
            Log::error('Error retrieving category for edit: ' . $e->getMessage());
            return redirect()->route('admin.coupon')->with('error', 'Failed to retrieve Coupon for editing.');
        }
    }
    ///////////////////////////////////////
    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
      'code_format' => 'required|in:numeric,alphanumeric,alphabetical',
    'usage_limit_per_coupon' => 'required|integer|min:1|max:100000', // Set max limit here
    'usage_limit_per_customer' => 'required|integer|min:1|max:100',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
    'discount_type' => 'required|in:percentage,flat',
    'discount_value' => 'required|numeric|min:0|max:99',
    'min_purchase_amount' => 'nullable|numeric|min:0',
    'max_discount_amount' => 'nullable|numeric|min:0',
    ]);
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    try {
        $coupon = Coupon::findOrFail($id);
        $coupon->code_format = $request->input('code_format');
        $coupon->usage_limit_per_coupon = $request->input('usage_limit_per_coupon');
        $coupon->usage_limit_per_customer = $request->input('usage_limit_per_customer');
        $coupon->start_date = $request->input('start_date');
        $coupon->end_date = $request->input('end_date');
        $coupon->discount_type = $request->input('discount_type');
        $coupon->discount_value = $request->input('discount_value');
        $coupon->min_purchase_amount = $request->input('min_purchase_amount') ?? 0;
        $coupon->max_discount_amount = $request->input('max_discount_amount') ?? null;
        $coupon->save();
        return redirect()->route('admin.coupon')->with('success', 'Coupon updated successfully.');
    } catch (\Exception $e) {
        \Log::error('Error updating coupon: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update coupon.')->withInput();
    }
}
//////////////////////////////////////////////////
public function show($id)
{
    try{
         $decodedId = base64_decode($id);
         $coupon=Coupon::where('coupon_id',$decodedId)->first();
         return view('admin.coupon.view', compact('coupon'));
    }
    catch (\Exception $e) {
        \Log::error('Error updating coupon: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update coupon.')->withInput();
    }
}
////////////////////////////////////////////////////
}
