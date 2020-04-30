@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{ config('app.app_path') }}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{$detail['slugs']['slug']}}">{{$detail['title']}}</a>
        </li>
    </ul>
</div>
<div class="flexWrapper strCpnDeal">
    <div class="contntWrpr">
        <div class="cupnsTextAlgment">
            <h3 class="pageTitle">{{$detail['title']}}</h3>
            <div class="cupnsFilter">
                <span>{{ trans('sentence.page_sort_by') }}</span>
                <ul>
                    <li data-target="productBox" class="active"><a href="javascript:;">{{ trans('sentence.page_all_offers') }}</a></li>
                    <li data-target="only-codes"><a href="javascript:;">{{ trans('sentence.page_get_codes') }}</a></li>
                    <li data-target="only-deals"><a href="javascript:;">{{ trans('sentence.page_get_deals') }}</a></li>
                </ul>
            </div>
            <div class="rowbar">

                <div class="flexWrap cupnsAdjust">
                	
                	@foreach($detail['coupons'] as $store)
                    @if($store['code'] == "")
                        <div class="only-deals productBox fullPrdoduct">
                            <div class="coupons">
                                    @if($store['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                                <figure>
                                    <a href="{{config('app.app_path').isset($store['store']['slugs']) ? $store['store']['slugs']['slug'] : $store['store']['slugs']['slug'] }}" class="logoAnchor">

                                    <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($store['image']['url']) ? $store['image']['url'] : $store['store']['image']['url'] }}" alt="" class="couponImage">
                                    </a>
                                </figure>
                                <div class="cpnDtlSec">
                                    <div class="textWrpr">
                                        <div class="title">
                                            <h4 class="offerTitle">{{ $store['title'] }}{{
                                                    ($store['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' 
                                                    }}</h4>
                                            <p class="offerDesr">{!! $store['description'] !!}</p>
                                        </div>
                                        <div class="expiry">
                                            <div class="views">
                                            <i class="lm_user"></i><span>{{$store['viewed']}} {{ trans('sentence.page_views') }}</span>
                                        </div>
                                        @if($store['verified'] == 1)
                                        <div class="verify">
                                            <i class="lm_check_square"></i><span>{{ trans('sentence.page_event_verified') }}</span>
                                        </div>
                                        @endif
                                            @php
                                            $expiryDate = date('d-M-yy', strtotime($store['date_expiry']));
                                            @endphp
                                            <div class="date">
                                                <i class="lm_clock"></i><span>{{ trans('sentence.page_event_expiry_text') }} {{ $expiryDate }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttonsWrapper">
                                        <div class="codeButton openOverlay" data-name="copycode">
                                            <a class="baseurlappend DealButton" data-id="{{ $store['id'] }}" data-store="{{ $store['affiliate_url'] }}" data-marchant="{{ $store['affiliate_url'] }}" data-var="deal">
                                            <span class="buttonSpan"> {{ trans('sentence.page_event_get_deals') }} </span>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <i class="lm_right vsbanchr"></i>
                                <a class="cids responsiveLink" data-id="{{ $store['id'] }}" data-store="{{ $store['affiliate_url'] }}"></a>
                            </div>
                        </div>
                        @else
                	<div class="only-codes productBox fullPrdoduct">
                        <div class="coupons">
                                   @if($store['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                            <figure>
                                <a href="{{config('app.app_path').isset($store['store']['slugs']['slug']) ? $store['store']['slugs']['slug'] : $store['store']['slugs']['slug'] }}" class="logoAnchor">
                                <!-- <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($store['media'][0]['thumbnail']) ? $store['media'][0]['thumbnail'] : config('app.image_path') . '/build/images/placeholder.png' }}" alt=""> -->

                                <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($store['image']['url']) ? $store['image']['url'] : $store['store']['image']['url'] }}" alt="" class="couponImage">

                                </a>
                            </figure>
                            <div class="cpnDtlSec">
                                <div class="textWrpr">
                                    <div class="title">
                                        <h4 class="offerTitle">{{ $store['title'] }}{{
                                                    ($store['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' 
                                                    }}</h4>
                                        <p class="offerDesr">{!! $store['description'] !!}</p>
                                    </div>
                                    <div class="expiry">
                                        <div class="views">
                                            <i class="lm_user"></i><span>{{$store['viewed']}} {{ trans('sentence.page_views') }}</span>
                                        </div>
                                        @if($store['verified'] == 1)
                                        <div class="verify">
                                            <i class="lm_check_square"></i><span>{{ trans('sentence.page_event_verified') }}</span>
                                        </div>
                                        @endif
                                        <div class="date">
                                            <i class="lm_clock"></i><span>{{ trans('sentence.page_event_expiry_text') }} {{ date('d-M-Y',strtotime($store['date_expiry'])) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="buttonsWrapper">
                                    <div class="codeButton openOverlay" data-name="copycode">
                                        <a class="baseurlappend visibleButton" data-id="{{ $store['id'] }}" data-store="{{ $store['affiliate_url'] }}" data-marchant="{{ $store['affiliate_url'] }}" data-var="copy">
                                        <span class="buttonSpan"> {{ trans('sentence.page_event_get_codes') }} </span>
                                        </a>
                                        <span class="hiddenCode"> <span class="foldedCorner"></span> </span>
                                    </div>
                                </div>
                            </div>
                            <i class="lm_right vsbanchr"></i>
                            <a class="cids responsiveLink" data-id="{{ $store['id'] }}" data-store="{{ $store['affiliate_url'] }}"></a>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="sidCntnt">
        <div class="sidePannel brandRating">

            <div class="text">
                <h4>{{$detail['title']}}</h4>
            </div>
            <div class="rate">
                <input type="radio" id="georgina4" name="georgina">
                <label for="georgina4" class="half" title="3 1/2 stars"></label>

                <input type="radio" id="georgina5" name="georgina">
                <label for="georgina5" title="3 stars"></label>

                <input type="radio" id="georgina6" name="georgina">
                <label for="georgina6" class="half" title="2 1/2 stars"></label>

                <input type="radio" id="georgina7" name="georgina">
                <label for="georgina7" title="2 stars"></label>

                <input type="radio" id="georgina8" name="georgina">
                <label for="georgina8" class="half" title="1 1/2 stars"></label>
            </div>
            <p>{{ trans('sentence.page_event_rating_text') }}</p>
        </div>
        <div class="sidePannel">
            <h4>{{ trans('sentence.page_event_detail_about') }} {{$detail['title']}}</h4>
            <p>{!! html_entity_decode($detail['long_description']) !!}</p>
        </div>
        <div class="sidePannel SdePnlCat">
            <h4>{{ trans('sentence.page_popular_stores') }}</h4>
            <h5>{{ trans('sentence.page_discount_voucher_code') }} {{ date('M-Y') }}</h5>
            <ul class="sideBarCategories">
                @if(!empty($detail['stores']))
                	@foreach($detail['stores'] as $store)
                    	<li><a href="{{ config('app.app_path') }}/{{$store['slugs']['slug']}}">{{$store['name']}}</a></li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="sidePannel SdePnlCat">
            <h4>{{ trans('sentence.page_event_related_categories') }}</h4>
            <ul class="sideBarCategories">
                @if(!empty($detail['categories']))
                	@foreach($detail['categories'] as $category)
                    	<li><a href="{{ config('app.app_path') }}/{{$category['slug']}}">{{$category['title']}}</a></li>
                    @endforeach
                @endif
            </ul>
            <div class="buttons">
                <a href="{{config('app.app_path')}}/category" class="relCatBtn">View all <span>Categories</span></a>
            </div>
        </div>

        <div class="sidePannel socialPnl">
            <h4>{{ trans('sentence.page_event_share_these_offers') }}</h4>
            @php
            $encodeUrl = urlencode(url()->current());
            $title = $detail['title'] ;
            @endphp
            <div class="social">
                <a href="http://www.facebook.com/sharer.php?u={{$encodeUrl}}" target="_blank"><i class="lm_facebook"></i></a>
                <a href="//twitter.com/share?text=$title&url={{$encodeUrl}}" target="_blank"><i class="lm_twitter"></i></a>
                <a href="http://www.linkedin.com/shareArticle?mini=true&url={{$encodeUrl}}" target="_blank"><i class="lm_linkedin"></i></a>
                <a href="http://pinterest.com/pin/create/button/?url={{$encodeUrl}}" target="_blank" data-src=""><i class="lm_pinterest"></i></a>
            </div>


        </div>

    </div>
</div>
@endsection
