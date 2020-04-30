@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{config('app.app_path')}}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{config('app.app_path')}}/category">{{ trans('sentence.category_page_title') }} </a>
        </li>
    </ul>
</div>
<div class="innerContainer">
    <div class="contentWrpr">

        <h2 class="pageHeading">{{ trans('sentence.category_page_heading') }}</h2>
        
        <div class="rowbar">
            <div class="flexWrap">

                <style>
                    .catlist .icon img{
                        max-width: 100%;
                        object-fit: contain;
                    }
                </style>

            @if(!empty($list))
                @foreach($list as $category)
                    <div class="catlist" title="{{ $category['title']}}">
                        <a href="{{$category['slugs']['slug']}}">
                            <div class="icon">
                            <img src="{{ $category['icon']['url'] }}" data-src="{{ $category['icon']['url'] }}" alt="{{ $category['title']}}" >

                            </div>
                            <p>{{ $category['title']}}</p>
                        </a>
                    </div>
                @endforeach
            @endif


            </div>
        </div>
    </div>
</div>
@endsection
