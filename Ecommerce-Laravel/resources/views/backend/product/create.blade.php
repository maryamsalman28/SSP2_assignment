@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">
      <form method="post" action="{{route('product.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="is_featured">Is Featured</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes                        
        </div>

        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($categories as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">Sub Category</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Select any category--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price(Rupees) <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Enter price" value="{{old('price')}}" class="form-control">
          @error('price')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Discount(%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount" value="{{old('discount')}}" class="form-control">
          @error('discount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="portion_size">Portion Size</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select any size--</option>
              <option value="S">Small (S)</option>
              <option value="R">Regular (R)</option>
              <option value="L">Large (L)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="allergen_information">Allergen Information</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select allergies--</option>
              <option value="1">Contains Nuts</option>
              <option value="2">Contains Dairy</option>
              <option value="3">Contains Soy</option>
              <option value="4">Contains Eggs</option>
              <option value="5">Gluten-Free</option>
              <option value="6">Vegan-Friendly</option>
              <option value="7">May Contain Traces of Shellfish</option>
          </select>
        </div>

        <div class="form-group">
          <label for="maximum_order_quantity">Maximum Order Quantity</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select maximum order quantity--</option>
              <option value="1">1 meal per customer</option>
              <option value="2">Upto 3 meals per customer</option>
              <option value="3">Upto 7 meals per customer</option>
              <option value="4">Upto 14 meals per customer</option>
          </select>
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo</label>
          <input id="inputPhoto" type="text" name="photo" class="form-control">
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });

    $('#cat_id').change(function(){
      var cat_id = $(this).val();
      if(cat_id != null){
        $.ajax({
          url: "/admin/category/" + cat_id + "/child",
          data: {
            _token: "{{csrf_token()}}",
            id: cat_id
          },
          type: "POST",
          success: function(response){
            if(typeof(response) != 'object'){
              response = $.parseJSON(response)
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
</script>
@endpush
