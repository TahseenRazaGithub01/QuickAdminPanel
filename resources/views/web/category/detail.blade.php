@extends('web.layouts.app')
@section('content')
    <div class="breadcrumb">
        <ul>
            <li>
                <a href="{{config('app.app_path')}}"><i class="lm_home"></i> Home</a>
            </li>
            <li>
                <a href="{{config('app.app_path')}}/category">{{ trans('sentence.category_page_title') }}</a>
            </li>
            <li>
                <a href="{{ config('app.app_path') }}/{{$detail['slug']}}">{{$detail['title']}}</a>
            </li>
        </ul>
    </div>

    <div class="flexWrapper ftRemMar">
        <div class="contntWrpr">
            <div class="rowbar">
                
                <div class="popularStore brandLogo">
                    <div class="flexWrap">
                        @foreach($detail['category_stores'] as $store)
                            <div class="stores">
                                <a href="{{config('app.app_path').'/'.$store['slugs']['slug']}}" class="image" title="{{$store['name']}}">
                                    @if(!empty($store['image']['url']))
                                    <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ isset($store['image']['url']) ? $store['image']['url'] : '' }}" alt="">
                                    @else
                                    <img src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" data-src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" alt="">
                                    @endif
                                </a>
                            </div>
                        @endforeach

                        <div class="buttons">
                            <a href="{{ config('app.app_path') }}/sitemap" class="btn viewStoreBtn">{{ trans('sentence.category_detail_view_all') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="sidCntnt">
            <div class="sidePannel">
                <h4>{{ trans('sentence.category_store_detail_about') }} {{$detail['title']}}</h4>
                <p>{!! $detail['long_description'] !!}</p>

            </div>
            <div class="sidePannel SdePnlCat">
                <h4>{{ trans('sentence.category_detail_related_categories') }}</h4>
                <ul class="sideBarCategories">
                    @foreach($popular as $store)
                        <li><a href="{{config('app.app_path').'/'.$store['slugs']['slug']}}">{{$store['title']}}</a></li>
                    @endforeach
                </ul>
                <div class="buttons">
                    <a href="{{config('app.app_path')}}/category" class="relCatBtn">{{ trans('sentence.category_view_all') }}<span> {{ trans('sentence.category_page_title') }}</span></a>
                </div>
            </div>

        </div>
    </div>
@endsection
