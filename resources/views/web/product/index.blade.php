@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{ route('home') }}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{ route('product') }}">Product Listing</a>
        </li>
    </ul>
</div>
<div class="flexWrapper ftRemMar">
    <div class="contntWrpr">
        <!-- brandLogo class use for brand logo page styling -->
        <div class="popularProducts">
            <div class="flexWrap rowbar">
                @foreach($detail as $categoryListing)
                <div class="productlisting">
                    <a href="{{ config('app.app_path') }}/{{ $categoryListing['slugs']['slug'] }}">
                        <div class="icon">
                            @if($categoryListing['image'] != NULL)
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{$categoryListing['image']['url']}}" alt="">
                            @else
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="" alt="">
                            @endif
                        </div>
                        <p>{{ $categoryListing['name'] }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection