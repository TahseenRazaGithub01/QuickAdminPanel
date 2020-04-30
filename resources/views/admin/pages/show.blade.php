@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.page.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.id') }}
                        </th>
                        <td>
                            {{ $page->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.site') }}
                        </th>
                        <td>
                            @foreach($page->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.title') }}
                        </th>
                        <td>
                            {{ $page->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.description') }}
                        </th>
                        <td>
                            {!! $page->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.slug') }}
                        </th>
                        <td>
                            {{ $page->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.banner_image') }}
                        </th>
                        <td>
                            @if($page->banner_image)
                                <a href="{{ $page->banner_image->getUrl() }}" target="_blank">
                                    <img src="{{ $page->banner_image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.image') }}
                        </th>
                        <td>
                            @if($page->image)
                                <a href="{{ $page->image->getUrl() }}" target="_blank">
                                    <img src="{{ $page->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.additional_image') }}
                        </th>
                        <td>
                            @if($page->additional_image)
                                <a href="{{ $page->additional_image->getUrl() }}" target="_blank">
                                    <img src="{{ $page->additional_image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $page->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.meta_title') }}
                        </th>
                        <td>
                            {{ $page->meta_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $page->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.page.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $page->meta_description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection