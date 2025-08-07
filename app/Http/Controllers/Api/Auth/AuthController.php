<?php
namespace App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Import Log for logging errors
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Services\FirebaseService;
class AuthController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

public function register(Request $request)
{
    try {
        $fcmToken = $request->header('fcm-token');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at'), // Check only non-deleted records
            ],
            'phone' => [
                'required',
                'digits_between:8,15',
                Rule::unique('users')->whereNull('deleted_at'), // Check only non-deleted records
            ],
            'country_code' => 'required|string',
            'whatsapp' => 'nullable|numeric',
            'whatsapp_country_code' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => implode(' ', $errors)], 400);
        }

        // Check if the email or phone already exists (whether active or soft-deleted)
        $existingUser = User::withTrashed()
            ->where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if ($existingUser) {
            if ($existingUser->trashed()) {
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'country_code' => $request->country_code,
                    'whatsapp' => $request->whatsapp,
                    'whatsapp_country_code' => $request->whatsapp_country_code,
                    'device_type' => $request->device_type,
                    'fcm_token' => $fcmToken,
                    // 'lang'=> $request->lang,
                    'status' => 'active',
                ]);
            } else {
                return response()->json(['message' => __('messages.email_exists')], 400);
            }
        } else {
            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country_code' => $request->country_code,
                'whatsapp' => $request->whatsapp,
                'whatsapp_country_code' => $request->whatsapp_country_code,
                'device_type' => $request->device_type,
                'fcm_token' => $fcmToken,
                'status' => 'active',
            ]);
        }

        Notification::create([
            'user_id' => $newUser->id,
            'type' => 'others', 
            'title' => __('messages.notification_title'),
            'message' => __('messages.notification_message'),
            'status' => 'unread',
        ]);

        if ($newUser->fcm_token) {
            $title = __('messages.notification_title');
            $body = __('messages.notification_message');
            $this->firebaseService->sendNotification($newUser->fcm_token, $title, $body);
        }

        // Generate OTP for verification
        $otp = rand(1000, 9999);
        Otp::create([
            'type' => 'phone',
            'value' => $otp,
            'user_id' => $newUser->id,
            'models_type' => 'user'
        ]);

        // Generate Bearer token
        $token = $newUser->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'message' => __('messages.registration_success'),
            'otp' => $otp, // ⚠️ Remove this in production
            'token' => $token,
            'user_id' => $newUser->id,
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error during user registration: ' . $e->getMessage());
        return response()->json(['message' => __('messages.registration_failed')], 500);
    }
}

    public function otpVerify(Request $request)
{
    try {
        $fcmToken = $request->header('fcm-token');

        // Validate input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Check for the OTP in the database
        $otpRecord = Otp::where('user_id', $request->user_id)
            ->where('value', $request->otp)
            ->where('type', 'phone')
            ->first();

        if (!$otpRecord) {
            return response()->json(['status' => 0, 'message' => __('messages.otp_invalid')], 400);
        }

        // If OTP is valid, update the user's status
        $user = User::find($request->user_id);
        $user->status = 'active'; 
        $user->lang = $request->lang;
        $user->phone_verified_at = now(); 
        $user->fcm_token = $fcmToken;
        $user->save();

        // Delete OTP record after successful verification
        Otp::where('type', 'phone')->where('user_id', $user->id)->delete();

        return response()->json(['status' => 1, 'message' => __('messages.otp_verified')], 200);

    } catch (\Exception $e) {
        Log::error('Error during OTP verification: ' . $e->getMessage());
        return response()->json(['message' => __('messages.otp_verification_failed')], 500);
    }
}
    public function resendOtp(Request $request)
{
    $fcmtoken = $request->input('fcm_token');

    try {
        // Validate input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Fetch user
        $user = User::find($request->user_id);

        // Generate a new OTP
        $otp = rand(1000, 9999);

        // Remove any existing OTP and create a new one
        Otp::where('type', 'phone')->where('user_id', $user->id)->delete();
        Otp::create(['type' => 'phone', 'value' => $otp, 'user_id' => $user->id, 'models_type' => 'user']);

        // Implement SMS sending service here (Example: $this->sendSms($user->phone, $otp));

        return response()->json([
            'message' => __('messages.otp_resend_success'),
            'otp' => $otp // Remove in production
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error during OTP resend: ' . $e->getMessage());
        return response()->json(['message' => __('messages.otp_resend_failed')], 500);
    }
}
   public function requestOtp(Request $request)
{
    try {
        $fcmToken = $request->header('fcm-token');
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'country_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $input = $request->phone;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $input)->first();
            if (!$user) {
                return response()->json(['message' => __('messages.email_not_found')], 404);
            }
        } else {
            $user = User::where('phone', $input)
                        ->where('country_code', $request->country_code)
                        ->first();
            if (!$user) {
                return response()->json(['message' => __('messages.phone_not_found')], 404);
            }
        }

        if ($user->status != "active") {
            return response()->json(['message' => __('messages.account_inactive')], 403);
        }

        if ($fcmToken) {
            $user->update(['fcm_token' => $fcmToken]);
        }

        $otp = rand(1000, 9999);
        Otp::where('type', 'phone')->where('user_id', $user->id)->delete();
        Otp::insert([
            'type' => 'phone',
            'value' => $otp,
            'user_id' => $user->id,
            'models_type' => 'user',
        ]);

        // Send OTP (SMS or Email)
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // Mail::to($user->email)->send(new OtpMail($otp));
        } else {
            // $this->sendSms($user->phone, $otp);
        }

        return response()->json([
            'message' => __('messages.otp_sent', ['type' => filter_var($input, FILTER_VALIDATE_EMAIL) ? __('messages.email') : __('messages.phone')]),
            'otp' => $otp, // ⚠️ Remove this in production
            'user_id' => $user->id,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error during OTP request: ' . $e->getMessage());
        return response()->json(['message' => __('messages.otp_failed')], 500);
    }
}
//////////////////////////////////////////////////////////////////////////////////
 public function verifyOtp(Request $request)
{
    try {
        $fcmToken=$request->header('fcm-token');
        $validator = Validator::make($request->all(), [
            'phone' => 'required_without:email', 
            'otp' => 'required|numeric', 
            'country_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $input = $request->phone ?: $request->email;
        $user = null;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $input)->first();
        } else {
            if ($request->phone) {
                $user = User::where('phone', $request->phone)
                    ->where('country_code', $request->country_code)
                    ->first();
            }
        }
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $otpRecord = Otp::where('user_id', $user->id)
            ->where('value', $request->otp)
            ->where('type', 'phone')
            ->first();
        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid OTP.'], 400);
        }
         if ($fcmToken) {
            $user->update(['fcm_token' => $fcmToken]);
        }
         
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $type=$request->type;
        if($type==1)
        {
            return response()->json([
            'message' => __('messages.login_success'),
            'user' => $user,
            'token' => $token,
        ], 200);
        }
        else
        {
            return response()->json([
            'message' => __('messages.register_success'),
            'user' => $user,
            'token' => $token,
        ], 200);
        }
        
    } catch (\Exception $e) {
        Log::error('Error during OTP verification: ' . $e->getMessage());
        return response()->json(['message' => 'OTP verification failed.'], 500);
    }
}
//////////////////////////////////////////////////////////////////////////////
}
