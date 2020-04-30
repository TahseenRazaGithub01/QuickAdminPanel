@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.press.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.presses.store") }}" enctype="multipart/form-data" id="pressForm">
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.press.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ in_array($id, old('sites', [])) ? 'selected' : (in_array($id, [getSiteID()])) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.press.fields.title') }}</label>
                <input class="form-control auto_slug {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" data-target_controller="press" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="short_description">{{ trans('cruds.press.fields.short_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('short_description') ? 'is-invalid' : '' }}" name="short_description" id="short_description" required>{{ old('short_description') }}</textarea>
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.short_description_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('show_on_listing') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="show_on_listing" value="0">
                    <input class="form-check-input" type="checkbox" name="show_on_listing" id="show_on_listing" value="1" {{ old('show_on_listing', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_on_listing">{{ trans('cruds.press.fields.show_on_listing') }}</label>
                </div>
                @if($errors->has('show_on_listing'))
                    <div class="invalid-feedback">
                        {{ $errors->first('show_on_listing') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.show_on_listing_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.press.fields.slug') }}</label>
                <div class="row">
                    <div class="col-lg-2">
                        <input type="text" value="press/" disabled class="form-control">
                    </div>
                    <div class="col-lg-10">
                        <input class="form-control org_slug {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                        @if($errors->has('slug'))
                            <div class="invalid-feedback">
                                {{ $errors->first('slug') }}
                            </div>
                        @endif
                    </div>
                </div>
                <span class="help-block">{{ trans('cruds.press.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sort">{{ trans('cruds.press.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort') }}" step="1" required>
                @if($errors->has('sort'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.sort_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.press.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="long_description">{{ trans('cruds.press.fields.long_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('long_description') ? 'is-invalid' : '' }}" name="long_description" id="long_description" required>{{ old('long_description') }}</textarea>
                @if($errors->has('long_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('long_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.long_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="related_links">{{ trans('cruds.press.fields.related_links') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('related_links') ? 'is-invalid' : '' }}" name="related_links" id="related_links">{!! old('related_links') !!}</textarea>
                @if($errors->has('related_links'))
                    <div class="invalid-feedback">
                        {{ $errors->first('related_links') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.related_links_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="featured" value="0">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured">{{ trans('cruds.press.fields.featured') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.featured_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="publish" value="0">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ old('publish', 0) == 1 || old('publish') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.press.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.publish_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_title">{{ trans('cruds.press.fields.meta_title') }}</label>
                <input class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', '') }}" required>
                @if($errors->has('meta_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.meta_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_keywords">{{ trans('cruds.press.fields.meta_keywords') }}</label>
                <input class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', '') }}" required>
                @if($errors->has('meta_keywords'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_keywords') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.meta_keywords_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_description">{{ trans('cruds.press.fields.meta_description') }}</label>
                <input class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', '') }}" required>
                @if($errors->has('meta_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.press.fields.meta_description_helper') }}</span>
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
    url: '{{ route('admin.presses.storeMedia') }}',
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
@if(isset($press) && $press->image)
      var file = {!! json_encode($press->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $press->image->getUrl('thumb') }}')
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
