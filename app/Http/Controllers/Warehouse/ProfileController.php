<?php
namespace App\Http\Controllers\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function index()
{
    $user = Auth::guard('warehouse')->user();
    if ($user) {
        return view('warehouse.profile.index', compact('user'));
    }
}
    //////////////////////////////////////
   public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|min:8',
        'new_password' => 'required|min:8',
        'confirm_password' => 'required|min:8'
    ]);

    $user = Auth::guard('warehouse')->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->with('error', 'Current password does not match.');
    }

    if ($request->current_password === $request->new_password) {
        return redirect()->back()->with('error', 'New password cannot be the same as the current password.');
    }

    if ($request->new_password !== $request->confirm_password) {
        return redirect()->back()->with('error', 'New password and confirmation password do not match.');
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Password updated successfully!');
}

//////////////////////////////////
    public function updateProfile(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:20',
             'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            // Get the authenticated user
            $user = Auth::guard('warehouse')->user();
            // dd($user);
            // Update user's name and email
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            // Handle the profile picture upload if provided
            if ($request->hasFile('image')) {
                // Delete the old profile picture if it exists
                if ($user->image) {
                    Storage::delete($user->image);
                }
                // Store the new image in 'public/profile_images'
                $imagePath = $request->file('image')->store('profile_images', 'public');
                // Update the user's profile image path
                $user->image = $imagePath;
            }
            // Save the updated user data
            $user->save();
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
    }
}
