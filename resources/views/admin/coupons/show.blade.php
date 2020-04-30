@extends('layouts.admin')
@section('content')

@php
    $url = request()->sid ? route('admin.coupons.index', 'sid=' . request()->sid) : route('admin.coupons.index');
@endphp

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coupon.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ $url }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.id') }}
                        </th>
                        <td>
                            {{ $coupon->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.site') }}
                        </th>
                        <td>
                            @foreach($coupon->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.type') }}
                        </th>
                        <td>
                            {{ App\Coupon::TYPE_SELECT[$coupon->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.title') }}
                        </th>
                        <td>
                            {{ $coupon->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.custom_image_title') }}
                        </th>
                        <td>
                            {{ $coupon->custom_image_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.description') }}
                        </th>
                        <td>
                            {!! $coupon->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.image') }}
                        </th>
                        <td>
                            @if($coupon->image)
                                <a href="{{ $coupon->image->getUrl() }}" target="_blank">
                                    <img src="{{ $coupon->image->getUrl('thumb') }}" width="50px" height="50px">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.affiliate_url') }}
                        </th>
                        <td>
                            {{ $coupon->affiliate_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.sort') }}
                        </th>
                        <td>
                            {{ $coupon->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.date_available') }}
                        </th>
                        <td>
                            {{ $coupon->date_available }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.date_expiry') }}
                        </th>
                        <td>
                            {{ $coupon->date_expiry }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.category') }}
                        </th>
                        <td>
                            @foreach($coupon->categories as $key => $category)
                                <span class="label label-info">{{ $category->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.store') }}
                        </th>
                        <td>
                            {{ $coupon->store->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.verified') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coupon->verified ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.exclusive') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coupon->exclusive ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.featured') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coupon->featured ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.popular') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coupon->popular ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coupon->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.free_shipping') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coupon->free_shipping ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.code') }}
                        </th>
                        <td>
                            {{ $coupon->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.special_event_sort') }}
                        </th>
                        <td>
                            {{ $coupon->special_event_sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.coupon') }}
                        </th>
                        <td>
                            {{ $coupon->coupon->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ $url }}">
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
            <a class="nav-link" href="#coupon_coupons" role="tab" data-toggle="tab">
                {{ trans('cruds.coupon.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#coupon_events" role="tab" data-toggle="tab">
                {{ trans('cruds.event.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="coupon_coupons">
            @includeIf('admin.coupons.relationships.couponCoupons', ['coupons' => $coupon->couponCoupons])
        </div>
        <div class="tab-pane" role="tabpanel" id="coupon_events">
            @includeIf('admin.coupons.relationships.couponEvents', ['events' => $coupon->couponEvents])
        </div>
    </div>
</div>

@endsection
