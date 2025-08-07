<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\User;
use App\Mail\ContactUsMail;
use Mail;
class ContactusController extends Controller
{
    public function index(Request $request)
    {
        $pageCount = config('app.admin_record_per_page', 20);
        $currentPage = $request->input('page', 1);
        $query = ContactUs::with('user')->orderBy('id','desc');
        if ($search = $request->input('search')) {
    $query->where('name', 'like', '%' . $search . '%')
          ->orWhereHas('user', function ($q) use ($search) {
              $q->where('name', 'like', '%' . $search . '%');
          });
}
        $count = ($currentPage - 1) * $pageCount + 1;
       
        try {
            $users = $query->paginate($pageCount);
        } catch (\Exception $e) {
            Log::error('Error retrieving categories: ' . $e->getMessage());
            return redirect()->route('admin.contactus')->with('error', 'Failed to retrieve categories.');
        }
        return view('admin.contactus.index', compact('users', 'count'));
    }
    //////////////////////////////////////////////////////
    public function view($id)
    {
        $Contactus=ContactUS::where('id',$id)->first();
       return view('admin.contactus.view', compact('Contactus'));
    }
    /////////////////////////////////////////
    public function replyToContactUs(Request $request, $id)
    {
        $validated = $request->validate([
            'replay' => 'required|string',
        ]);
        $contactus = ContactUs::find($id);
        if (!$contactus) {
            return redirect()->route('admin.contactus.view', ['id' => $id])
                            ->with('error', 'Contact message not found.');
        }
        // Save the reply
        $contactus->replay = $validated['replay'];

        $contactus->save();
        $replyData = [
        'name' => $contactus->name,
        'email' => $contactus->email,  // User's email
        'subject' => 'Reply to Your Inquiry: ' . $contactus->subject,
        'replay' => $validated['replay'], // Reply message
        'description' => $contactus->description
    ];

    // Send email to the user
    Mail::to($contactus->email)->send(new ContactUsMail($replyData));
        return redirect()->route('admin.contactus')
                        ->with('success', 'Reply sent successfully.');
    }
    ///////////////////////////////////////////////////////
}
