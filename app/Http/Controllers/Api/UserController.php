<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\ContactUs;
use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Mail;

class UserController extends Controller
{
    public function index(Request $request)
{
    try {
        // Retrieve authenticated user
        $user = Auth::user();

        // Check if the user exists and is active
        if ($user && $user->status === 'active') {
            $userdata = User::where('id', $user->id)->first();
            return response()->json([
                'message' => __('messages.user_details_success'),
                'data' => $userdata
            ], 200);
        } else {
            return response()->json(['message' => __('messages.user_not_found')], 404);
        }
    } catch (\Exception $e) {
        Log::error('Error retrieving user details: ' . $e->getMessage());
        return response()->json(['message' => __('messages.user_details_failed')], 500);
    }
}
    ///////////////////////////////////////////////////////////////////////////
 public function profileCreateUpdate(Request $request)
{
    try {
        // Validate input
        $validatedData = $request->validate([
            'phone' => 'nullable|numeric',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'whatsapp' => 'nullable|numeric',
            'country_code' => 'nullable|string|max:10',
            'whatsapp_country_code' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();

        // Ensure user exists and is active
        if (!$user || $user->status !== 'active') {
            return response()->json(['message' => __('messages.user_not_found')], 404);
        }

        // Check if the new email already exists for another user
        if ($request->email && $request->email !== $user->email) {
            $existingUser = \App\Models\User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json(['message' => __('messages.email_already_used')], 409);
            }
        }

        // Update user basic information
        $user->update([
            'phone' => $request->phone ?? $user->phone,
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'whatsapp' => $request->whatsapp,
            'country_code' => $request->country_code ?? $user->country_code,
            'whatsapp_country_code' => $request->whatsapp_country_code ?? $user->whatsapp_country_code,
        ]);

        return response()->json([
            'message' => __('messages.profile_update_success'),
            'data' => $user
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error creating/updating profile: ' . $e->getMessage());
        return response()->json(['message' => __('messages.profile_update_failed')], 500);
    }
}
///////////////////////////////////////////////////////
public function contactus(Request $request)
{
    try {
        // Check if the user is authenticated
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|regex:/^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})$/',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Save the message in the ContactUs table
        ContactUs::create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'replay' => null,
        ]);
        $contactData = [
                   'name' => $validated['name'],
                    'email' => $validated['email'],
                    'subject' => $validated['subject'],
                    'description' => $validated['description'],
                ];
                // Send email to admin
                Mail::to('gomommy18@gmail.com')->send(new ContactUsMail($contactData));
        return response()->json(['message' => __('messages.contact_success')], 200);

    } catch (\Exception $e) {
        Log::error('Error sending contact message: ' . $e->getMessage());
        return response()->json(['message' => __('messages.contact_failed')], 500);
    }
}

/////////////////////////////////////////

}
