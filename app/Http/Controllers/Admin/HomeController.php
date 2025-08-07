<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserEmailRequests;
use App\Http\Requests\Admin\Users\UserSignInRequests;
use App\Mail\ForgetPassword;
use App\Models\Admin;
use App\Models\Otp;
use App\Models\Transaction;
use App\Models\CartOrderSummary;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use carbon\Carbon;
use App\Mail\forgetPasswordAdmin;

class HomeController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user();
            $request->session()->put('admin.name', $admin->name);
            $request->session()->put('admin.image', url('public/storage/' . $admin->image));
            return redirect()->route('admin.dashboard')->with('success', 'Login successfully');
        }
       return back()->with('error', 'Invalid credentials. Please try again.');

    }
    public function createForgetPassword()
    {
         return view('auth.forget_password');
    }
    public function sendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|regex:/^[^@]+@[^@]+\.[a-zA-Z]{2,6}$/',
    ]);

    $admin = Admin::where('email', $request->email)->first();
    if (!$admin) {
        return back()->with('error', 'Admin not found. Please check your email address.');
    }

    try {
        // Generate a random 6-digit OTP
        $otpValue = rand(1000, 9999);

        // Delete any existing OTPs for this admin
        OTP::where('type', 'email')->where('user_id', $admin->id)->delete();

        // Insert new OTP
        OTP::create([
            'type' => 'email',
            'value' => $otpValue,
            'user_id' => $admin->id,
            'models_type' => 'admin'
        ]);

        // Send OTP email
        Mail::to($admin->email)->send(new forgetPasswordAdmin($otpValue));

        return redirect()->route('admin.access.changePassword')->with('success', 'OTP has been sent to your email address.');
    } catch (\Exception $e) {
        // dd($e);
        \Log::error('OTP sending failed: ' . $e->getMessage());
        return back()->withErrors(['email' => 'Failed to send OTP. Please try again later.']);
    }
}
    public function editForgetPassword()
    {
         return view('auth.change_password');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:4',
            'password' => 'required|min:8|max:20',
            'confirm_password' => 'required|same:password|min:6|max:20',
        ]);
        try {
            $otp = OTP::where('value', $request->otp)
                ->where('user_id', 1)
                ->where('models_type', 'admin')
                ->first();
            if (!$otp) {
                return back()->withErrors(['otp' => 'Invalid OTP.']);
            }
            $admin = Admin::find(1);
            if (!$admin) {
                return redirect()->route('admin.access.login')->withErrors(['error' => 'Admin user not found.']);
            }
            $admin->password = Hash::make($request->password);
            if (!$admin->save()) {
                return back()->withErrors(['error' => 'Failed to update password.']);
            }
            $admin->save();
                OTP::where('value', $request->otp)
                ->where('user_id', 1)
                ->where('models_type', 'admin')
                ->delete();
            return redirect()->route('admin.access.login')->with('success', 'Password changed successfully. Please login with your new password.');
        } catch (\Exception $e) {
            dd($e);
            \Log::error('Password change failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to change password. Please try again later.']);
        }
    }
public function dashboard(Request $request)
{
    // Define default start and end date if no input is given
    $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : now()->startOfDay();
    $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : now()->endOfDay();

    // Fetch required stats with date range filter
    $userCount = User::whereBetween('created_at', [$startDate, $endDate])->count();
    $transactionCount = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
    $notificationCount = Notification::whereBetween('created_at', [$startDate, $endDate])->count();
    $productCount = Product::whereBetween('created_at', [$startDate, $endDate])->count(); // Assuming product count is not filtered by date
    $couponCount = Coupon::whereBetween('created_at', [$startDate, $endDate])->count(); // Assuming coupon count is not filtered by date
    $totalEarnings = CartOrderSummary::whereBetween('created_at', [$startDate, $endDate])->count();

    // Earnings chart: Earnings Over Time (Filtered by date range)
    $earnings = CartOrderSummary::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(grand_total) as total')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

    $earningsLabels = $earnings->map(function ($e) {
        return \Carbon\Carbon::create($e->year, $e->month, 1)->format('M Y');
    });

    $earningsData = $earnings->pluck('total');

    // User growth chart: User Growth Over Time (Filtered by date range)
    $userGrowth = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

    $userGrowthLabels = $userGrowth->map(function ($u) {
        return \Carbon\Carbon::create($u->year, $u->month, 1)->format('M Y');
    });

    $userGrowthData = $userGrowth->pluck('total');

    // Pass the startDate and endDate to the view
    return view('admin.dashboard', compact(
        'userCount',
        'productCount',
        'couponCount',
        'notificationCount',
        'transactionCount',
        'totalEarnings',
        'earningsLabels',
        'earningsData',
        'userGrowthLabels',
        'userGrowthData',
        'startDate',
        'endDate' // Pass the variables to the view
    ));
}





    public function signOut()
    {
        Auth::guard('admin')->logout(); 
        return redirect()->route('admin.access.login')->with('status', 'You have been logged out successfully.');
    }
}
