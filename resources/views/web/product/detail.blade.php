@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{ config('app.app_path') }}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{ config('app.app_path') }}/{{ route('product') }}">product</a>
        </li>
        <li>
            <a href="{{ config('app.app_path') }}/{{$categoryProducts['slug']}}">{{ $categoryProducts['name'] }}</a>
        </li>
    </ul>
</div>
<div class="about-section">
    <div class="flexWrapper">
        <h2>{{ $categoryProducts['title_heading'] }}</h2>
        <div class="prdTextDet">
            <p>
                {{ $categoryProducts['description'] }}
            </p>
        </div>
    </div>
</div>
<div class="flexWrapper ftRemMar">
    <div class="contntWrpr">
        @php
        $serialNumber = 0;
        @endphp
        @foreach($categoryProducts['product_category_products'] as $product)
        <div class="main-pro-wrap">
            <div class="pro-wrper">
                <span class="counter">
                    <?php echo $serialNumber +=1; ?></span>
                @if($product['discount_percent'] !='')
                <div class="offDet">
                    <span>{{ $product['discount_percent'] }}</span> OFF
                </div>
                @endif
                <div class="pro-img">
                    <a href="javascript:;"><img src="{{ config('app.image_path') }}/build/images/placeholder.png" data-src="{{ isset($product['media']['url']) ? $product['media']['url'] : config('app.image_path') . '/build/images/placeholder.png' }}" alt=""></a>
                </div>
                <div class="content">
                    <a href="javascript:;" class="title">{{ $product['title'] }}</a>

                        {!! html_entity_decode($product['long_description']) !!}
                    <div data-targetit="box-mreinfo<?php echo $serialNumber; ?>" class="more-info">
                        <a class="box-mreinfo1" href="javascript:;">More Info</a>
                    </div>
                </div>
                <div class="rating">
                    <a href="javascript:;" class="title">{{ $product['title'] }}</a>
                    <div class="rating-count">
                        <span>Our score: {{ $product['rating'] }}</span>
                    </div>
                    <div class="amz-logo">
                        <a href="#"><img src="{{ config('app.image_path') }}/build/images/placeholder.png" data-src="{{ config('app.image_path') }}/./build/images/prime-logo.png" alt=""></a>
                    </div>
                    <div class="link">
                        <a href="{{ $product['affiliate_url'] }}" target="_blank">Buy Now</a>
                    </div>
                    <div class="price">
                        @if($product['discount_price'] !='')
                        <span class="new">${{ $product['discount_price'] }}</span>
                        @endif
                        @if($product['price'] != '')
                        <span class="old">${{ $product['price'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-mreinfo<?php echo $serialNumber; ?> accordian-panel">
                {!! html_entity_decode($product['short_description']) !!}
            </div>
        </div>
        <?php if ($serialNumber % 2 == 0){ ?>
        <div class="storeAddSpace">space for ads Kindly remove heading when its get dynamic.</div>
        <?php } ?>

        @endforeach
        <div class="btn-viewall">
            <a href="javascript:;">view all inversion tables</a>
        </div>
    </div>
    <div class="sidCntnt">
        <div class="sidePannel storeAddSpace">
            space for ads Kindly remove heading when its get dynamic.
        </div>
        <div class="sidePannel">
            <h4>About {{ $categoryProducts['name'] }}</h4>
            <p>{{ $categoryProducts['about_description'] }}</p>
        </div>

    </div>
</div>
<div class="about-section">
    <div class="flexWrapper">
        {!! html_entity_decode($categoryProducts['sub_heading']) !!}
    </div>
</div>
@endsection
