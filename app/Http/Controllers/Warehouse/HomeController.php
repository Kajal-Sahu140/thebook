<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\CartOrderSummary;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HomeController extends Controller
{
   public function index()
   {
    return view('warehouse.auth.login');
   }
    public function signIn(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    if (Auth::guard('warehouse')->attempt($request->only('email', 'password'))) {
        $warehouse = Auth::guard('warehouse')->user();
        if ($warehouse->status !== 'active') {
            Auth::guard('warehouse')->logout();
            return back()->withErrors([
                'email' => 'Your account is inactive. Please contact support.',
            ]);
        }
        $request->session()->regenerate();
        $request->session()->put('warehouse.name', $warehouse->name);
        $request->session()->put('warehouse.image', url('/storage/' . $warehouse->image));
        return redirect()->route('warehouse.dashboard')->with('success', 'You have been logged in successfully.');
    }
    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}
public function dashboard(Request $request)
{
    // Default start and end dates (last 30 days)
    $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : now()->subDays(30);
    $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : now();

    // Fetch total users and earnings
    $userCount = User::count();
    $totalEarnings = CartOrderSummary::sum('grand_total');

    // Earnings over the last 6 months
    $earnings = CartOrderSummary::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(grand_total) as total')
        ->groupBy('year', 'month')
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->take(6)
        ->get();

    $earningsLabels = $earnings->map(fn($e) => Carbon::create($e->year, $e->month, 1)->format('M Y'));
    $earningsData = $earnings->pluck('total');

    // User growth over the last 6 months
    $userGrowth = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('year', 'month')
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->take(6)
        ->get();

    $userGrowthLabels = $userGrowth->map(fn($u) => Carbon::create($u->year, $u->month, 1)->format('M Y'));
    $userGrowthData = $userGrowth->pluck('total');

    // ✅ Pending Orders Section (Includes product details)
    $pendingOrders = CartOrderSummary::where('order_status', 'Pending')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->with(['cartItems.product'])
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    // ✅ Best-Selling Products Section (Includes ratings)
   $bestSellingProducts = Cart::selectRaw('product_sku, SUM(quantity) as total_quantity')
    ->groupBy('product_sku')
    ->with(['product' => function ($query) {
        $query->select('product_id', 'product_name', 'base_price')
            ->withAvg('productRatings as rating', 'rating') // Correct alias usage
            ->withCount('productRatings as reviews_count'); // Correct alias for count
    }])
    ->orderByDesc('total_quantity')
    ->take(5)
    ->get();


    // ✅ Real-Time Inventory Levels
    $inventoryLevels = Product::select('product_name', 'quantity')
        ->orderByDesc('quantity')
        ->get();

    return view('warehouse.dashboard', compact(
        'userCount',
        'totalEarnings',
        'earningsLabels',
        'earningsData',
        'userGrowthLabels',
        'userGrowthData',
        'pendingOrders', 
        'bestSellingProducts',
        'inventoryLevels',
        'startDate',
        'endDate'
    ));
}


    public function signOut()
    {
        Auth::guard('warehouse')->logout(); // Log out the admin user
        return redirect()->route('warehouse.access.login')->with('success', 'You have been logged out successfully.');
    }
    /////////////////////////////////////////////
    public function createForgetPassword()
    {
         return view('warehouse.auth.forgot_password');
    }
    ////////////////////////
    public function sendOtp(Request $request)
    {
    $request->validate([
        'email' => 'required|email|exists:warehouse,email', // Check if email exists in admins table
    ]);
    $otpValue = rand(1000, 9999); // Generates a random four-digit number
    $admin = warehouse::where('email', $request->email)->first();
    if (!$admin) {
        return back()->withErrors(['email' => 'warehouse not found.']);
    }
    try {
        // Insert the OTP into the database
        OTP::where('type', 'email')->where('user_id',$admin->id)->delete();
        OTP::insert([
            'type' => 'email',
            'value' => $otpValue,
            'user_id' => $admin->id,
            'models_type' => 'warehouse'
        ]);
        session()->flash('otpValue', $otpValue);
         return redirect()->route('warehouse.access.changePassword')->with('success', 'OTP has been sent to your email address get otp. ');
    } catch (\Exception $e) {
        // dd($e);
        // Log the error message (optional)
        \Log::error('OTP sending failed: ' . $e->getMessage());
        // Redirect back with an error message
        return back()->withErrors(['email' => 'Failed to send OTP. Please try again later.']);
    }
  }
  ///////////////////////////////////////////////////////////////////////////////////////////////////
  public function editForgetPassword()
    {
         return view('warehouse.auth.change_password');
    }
  public function changePassword(Request $request)
{
    // Validate the request
    $request->validate([
        'otp' => 'required|digits:4',
        'password' => 'required|min:6|max:20',
        'confirm_password' => 'required|same:password|min:6|max:20',
    ]);
    try {
        // Check if the OTP is valid
        $otp = OTP::where('value', $request->otp)
            ->where('models_type', 'warehouse')
            ->first();
        if (!$otp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }
        // Get the admin user based on OTP's user_id
        $admin = warehouse::find($otp->user_id);
        if (!$admin) {
            return redirect()->route('warehouse.access.login')->withErrors(['error' => 'Admin user not found.']);
        }
        // Update the password and save
        $admin->password = Hash::make($request->password);
        $admin->dummy_password=$request->password;
         $admin->email_verified_at= now();
        if ($admin->save()) {
            // Optionally delete the OTP after use
            OTP::where('value', $request->otp)
                ->where('user_id', $otp->user_id)
                ->where('models_type', 'warehouse')
                ->delete();

            // Redirect to login with a success message
            return redirect()->route('warehouse.access.login')->with('success', 'Password changed successfully. Please login with your new password.');
        }
        return back()->withErrors(['error' => 'Failed to update password.']);
    } catch (\Exception $e) {
        // Log the error message
        Log::error('Password change failed: ' . $e->getMessage());
        // Redirect back with an error message
        return back()->withErrors(['error' => 'Failed to change password. Please try again later.']);
    }
}
}
