@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.addspaceStore.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.addspace-stores.update", [$addspaceStore->id]) }}" enctype="multipart/form-data" id="spaceForm">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.addspaceStore.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $addspaceStore->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addspaceStore.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="horizontal_add_script">{{ trans('cruds.addspaceStore.fields.horizontal_add_script') }}</label>
                <textarea class="form-control {{ $errors->has('horizontal_add_script') ? 'is-invalid' : '' }}" name="horizontal_add_script" id="horizontal_add_script" required>{{ old('horizontal_add_script', $addspaceStore->horizontal_add_script) }}</textarea>
                @if($errors->has('horizontal_add_script'))
                    <div class="invalid-feedback">
                        {{ $errors->first('horizontal_add_script') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addspaceStore.fields.horizontal_add_script_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vertical_add_script">{{ trans('cruds.addspaceStore.fields.vertical_add_script') }}</label>
                <textarea class="form-control {{ $errors->has('vertical_add_script') ? 'is-invalid' : '' }}" name="vertical_add_script" id="vertical_add_script" required>{{ old('vertical_add_script', $addspaceStore->vertical_add_script) }}</textarea>
                @if($errors->has('vertical_add_script'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vertical_add_script') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addspaceStore.fields.vertical_add_script_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="stores">{{ trans('cruds.addspaceStore.fields.stores') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('stores') ? 'is-invalid' : '' }}" name="stores[]" id="stores" multiple required>
                    @foreach($stores as $id => $stores)
                        <option value="{{ $id }}" {{ (in_array($id, old('stores', [])) || $addspaceStore->stores->contains($id)) ? 'selected' : '' }}>{{ $stores }}</option>
                    @endforeach
                </select>
                @if($errors->has('stores'))
                    <div class="invalid-feedback">
                        {{ $errors->first('stores') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addspaceStore.fields.stores_helper') }}</span>
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
