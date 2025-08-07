@extends('warehouse.master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<style>
   /* Breadcrumb Styles */
   .breadcrumb {
   background-color: #e9eef2;
   margin-bottom: 1rem;
   padding: 0.75rem 1rem;
   border-radius: 0.25rem;
   }
   .breadcrumb li a {
   text-decoration: none;
   }
   #description-error{
   display: none;
   }
   /* Custom responsive styles */
   @media (max-width: 768px) {
   .breadcrumb {
   font-size: 0.9rem;
   }
   .h3.mb-3 {
   font-size: 1.5rem;
   }
   .btn-primary {
   width: 100%;
   margin-top: 0.5rem;
   }
   .form-control {
   font-size: 0.875rem;
   }
   .variant-row .col {
   padding: 0.2rem;
   }
   }
   /* Ensure error message display is better */
   .invalid-feedback {
   display: block;
   font-size: 0.875rem;
   }
</style>
<div class="content-body">
 <div class="container-fluid mt-3">
   
    <div aria-label="breadcrumb">
      <ol class="breadcrumb float-end">
         <li class="breadcrumb-item"><a href="{{ route('warehouse.dashboard') }}">Dashboard</a></li>
         <li class="breadcrumb-item"><a href="{{ route('warehouse.product') }}">Products</a></li>
         <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">Add Product</li>
      </ol>
   </div>
   <h1 class="h3 mb-3">Add New Product</h1>
   <div class="card">
      <div class="card-body">
         <form action="{{ route('warehouse.product.store') }}" id="addProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Product Name -->
            <div class="mb-3">
               <label for="product_name" class="form-label">Product Name</label>
               <input type="text" class="form-control @error('product_name') is-invalid @enderror" min="2" id="product_name" name="product_name" value="{{ old('product_name') }}" placeholder="Enter product name">
               @error('product_name')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3">
               <label for="product_name_ar" class="form-label">Product Name (AR)</label>
               <input type="text" class="form-control @error('product_name_ar') is-invalid @enderror" min="2" id="product_name_ar" name="product_name_ar" value="{{ old('product_name_ar') }}" placeholder="Enter product name">
               @error('product_name_ar')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3">
               <label for="product_name_cku" class="form-label">Product Name (CKU)</label>
               <input type="text" class="form-control @error('product_name_cku') is-invalid @enderror" min="2" id="product_name_cku" name="product_name_cku" value="{{ old('product_name_cku') }}" placeholder="Enter product name">
               @error('product_name_cku')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Description -->
            <div class="mb-3">
               <label for="description" class="form-label">Description</label>
               <textarea class="form-control @error('description') is-invalid @enderror" min="2" id="description" name="description" placeholder="Enter product description">{{old('description')}}</textarea>
               @error('description')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3">
               <label for="description_ar" class="form-label">Description (Ar)</label>
               <textarea class="form-control @error('description_ar') is-invalid @enderror"  min="2" id="description_ar" name="description_ar" placeholder="Enter product description">{{old('description_ar')}}</textarea>
               @error('description_ar')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3">
               <label for="description_cku" class="form-label">Description (CKU)</label>
               <textarea class="form-control @error('description_cku') is-invalid @enderror" min="2" id="description_cku" name="description_cku" placeholder="Enter product description">{{old('description_cku')}}</textarea>
               @error('description_cku')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Base Price -->
            <div class="mb-3">
               <label for="base_price" class="form-label">Base Price (IQD)</label>
               <input 
                  type="number" 
                  step="0.01" 
                  min="0.01" 
                  max="999999.99"
                  maxlength="9" 
                  class="form-control @error('base_price') is-invalid @enderror" 
                  id="base_price" 
                  name="base_price" 
                  value="{{ old('base_price') }}" 
                  placeholder="Enter base price"
                  oninput="this.value = this.value.slice(0, 11)" 
                  >
               @error('base_price')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Brand -->
            <div class="mb-3">
               <label for="brand_id" class="form-label">Brand</label>
               <select class="form-control @error('brand_id') is-invalid @enderror" id="brand_id" name="brand_id">
                  <option value="">Select Brand</option>
                  @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                  @endforeach
               </select>
               @error('brand_id')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <div class="mb-3">
               <label for="quantity" class="form-label">Quantity</label>
               <input 
                  type="number" 
                  step="1" 
                  min="0" 
                  max="999999" 
                  maxlength="6" 
                  class="form-control @error('quantity') is-invalid @enderror" 
                  id="quantity" 
                  name="quantity" 
                  value="{{ old('quantity', 0) }}" 
                  placeholder="Enter product quantity"
                  oninput="this.value = this.value.slice(0, 6)" 
                  >
               @error('quantity')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Discount -->
            <div class="mb-3">
               <label for="discount" class="form-label">Discount (%)</label>
               <input 
                  type="number" 
                  step="1" 
                  min="0" 
                  max="100" 
                  class="form-control @error('discount') is-invalid @enderror" 
                  id="discount" 
                  name="discount" 
                  value="{{ old('discount', 0.00) }}" 
                  placeholder="Enter discount percentage"
                  >
               @error('discount')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Image Upload -->
            <div class="mb-3">
               <label for="images" class="form-label">Product Images</label>
               <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple>
               @error('images')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
               <div id="imagePreviewContainer" style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                  <!-- Image previews with delete buttons will appear here -->
               </div>
            </div>
            <!-- Categories -->
            <div class="mb-3">
               <label for="category_id" class="form-label">Category</label>
               <select name="categories" id="categories" class="form-control @error('category_id') is-invalid @enderror">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                  </option>
                  @endforeach
               </select>
               @error('categories')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Subcategories -->
            <div class="mb-3">
               <label for="subcategories" class="form-label">Subcategories</label>
               <select class="form-control @error('subcategories') is-invalid @enderror" id="subcategories" name="subcategories">
                  <option value="">Select Subcategory</option>
               </select>
               @error('subcategories')
               <div class="invalid-feedback">{{ $message }}</div>
               @enderror
            </div>
            <!-- Variants: Color, Size, Price -->
            <div class="mb-3">
               <label for="variants" class="form-label">Variants</label>
               <div id="variants">
                  <!-- Default Variant Row -->
                  <div class="variant-row row mb-2">
                     <div class="col">
                        <select name="variant_colors[]" id="variant_colors" class="form-control ">
                           <option value="" disabled selected>Select Color</option>
                           @foreach($colors as $color)
                           <option value="{{ $color->id }}" {{ old('variant_colors.0') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                           @endforeach
                        </select>
                        @error('variant_colors[]')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col">
                        <div>
                           <select name="variant_sizes[]" id="variant_sizes" class="form-control">
                              <option value="" disabled selected>Select Size</option>
                              @foreach($sizes as $size)
                              <option value="{{ $size->id }}" {{ old('variant_sizes.0') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                              @endforeach
                           </select>
                           @error('variant_sizes[]')
                           <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
                        <!-- <input type="number"  min="0" max="999999.99" 
                           maxlength="9"  id="variant_prices" name="variant_prices[]" class="form-control" placeholder="Price" value="{{ old('variant_prices.0') }}" oninput="validateDecimalPlaces(this)">
                        <script>
                           function validateDecimalPlaces(input) {
                               let value = input.value;
                               
                               // Prevent more than two decimal places
                               if (value.includes('.')) {
                                   let parts = value.split('.');
                                   if (parts[1].length > 2) {
                                       input.value = parts[0] + '.' + parts[1].slice(0, 2);
                                   }
                               }
                           }
                           
                           
                                  
                        </script> -->
                        <div class="col">
                        <input type="number" min="0" max="1000000" step="0.01"
                            id="variant_prices" name="variant_prices[]"
                            class="form-control" placeholder="Price"
                            value="{{ old('variant_prices.0') }}" 
                            oninput="validateDecimalPlaces(this)">
                    </div>
                <script>
                    function validateDecimalPlaces(input) {
                        let value = input.value;

                        // Ensure value does not exceed max limit
                        if (parseFloat(value) > 1000000) {
                            input.value = "1000000"; // Set to max value
                        }

                        // Restrict decimal places to two
                        if (value.includes('.')) {
                            let parts = value.split('.');
                            if (parts[1].length > 2) {
                                input.value = parts[0] + '.' + parts[1].slice(0, 2);
                            }
                        }
                    }
                </script>
                        @error('variant_prices[]')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                     </div>
                     <div class="col-auto">
                        <button type="button" class="btn btn-danger remove-variant-btn">
                        <i class="fas fa-trash"></i>
                        </button>
                     </div>
                  </div>
               </div>
               <button type="button" class="btn btn-info" id="add-variant-btn">Add Variant</button>
            </div>
            <!-- Submit Button -->
            <div class="d-flex justify-content-end">
               <button type="submit" class="btn btn-primary" id="submit-btn">Create Product</button>
            </div>
         </form>
      </div>
   </div>
 </div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
   // Track selected files globally
   $(document).ready(function () {
       // Handle the form submission to disable the button after click
       $("form").on("submit", function () {
           // Disable the submit button to prevent multiple submissions
           $("#submit-btn").prop("disabled", true);
           
           // Delay changing the button text by 3 seconds
           setTimeout(function() {
               $("#submit-btn").prop("disabled", false);
               // $("#submit-btn").text("Submitting..."); // Change the text after 3 seconds
           }, 3000); // 3000 milliseconds = 3 seconds
       });
   });
   
   
    $(document).ready(function() {
        $.validator.addMethod("extension", function(value, element, param) {
               if (this.optional(element)) {
                   return true;
               }
               var file = element.files[0];
               if (file) {
                   var ext = file.name.split('.').pop().toLowerCase();
                   return param.split('|').indexOf(ext) > -1;
               }
               return false;
           }, "Only image files (jpg, jpeg, png, gif) are allowed");
           $.validator.addMethod("fileSize", function(value, element, param) {
           if (element.files.length > 0) {
               for (let i = 0; i < element.files.length; i++) {
                   if (element.files[i].size > param) {
                       return false;
                   }
               }
           }
           return true;
       }, "Each image must be less than 3MB.");
   
     
       $.validator.addMethod("maxFiles", function(value, element, param) {
           return element.files.length <= param;
       }, "You can upload a maximum of 5 images.");
       // Add validation rules
       $('#addProductForm').validate({
           rules: {
               product_name: {
                   required: true,
                   maxlength: 50,
               },
               product_name_ar: {
                   required: true,
                   maxlength: 50,
               },
               product_name_cku: {
                   required: true,
                   maxlength: 50,
               },
               description: {
                   required: true,
                   maxlength: 500,
               },
               description_ar: {
                   required: true,
                   maxlength: 500,
               },
               description_cku: {
                   required: true,
                   maxlength: 500,
               },
              
               brand_id: {
                   required: true,
               },
              base_price: {
               required: true,
               number: true,
               min: 0.01, // Minimum base price
               max: 999999.99, // Maximum base price (8 digits before decimal, 2 after)
           },
            categories: {
                   required: true,
               },
           quantity: {
               required: true,
               digits: true,
               min: 0, // Minimum quantity
               max: 999999, // Maximum quantity (6 digits)
           },
           discount: {
               required: false,
               number: true,
               min: 0, // Minimum discount
               max: 100, // Maximum discount
           },
   
                'images[]': {
                   required: true,
                   extension: "jpg|jpeg|png|gif",
                   fileSize: 3145728,  // 3MB in bytes
                   maxFiles: 5
               },
              
              'variant_colors[]': {
                   required: true,
              },
              'variant_sizes[]': {
                   required: true,
              },
                'variant_prices[]': {
                   required: true,
                   number: true,
                   min: 0,
                //    max: 999999.99,
              //  max: 1000000,
                  // maxlength: 9,
                    max: 1000000,
                    pattern: /^(1000000(\.00?)?|[0-9]{1,6}(\.\d{1,2})?)$/
                //    pattern: /^\d{0,6}(\.\d{1,2})?$/
               },
           },
           messages: {
               product_name:{
                   required: "Please enter a product name.",
                   maxlength: "Product name can't exceed 50 characters.",
               },
               product_name_ar:{
                   required: "Please enter a product name (AR).",
                   maxlength: "Product name can't exceed 50 characters.",
               },
               product_name_cku:{
                   required: "Please enter a product name (CKU).",
                   maxlength: "Product name can't exceed 50 characters.",
                   },
               description:{
                   required: "Please provide a description.",
                   maxlength: "Description can't exceed 500 characters.",
               },
               description_ar:{
                   required: "Please provide a description (AR).",
                   maxlength: "Description can't exceed 500 characters.",
               },
               description_cku:{
                   required: "Please provide a description (CKU).",
                   maxlength: "Description can't exceed 500 characters.",
               },
               brand_id:{
                   required: "Please select a brand.",
               } ,
              base_price: {
                   required: "Please enter a base price.",
                   number: "Base price must be a valid number.",
                   min: "Base price must be at least 0.01.",
                   max: "Base price cannot exceed 999999.99.",
               },
               quantity: {
                   required: "Please enter the product quantity.",
                   digits: "Quantity must be a whole number.",
                   min: "Quantity must be at least 0.",
                   max: "Quantity cannot exceed 999,999.",
               },
               discount: {
                   number: "Discount must be a valid number.",
                   min: "Discount must be at least 0.",
                   max: "Discount must be between 0 and 100.",
               },
               'images[]':{
                   required: "Please upload at least one image for the product.",
                   extension: "Please upload valid images (JPG, JPEG, PNG).",
                   fileSize: "Each image must be less than 3MB.",
                   maxFiles: "You can upload a maximum of 5 images.",
               },
               categories:{
                   required: "Please select at least one category.",
               },
               'variant_prices[]':{
                   required: "Please enter at least one variant price.",
                   number: "Variant price must be a number.",
                   min: "Variant price must be a positive number.",
                   max: "Variant price cannot exceed 9999999.99.",
                   maxlength: "Variant price must be at most 9 digits.",
                     pattern: "Price cannot have more than 2 decimal places."
               },
               'variant_colors[]': {
                   required: "Please select at least one variant color.",
               },
               'variant_sizes[]': {
                   required: "Please select at least one variant size.",
               }
           },
           errorElement: 'div',
               errorPlacement: function (error, element) {
                   error.addClass('invalid-feedback');
                   element.closest('.mb-3').append(error);
               },
               highlight: function (element, errorClass, validClass) {
                   $(element).addClass('is-invalid');
               },
               unhighlight: function (element, errorClass, validClass) {
                   $(element).removeClass('is-invalid');
               },
               
   
               submitHandler: function(form) {
                   form.submit();
               }
       });
       $('#images').change(function () {
           const files = this.files;
           const previewContainer = $('#image-preview-container');
           previewContainer.empty();
           for (let i = 0; i < files.length; i++) {
               const reader = new FileReader();
               reader.onload = function (e) {
                   previewContainer.append(`<img src="${e.target.result}" alt="Image Preview" class="img-thumbnail" style="max-height: 150px; margin: 5px;">`);
               };
               reader.readAsDataURL(files[i]);
           }
   
           
       });
   
       
   });
   ///////////////////////////////////////
   let fileArray = []; // Store selected files
   
   document.getElementById('images').addEventListener('change', function(event) {
       const newFiles = Array.from(event.target.files); // Convert FileList to array
       fileArray = fileArray.concat(newFiles); // Merge old and new files
   
       updatePreviews();
       
       // Update input field to hold all selected files
       const dataTransfer = new DataTransfer();
       fileArray.forEach(file => dataTransfer.items.add(file));
       document.getElementById('images').files = dataTransfer.files;
   });
   
   function updatePreviews() {
       const previewContainer = document.getElementById('imagePreviewContainer');
       previewContainer.innerHTML = '';
       fileArray.forEach((file, index) => {
           if (file.type.startsWith('image/')) {
               const reader = new FileReader();
   
               reader.onload = function(e) {
                   // Create image wrapper
                   const imageWrapper = document.createElement('div');
                   imageWrapper.style.position = 'relative';
                   imageWrapper.style.display = 'inline-block';
                   imageWrapper.style.margin = '5px';
   
                   // Create image element
                   const img = document.createElement('img');
                   img.src = e.target.result;
                   img.style.maxHeight = '150px';
                   img.style.border = '1px solid #ddd';
                   img.style.borderRadius = '5px';
                   img.style.objectFit = 'cover';
   
                   // Create delete button
                   const deleteButton = document.createElement('button');
                   deleteButton.textContent = '✖';
                   deleteButton.style.position = 'absolute';
                   deleteButton.style.top = '5px';
                   deleteButton.style.right = '5px';
                   deleteButton.style.background = 'rgba(255, 0, 0, 0.7)';
                   deleteButton.style.color = '#fff';
                   deleteButton.style.border = 'none';
                   deleteButton.style.borderRadius = '50%';
                   deleteButton.style.cursor = 'pointer';
                   deleteButton.style.padding = '5px';
                   deleteButton.style.fontSize = '12px';
   
                   // Attach delete event
                   deleteButton.addEventListener('click', function() {
                       fileArray.splice(index, 1); // Remove from fileArray
                       updatePreviews(); // Refresh previews
                       
                       // Update input field with remaining files
                       const dataTransfer = new DataTransfer();
                       fileArray.forEach(file => dataTransfer.items.add(file));
                       document.getElementById('images').files = dataTransfer.files;
                   });
   
                   // Append elements
                   imageWrapper.appendChild(img);
                   imageWrapper.appendChild(deleteButton);
                   previewContainer.appendChild(imageWrapper);
               };
               reader.readAsDataURL(file);
           }
       });
   }
   
</script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       // Handle category and subcategory dynamic selection
       const categorySelect = document.getElementById('categories');
       const subcategorySelect = document.getElementById('subcategories');
   
       categorySelect.addEventListener('change', function () {
   const categoryId = categorySelect.value;
   // Clear existing subcategory options
   subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
   if (categoryId) {
       // Make AJAX request to fetch subcategories based on selected category
       fetch("{{ route('warehouse.getSubcategories') }}", {
           method: "POST",
           headers: {
               "Content-Type": "application/json",
               "X-CSRF-TOKEN": "{{ csrf_token() }}",
           },
           body: JSON.stringify({ category_id: categoryId }),
       })
           .then(response => response.json())
           .then(data => {
               // Populate subcategory dropdown
               data.forEach(subcategory => {
                   const option = document.createElement('option');
                   option.value = subcategory.id;
                   option.textContent = subcategory.name;
   
                   // Mark the correct subcategory as selected if it matches the saved subcategory_id
                  
                       option.selected = true;
                   
                   subcategorySelect.appendChild(option);
               });
           })
           .catch(error => console.error("Error fetching subcategories:", error));
   }
   });
       // Handle adding and removing variant rows dynamically
     const addVariantButton = document.getElementById('add-variant-btn');
   const variantsContainer = document.getElementById('variants');
   
   addVariantButton.addEventListener('click', function() {
   const newVariant = document.createElement('div');
   newVariant.classList.add('variant-row', 'row', 'mb-2');
   newVariant.innerHTML = `
       <div class="col">
           <select name="variant_colors[]" id="variant_colors" class="form-control">
               <option value="" disabled selected>Select Color</option>
               @foreach($colors as $color)
                   <option value="{{ $color->id }}" {{ old('variant_colors.0') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
               @endforeach
           </select>
       </div>
       <div class="col">
           <select name="variant_sizes[]" id="variant_sizes" class="form-control">
               <option value="" disabled selected>Select Size</option>
               @foreach($sizes as $size)
                   <option value="{{ $size->id }}" {{ old('variant_sizes.0') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
               @endforeach
           </select>
       </div>
       <div class="col">
           <input type="number" step="1" min="0" max="1000000"
       name="variant_prices[]" id="variant_prices" class="form-control" placeholder="Price" value="">
       </div>
       <div class="col-auto">
           <button type="button" class="btn btn-danger remove-variant-btn">
               <i class="fas fa-trash"></i>
           </button>
       </div>
   `;
   
   // Append the new variant row
   variantsContainer.appendChild(newVariant);
   });
   
   // Handle removing variant row
   variantsContainer.addEventListener('click', function(event) {
   if (event.target.classList.contains('remove-variant-btn')) {
       const row = event.target.closest('.variant-row');
       
       // Ensure that there's at least one row remaining
       const allRows = variantsContainer.querySelectorAll('.variant-row');
       if (allRows.length > 1) {
           row.remove();
       } else {
           alert('At least one variant must remain.');
       }
   }
   });
   
   
   });
</script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       feather.replace();
   });
</script>
@endsection
