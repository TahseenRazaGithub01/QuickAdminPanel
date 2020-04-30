@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.page.title_singular') }}
    </div>

    <div class="card-body">
        <input type="hidden" data-name="edit_id" value="{{ $page->id }}" class="edit_id">
        <form method="POST" action="{{ route("admin.pages.update", [$page->id]) }}" enctype="multipart/form-data" id="pageForm">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.page.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $page->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.page.fields.title') }}</label>
                <input class="form-control auto_slug {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" data-target_controller="pages" value="{{ old('title', $page->title) }}">
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.page.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $page->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.page.fields.slug') }}</label>
                <input class="form-control org_slug {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="banner_image">{{ trans('cruds.page.fields.banner_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('banner_image') ? 'is-invalid' : '' }}" id="banner_image-dropzone">
                </div>
                @if($errors->has('banner_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('banner_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.banner_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.page.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="additional_image">{{ trans('cruds.page.fields.additional_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('additional_image') ? 'is-invalid' : '' }}" id="additional_image-dropzone">
                </div>
                @if($errors->has('additional_image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('additional_image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.additional_image_helper') }}</span>
            </div>
            <!-- Top -->
            <div class="form-group">
                <div class="form-check {{ $errors->has('top') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="top" value="0">
                    <input class="form-check-input" type="checkbox" name="top" id="top" value="1" {{ $page->top || old('top', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="top">{{ trans('cruds.page.fields.top_helper') }}</label>
                </div>
                @if($errors->has('top'))
                    <div class="invalid-feedback">
                        {{ $errors->first('top') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <!-- Bottom -->
            <div class="form-group">
                <div class="form-check {{ $errors->has('bottom') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="bottom" value="0">
                    <input class="form-check-input" type="checkbox" name="bottom" id="bottom" value="1" {{ $page->bottom || old('bottom', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="bottom">{{ trans('cruds.page.fields.bottom_helper') }}</label>
                </div>
                @if($errors->has('bottom'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bottom') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>

            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="publish" value="0">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ $page->publish || old('publish', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.page.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.publish_helper') }}</span>
            </div>


            <div class="form-group">
                <label class="required" for="meta_title">{{ trans('cruds.page.fields.meta_title') }}</label>
                <input class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" required>
                @if($errors->has('meta_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.meta_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_keywords">{{ trans('cruds.page.fields.meta_keywords') }}</label>
                <input class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" required>
                @if($errors->has('meta_keywords'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_keywords') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.meta_keywords_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_description">{{ trans('cruds.page.fields.meta_description') }}</label>
                <input class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', $page->meta_description) }}" required>
                @if($errors->has('meta_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.page.fields.meta_description_helper') }}</span>
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
    Dropzone.options.bannerImageDropzone = {
    url: '{{ route('admin.pages.storeMedia') }}',
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
      $('form').find('input[name="banner_image"]').remove()
      $('form').append('<input type="hidden" name="banner_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="banner_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($page) && $page->banner_image)
      var file = {!! json_encode($page->banner_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $page->banner_image->getUrl('thumb') }}')
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="banner_image" value="' + file.file_name + '">')
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
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.pages.storeMedia') }}',
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
@if(isset($page) && $page->image)
      var file = {!! json_encode($page->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $page->image->getUrl('thumb') }}')
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
    url: '{{ route('admin.pages.storeMedia') }}',
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
@if(isset($page) && $page->additional_image)
      var file = {!! json_encode($page->additional_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $page->additional_image->getUrl('thumb') }}')
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
