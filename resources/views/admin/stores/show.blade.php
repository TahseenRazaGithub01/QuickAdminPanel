@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.store.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stores.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.id') }}
                        </th>
                        <td>
                            {{ $store->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.site') }}
                        </th>
                        <td>
                            @foreach($store->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.name') }}
                        </th>
                        <td>
                            {{ $store->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.slug') }}
                        </th>
                        <td>
                            {{ $store->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.category') }}
                        </th>
                        <td>
                            @foreach($store->categories as $key => $category)
                                <span class="label label-info">{{ $category->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.short_description') }}
                        </th>
                        <td>
                            {{ $store->short_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.long_description') }}
                        </th>
                        <td>
                            {!! $store->long_description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.store_url') }}
                        </th>
                        <td>
                            {{ $store->store_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.affiliate_url') }}
                        </th>
                        <td>
                            {{ $store->affiliate_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.image') }}
                        </th>
                        <td>
                            @if($store->image)
                                <a href="{{ $store->image->getUrl() }}" target="_blank">
                                    <img src="{{ $store->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.sort') }}
                        </th>
                        <td>
                            {{ $store->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.faq') }}
                        </th>
                        <td>
                            {!! $store->faq !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $store->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.popular') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $store->popular ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $store->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.html_tags') }}
                        </th>
                        <td>
                            {{ $store->html_tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.script_tags') }}
                        </th>
                        <td>
                            {{ $store->script_tags }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.template') }}
                        </th>
                        <td>
                            {{ App\Store::TEMPLATE_SELECT[$store->template] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.viewed') }}
                        </th>
                        <td>
                            {{ $store->viewed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.meta_title') }}
                        </th>
                        <td>
                            {{ $store->meta_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $store->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $store->meta_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.created_by') }}
                        </th>
                        <td>
                            {{ $store->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.store.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $store->updated_by }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stores.index') }}">
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
            <a class="nav-link" href="#store_coupons" role="tab" data-toggle="tab">
                {{ trans('cruds.coupon.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#stores_addspace_stores" role="tab" data-toggle="tab">
                {{ trans('cruds.addspaceStore.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#store_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="store_coupons">
            @includeIf('admin.stores.relationships.storeCoupons', ['coupons' => $store->storeCoupons])
        </div>
        <div class="tab-pane" role="tabpanel" id="stores_addspace_stores">
            @includeIf('admin.stores.relationships.storesAddspaceStores', ['addspaceStores' => $store->storesAddspaceStores])
        </div>
        <div class="tab-pane" role="tabpanel" id="store_events">
            @includeIf('admin.stores.relationships.storeEvents', ['events' => $store->storeEvents])
        </div>
    </div>
</div>

@endsection
