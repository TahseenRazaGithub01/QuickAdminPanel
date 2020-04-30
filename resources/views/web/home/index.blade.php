@extends('web.layouts.app')
@section('content')
<?php $imgHolder = 'data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';?>

<div class="innerContainer">
    <div class="banner">

  <div class="buzzSlider">
 @if(!empty($banners))
            @foreach($banners as $banner)
            <div class="slide">
       <a href="{{ $banner['link'] }}" target="_blank" title="{{ isset($banner['title']) ? $banner['title'] : '' }}">
                        <picture>
                            <source
                                media="(min-width: 650px)"
                                srcset="{{ $banner['image']['url'] }}">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($banner['image']['url']) ? $banner['image']['url'] : '' }}" alt="{{ isset($banner['title']) ? $banner['title'] : ''}}">
                        </picture>
      </a>
            </div>

            @endforeach
        @endif
        </div>
    </div>

</div>
<div class="innerContainer">
@if(!isset($banners))
            <picture>
                <source
                    media="(min-width: 650px)"
                    srcset="{{config('app.image_path')}}/build/images/404.jpg">
            <!-- <source
        media="(max-width: 649px)"
        srcset="{{config('app.image_path')}}/build/images/banner1_res.jpg"> -->
                <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/404.jpg" alt="404">
            </picture>
        @endif
</div>
<div class="tSlBg">

    <div class="innerContainer">

        <div class="topStores">

            <h2 class="pageHeading">{{ trans('sentence.home_top_stores') }}</h2>

            <div class="stWrp">

                @if(!empty($popularStores))
                @foreach($popularStores as $store)
                <div class="slide">

                    <a href="{{config('app.app_path')}}/{{ isset($store['slugs']['slug']) ? $store['slugs']['slug'] : ''}}" class="image">

                    <img class="lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($store['image']['url']) ? $store['image']['url'] : '' }}" alt="">

                    </a>

                </div>
                @endforeach
                @endif

            </div>

            <a href="{{ config('app.app_path') }}/sitemap" class="visBtn">{{ trans('sentence.home_top_visit_all_stores') }}</a>

        </div>

    </div>

</div>

<div class="featBg">

    <div class="innerContainer">

        <div class="featureDeals">

            <h3 class="pageHeading">{{ trans('sentence.home_best_offers_and_coupons') }}</h3>

            <div class="rowbar">

                <div class="flexWrap">

                    @if(!empty($featuredCouponsAndPopularCoupons))
                        @foreach($featuredCouponsAndPopularCoupons as $featuredCoupons)
                            @if($featuredCoupons['featured'] == 1)
                    @if($featuredCoupons['code'] != '')
                    <div class="productBox">

                                <div class="coupons">
                                    @if($featuredCoupons['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif

                                    <figure>

                                        <a href="{{config('app.app_path').'/'.$featuredCoupons['store']['slugs']['slug']}}" class="logoAnchor">

                                        <!-- <img class="couponImage lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($featuredCoupons['image']['url']) ? $featuredCoupons['image']['url'] : '' }}" alt=""> -->
                                    @if(!empty($featuredCoupons['custom_image_title']))
                                    <div class="custom_title_off" style="font-size: 16px;height: auto;margin: 0;color: #000;line-height: 28px;font-weight: bold;width: 14%;text-align: center;">
                                        <h4>{{ $featuredCoupons['custom_image_title'] }}</h4>
                                    </div>
                                    @else
                                        <img class="couponImage lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ ( !empty($featuredCoupons['image']['url']) ? $featuredCoupons['image']['url'] : (isset($featuredCoupons['store']['image']['url']) ? $featuredCoupons['store']['image']['url'] : '') ) }}" alt="" class="couponImage">
                                    @endif

                                        </a>

                                    </figure>

                                    <div class="cpnDtlSec">

                                        <div class="textWrpr">

                                            <div class="title">

                                                <h4 class="offerTitle">{{ isset($featuredCoupons['title']) ? $featuredCoupons['title'] : '' }} {{ ($featuredCoupons['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' }}</h4>

                                            </div>

                                            <div class="expiry">

                                                <div class="views">

                                                    <i class="lm_user"></i><span>{{ isset($featuredCoupons['viewed']) ? $featuredCoupons['viewed'] : 0 }} {{ trans('sentence.home_coupon_views') }}</span>

                                                </div>
                                                @if($featuredCoupons['verified']==1)
                                                <div class="verify">

                                                    <i class="lm_check_square"></i><span>{{ trans('sentence.home_verified') }}</span>

                                                </div>
                                                @endif

                                                <div class="date">
                                                @php
                                                if (date("Y", strtotime($featuredCoupons['date_expiry'])) >= '2090')
                                                {
                                                        $expiryDate = 'On Going';
                                                } else {
                                                    $expiryDate = date("M-j-Y", strtotime($featuredCoupons['date_expiry']));
                                                }
                                                @endphp

                                                    <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="buttonsWrapper">

                                            <div class="codeButton openOverlay" data-name="copycode">

                                                <a class="baseurlappend visibleButton" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ $featuredCoupons['affiliate_url'] }}" data-marchant="{{ $featuredCoupons['affiliate_url'] }}" data-var="copy" title="">

                                                <span> {{ trans('sentence.home_get_code') }} </span>

                                                </a>

                                            </div>

                                        </div>
                                        <i class="lm_right vsbanchr"></i>
                                            <a class="cids responsiveLink" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ $featuredCoupons['affiliate_url'] }}" title=""></a>
                                    </div>

                                </div>

                            </div>
                    @else
                    <div class="productBox">

                                <div class="coupons">
                                    @if($featuredCoupons['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                                    <figure>

                                        <a href="{{config('app.app_path').'/'.$featuredCoupons['store']['slugs']['slug']}}" class="logoAnchor">

                                        <!-- <img class="couponImage lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($featuredCoupons['image']['url']) ? $featuredCoupons['image']['url'] : '' }}" alt=""> -->
                                    @if(!empty($featuredCoupons['custom_image_title']))
                                    <div class="custom_title_off" style="font-size: 16px;height: auto;margin: 0;color: #000;line-height: 28px;font-weight: bold;width: 14%;text-align: center;">
                                        <h4>{{ $featuredCoupons['custom_image_title'] }}</h4>
                                    </div>
                                    @else
                                        <img class="couponImage lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ ( !empty($featuredCoupons['image']['url']) ? $featuredCoupons['image']['url'] : (isset($featuredCoupons['store']['image']['url']) ? $featuredCoupons['store']['image']['url'] : '') ) }}" alt="" class="couponImage">
                                    @endif

                                        </a>

                                    </figure>

                                    <div class="cpnDtlSec">

                                        <div class="textWrpr">

                                            <div class="title">

                                                <h4 class="offerTitle">{{ isset($featuredCoupons['title']) ? $featuredCoupons['title'] : '' }}{{ ($featuredCoupons['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' }}</h4>

                                            </div>

                                            <div class="expiry">

                                                <div class="views">

                                                    <i class="lm_user"></i><span>{{ isset($featuredCoupons['viewed']) ? $featuredCoupons['viewed'] : 0 }} {{ trans('sentence.home_coupon_views') }}</span>

                                                </div>
                                                @if($featuredCoupons['verified']==1)
                                                <div class="verify">

                                                    <i class="lm_check_square"></i><span>{{ trans('sentence.home_verified') }}</span>

                                                </div>
                                                @endif

                                                <div class="date">
                                                @php
                                                if (date("Y", strtotime($featuredCoupons['date_expiry'])) >= '2090')
                                                {
                                                        $expiryDate = 'On Going';
                                                } else {
                                                    $expiryDate = date("M-j-Y", strtotime($featuredCoupons['date_expiry']));
                                                }
                                                @endphp

                                                    <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>

                                                </div>

                                            </div>

                                        </div>

                                    <div class="buttonsWrapper">
                                            <div class="codeButton openOverlay" data-name="copycode">
                                                <a class="baseurlappend DealButton" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ $featuredCoupons['affiliate_url'] }}" data-marchant="{{ $featuredCoupons['affiliate_url'] }}" data-var="deal">
                                                <span class="buttonSpan"> {{ trans('sentence.category_store_detail_get_deals') }}</span>
                                                </a>

                                            </div>
                                        </div>
                                        <i class="lm_right vsbanchr"></i>
                                            <a class="cids responsiveLink" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ $featuredCoupons['affiliate_url'] }}" title=""></a>
                                    </div>

                                </div>

                            </div>
                    @endif
                            
                            @endif
                        @endforeach
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

<div class="innerContainer">

    <div class="daysDeals">

        <h3 class="pageHeading">{{ trans('sentence.home_top_recommended') }}</h3>

        <div class="rowbar">

            <div class="flexWrap">

                @if(!empty($featuredCouponsAndPopularCoupons))
                    @foreach($featuredCouponsAndPopularCoupons as $featuredCoupons)

                        @if($featuredCoupons['popular'] == 1 || $featuredCoupons['recommended'] == 1)
                    @if($featuredCoupons['code'] != '')
                  <div class="productBox fullPrdoduct">

                            <div class="coupons">
                                    @if($featuredCoupons['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                                <figure>

                                    <a href="{{config('app.app_path').'/'.$featuredCoupons['store']['slugs']['slug']}}" class="logoAnchor">
                                    @if(!empty($featuredCoupons['custom_image_title']))
                                    <div class="custom_title_off" style="font-size: 16px;height: auto;margin: 0;color: #000;line-height: 28px;font-weight: bold;width: 14%;text-align: center;">
                                        <h4>{{ $featuredCoupons['custom_image_title'] }}</h4>
                                    </div>
                                    @else
                                    <img class="couponImage lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($featuredCoupons['image']['url']) ? $featuredCoupons['image']['url'] : (isset($featuredCoupons['store']['image']['url']) ? $featuredCoupons['store']['image']['url'] : '') }}" alt="">
                                    @endif
                                    </a>

                                </figure>

                                <div class="cpnDtlSec">

                                    <div class="textWrpr">
                                                                            <div class="title">

                                            <h4 class="offerTitle">{{ isset($featuredCoupons['title']) ? $featuredCoupons['title'] : '' }}{{ ($featuredCoupons['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' }}</h4>

                                            @php
                                            $description = substr($featuredCoupons['description'], 0, 80);
                                            $descriptionLength = strlen($featuredCoupons['description']);
                                            @endphp
<!--
                                            <p class="offerDesr">

                                                {!! $description !!} @if($descriptionLength > 80) ... @endif
                                            </p>
-->

                                        </div>

                                        <div class="expiry">

                                            <div class="views">

                                                <i class="lm_user"></i><span>{{ isset($featuredCoupons['viewed']) ? $featuredCoupons['viewed'] : 0 }} {{ trans('sentence.home_coupon_views') }}</span>

                                            </div>

                                            @if($featuredCoupons['verified']==1)
                                            <div class="verify">

                                                <i class="lm_check_square"></i><span>{{ trans('sentence.home_verified') }}</span>

                                            </div>
                                            @endif

                                            <div class="date">
                                                @php
                                                if (date("Y", strtotime($featuredCoupons['date_expiry'])) >= '2090')
                                                {
                                                        $expiryDate = 'On Going';
                                                } else {
                                                    $expiryDate = date("M-j-Y", strtotime($featuredCoupons['date_expiry']));
                                                }
                                                @endphp
                                                <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>

                                            </div>

                                        </div>

    

                                    </div>

                                    <div class="buttonsWrapper">

                                        <div class="codeButton openOverlay" data-name="copycode">

                                            <a class="baseurlappend visibleButton" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ isset($featuredCoupons['affiliate_url']) ? $featuredCoupons['affiliate_url'] : '' }}" data-marchant="{{ isset($featuredCoupons['affiliate_url']) ? $featuredCoupons['affiliate_url'] : '' }}" data-var="copy" title="">

                                            <span> {{ trans('sentence.home_get_code') }} </span>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <i class="lm_right vsbanchr"></i>

                                <a class="cids responsiveLink" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ isset($featuredCoupons['affiliate_url']) ? $featuredCoupons['affiliate_url'] : '' }}" title=""></a>

                            </div>

                        </div>
                    @else
                  <div class="productBox fullPrdoduct">

                            <div class="coupons">
                                    @if($featuredCoupons['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                                <figure>

                                    <a href="{{config('app.app_path').'/'.$featuredCoupons['store']['slugs']['slug']}}" class="logoAnchor">
                                    @if(!empty($featuredCoupons['custom_image_title']))
                                    <div class="custom_title_off" style="font-size: 16px;height: auto;margin: 0;color: #000;line-height: 28px;font-weight: bold;width: 14%;text-align: center;">
                                        <h4>{{ $featuredCoupons['custom_image_title'] }}</h4>
                                    </div>
                                    @else
                                    <img class="couponImage lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($featuredCoupons['image']['url']) ? $featuredCoupons['image']['url'] : (isset($featuredCoupons['store']['image']['url']) ? $featuredCoupons['store']['image']['url'] : '') }}" alt="">
                                    @endif
                                    </a>

                                </figure>

                                <div class="cpnDtlSec">

                                    <div class="textWrpr">
                                                                                <div class="title">

                                            <h4 class="offerTitle">{{ isset($featuredCoupons['title']) ? $featuredCoupons['title'] : '' }}{{ ($featuredCoupons['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' }}</h4>

                                            @php
                                            $description = substr($featuredCoupons['description'], 0, 80);
                                            $descriptionLength = strlen($featuredCoupons['description']);
                                            @endphp
<!--
                                            <p class="offerDesr">

                                                {!! $description !!} @if($descriptionLength > 80) ... @endif
                                            </p>
-->

                                        </div>

                                        <div class="expiry">

                                            <div class="views">

                                                <i class="lm_user"></i><span>{{ isset($featuredCoupons['viewed']) ? $featuredCoupons['viewed'] : 0 }} {{ trans('sentence.home_coupon_views') }}</span>

                                            </div>

                                            @if($featuredCoupons['verified']==1)
                                            <div class="verify">

                                                <i class="lm_check_square"></i><span>{{ trans('sentence.home_verified') }}</span>

                                            </div>
                                            @endif

                                            <div class="date">
                                                @php
                                                if (date("Y", strtotime($featuredCoupons['date_expiry'])) >= '2090')
                                                {
                                                        $expiryDate = 'On Going';
                                                } else {
                                                    $expiryDate = date("M-j-Y", strtotime($featuredCoupons['date_expiry']));
                                                }
                                                @endphp
                                                <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>

                                            </div>

                                        </div>



                                    </div>

                               <div class="buttonsWrapper">
                                            <div class="codeButton openOverlay" data-name="copycode">
                                                <a class="baseurlappend DealButton" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ $featuredCoupons['affiliate_url'] }}" data-marchant="{{ $featuredCoupons['affiliate_url'] }}" data-var="deal">
                                                <span class="buttonSpan"> {{ trans('sentence.category_store_detail_get_deals') }}</span>
                                                </a>

                                            </div>
                                        </div>

                                </div>

                                <i class="lm_right vsbanchr"></i>

                                <a class="cids responsiveLink" data-id="{{ $featuredCoupons['id'] }}" data-store="{{ isset($featuredCoupons['affiliate_url']) ? $featuredCoupons['affiliate_url'] : '' }}" title=""></a>

                            </div>

                        </div>
                    @endif

                      
                        @endif
                    @endforeach
                @endif

            </div>

        </div>

    </div>

</div>

<div class="innerContainer">
    <div class="webSubDomain">
        <div class="rowbar">
            <div class="Flx">
                @if(!empty($sites))
                    @foreach($sites as $site)
                    <div class="subDom">
                        <a href="{{ isset($site['country_code']) ? url(strtolower($site['country_code'])) : '' }}">
                            <picture>
                                    @if(!empty($site['flag']['url']))
                                    <img class="lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($site['flag']['url']) ? $site['flag']['url'] : '' }}" class="flags" alt="" />
                                    @else
                                    <img class="lazy" src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" alt="">
                                    @endif
                                </picture>
                                <span>{{ isset($site['country_name']) ? $site['country_name'] : '' }}</span>
                        </a>
                    </div>
                    @endforeach
                @endif



            </div>
        </div>
    </div>
</div>
@endsection
