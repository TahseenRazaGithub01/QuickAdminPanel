@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{config('app.app_path')}}/"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{config('app.app_path')}}/sitemap">{{ trans('sentence.sitemap_page_name') }}</a>
        </li>
    </ul>
</div>
<div class="innerContainer">
    <div class="contentWrpr">
        <h1 class="pageTitle">{{ trans('sentence.sitemap_browse_coupons_by_store') }}</h1>
        <div class="popularStore">
            <h3>{{ trans('sentence.sitemap_popular_stores') }}</h3>
            <div class="rowbar">
                <div class="flexWrap">
                    @if(!empty($popular))
                        @foreach($popular as $store)
                        <div class="stores">
                            <a href="{{ config('app.app_path') }}/{{$store['slugs']['slug']}}" class="image">
                                <img src="{{config('app.app_image')}}/build/images/placeholder.png" data-src="{{$store['image']['url']}}" alt="">
                            </a>
                        </div>
                       @endforeach
                   @endif
                </div>
            </div>
        </div>
        <div class="allStore">
            <h3>{{ trans('sentence.sitemap_view_all_stores') }}</h3>

            <div class="alphabtLsting">
                <ul>
                    <li @if(!isset($_GET["q"])) class="active" @endif>
                        <a class="sortalpha" data-target2="/sitemap" >{{ trans('sentence.sitemap_search_all') }}</a>
                    </li>
                    <li @if(isset($_GET["q"]) && $_GET["q"] == '0-9') class="active" @endif>
                        <a class="sortalpha" data-target2="/sitemap?q=0-9" >{{ trans('sentence.sitemap_numeric_key') }}</a>
                    </li>
                    <?php $c=0; ?>
                    @for($lp='a';$lp <= 'z';$lp++)
                    @if($c == 26)<?php break;?>@else<?php $c++;?>@endif
                    <li @if(isset($_GET["q"]) && $_GET["q"] == $lp) class="active" @endif>
                        <a class="sortalpha" data-target2="/sitemap?q={{ $lp }}">{{ trans('sentence.sitemap_search_by_'.$lp) }}</a>
                    </li>
                    @endfor
                </ul>
            </div>

            <ul class="storeResult">
                @if(COUNT($list) > 0)
                    @foreach($list as $store)
                        <li><a href="{{ $store['slug'] }}">{{$store['name']}}</a></li>
                    @endforeach
                @else
                    <li>
                        No Record Found
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
