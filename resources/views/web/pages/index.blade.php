@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{ route('home') }}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{ config('app.app_path') }}/{{ $pageRecord['slugs']['slug'] }}">{{ $pageRecord['title'] }}</a>
        </li>
    </ul>
</div>
<div class="innerContainer">
    <div class="contentWrpr">
        <div class="contentAbout">
            @if(!empty($pageRecord['title']))
                <h1>{{ $pageRecord['title'] }}</h1>
            @endif
            @if(!empty($pageRecord['description']))
                {!! html_entity_decode($pageRecord['description']) !!}
            @endif
        </div>
    </div>
</div>
@endsection