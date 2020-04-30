@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.network.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.networks.update", [$network->id]) }}" enctype="multipart/form-data" id="networkForm">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.network.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $network->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.network.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.network.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $network->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.network.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="api_key">{{ trans('cruds.network.fields.api_key') }}</label>
                <input class="form-control {{ $errors->has('api_key') ? 'is-invalid' : '' }}" type="text" name="api_key" id="api_key" value="{{ old('api_key', $network->api_key) }}" required>
                @if($errors->has('api_key'))
                    <div class="invalid-feedback">
                        {{ $errors->first('api_key') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.network.fields.api_key_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="secret_key">{{ trans('cruds.network.fields.secret_key') }}</label>
                <input class="form-control {{ $errors->has('secret_key') ? 'is-invalid' : '' }}" type="text" name="secret_key" id="secret_key" value="{{ old('secret_key', $network->secret_key) }}">
                @if($errors->has('secret_key'))
                    <div class="invalid-feedback">
                        {{ $errors->first('secret_key') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.network.fields.secret_key_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="affiliate">{{ trans('cruds.network.fields.affiliate') }}</label>
                <input class="form-control {{ $errors->has('affiliate') ? 'is-invalid' : '' }}" type="text" name="affiliate" id="affiliate" value="{{ old('affiliate', $network->affiliate) }}">
                @if($errors->has('affiliate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('affiliate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.network.fields.affiliate_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('publish') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="publish" value="0">
                    <input class="form-check-input" type="checkbox" name="publish" id="publish" value="1" {{ $network->publish || old('publish', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="publish">{{ trans('cruds.network.fields.publish') }}</label>
                </div>
                @if($errors->has('publish'))
                    <div class="invalid-feedback">
                        {{ $errors->first('publish') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.network.fields.publish_helper') }}</span>
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
