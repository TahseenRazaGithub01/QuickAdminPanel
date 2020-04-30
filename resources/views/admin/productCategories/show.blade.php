@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $productCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.site') }}
                        </th>
                        <td>
                            @foreach($productCategory->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $productCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.title_heading') }}
                        </th>
                        <td>
                            {{ $productCategory->title_heading }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.sub_heading') }}
                        </th>
                        <td>
                            {{ $productCategory->sub_heading }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.slug') }}
                        </th>
                        <td>
                            {{ $productCategory->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.description') }}
                        </th>
                        <td>
                            {{ $productCategory->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.about_description') }}
                        </th>
                        <td>
                            {!! $productCategory->about_description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.long_description') }}
                        </th>
                        <td>
                            {!! $productCategory->long_description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.sort') }}
                        </th>
                        <td>
                            {{ $productCategory->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $productCategory->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.popular') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $productCategory->popular ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $productCategory->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.image') }}
                        </th>
                        <td>
                            @if($productCategory->image)
                                <a href="{{ $productCategory->image->getUrl() }}" target="_blank">
                                    <img src="{{ $productCategory->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.old_url') }}
                        </th>
                        <td>
                            {{ $productCategory->old_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.new_url') }}
                        </th>
                        <td>
                            {{ $productCategory->new_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.template') }}
                        </th>
                        <td>
                            {{ App\ProductCategory::TEMPLATE_SELECT[$productCategory->template] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.meta_title') }}
                        </th>
                        <td>
                            {{ $productCategory->meta_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $productCategory->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productCategory.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $productCategory->meta_description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-categories.index') }}">
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
            <a class="nav-link" href="#product_add_space_products" role="tab" data-toggle="tab">
                {{ trans('cruds.addSpaceProduct.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#product_category_products" role="tab" data-toggle="tab">
                {{ trans('cruds.product.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="product_add_space_products">
            @includeIf('admin.productCategories.relationships.productAddSpaceProducts', ['addSpaceProducts' => $productCategory->productAddSpaceProducts])
        </div>
        <div class="tab-pane" role="tabpanel" id="product_category_products">
            @includeIf('admin.productCategories.relationships.productCategoryProducts', ['products' => $productCategory->productCategoryProducts])
        </div>
    </div>
</div>

@endsection