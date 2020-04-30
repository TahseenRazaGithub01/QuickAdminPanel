@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.category.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.id') }}
                        </th>
                        <td>
                            {{ $category->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.site') }}
                        </th>
                        <td>
                            @foreach($category->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.title') }}
                        </th>
                        <td>
                            {{ $category->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.slug') }}
                        </th>
                        <td>
                            {{ $category->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.parent') }}
                        </th>
                        <td>
                            {{ $category->parent->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.short_description') }}
                        </th>
                        <td>
                            {{ $category->short_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.long_description') }}
                        </th>
                        <td>
                            {!! $category->long_description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.image') }}
                        </th>
                        <td>
                            @if($category->image)
                                <a href="{{ $category->image->getUrl() }}" target="_blank">
                                    <img src="{{ $category->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.icon') }}
                        </th>
                        <td>
                            @if($category->icon)
                                <a href="{{ $category->icon->getUrl() }}" target="_blank">
                                    <img src="{{ $category->icon->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.sort') }}
                        </th>
                        <td>
                            {{ $category->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $category->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.popular') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $category->popular ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $category->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.meta_title') }}
                        </th>
                        <td>
                            {{ $category->meta_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $category->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $category->meta_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.category.fields.user') }}
                        </th>
                        <td>
                            {{ $category->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#parent_categories" role="tab" data-toggle="tab">
                {{ trans('cruds.category.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#category_blogs" role="tab" data-toggle="tab">
                {{ trans('cruds.blog.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#category_coupons" role="tab" data-toggle="tab">
                {{ trans('cruds.coupon.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#category_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#category_stores" role="tab" data-toggle="tab">
                {{ trans('cruds.store.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="parent_categories">
            @includeIf('admin.categories.relationships.parentCategories', ['categories' => $category->parentCategories])
        </div>
        <div class="tab-pane" role="tabpanel" id="category_blogs">
            @includeIf('admin.categories.relationships.categoryBlogs', ['blogs' => $category->categoryBlogs])
        </div>
        <div class="tab-pane" role="tabpanel" id="category_coupons">
            @includeIf('admin.categories.relationships.categoryCoupons', ['coupons' => $category->categoryCoupons])
        </div>
        <div class="tab-pane" role="tabpanel" id="category_events">
            @includeIf('admin.categories.relationships.categoryEvents', ['events' => $category->categoryEvents])
        </div>
        <div class="tab-pane" role="tabpanel" id="category_stores">
            @includeIf('admin.categories.relationships.categoryStores', ['stores' => $category->categoryStores])
        </div>
    </div>
</div>

@endsection