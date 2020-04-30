@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.coupon.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.coupons.update", [$coupon->id]) }}" enctype="multipart/form-data" id="couponsForm">
            @method('PUT')
            @csrf
            <input type="hidden" name="sid" value="{{ request()->sid }}">
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.coupon.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $coupon->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.site_helper') }}</span>
            </div>
            <div class="form-group" id="storeId">
                <label class="required" for="store_id">{{ trans('cruds.coupon.fields.store') }}</label>
                <select class="form-control select2 {{ $errors->has('store') ? 'is-invalid' : '' }}" name="store_id" id="store_id" required>
                    @foreach($stores as $id => $store)
  <option value="{{ $id }}" {{$coupon->store_id == $id ? 'selected' : ''  }}>{{ $store }}</option>
                    @endforeach
                </select>
                @if($errors->has('store_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('store_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.store_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.coupon.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $coupon->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="custom_image_title">{{ trans('cruds.coupon.fields.custom_image_title') }}</label>
                <input class="form-control {{ $errors->has('custom_image_title') ? 'is-invalid' : '' }}" type="text" name="custom_image_title" id="custom_image_title" value="{{ old('custom_image_title', $coupon->custom_image_title) }}">
                @if($errors->has('custom_image_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('custom_image_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.custom_image_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.coupon.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $coupon->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="affiliate_url">{{ trans('cruds.coupon.fields.affiliate_url') }}</label>
                <input class="form-control {{ $errors->has('affiliate_url') ? 'is-invalid' : '' }}" type="text" name="affiliate_url" id="affiliate_url" value="{{ old('affiliate_url', $coupon->affiliate_url) }}">
                @if($errors->has('affiliate_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('affiliate_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.affiliate_url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="code">{{ trans('cruds.coupon.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}">
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.coupon.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', $coupon->sort) }}" step="1">
                @if($errors->has('sort'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.sort_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_available">{{ trans('cruds.coupon.fields.date_available') }}</label>
                <input class="form-control date {{ $errors->has('date_available') ? 'is-invalid' : '' }}" required type="text" name="date_available" id="date_available" value="{{ old('date_available', $coupon->date_available) }}">
                @if($errors->has('date_available'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_available') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.date_available_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_expiry">{{ trans('cruds.coupon.fields.date_expiry') }}</label>
                <input class="form-control date {{ $errors->has('date_expiry') ? 'is-invalid' : '' }}" required type="text" name="date_expiry" id="date_expiry" value="{{ old('date_expiry', $coupon->date_expiry) }}">
                @if($errors->has('date_expiry'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_expiry') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.date_expiry_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('verified') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="verified" value="0">
                    <input class="form-check-input" type="checkbox" name="verified" id="verified" value="1" {{ $coupon->verified || old('verified', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="verified">{{ trans('cruds.coupon.fields.verified') }}</label>
                </div>
                @if($errors->has('verified'))
                    <div class="invalid-feedback">
                        {{ $errors->first('verified') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.verified_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('exclusive') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="exclusive" value="0">
                    <input class="form-check-input" type="checkbox" name="exclusive" id="exclusive" value="1" {{ $coupon->exclusive || old('exclusive', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="exclusive">{{ trans('cruds.coupon.fields.exclusive') }}</label>
                </div>
                @if($errors->has('exclusive'))
                    <div class="invalid-feedback">
                        {{ $errors->first('exclusive') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.exclusive_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="featured" value="0">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ $coupon->featured || old('featured', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured">{{ trans('cruds.coupon.fields.featured') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.featured_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('recommended') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="recommended" value="0">
                    <input class="form-check-input" type="checkbox" name="recommended" id="recommended" value="1" {{ $coupon->recommended || old('recommended', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="recommended">{{ trans('cruds.coupon.fields.recommended') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('recommended') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.recommended_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('popular') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="popular" value="0">
                    <input class="form-check-input" type="checkbox" name="popular" id="popular" value="1" {{ $coupon->popular || old('popular', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="popular">{{ trans('cruds.coupon.fields.popular') }}</label>
                </div>
                @if($errors->has('popular'))
                    <div class="invalid-feedback">
                        {{ $errors->first('popular') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.popular_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="publish" value="0">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ $coupon->publish || old('publish', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.coupon.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.publish_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('free_shipping') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="free_shipping" value="0">
                    <input class="form-check-input" type="checkbox" name="free_shipping" id="free_shipping" value="1" {{ $coupon->free_shipping || old('free_shipping', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="free_shipping">{{ trans('cruds.coupon.fields.free_shipping') }}</label>
                </div>
                @if($errors->has('free_shipping'))
                    <div class="invalid-feedback">
                        {{ $errors->first('free_shipping') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.free_shipping_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.coupon.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Coupon::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $coupon->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.coupon.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="categories">{{ trans('cruds.coupon.fields.category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || $coupon->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="special_event_sort">{{ trans('cruds.coupon.fields.special_event_sort') }}</label>
                <input class="form-control {{ $errors->has('special_event_sort') ? 'is-invalid' : '' }}" type="number" name="special_event_sort" id="special_event_sort" value="{{ old('special_event_sort', $coupon->special_event_sort) }}" step="1">
                @if($errors->has('special_event_sort'))
                    <div class="invalid-feedback">
                        {{ $errors->first('special_event_sort') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.special_event_sort_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coupon_id">{{ trans('cruds.coupon.fields.coupon') }}</label>
                <select class="form-control select2 {{ $errors->has('coupon') ? 'is-invalid' : '' }}" name="coupon_id" id="coupon_id">
                    @foreach($coupons as $id => $coup)
                        <option value="{{ $id }}" {{ (old('coupon_id') == $id ? 'selected' : $id == $coupon->coupon_id) ? 'selected' : '' }}>{{ $coup }}</option>
                    @endforeach
                </select>
                @if($errors->has('coupon_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coupon_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.coupon_helper') }}</span>
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
    url: '{{ route('admin.coupons.storeMedia') }}',
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
@if(isset($coupon) && $coupon->image)
      var file = {!! json_encode($coupon->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $coupon->image->getUrl('thumb') }}')
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
@endsection
