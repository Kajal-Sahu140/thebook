<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function index()
    {
        $user=Admin::first();
        return view('admin.Profile.index',compact('user'));
    }
    //////////////////////////////////////
 public function updatePassword(Request $request)
{
    // Validate the input fields
    $request->validate([
        'current_password' => 'required|min:8', // Current password is required with a minimum length of 6
        'new_password' => 'required|min:8', // New password is required with a minimum length of 6 and must be confirmed
    ]);
     //dd($request->all());
    // Get the authenticated user
    $user = Auth::guard('admin')->user();
    // Check if the current password matches the one in the database
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withInput()->withErrors(['current_password' => 'Current password does not match.']);
    }
    // Check if the new password is the same as the current password
    if ($request->current_password === $request->new_password) {
        return redirect()->back()->with('error', 'New password cannot be the same as the current password.');
    }
    // Check if the new password and confirm password match
    if ($request->new_password !== $request->confirm_password) {
        return redirect()->back()->with('error', 'New password and confirmation password do not match.');
    }
    // dd($request->all());
    // Update the password in the database
    $user->password = Hash::make($request->new_password);
    $user->save();
    // Return success message
    return redirect()->back()->with('success', 'Password changed successfully!');
}

public function updateProfile(Request $request)
{
    // Validation rules with proper email format validation
    $request->validate([
        'name' => 'required|string|max:50',
        'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/','max:100'], // Ensures a valid email format
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // File size validation
    ]);
    try {
        $user = Auth::guard('admin')->user();

        // Assign updated data
        $user->name = $request->name;
        $user->email = $request->email;

        // Handle profile image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Store new image
            $user->image = $request->file('image')->store('profile_images', 'public');
        }

        // Save updated user data
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        // Handle exceptions and return an error message
        return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
    }
}

////////////////////////////////////////
}
