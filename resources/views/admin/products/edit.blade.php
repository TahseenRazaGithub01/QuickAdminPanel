@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.product.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.products.update", [$product->id]) }}" enctype="multipart/form-data" id="productForm">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.product.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $product->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="product_categories">{{ trans('cruds.product.fields.product_category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('product_categories') ? 'is-invalid' : '' }}" name="product_categories[]" id="product_categories" multiple required>
                    @foreach($product_categories as $id => $product_category)
                        <option value="{{ $id }}" {{ (in_array($id, old('product_categories', [])) || $product->product_categories->contains($id)) ? 'selected' : '' }}>{{ $product_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('product_categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product_categories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.product_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.product.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="short_description">{{ trans('cruds.product.fields.short_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('short_description') ? 'is-invalid' : '' }}" name="short_description" id="short_description">{!! old('short_description', $product->short_description) !!}</textarea>
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.short_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="long_description">{{ trans('cruds.product.fields.long_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('long_description') ? 'is-invalid' : '' }}" name="long_description" id="long_description">{{ old('long_description', $product->long_description) }}</textarea>
                @if($errors->has('long_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('long_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.long_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rating">{{ trans('cruds.product.fields.rating') }}</label>
                <input class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}" type="text" name="rating" id="rating" value="{{ old('rating', $product->rating) }}">
                @if($errors->has('rating'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rating') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.rating_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="affiliate_url">{{ trans('cruds.product.fields.affiliate_url') }}</label>
                <input class="form-control {{ $errors->has('affiliate_url') ? 'is-invalid' : '' }}" type="text" name="affiliate_url" id="affiliate_url" value="{{ old('affiliate_url', $product->affiliate_url) }}">
                @if($errors->has('affiliate_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('affiliate_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.affiliate_url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.product.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $product->date) }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.product.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $product->price) }}">
                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount_price">{{ trans('cruds.product.fields.discount_price') }}</label>
                <input class="form-control {{ $errors->has('discount_price') ? 'is-invalid' : '' }}" type="text" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}">
                @if($errors->has('discount_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.discount_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="discount_percent">{{ trans('cruds.product.fields.discount_percent') }}</label>
                <input class="form-control {{ $errors->has('discount_percent') ? 'is-invalid' : '' }}" type="text" name="discount_percent" id="discount_percent" value="{{ old('discount_percent', $product->discount_percent) }}">
                @if($errors->has('discount_percent'))
                    <div class="invalid-feedback">
                        {{ $errors->first('discount_percent') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.discount_percent_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.product.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', $product->sort) }}" step="1">
                @if($errors->has('sort'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.sort_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="featured" value="0">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ $product->featured || old('featured', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured">{{ trans('cruds.product.fields.featured') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.featured_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('popular') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="popular" value="0">
                    <input class="form-check-input" type="checkbox" name="popular" id="popular" value="1" {{ $product->popular || old('popular', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="popular">{{ trans('cruds.product.fields.popular') }}</label>
                </div>
                @if($errors->has('popular'))
                    <div class="invalid-feedback">
                        {{ $errors->first('popular') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.popular_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="publish" value="0">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ $product->publish || old('publish', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.product.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.publish_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.product.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="additional_image">{{ trans('cruds.product.fields.additional_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('additional_image') ? 'is-invalid' : '' }}" id="additional_image-dropzone">
                </div>
                @if($errors->has('additional_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('additional_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.product.fields.additional_image_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 1, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 1,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($product) && $product->image)
      var file = {!! json_encode($product->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $product->image->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
<script>
    Dropzone.options.additionalImageDropzone = {
    url: '{{ route('admin.products.storeMedia') }}',
    maxFilesize: 1, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 1,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="additional_image"]').remove()
      $('form').append('<input type="hidden" name="additional_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="additional_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($product) && $product->additional_image)
      var file = {!! json_encode($product->additional_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $product->additional_image->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="additional_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection
