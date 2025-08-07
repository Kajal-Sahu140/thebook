<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Blog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class BlogController extends Controller
{
       public function index(Request $request)
        {
            $pageCount = config('app.admin_record_per_page', 10);
            $currentPage = $request->input('page', 1);
            $query = Blog::orderBy('id','DESC');
            if ($search = $request->input('search')) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');    
                });
            }
            $count = ($currentPage - 1) * $pageCount + 1;
            $users = $query->paginate($pageCount);
            return view('admin.blog.index', compact('users', 'count'));
        }
        //////////////////////////////////////////////////////
        public function create()
        {
            return view('admin.blog.create');
        }
        /////////////////////////////////////////
         public function store(Request $request)
         {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'author' => 'required|max:50',
            'title' => 'required|max:400',
            // 'title_ar' => 'required|max:50',
            // 'description_ar' => 'required',
            // 'title_cku' => 'required|max:50',
            // 'description_cku' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required',
        ]);
        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('blogs', 'public');
            }
            // Create the blog
            Blog::create([
                'author' => $validatedData['author'],
                'title' => $validatedData['title'],
                // 'title_ar' => $validatedData['title_ar'],
                // 'description_ar' => $validatedData['description_ar'],
                // 'title_cku' => $validatedData['title_cku'],
                // 'description_cku' => $validatedData['description_cku'],
                'description' => $validatedData['description'],
                'image' => $imagePath,
                'status' => $validatedData['status'],
            ]);
            // Redirect with success message
            return redirect()->route('admin.blog')->with('success', 'Blog created successfully!');
        } catch (\Exception $e) {
            // Handle any errors
            return redirect()->back()->with('error', 'An error occurred while creating the blog: ' . $e->getMessage());
        }
    }
    ///////////////////////////////////
    public function view($id)
    {
    $decodedId = base64_decode($id);
    $blog = Blog::findOrFail($decodedId);
    return view('admin.blog.view', compact('blog'));
    }
    ///////////////////////////////////////////
    public function edit($id)
    {
        $decodedId = base64_decode($id);
        $blog = Blog::find($decodedId);
        if (!$blog) {
            return redirect()->route('admin.blog')->with('error', 'blog not found.');
        }
        return view('admin.blog.edit', compact('blog'));
    }
    ///////////////////////////////
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $request->validate([
            'author' => 'required|max:50',
            'title' => 'required|max:400',
            // 'title_ar' => 'required|max:50',
            // 'description_ar' => 'required',
            // 'title_cku' => 'required|max:50',
            // 'description_cku' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required',
        ]);
        $data = $request->only('author', 'title','title_ar','description_ar','title_cku','description_cku', 'description', 'status');
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($blog->image && Storage::exists($blog->image)) {
                Storage::delete($blog->image);
            }
            $data['image'] =$request->file('image')->store('blogs', 'public');
        }
        $blog->update($data);
        return redirect()->route('admin.blog')->with('success', 'Blog updated successfully.');
    }
    ///////////////////////////////////
    public function destroy($id)
    {
        $decodedId = base64_decode($id);
        $blog = Blog::findOrFail($decodedId);
        if ($blog->image && Storage::exists($blog->image)) {
            Storage::delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('admin.blog')->with('success', 'Blog deleted successfully.');
    }
    ///////////////////
}
