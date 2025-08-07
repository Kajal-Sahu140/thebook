<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pages;
use App\Models\Faq;
use Illuminate\Http\Request;
class PageController extends Controller
{
    public function edit($slug)
    {
        $page = Pages::where('slug', $slug)->firstOrFail();
        return view('admin.Pages.aboutus', compact('page'));
    }
  public function update(Request $request, $slug)
{
    try {
        $page = Pages::where('slug', $slug)->firstOrFail();

        // Validation rules
        $request->validate([
            'title' => 'required|string|max:255',
            // 'title_ar' => 'required|string|max:255',
            // 'title_cku' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'description' => 'required|string|min:10',
            // 'description_ar' => 'required|string|min:10',
            // 'description_cku' => 'required|string|min:10',
        ]); 


        $page->update([
            'title' => $request->input('title'),
            'title_ar' => $request->input('title_ar'),
            'title_cku' => $request->input('title_cku'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'description_ar' => $request->input('description_ar'),
            'description_cku' => $request->input('description_cku'),
            'status' => $request->input('status'),
        ]);

        // Redirect back with success message
        return redirect()->route('admin.pages.edit', $request->slug)
            ->with('success', 'Page updated successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle the case where the page was not found
        return redirect()->route('admin.pages.edit')
            ->with('error', 'Page not found.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation exceptions
        // dd($e);
        return redirect()->route('admin.pages.edit', $slug)
            ->withErrors($e->validator)
            ->withInput();

    } catch (\Exception $e) {
        dd($e);
        // Handle any other exceptions
        return redirect()->route('admin.pages.edit', $slug)
            ->with('error', 'An unexpected error occurred: ' . $e->getMessage())
            ->withInput();
    }
}


    ////////////////////////////faq//////////////////////////////////////////////
    public function index(Request $request)
        {
            $pageCount = config('app.admin_record_per_page', 10); // Adjust this config if needed
            $currentPage = $request->input('page', 1);
            $query = Faq::orderBy('id','DESC');
            if ($search = $request->input('search')) {
                $query->where(function($q) use ($search) {
                    $q->where('question', 'like', '%' . $search . '%');
                });
            }
            $count = ($currentPage - 1) * $pageCount + 1;
            $users = $query->paginate($pageCount);
            return view('admin.Pages.faq', compact('users', 'count'));
        }
        public function create()
        {
            return view('admin.Pages.faqcreate');
        }
        public function store(Request $request)
            {
                $validated = $request->validate([
                    'question' => 'required|string|max:255',
                    // 'question_ar' => 'required|string|max:255',
                    // 'question_cku' => 'required|string|max:255',
                    'answer' => 'required|string|max:1000',
                    // 'answer_ar' => 'required|string|max:1000',
                    // 'answer_cku' => 'required|string|max:1000',
                    'status' => 'required',
                ]);
                Faq::create([
                    'question' => $validated['question'],
                    'question_ar' => $validated['question_ar'],
                    'question_cku' => $validated['question_cku'],
                    'answer' => $validated['answer'],
                    'answer_ar' => $validated['answer_ar'],
                    'answer_cku' => $validated['answer_cku'],
                    'status' => $validated['status'],
                ]);
                return redirect()->route('admin.faq')->with('success', 'FAQ created successfully.');
            }
        ////////////////////////////////////////////////////////
        public function faqview($id)
        {
            $faq=Faq::where('id',$id)->first();
            return view('admin.Pages.faqview', compact('faq'));
        }
        public function faqedit($id)
        {
             $faq=Faq::where('id',$id)->first();
            return view('admin.Pages.faqedit', compact('faq'));
        }
        public function faqupdate(Request $request, $id)
            {
                $faq = Faq::findOrFail($id);
                $request->validate([
                    'question' => 'required|max:255',
                    // 'question_ar' => 'required|max:255',
                    // 'question_cku' => 'required|max:255',
                    'answer' => 'required|max:1000',
                    'answer_ar' => 'required|max:1000',
                    'answer_cku' => 'required|max:1000',
                    'status' => 'required',
                ]);
                $faq->update([
                    'question' => $request->input('question'),
                    // 'question_ar' => $request->input('question_ar'),
                    // 'question_cku' => $request->input('question_cku'),
                    'answer' => $request->input('answer'),
                    'answer_ar' => $request->input('answer_ar'),
                    'answer_cku' => $request->input('answer_cku'),
                    'status' => $request->input('status'),
                ]);
                return redirect()->route('admin.faq')->with('success', 'FAQ updated successfully!');
            }
            /////////////////////////////
            public function destroy($id)
            {
                $decodedId = base64_decode($id);
                try {
                    $faq = Faq::findOrFail($decodedId);
                    $faq->delete();
                    return redirect()->route('admin.faq')->with('success', 'FAQ deleted successfully!');
                } catch (\Exception $e) {
                    Log::error('Error deleting FAQ: ' . $e->getMessage());
                    return redirect()->route('admin.faq')->with('error', 'Failed to delete FAQ.');
                }
            }
 }

