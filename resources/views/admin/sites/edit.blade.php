@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.site.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.sites.update", [$site->id]) }}" enctype="multipart/form-data" id="siteSubmit">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.site.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $site->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="country_name">{{ trans('cruds.site.fields.country_name') }}</label>
                    <input class="form-control {{ $errors->has('country_name') ? 'is-invalid' : '' }}" type="text" name="country_name" id="country_name" value="{{ old('country_name', $site->country_name) }}" required>
                    @if($errors->has('country_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('country_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.country_name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="country_code">{{ trans('cruds.site.fields.country_code') }}</label>
                    <input class="form-control {{ $errors->has('country_code') ? 'is-invalid' : '' }}" type="text" name="country_code" id="country_code" value="{{ old('country_code', $site->country_code) }}" required>
                    @if($errors->has('country_code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('country_code') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.country_code_helper') }}</span>
                </div>

                <div class="form-group" id="langCode">
                    <label class="required" for="language_code">{{ trans('cruds.site.fields.language_code') }}</label>
                    <select class="form-control select2" name="language_code" id="language_code" required>
                        @if(count($language) > 0)
                            @foreach($language as $id => $item)
                                <option value="{{ $item['code'] }}" {{ ( $site->language_code ? $site->language_code : old('language_code')) == $item['code'] ? 'selected' : '' }} >{{ $item['language'] }}</option>
                            @endforeach
                        @else
                            <option value="en">English</option>
                        @endif
                    </select>
                    @if($errors->has('language_code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('language_code') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.country_code_helper') }}</span>
                </div>



                <div class="form-group">
                    <label class="required" for="flag">{{ trans('cruds.site.fields.flag') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('flag') ? 'is-invalid' : '' }}" id="flag-dropzone">
                    </div>
                    @if($errors->has('flag'))
                        <div class="invalid-feedback">
                            {{ $errors->first('flag') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.flag_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="url">{{ trans('cruds.site.fields.url') }}</label>
                    <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', $site->url) }}" required>
                    @if($errors->has('url'))
                        <div class="invalid-feedback">
                            {{ $errors->first('url') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.url_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="logo">{{ trans('cruds.site.fields.logo') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                    </div>
                    @if($errors->has('logo'))
                        <div class="invalid-feedback">
                            {{ $errors->first('logo') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.logo_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="favicon">{{ trans('cruds.site.fields.favicon') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('favicon') ? 'is-invalid' : '' }}" id="favicon-dropzone">
                    </div>
                    @if($errors->has('favicon'))
                        <div class="invalid-feedback">
                            {{ $errors->first('favicon') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.favicon_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="html_tags">{{ trans('cruds.site.fields.html_tags') }}</label>
                    <textarea class="form-control {{ $errors->has('html_tags') ? 'is-invalid' : '' }}" name="html_tags" id="html_tags">{{ old('html_tags', $site->html_tags) }}</textarea>
                    @if($errors->has('html_tags'))
                        <div class="invalid-feedback">
                            {{ $errors->first('html_tags') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.html_tags_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="javascript_tags">{{ trans('cruds.site.fields.javascript_tags') }}</label>
                    <textarea class="form-control {{ $errors->has('javascript_tags') ? 'is-invalid' : '' }}" name="javascript_tags" id="javascript_tags">{{ old('javascript_tags', $site->javascript_tags) }}</textarea>
                    @if($errors->has('javascript_tags'))
                        <div class="invalid-feedback">
                            {{ $errors->first('javascript_tags') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.javascript_tags_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="twitter">{{ trans('cruds.site.fields.twitter') }}</label>
                    <input class="form-control {{ $errors->has('twitter') ? 'is-invalid' : '' }}" type="text" name="twitter" id="twitter" value="{{ old('twitter', $site->twitter) }}">
                    @if($errors->has('twitter'))
                        <div class="invalid-feedback">
                            {{ $errors->first('twitter') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.twitter_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="linked_in">{{ trans('cruds.site.fields.linked_in') }}</label>
                    <input class="form-control {{ $errors->has('linked_in') ? 'is-invalid' : '' }}" type="text" name="linked_in" id="linked_in" value="{{ old('linked_in', $site->linked_in) }}">
                    @if($errors->has('linked_in'))
                        <div class="invalid-feedback">
                            {{ $errors->first('linked_in') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.linked_in_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="facebook">{{ trans('cruds.site.fields.facebook') }}</label>
                    <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" type="text" name="facebook" id="facebook" value="{{ old('facebook', $site->facebook) }}">
                    @if($errors->has('facebook'))
                        <div class="invalid-feedback">
                            {{ $errors->first('facebook') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.facebook_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="youtube">{{ trans('cruds.site.fields.youtube') }}</label>
                    <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube" id="youtube" value="{{ old('youtube', $site->youtube) }}">
                    @if($errors->has('youtube'))
                        <div class="invalid-feedback">
                            {{ $errors->first('youtube') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.youtube_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="instagram">{{ trans('cruds.site.fields.instagram') }}</label>
                    <input class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}" type="text" name="instagram" id="instagram" value="{{ old('instagram', $site->instagram) }}">
                    @if($errors->has('instagram'))
                        <div class="invalid-feedback">
                            {{ $errors->first('instagram') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.instagram_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="pinterest">{{ trans('cruds.site.fields.pinterest') }}</label>
                    <input class="form-control {{ $errors->has('pinterest') ? 'is-invalid' : '' }}" type="text" name="pinterest" id="pinterest" value="{{ old('pinterest', $site->pinterest) }}">
                    @if($errors->has('pinterest'))
                        <div class="invalid-feedback">
                            {{ $errors->first('pinterest') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.pinterest_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="publish" value="0">
                        <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ $site->publish || old('publish', 0) === 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="publish">{{ trans('cruds.site.fields.publish') }}</label>
                    </div>
                    @if($errors->has('publish'))
                        <div class="invalid-feedback">
                            {{ $errors->first('publish') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.site.fields.publish_helper') }}</span>
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
        Dropzone.options.flagDropzone = {
            url: '{{ route('admin.sites.storeMedia') }}',
            maxFilesize: 1, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 1,
                width: 50,
                height: 50
            },
            success: function (file, response) {
                $('form').find('input[name="flag"]').remove()
                $('form').append('<input type="hidden" name="flag" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="flag"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($site) && $site->flag)
                var file = {!! json_encode($site->flag) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, '{{ $site->flag->getUrl('thumb') }}')
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="flag" value="' + file.file_name + '">')
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
        Dropzone.options.logoDropzone = {
            url: '{{ route('admin.sites.storeMedia') }}',
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
                $('form').find('input[name="logo"]').remove()
                $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="logo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($site) && $site->logo)
                var file = {!! json_encode($site->logo) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, '{{ $site->logo->getUrl('thumb') }}')
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
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
        Dropzone.options.faviconDropzone = {
            url: '{{ route('admin.sites.storeMedia') }}',
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
                $('form').find('input[name="favicon"]').remove()
                $('form').append('<input type="hidden" name="favicon" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="favicon"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                    @if(isset($site) && $site->favicon)
                var file = {!! json_encode($site->favicon) !!}
                        this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, '{{ $site->favicon->getUrl('thumb') }}')
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="favicon" value="' + file.file_name + '">')
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
