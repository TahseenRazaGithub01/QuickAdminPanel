@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.addSpaceProduct.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.add-space-products.update", [$addSpaceProduct->id]) }}" enctype="multipart/form-data" id="spaceForm">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="sites">{{ trans('cruds.addSpaceProduct.fields.site') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sites') ? 'is-invalid' : '' }}" name="sites[]" id="sites" multiple required>
                    @foreach($sites as $id => $site)
                        <option value="{{ $id }}" {{ (in_array($id, old('sites', [])) || $addSpaceProduct->sites->contains($id)) ? 'selected' : '' }}>{{ $site }}</option>
                    @endforeach
                </select>
                @if($errors->has('sites'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sites') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addSpaceProduct.fields.site_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="horizontal_script">{{ trans('cruds.addSpaceProduct.fields.horizontal_script') }}</label>
                <textarea class="form-control {{ $errors->has('horizontal_script') ? 'is-invalid' : '' }}" name="horizontal_script" id="horizontal_script" required>{{ old('horizontal_script', $addSpaceProduct->horizontal_script) }}</textarea>
                @if($errors->has('horizontal_script'))
                    <div class="invalid-feedback">
                        {{ $errors->first('horizontal_script') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addSpaceProduct.fields.horizontal_script_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vertical_script">{{ trans('cruds.addSpaceProduct.fields.vertical_script') }}</label>
                <textarea class="form-control {{ $errors->has('vertical_script') ? 'is-invalid' : '' }}" name="vertical_script" id="vertical_script" required>{{ old('vertical_script', $addSpaceProduct->vertical_script) }}</textarea>
                @if($errors->has('vertical_script'))
                    <div class="invalid-feedback">
                        {{ $errors->first('vertical_script') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addSpaceProduct.fields.vertical_script_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="products">{{ trans('cruds.addSpaceProduct.fields.product') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products[]" id="products" multiple required>
                    @foreach($products as $id => $product)
                        <option value="{{ $id }}" {{ (in_array($id, old('products', [])) || $addSpaceProduct->products->contains($id)) ? 'selected' : '' }}>{{ $product }}</option>
                    @endforeach
                </select>
                @if($errors->has('products'))
                    <div class="invalid-feedback">
                        {{ $errors->first('products') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.addSpaceProduct.fields.product_helper') }}</span>
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
