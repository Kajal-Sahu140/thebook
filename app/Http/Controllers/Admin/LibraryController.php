<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Libraries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class LibraryController extends Controller
{
   public function index(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10);
    $currentPage = $request->input('page', 1);
    $query = Libraries::query();

    if ($search = $request->input('search')) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    $query->orderBy('id', 'desc');
    $count = ($currentPage - 1) * $pageCount + 1;

    try {
        $libraries = $query->paginate($pageCount);
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error retrieving libraries: ' . $e->getMessage());
        return redirect()->route('admin.category')->with('error', 'Failed to retrieve libraries.');
    }

    return view('admin.libraries.index', compact('libraries', 'count'));
}


    public function create(){
        return view('admin.libraries.add');
    }
    
 
public function store(Request $request)
{
    $randomno = rand(100000, 999999); // Fixed function name and added semicolon

    $library = new Libraries;
    $library->name = $request->name;
    $library->address = $request->address;
    $library->phone = $request->phone;
    $library->email = $request->email;
    $library->description = $request->description;
    $library->unique_code =  $randomno;
    if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('library_images', 'public');
            $library->image = $imagePath;
        }
    $library->save();

    return redirect()->back()->with('success', 'Library added successfully');
}

public function edit(Request $request){
 $library =  Libraries::where('id',$request->id)->first();
 return view('admin.libraries.edit',compact('library'));


}

public function update(Request $request)
{
    $library = Libraries::find($request->id);

    if (!$library) {
        return redirect()->back()->with('error', 'Library not found.');
    }

    if ($request->has('name')) {
        $library->name = $request->name;
    }

    if ($request->has('address')) {
        $library->address = $request->address;
    }

    if ($request->has('phone')) {
        $library->phone = $request->phone;
    }

    if ($request->has('email')) {
        $library->email = $request->email;
    }

    if ($request->has('description')) {
        $library->description = $request->description;
    }

    if ($request->has('status')) {
        $library->status = $request->status;
    }
      if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('library_images', 'public');
            $library->image = $imagePath;
        }

    $library->save();

    return redirect()->route('admin.library.index')->with('success', 'Library updated successfully.');
}


       
   
}
