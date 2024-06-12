@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Product</h5>
    <div class="card-body">
      <form method="post" action="{{ route('product.update', $product->id) }}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{ $product->title }}" class="form-control">
          @error('title')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{ $product->summary }}</textarea>
          @error('summary')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
          @error('description')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="is_featured">Is Featured</label><br>
          <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}> Yes                        
        </div>

        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($categories as $key => $cat_data)
                  <option value='{{ $cat_data->id }}' {{ $product->cat_id == $cat_data->id ? 'selected' : '' }}>{{ $cat_data->title }}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group {{ $product->child_cat_id ? '' : 'd-none' }}" id="child_cat_div">
          <label for="child_cat_id">Sub Category</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Select any sub category--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price(NRS) <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Enter price" value="{{ $product->price }}" class="form-control">
          @error('price')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Discount(%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount" value="{{ $product->discount }}" class="form-control">
          @error('discount')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="portion_size">Portion Size</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select any size--</option>
              <option value="S" {{ in_array('S', explode(',', $product->portion_size)) ? 'selected' : '' }}>Small (S)</option>
              <option value="R" {{ in_array('R', explode(',', $product->portion_size)) ? 'selected' : '' }}>Regular (R)</option>
              <option value="L" {{ in_array('L', explode(',', $product->portion_size)) ? 'selected' : '' }}>Large (L)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="allergen_information">Allergen Information</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select allergies--</option>
              <option value="1" {{ in_array('1', explode(',', $product->allergen_information)) ? 'selected' : '' }}>Contains Nuts</option>
              <option value="2" {{ in_array('2', explode(',', $product->allergen_information)) ? 'selected' : '' }}>Contains Dairy</option>
              <option value="3" {{ in_array('3', explode(',', $product->allergen_information)) ? 'selected' : '' }}>Contains Soy</option>
              <option value="4" {{ in_array('4', explode(',', $product->allergen_information)) ? 'selected' : '' }}>Contains Eggs</option>
              <option value="5" {{ in_array('5', explode(',', $product->allergen_information)) ? 'selected' : '' }}>Gluten-Free</option>
              <option value="6" {{ in_array('6', explode(',', $product->allergen_information)) ? 'selected' : '' }}>Vegan-Friendly</option>
              <option value="7" {{ in_array('7', explode(',', $product->allergen_information)) ? 'selected' : '' }}>May Contain Traces of Shellfish</option>
          </select>
        </div>

        <div class="form-group">
          <label for="maximum_order_quantity">Maximum Order Quantity</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select maximum order quantity--</option>
              <option value="1" {{ in_array('1', explode(',', $product->maximum_order_quantity)) ? 'selected' : '' }}>1 meal per customer</option>
              <option value="2" {{ in_array('2', explode(',', $product->maximum_order_quantity)) ? 'selected' : '' }}>Upto 3 meals per customer</option>
              <option value="3" {{ in_array('3', explode(',', $product->maximum_order_quantity)) ? 'selected' : '' }}>Upto 7 meals per customer</option>
              <option value="4" {{ in_array('4', explode(',', $product->maximum_order_quantity)) ? 'selected' : '' }}>Upto 14 meals per customer</option>
          </select>
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo</label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-secondary text-white">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $product->photo }}">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail Description.....",
        tabsize: 2,
        height: 150
      });
    });

    $('#cat_id').
    change(function(){
      var cat_id = $(this).val();
      if(cat_id != null){
        $.ajax({
          url: "/admin/category/" + cat_id + "/child",
          data: {
            _token: "{{ csrf_token() }}",
            id: cat_id
          },
          type: "POST",
          success: function(response){
            if(typeof(response) != 'object'){
              response = $.parseJSON(response);
            }
            var html_option = "<option value=''>----Select sub category----</option>";
            if(response.status){
              var data = response.data;
              if(response.data){
                $('#child_cat_div').removeClass('d-none');
                $.each(data, function(id, title){
                  html_option += "<option value='" + id + "'>" + title + "</option>";
                });
              }
            } else {
              $('#child_cat_div').addClass('d-none');
            }
            $('#child_cat_id').html(html_option);
          }
        });
      }
    });

    var child_cat_id = '{{ $product->child_cat_id }}';
    $('#cat_id').change(function(){
      var cat_id = $(this).val();

      if(cat_id != null){
        $.ajax({
          url: "/admin/category/" + cat_id + "/child",
          type: "POST",
          data: {
            _token: "{{ csrf_token() }}"
          },
          success: function(response){
            if(typeof(response) != 'object'){
              response = $.parseJSON(response);
            }
            var html_option = "<option value=''>--Select any one--</option>";
            if(response.status){
              var data = response.data;
              if(response.data){
                $('#child_cat_div').removeClass('d-none');
                $.each(data, function(id, title){
                  html_option += "<option value='" + id + "'" + (child_cat_id == id ? 'selected ' : '') + ">" + title + "</option>";
                });
              } else {
                console.log('no response data');
              }
            } else {
              $('#child_cat_div').addClass('d-none');
            }
            $('#child_cat_id').html(html_option);
          }
        });
      }
    });

    if(child_cat_id != null){
      $('#cat_id').change();
    }
</script>
@endpush

