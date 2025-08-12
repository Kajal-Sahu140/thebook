<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Video\VideoRequest;
use App\Models\Refund;
use App\Models\User;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class whatsupController extends Controller
{

  public function index()
{
    // Fetch all templates for dropdown
    $templates = Template::all();
    return view('admin.whatsup.index', compact('templates'));
}

public function sendMultipleWhatsApp(Request $request)
{
    $request->validate([
        'template_id' => 'required|integer|exists:templates,id',
        'users' => 'required|string'
    ]);

    // Get template description from DB
    $template = Template::findOrFail($request->template_id);
    $message = $template->description;

    // Convert comma-separated numbers to array
    $userList = explode(',', $request->users);
    $waLinks = [];

    foreach ($userList as $phone) {
        $cleanPhone = preg_replace('/\D/', '', $phone); // remove non-digits
        if ($cleanPhone) {
            $waLinks[] = "https://wa.me/{$cleanPhone}?text=" . urlencode($message);
        }
    }

    return view('admin.whatsup.index', [
        'waLinks' => $waLinks,
        'templates' => Template::all()
    ]);
}


 public function template()
    {
        return view('admin.whatsup.templates');
    }

    public function storetemplate(Request $request)
    {
        $request->validate([
            'description' => 'required|string'
        ]);

        $template = new Template();
        $template->description = $request->description;
        $template->save();

        return redirect()->back()->with('success', 'Template added successfully');
    }



}
