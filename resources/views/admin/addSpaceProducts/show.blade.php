@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.addSpaceProduct.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.add-space-products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.id') }}
                        </th>
                        <td>
                            {{ $addSpaceProduct->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.site') }}
                        </th>
                        <td>
                            @foreach($addSpaceProduct->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.horizontal_script') }}
                        </th>
                        <td>
                            {{ $addSpaceProduct->horizontal_script }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.vertical_script') }}
                        </th>
                        <td>
                            {{ $addSpaceProduct->vertical_script }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.product') }}
                        </th>
                        <td>
                            @foreach($addSpaceProduct->products as $key => $product)
                                <span class="label label-info">{{ $product->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.created_by') }}
                        </th>
                        <td>
                            {{ $addSpaceProduct->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $addSpaceProduct->updated_by }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.add-space-products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection