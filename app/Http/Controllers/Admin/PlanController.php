<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use DB;
use App\Models\Cart;

use App\Models\PlanUser;
use App\Models\CartOrderSummary;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\Brand;
use App\Models\PlanModule;
use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class PlanController extends Controller
{
   public function index(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10);
    $currentPage = $request->input('page', 1);
    $query = PlanModule::query();

    if ($search = $request->input('search')) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    $query->orderBy('id', 'desc');
    $count = ($currentPage - 1) * $pageCount + 1;

    try {
        $PlanModule = $query->paginate($pageCount);
    } catch (\Exception $e) {
        Log::error('Error retrieving PlanModule: ' . $e->getMessage());
        return redirect()->route('admin.category')->with('error', 'Failed to retrieve libraries.');
    }

    return view('admin.bookplane.index', compact('PlanModule', 'count'));
}
////////////////////////////////////////////////////////////


   public function userplanindex(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10);
    $currentPage = $request->input('page', 1);
    $query = PlanUser::query();

    if ($search = $request->input('search')) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    $query->orderBy('id', 'desc');
    $count = ($currentPage - 1) * $pageCount + 1;

    try {
        $PlanUser = $query->paginate($pageCount);
    } catch (\Exception $e) {
        Log::error('Error retrieving PlanModule: ' . $e->getMessage());
        return redirect()->route('admin.category')->with('error', 'Failed to retrieve libraries.');
    }

    return view('admin.bookplane.userplanindex', compact('PlanUser', 'count'));
}




    public function create(){
        return view('admin.bookplane.create');
    }
    
 
public function store(Request $request)
{
  

    $planModule = new PlanModule;
    $planModule->name = $request->name;
    $planModule->price = $request->price;
    $planModule->quantity = $request->quantity;
    $planModule->discount = $request->discount;
     $planModule->description = $request->description;
     $planModule->security_amount = $request->security_amount;
     
      $planModule->tbd_price = $request->tbd_price;
    $planModule->days = $request->days;
     $planModule->minum_order = $request->minum_order;
    $planModule->status = $request->status;
    
    $planModule->save();

    return redirect()->back()->with('success', 'planModule added successfully');
}

public function edit(Request $request){
 $planModule =  PlanModule::where('id',$request->id)->first();
 return view('admin.bookplane.edit',compact('planModule'));


}

public function update(Request $request)
{
     $planModule = PlanModule::where('id',$request->id)->first();

    if (! $planModule) {
        return redirect()->back()->with('error', 'Library not found.');
    }

    if ($request->has('name')) {
         $planModule->name = $request->name;
    }

    if ($request->has('price')) {
         $planModule->price = $request->price;
    }
     if ($request->has('security_amount')) {
         $planModule->security_amount = $request->security_amount;
    }

    if ($request->has('quantity')) {
         $planModule->quantity = $request->quantity;
    }

    if ($request->has('discount')) {
         $planModule->discount = $request->discount;
    }

    if ($request->has('description')) {
         $planModule->description = $request->description;
    }
    
    
    
    if ($request->has('tbd_price')) {
         $planModule->tbd_price = $request->tbd_price;
    }

    if ($request->has('days')) {
         $planModule->days = $request->days;
    }

    if ($request->has('minum_order')) {
         $planModule->minum_order = $request->minum_order;
    }
    
    

    if ($request->has('status')) {
         $planModule->status = $request->status;
    }

     $planModule->save();

    return redirect()->route('admin.plan.index')->with('success', 'PlanModule updated successfully.');
}
/////////////////////////////////////////////
}

