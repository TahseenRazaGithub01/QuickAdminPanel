@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.event.title_singular') }}
    </div>

    <div class="card-body">
        <input type="hidden" data-name="edit_id" value="{{ $event->id }}" class="edit_id">
        <form method="POST" action="{{ route("admin.events.update", [$event->id]) }}" enctype="multipart/form-data" id="eventForm">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.event.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $event->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.event.fields.title') }}</label>
                <input class="form-control auto_slug {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" data-target_controller="event" value="{{ old('title', $event->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.event.fields.slug') }}</label>
                <input class="form-control org_slug {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $event->slug) }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="short_description">{{ trans('cruds.event.fields.short_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('short_description') ? 'is-invalid' : '' }}" name="short_description" id="short_description" required>{{ old('short_description', $event->short_description) }}</textarea>
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.short_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="long_description">{{ trans('cruds.event.fields.long_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('long_description') ? 'is-invalid' : '' }}" name="long_description" id="long_description">{{ old('long_description', $event->long_description) }}</textarea>
                @if($errors->has('long_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('long_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.long_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.event.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="banner">{{ trans('cruds.event.fields.banner') }}</label>
                <div class="needsclick dropzone {{ $errors->has('banner') ? 'is-invalid' : '' }}" id="banner-dropzone">
                </div>
                @if($errors->has('banner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('banner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.banner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="menu_icon">{{ trans('cruds.event.fields.menu_icon') }}</label>
                <div class="needsclick dropzone {{ $errors->has('menu_icon') ? 'is-invalid' : '' }}" id="menu_icon-dropzone">
                </div>
                @if($errors->has('menu_icon'))
                    <div class="invalid-feedback">
                        {{ $errors->first('menu_icon') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.menu_icon_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="banner_description">{{ trans('cruds.event.fields.banner_description') }}</label>
                <textarea class="form-control {{ $errors->has('banner_description') ? 'is-invalid' : '' }}" name="banner_description" id="banner_description">{{ old('banner_description', $event->banner_description) }}</textarea>
                @if($errors->has('banner_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('banner_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.banner_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="categories">{{ trans('cruds.event.fields.category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (in_array($id, old('categories', [])) || $event->categories->contains($id)) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="stores">{{ trans('cruds.event.fields.store') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('stores') ? 'is-invalid' : '' }}" name="stores[]" id="stores" multiple>
                    @foreach($stores as $id => $store)
                        <option value="{{ $id }}" {{ (in_array($id, old('stores', [])) || $event->stores->contains($id)) ? 'selected' : '' }}>{{ $store }}</option>
                    @endforeach
                </select>
                @if($errors->has('stores'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stores') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.store_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coupons">{{ trans('cruds.event.fields.coupon') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('coupons') ? 'is-invalid' : '' }}" name="coupons[]" id="coupons" multiple>
                    @foreach($coupons as $id => $coupon)
                        <option value="{{ $id }}" {{ (in_array($id, old('coupons', [])) || $event->coupons->contains($id)) ? 'selected' : '' }}>{{ $coupon }}</option>
                    @endforeach
                </select>
                @if($errors->has('coupons'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coupons') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.coupon_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="featured" value="0">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ $event->featured || old('featured', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured">{{ trans('cruds.event.fields.featured') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.featured_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('popular') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="popular" value="0">
                    <input class="form-check-input" type="checkbox" name="popular" id="popular" value="1" {{ $event->popular || old('popular', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="popular">{{ trans('cruds.event.fields.popular') }}</label>
                </div>
                @if($errors->has('popular'))
                    <div class="invalid-feedback">
                        {{ $errors->first('popular') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.popular_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="publish" value="0">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ $event->publish || old('publish', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.event.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.publish_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('top') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="top" value="0">
                    <input class="form-check-input" type="checkbox" name="top" id="top" value="1" {{ $event->top || old('top', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="top">{{ trans('cruds.event.fields.top') }}</label>
                </div>
                @if($errors->has('top'))
                    <div class="invalid-feedback">
                        {{ $errors->first('top') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.top_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('bottom') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="bottom" value="0">
                    <input class="form-check-input" type="checkbox" name="bottom" id="bottom" value="1" {{ $event->bottom || old('bottom', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="bottom">{{ trans('cruds.event.fields.bottom') }}</label>
                </div>
                @if($errors->has('bottom'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bottom') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.bottom_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.event.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $event->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_title">{{ trans('cruds.event.fields.meta_title') }}</label>
                <input class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $event->meta_title) }}" required>
                @if($errors->has('meta_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.meta_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="meta_keywords">{{ trans('cruds.event.fields.meta_keywords') }}</label>
                <input class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $event->meta_keywords) }}">
                @if($errors->has('meta_keywords'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_keywords') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.meta_keywords_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_description">{{ trans('cruds.event.fields.meta_description') }}</label>
                <input class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', $event->meta_description) }}" required>
                @if($errors->has('meta_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.meta_description_helper') }}</span>
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
    url: '{{ route('admin.events.storeMedia') }}',
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
@if(isset($event) && $event->image)
      var file = {!! json_encode($event->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $event->image->getUrl('thumb') }}')
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
    Dropzone.options.bannerDropzone = {
    url: '{{ route('admin.events.storeMedia') }}',
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
      $('form').find('input[name="banner"]').remove()
      $('form').append('<input type="hidden" name="banner" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="banner"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($event) && $event->banner)
      var file = {!! json_encode($event->banner) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $event->banner->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="banner" value="' + file.file_name + '">')
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
    Dropzone.options.menuIconDropzone = {
    url: '{{ route('admin.events.storeMedia') }}',
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
      $('form').find('input[name="menu_icon"]').remove()
      $('form').append('<input type="hidden" name="menu_icon" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="menu_icon"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($event) && $event->menu_icon)
      var file = {!! json_encode($event->menu_icon) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $event->menu_icon->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="menu_icon" value="' + file.file_name + '">')
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
