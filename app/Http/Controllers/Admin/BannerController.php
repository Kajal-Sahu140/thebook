<?php
namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BannerController extends Controller
{
   public function index(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10); // Adjust this config if needed
    $currentPage = $request->input('page', 1);
    $query = Banner::orderBy('id','DESC');
    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%');
              
        });
    }
    $count = ($currentPage - 1) * $pageCount + 1;
    $users = $query->paginate($pageCount);
    return view('admin.banner.index', compact('users', 'count'));
}
/////////////////////////////////////////////
public function create()
{
    $categories=Category::where('status',1)->whereNull('category_id')->get();
    return view('admin.banner.create',compact('categories'));
}
///////////////////////////////////////
public function store(Request $request)
{
    // Validate inputs
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:100',
        'description' => 'required|string|max:300',
        'web_banner_image' => 'required|file|mimes:jpg,jpeg,png|max:2048', // 20 MB
        'app_banner_image' => 'required|file|mimes:jpg,jpeg,png|max:2048', // 20 MB
        'position' => 'required|in:homepage,sidebar,footer',
        'category_id' => 'required',
        'banner_link' => 'required|url',
        'click_status'=>'required|in:yes,no',
        'discount' => 'required|numeric|min:0|max:100',
        'status' => 'required|in:active,de-active',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    // Redirect back if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        
        // Create new Banner instance
        $banner = new Banner();
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->discount = $request->discount;
        $banner->status = $request->status;
        $banner->category_id = $request->category_id;
        $banner->position = $request->position;
        $banner->start_date = $request->start_date;
        $banner->click_status = $request->click_status;
        $banner->end_date = $request->end_date;
        $banner->banner_link = $request->banner_link;
        // Handle web banner image upload
        if ($request->hasFile('web_banner_image')) {
            $webFile = $request->file('web_banner_image');
            $webPath = $webFile->store('banners/web', 'public');
            $banner->web_banner_image = $webPath;
        }

        // Handle app banner image upload
        if ($request->hasFile('app_banner_image')) {
            $appFile = $request->file('app_banner_image');
            $appPath = $appFile->store('banners/app', 'public');
            $banner->app_banner_image = $appPath;
        }

        // Save banner to the database
        $banner->save();

        return redirect()->route('admin.banner')->with('success', 'Banner added successfully!');
    } catch (\Exception $e) {
        // Log the exception
        \Log::error('Error storing banner: ' . $e->getMessage());

        return redirect()->back()->with('error', 'An error occurred while uploading the banner. Please try again.');
    }
}

/////////////////////////////////////
public function destroy($id)
    {
        $decodedId = base64_decode($id);
        try {
            $category = Banner::findOrFail($decodedId);
            $category->delete();
            return redirect()->route('admin.banner')->with('success', 'Banner deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.banner')->with('error', 'Failed to delete Banner.');
        }
    }
//////////////////////////////////////////
public function show($id)
{
    $decodedId = base64_decode($id);
    $banner = Banner::findOrFail($decodedId);
    return view('admin.banner.view', compact('banner'));
}
public function edit($id)
{
    $decodedId = base64_decode($id);
    $banner = Banner::find($decodedId);
    // Format the date fields to YYYY-MM-DD format for the input type="date"
    $banner->start_date = \Carbon\Carbon::parse($banner->start_date)->format('Y-m-d');
    $banner->end_date = \Carbon\Carbon::parse($banner->end_date)->format('Y-m-d');
    $categories = Category::where('status', 1)->whereNull('category_id')->get();
    if (!$banner) {
        return redirect()->route('admin.banner')->with('error', 'Banner not found.');
    }
    return view('admin.banner.edit', compact('banner', 'categories'));
}

//////////////////////////////////////////////
public function update(Request $request, $id)
{
    // Validate inputs
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:100',
        'description' => 'required|string|max:300',
        'web_banner_image' => 'nullable|file', // 20 MB
        'app_banner_image' => 'nullable|file', // 20 MB
        'position' => 'required|in:homepage,sidebar,footer',
        'category_id' => 'required',
        'click_status'=>'required|in:yes,no',
        'banner_link' => 'required|url', 
        'discount' => 'required|numeric|min:0|max:100',
        'status' => 'required|in:active,de-active',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);
// dd($validator->fails());die;
    // Redirect back if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // Find the banner by ID
        $banner = Banner::findOrFail($id);

        // Update banner details
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->discount = $request->discount;
        $banner->status = $request->status;
        $banner->click_status = $request->click_status;
        
        $banner->category_id = $request->category_id;
        $banner->banner_link = $request->banner_link;
        $banner->position = $request->position; 
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;

        // Handle web banner image upload (only if new image is provided)
        if ($request->hasFile('web_banner_image')) {
            // Delete old web banner image if exists
            if ($banner->web_banner_image) {
                Storage::disk('public')->delete($banner->web_banner_image);
            }

            // Upload new image
            $webFile = $request->file('web_banner_image');
            $webPath = $webFile->store('banners/web', 'public');
            $banner->web_banner_image = $webPath;
        }

        // Handle app banner image upload (only if new image is provided)
        if ($request->hasFile('app_banner_image')) {
            // Delete old app banner image if exists
            if ($banner->app_banner_image) {
                Storage::disk('public')->delete($banner->app_banner_image);
            }

            // Upload new image
            $appFile = $request->file('app_banner_image');
            $appPath = $appFile->store('banners/app', 'public');
            $banner->app_banner_image = $appPath;
        }

        // Save the updated banner to the database
        $banner->save();

        return redirect()->route('admin.banner')->with('success', 'Banner updated successfully!');
    } catch (\Exception $e) {
        dd($e);
        // Log the exception
        \Log::error('Error updating banner: ' . $e->getMessage());

        return redirect()->back()->with('error', 'An error occurred while updating the banner. Please try again.');
    }
}

}



