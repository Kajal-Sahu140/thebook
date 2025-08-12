<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Video\VideoRequest;
use App\Models\Refund;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class whatsupController extends Controller
{

  public function index()
    {
        return view('admin.whatsup.index');
    }

    public function sendMultipleWhatsApp(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'users' => 'required|string'
        ]);

        $message = $request->input('message');
        $usersRaw = $request->input('users'); // comma-separated numbers

        // Convert to array & clean phone numbers
        $userList = explode(',', $usersRaw);
        $waLinks = [];

        foreach ($userList as $phone) {
            $cleanPhone = preg_replace('/\D/', '', $phone); // remove non-digits
            if ($cleanPhone) {
                $waLinks[] = "https://wa.me/{$cleanPhone}?text=" . urlencode($message);
            }
        }

        return view('admin.whatsup.index', compact('waLinks'));
    }


}
