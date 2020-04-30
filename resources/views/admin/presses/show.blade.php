@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.press.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.presses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.id') }}
                        </th>
                        <td>
                            {{ $press->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.site') }}
                        </th>
                        <td>
                            @foreach($press->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.title') }}
                        </th>
                        <td>
                            {{ $press->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.short_description') }}
                        </th>
                        <td>
                            {{ $press->short_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.show_on_listing') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $press->show_on_listing ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.slug') }}
                        </th>
                        <td>
                            {{ $press->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.sort') }}
                        </th>
                        <td>
                            {{ $press->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.image') }}
                        </th>
                        <td>
                            @if($press->image)
                                <a href="{{ $press->image->getUrl() }}" target="_blank">
                                    <img src="{{ $press->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.long_description') }}
                        </th>
                        <td>
                            {{ $press->long_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.related_links') }}
                        </th>
                        <td>
                            {!! $press->related_links !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $press->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $press->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.meta_title') }}
                        </th>
                        <td>
                            {{ $press->meta_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $press->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $press->meta_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.viewed') }}
                        </th>
                        <td>
                            {{ $press->viewed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.created_by') }}
                        </th>
                        <td>
                            {{ $press->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.press.fields.update_by') }}
                        </th>
                        <td>
                            {{ $press->update_by }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.presses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection