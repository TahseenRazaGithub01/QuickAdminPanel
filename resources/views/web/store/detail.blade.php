@extends('web.layouts.app')
@section('content')
@inject('store', 'App\Store')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{ config('app.app_path') }}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{config('app.app_path')}}/category">{{ trans('sentence.category_page_title') }}</a>
        </li>
        <li>
            <a href="{{ config('app.app_path') }}/{{$detail['slug']}}">{{$detail['name']}}</a>
        </li>

    </ul>
</div>
<div class="flexWrapper strCpnDeal">
    <div class="contntWrpr">
        <div class="cupnsTextAlgment">
            <h3 class="pageTitle">{{ isset($detail['name']) ? $detail['name'] : '' }}</h3>
            <div class="cupnsFilter">
                @if($store->couponLastUpdatedDate($detail['id']) != null)
                    @php
                        $updatedDate = $store->couponLastUpdatedDate($detail['id']);
                        $date = date('M-j-Y', strtotime($updatedDate->toDateString() ));
                    @endphp
                    <p>{{ trans('sentence.category_store_last_updated_text') }} {{ $date }}</p>
                @endif
                <ul>
                    <li data-target="productBox" class="active"><a href="javascript:;">{{ trans('sentence.category_store_all') }} <span>({{ $store->countAllCoupons($detail['id'], config('app.siteid'))  }})</span></a></li>
                    <li data-target="only-codes"><a href="javascript:;">{{ trans('sentence.category_store_detail_codes') }} <span>({{ $store->countCoupons($detail['id'], config('app.siteid'))  }})</span></a></li>
                    <li data-target="only-deals"><a href="javascript:;">{{ trans('sentence.category_store_detail_deals') }} <span>({{ $store->countCouponDeals($detail['id'], config('app.siteid'))  }})</span></a></li>
                </ul>
            </div>
            <div class="rowbar">
                <div class="flexWrap cupnsAdjust">
                    @php
                    $currentURL = URL::current();
                    @endphp
                    @if(!empty($detail['store_coupons']))
                        @foreach($detail['store_coupons'] as $coupon)
                            @if($coupon['code']!='')
                            <div class="only-codes productBox fullPrdoduct">
                                <div class="coupons">
                                    @if($coupon['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                                    @if(!empty($coupon['custom_image_title']))
                            <div class="cupnsOffrs">
                                <div class="logoAnchor">
                                    <span class="percent">{!! $coupon['custom_image_title'] !!}</span>
                                </div>
                            </div>
                                    @else       
                                    <figure>
                                        <a href="javascript:;" class="logoAnchor">    
                                  <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ ($coupon['image']) ? $coupon['image']['url'] : ( ( $detail['image'] ) ? $detail['image']['url'] : '') }}" alt="" class="couponImage">
                
                                        </a>
                                    </figure>
                                    @endif
                                    <div class="cpnDtlSec">
                                        <div class="textWrpr">

                                            <div class="title">
                                                <h4 class="offerTitle">{!! html_entity_decode($coupon['title']) !!}{{
                                                    ($coupon['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' 
                                                    }}</h4>
                                                <p class="offerDesr">{!! html_entity_decode($coupon['description']) !!}</p>
                                            </div>
                                            <div class="expiry">
                                                    <div class="views">
                                                        <i class="lm_user"></i><span>{{ $coupon['viewed'] }} {{ trans('sentence.category_store_detail_views') }}</span>
                                                    </div>
                                                    @if($coupon['verified']==1)
                                                    <div class="verify">
                                                        <i class="lm_check_square"></i><span>{{ trans('sentence.category_store_detail_verified') }}</span>
                                                    </div>
                                                    @endif
                                                     @php
                                                        if (date("Y", strtotime($coupon['date_expiry'])) >= '2090') {
                                                            $expiry = 'On Going';
                                                        } else {
                                                            $expiry = date("M-j-Y", strtotime($coupon['date_expiry']));
                                                        }
                                                    @endphp
                                                    <div class="date">
                                                        <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiry }}</span>
                                                    </div>
                                                </div>


                                            
                                        </div>
                                        <div class="buttonsWrapper">
                                            <div class="codeButton openOverlay" data-name="copycode">
                                                <a class="baseurlappend visibleButton" onclick="dataLayer.push({'Action': '{{ isset($currentURL) ? $currentURL : 'View Coupon' }}','JobID':'{{ isset($coupon['title']) ? $coupon['title'] : '' }}', 'event':'addtofavorite',});" data-id="{{ $coupon['id'] }}" data-store="{{ $coupon['affiliate_url'] }}" data-marchant="{{ $coupon['affiliate_url'] }}" data-var="copy">
                                                <span class="buttonSpan"> {{ trans('sentence.category_store_detail_get_codes') }} </span>
                                                </a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <i class="lm_right vsbanchr"></i>
                                    <a class="cids responsiveLink" data-id="{{ $coupon['id'] }}" data-store="{{ $coupon['affiliate_url'] }}"></a>
                                </div>
                            </div>
                            @else
                            <div class="only-deals productBox fullPrdoduct">
                                <div class="coupons">
                                    @if($coupon['exclusive']==1)
                                     <span class="ribbon">Exclusive</span>
                                    @endif
                            @if(!empty($coupon['custom_image_title']))
                            <div class="cupnsOffrs">
                                <div class="logoAnchor">
                                    <span class="percent">{!! $coupon['custom_image_title'] !!}</span>
                                </div>
                            </div>
                                    @else
                                    <figure>
                                        <a href="javascript:;" class="logoAnchor">
                                          <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ ($coupon['image']) ? $coupon['image']['url'] : ( ( $detail['image'] ) ? $detail['image']['url'] : '') }}" alt="" class="couponImage">
                                        </a>
                                    </figure>
                                    @endif
                                    <div class="cpnDtlSec">
                                        <div class="textWrpr">
              
                                            <div class="title">
                                                <h4 class="offerTitle">{!! html_entity_decode($coupon['title']) !!}{{
                                                    ($coupon['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' 
                                                    }}</h4>
                                                <p class="offerDesr">{!! html_entity_decode($coupon['description']) !!}</p>
                                            </div>
                                            <div class="expiry">
                                                <div class="views">
                                                    <i class="lm_user"></i><span>{{ $coupon['viewed'] }} {{ trans('sentence.category_store_detail_views') }}</span>
                                                </div>
                                                @if($coupon['verified']==1)
                                                <div class="verify">
                                                    <i class="lm_check_square"></i><span>{{ trans('sentence.category_store_detail_verified') }}</span>
                                                </div>
                                                @endif
                                                @php
                                                if (date("Y", strtotime($coupon['date_expiry'])) >= '2090')
                                                {
                                                        $expiryDate = 'On Going';
                                                } else {
                                                    $expiryDate = date("M-j-Y", strtotime($coupon['date_expiry']));
                                                }
                                                @endphp
                                                <div class="date">
                                                    <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>
                                                </div>
                                            </div>


                                            
                                        </div>
                                        <div class="buttonsWrapper">
                                            <div class="codeButton openOverlay" data-name="copycode">
                                                <a class="baseurlappend DealButton" onclick="dataLayer.push({'Action': '{{ isset($currentURL) ? $currentURL : 'View Deal' }}','JobID':'{{ isset($coupon['title']) ? $coupon['title'] : '' }}', 'event':'addtofavorite',});" data-id="{{ $coupon['id'] }}" data-store="{{ $coupon['affiliate_url'] }}" data-marchant="{{ $coupon['affiliate_url'] }}" data-var="deal">
                                                <span class="buttonSpan"> {{ trans('sentence.category_store_detail_get_deals') }}</span>
                                                </a>

                                            </div>
                                        </div>

                                    </div>
                                    <i class="lm_right vsbanchr"></i>
                                    <a class="cids responsiveLink" data-id="{{ $coupon['id'] }}" data-store="{{ $coupon['affiliate_url'] }}"></a>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                 <div class="moreabt">
                        <h3 class="heading">{{ trans('sentence.category_store_detail_more_about') }} {{$detail['name']}}</h3>
                        {!!html_entity_decode($detail['long_description'])!!}
                        {!!html_entity_decode($detail['faq'])!!}
                    </div>
            </div>
        </div>

    </div>
    <div class="sidCntnt">
        <div class="sidePannel brandRating">
            <div class="Logo">
                <img class="lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($detail['image']['url']) ? $detail['image']['url'] : '' }}" alt="">
            </div>
            <div class="rate">
                <input type="radio" id="georgina1" name="georgina" value="1">
                <label class="full " for="georgina1" onclick="storeRating('1' ,'8778','117.20.29.50')" ></label>
                <input type="radio" id="georgina2" name="georgina" value="2">
                <label class="full " for="georgina2" onclick="storeRating('2' ,'8778','117.20.29.50')" ></label>
                <input type="radio" id="georgina3" name="georgina" value="3">
                <label class="full " for="georgina3" onclick="storeRating('3' ,'8778','117.20.29.50')" ></label>
                <input type="radio" id="georgina4" name="georgina" value="4">
                <label class="full  RateActive " for="georgina4" onclick="storeRating('4' ,'8778','117.20.29.50')"></label>
                <input type="radio" id="georgina5" name="georgina" value="5">
                <label class="full " for="georgina5" onclick="storeRating('5' ,'8778','117.20.29.50')"></label>
            </div>

            <p>{{ trans('sentence.category_store_detail_rating_text') }}</p>
        </div>
        <div class="sidePannel couponAddSpace">

        </div>
        <div class="sidePannel">
            <h4>{{ trans('sentence.category_store_detail_about') }} {{$detail['name']}}</h4>

            <p>{!!html_entity_decode($detail['short_description'])!!}</p>
        </div>
        <div class="sidePannel SdePnlCat">
            <h4>{{ trans('sentence.category_detail_related_stores') }}</h4>
            
            <ul class="sideBarCategories">
            @if(!empty($popular))
                @foreach($popular as $store)
                    <li><a href="{{config('app.app_path')}}/{{ isset($store['slugs']['slug']) ? $store['slugs']['slug'] : '' }}">{{$store['name']}}</a></li>
                @endforeach
            @endif
            </ul>

            <div class="buttons">

                <a href="{{ config('app.app_path') }}/sitemap" class="relCatBtn">{{ trans('sentence.category_detail_show_more') }}</a>

            </div>

        </div>
        <div class="sidePannel SdePnlCat">
            <h4>{{ trans('sentence.category_detail_related_categories_heading') }}</h4>
            <ul class="sideBarCategories">
                @if(!empty($detail['categories']))
                    @foreach($detail['categories'] as $category)
                    <li><a href="{{ isset($category['slug']) ? $category['slug'] : '' }}">{{ isset($category['title']) ? $category['title'] : '' }}</a></li>
                    @endforeach
                @endif
            </ul>
            <div class="buttons">

                <a href="{{config('app.app_path')}}/category" class="relCatBtn">{{ trans('sentence.category_detail_show_more') }}</a>

            </div>

        </div>
        <div class="sidePannel socialPnl">
            <h4>{{ trans('sentence.category_detail_share_these_offers') }}</h4>
            @php
            $encodeUrl = urlencode(url()->current());
            $title = $detail['name'];
            @endphp
            <div class="social">
                <a href="//www.facebook.com/sharer.php?u={{ isset($encodeUrl) ? $encodeUrl : '' }}" target="_blank"><i class="lm_facebook"></i></a>
                <a href="//twitter.com/share?text={{ isset($title) ? $title : '' }}&url={{ isset($encodeUrl) ? $encodeUrl : '' }}" target="_blank"><i class="lm_twitter"></i></a>
                <a href="//pinterest.com/pin/create/button/?url={{ isset($encodeUrl) ? $encodeUrl : '' }}&media={{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($detail['image']['url']) ? $detail['image']['url'] : '' }}" target="_blank"><i class="lm_pinterest"></i></a>
                <a href="//www.linkedin.com/shareArticle?mini=true&url={{ isset($encodeUrl) ? $encodeUrl : ''  }}" target="_blank"><i class="lm_linkedin"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection