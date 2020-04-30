@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.site.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.id') }}
                        </th>
                        <td>
                            {{ $site->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.name') }}
                        </th>
                        <td>
                            {{ $site->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.country_name') }}
                        </th>
                        <td>
                            {{ $site->country_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.country_code') }}
                        </th>
                        <td>
                            {{ $site->country_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.flag') }}
                        </th>
                        <td>
                            @if($site->flag)
                                <a href="{{ $site->flag->getUrl() }}" target="_blank">
                                    <img src="{{ $site->flag->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.url') }}
                        </th>
                        <td>
                            {{ $site->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.logo') }}
                        </th>
                        <td>
                            @if($site->logo)
                                <a href="{{ $site->logo->getUrl() }}" target="_blank">
                                    <img src="{{ $site->logo->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.favicon') }}
                        </th>
                        <td>
                            @if($site->favicon)
                                <a href="{{ $site->favicon->getUrl() }}" target="_blank">
                                    <img src="{{ $site->favicon->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.html_tags') }}
                        </th>
                        <td>
                            {{ $site->html_tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.javascript_tags') }}
                        </th>
                        <td>
                            {{ $site->javascript_tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.twitter') }}
                        </th>
                        <td>
                            {{ $site->twitter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.linked_in') }}
                        </th>
                        <td>
                            {{ $site->linked_in }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.facebook') }}
                        </th>
                        <td>
                            {{ $site->facebook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.youtube') }}
                        </th>
                        <td>
                            {{ $site->youtube }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.site.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $site->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sites.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<?php /*
 Related Data Comment
 <div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#site_categories" role="tab" data-toggle="tab">
                {{ trans('cruds.category.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_stores" role="tab" data-toggle="tab">
                {{ trans('cruds.store.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_coupons" role="tab" data-toggle="tab">
                {{ trans('cruds.coupon.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_pages" role="tab" data-toggle="tab">
                {{ trans('cruds.page.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_presses" role="tab" data-toggle="tab">
                {{ trans('cruds.press.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_tags" role="tab" data-toggle="tab">
                {{ trans('cruds.tag.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_product_categories" role="tab" data-toggle="tab">
                {{ trans('cruds.productCategory.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_addspace_stores" role="tab" data-toggle="tab">
                {{ trans('cruds.addspaceStore.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_add_space_products" role="tab" data-toggle="tab">
                {{ trans('cruds.addSpaceProduct.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_banners" role="tab" data-toggle="tab">
                {{ trans('cruds.banner.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_networks" role="tab" data-toggle="tab">
                {{ trans('cruds.network.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_blogs" role="tab" data-toggle="tab">
                {{ trans('cruds.blog.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#site_products" role="tab" data-toggle="tab">
                {{ trans('cruds.product.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="site_categories">
            @includeIf('admin.sites.relationships.siteCategories', ['categories' => $site->siteCategories])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_stores">
            @includeIf('admin.sites.relationships.siteStores', ['stores' => $site->siteStores])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_coupons">
            @includeIf('admin.sites.relationships.siteCoupons', ['coupons' => $site->siteCoupons])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_pages">
            @includeIf('admin.sites.relationships.sitePages', ['pages' => $site->sitePages])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_presses">
            @includeIf('admin.sites.relationships.sitePresses', ['presses' => $site->sitePresses])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_events">
            @includeIf('admin.sites.relationships.siteEvents', ['events' => $site->siteEvents])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_tags">
            @includeIf('admin.sites.relationships.siteTags', ['tags' => $site->siteTags])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_product_categories">
            @includeIf('admin.sites.relationships.siteProductCategories', ['productCategories' => $site->siteProductCategories])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_addspace_stores">
            @includeIf('admin.sites.relationships.siteAddspaceStores', ['addspaceStores' => $site->siteAddspaceStores])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_add_space_products">
            @includeIf('admin.sites.relationships.siteAddSpaceProducts', ['addSpaceProducts' => $site->siteAddSpaceProducts])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_banners">
            @includeIf('admin.sites.relationships.siteBanners', ['banners' => $site->siteBanners])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_networks">
            @includeIf('admin.sites.relationships.siteNetworks', ['networks' => $site->siteNetworks])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_blogs">
            @includeIf('admin.sites.relationships.siteBlogs', ['blogs' => $site->siteBlogs])
        </div>
        <div class="tab-pane" role="tabpanel" id="site_products">
            @includeIf('admin.sites.relationships.siteProducts', ['products' => $site->siteProducts])
        </div>
    </div>
</div>
 */
?>

@endsection
