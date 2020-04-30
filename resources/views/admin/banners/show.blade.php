@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.banner.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.banners.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.id') }}
                        </th>
                        <td>
                            {{ $banner->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.site') }}
                        </th>
                        <td>
                            @foreach($banner->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.title') }}
                        </th>
                        <td>
                            {{ $banner->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.link') }}
                        </th>
                        <td>
                            {{ $banner->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.image') }}
                        </th>
                        <td>
                            @if($banner->image)
                                <a href="{{ $banner->image->getUrl() }}" target="_blank">
                                    <img src="{{ $banner->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.store_image') }}
                        </th>
                        <td>
                            @if($banner->store_image)
                                <a href="{{ $banner->store_image->getUrl() }}" target="_blank">
                                    <img src="{{ $banner->store_image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.mobile_image') }}
                        </th>
                        <td>
                            @if($banner->mobile_image)
                                <a href="{{ $banner->mobile_image->getUrl() }}" target="_blank">
                                    <img src="{{ $banner->mobile_image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.sort') }}
                        </th>
                        <td>
                            {{ $banner->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.created_by') }}
                        </th>
                        <td>
                            {{ $banner->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.banner.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $banner->updated_by }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.banners.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection