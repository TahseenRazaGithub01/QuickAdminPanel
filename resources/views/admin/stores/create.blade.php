@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.store.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stores.store") }}" enctype="multipart/form-data" id="storesForm">
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.store.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) ? 'selected' : (in_array($id, [getSiteID()]))) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.store.fields.name') }}</label>
                <input class="form-control auto_slug {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name"  data-target_controller="store" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="store_url">{{ trans('cruds.store.fields.store_url') }}</label>
                <input class="form-control {{ $errors->has('store_url') ? 'is-invalid' : '' }}" type="text" name="store_url" id="store_url" value="{{ old('store_url', '') }}" required>
                @if($errors->has('store_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('store_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.store_url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="affiliate_url">{{ trans('cruds.store.fields.affiliate_url') }}</label>
                <input class="form-control {{ $errors->has('affiliate_url') ? 'is-invalid' : '' }}" type="text" name="affiliate_url" id="affiliate_url" value="{{ old('affiliate_url', '') }}">
                @if($errors->has('affiliate_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('affiliate_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.affiliate_url_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.store.fields.slug') }}</label>
                <input class="form-control org_slug {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                @if($errors->has('slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="categories">{{ trans('cruds.store.fields.category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="short_description">{{ trans('cruds.store.fields.short_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('short_description') ? 'is-invalid' : '' }}" name="short_description" id="short_description" required>{{ old('short_description') }}</textarea>
                @if($errors->has('short_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('short_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.short_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="long_description">{{ trans('cruds.store.fields.long_description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('long_description') ? 'is-invalid' : '' }}" name="long_description" id="long_description">{!! old('long_description') !!}</textarea>
                @if($errors->has('long_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('long_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.long_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.store.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.image_helper') }}</span>
            </div>
                        <div class="form-group">
                <div class="form-check {{ $errors->has('featured') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="featured" value="0">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured">{{ trans('cruds.store.fields.featured') }}</label>
                </div>
                @if($errors->has('featured'))
                    <div class="invalid-feedback">
                        {{ $errors->first('featured') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.featured_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('popular') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="popular" value="0">
                    <input class="form-check-input" type="checkbox" name="popular" id="popular" value="1" {{ old('popular', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="popular">{{ trans('cruds.store.fields.popular') }}</label>
                </div>
                @if($errors->has('popular'))
                    <div class="invalid-feedback">
                        {{ $errors->first('popular') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.popular_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ old('publish', 0) == 1 || old('publish') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.store.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.publish_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_title">{{ trans('cruds.store.fields.meta_title') }}</label>
                <input class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', '') }}" required>
                @if($errors->has('meta_title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.meta_title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_keywords">{{ trans('cruds.store.fields.meta_keywords') }}</label>
                <input class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}" type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', '') }}" required>
                @if($errors->has('meta_keywords'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_keywords') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.meta_keywords_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="meta_description">{{ trans('cruds.store.fields.meta_description') }}</label>
                <input class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" type="text" name="meta_description" id="meta_description" value="{{ old('meta_description', '') }}" required>
                @if($errors->has('meta_description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meta_description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.meta_description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.store.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort') }}" step="1">
                @if($errors->has('sort'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.sort_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="faq">{{ trans('cruds.store.fields.faq') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('faq') ? 'is-invalid' : '' }}" name="faq" id="faq">{!! old('faq') !!}</textarea>
                @if($errors->has('faq'))
                    <div class="invalid-feedback">
                        {{ $errors->first('faq') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.faq_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="html_tags">{{ trans('cruds.store.fields.html_tags') }}</label>
                <textarea class="form-control {{ $errors->has('html_tags') ? 'is-invalid' : '' }}" name="html_tags" id="html_tags">{{ old('html_tags') }}</textarea>
                @if($errors->has('html_tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('html_tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.html_tags_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="script_tags">{{ trans('cruds.store.fields.script_tags') }}</label>
                <textarea class="form-control {{ $errors->has('script_tags') ? 'is-invalid' : '' }}" name="script_tags" id="script_tags">{{ old('script_tags') }}</textarea>
                @if($errors->has('script_tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('script_tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.script_tags_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.store.fields.template') }}</label>
                <select class="form-control {{ $errors->has('template') ? 'is-invalid' : '' }}" name="template" id="template">
                    <option value disabled {{ old('template', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Store::TEMPLATE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('template', 'template_1') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('template'))
                    <div class="invalid-feedback">
                        {{ $errors->first('template') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.store.fields.template_helper') }}</span>
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
    url: '{{ route('admin.stores.storeMedia') }}',
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
@if(isset($store) && $store->image)
      var file = {!! json_encode($store->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, '{{ $store->image->getUrl('thumb') }}')
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
