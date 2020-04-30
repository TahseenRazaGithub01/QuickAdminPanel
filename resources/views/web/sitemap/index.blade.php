@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="/"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="/sitemap">Site Map</a>
        </li>
    </ul>
</div>
<div class="innerContainer">
    <div class="contentWrpr">
        <h1 class="pageTitle">Browse Coupons by Store</h1>
        <div class="popularStore">
            <h3>Popular Stores</h3>
            <div class="rowbar">
                <div class="flexWrap">
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="/build/images/placeholder.png" data-src="/build/images/verizon.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="/build/images/placeholder.png" data-src="/build/images/expedia.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="/build/images/placeholder.png" data-src="/build/images/aeropostale.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="/build/images/placeholder.png" data-src="/build/images/oldnavy.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/build.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/tvinternet.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/shindigz.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/verizon.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/expedia.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/aeropostale.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/oldnavy.jpg" alt="">
                        </a>
                    </div>
                    <div class="stores">
                        <a href="javascript:;" class="image">
                            <img src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{config('app.image_path')}}/build/images/build.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="allStore">
            <h3>All Stores</h3>

            <div class="alphabtLsting">
                <ul>
                    <li>
                        <a href="javascript:;">0-9</a>
                    </li>
                    <li class="active">
                        <a href="javascript:;">A</a>
                    </li>
                    <li>
                        <a href="javascript:;">B</a>
                    </li>
                    <li>
                        <a href="javascript:;">C</a>
                    </li>
                    <li>
                        <a href="javascript:;">D</a>
                    </li>
                    <li>
                        <a href="javascript:;">E</a>
                    </li>
                    <li>
                        <a href="javascript:;">F</a>
                    </li>
                    <li>
                        <a href="javascript:;">G</a>
                    </li>
                    <li>
                        <a href="javascript:;">H</a>
                    </li>
                    <li>
                        <a href="javascript:;">I</a>
                    </li>
                    <li>
                        <a href="javascript:;">J</a>
                    </li>
                    <li>
                        <a href="javascript:;">K</a>
                    </li>
                    <li>
                        <a href="javascript:;">L</a>
                    </li>
                    <li>
                        <a href="javascript:;">M</a>
                    </li>
                    <li>
                        <a href="javascript:;">N</a>
                    </li>
                    <li>
                        <a href="javascript:;">O</a>
                    </li>
                    <li>
                        <a href="javascript:;">P</a>
                    </li>
                    <li>
                        <a href="javascript:;">Q</a>
                    </li>
                    <li>
                        <a href="javascript:;">R</a>
                    </li>
                    <li>
                        <a href="javascript:;">S</a>
                    </li>
                    <li>
                        <a href="javascript:;">T</a>
                    </li>
                    <li>
                        <a href="javascript:;">U</a>
                    </li>
                    <li>
                        <a href="javascript:;">V</a>
                    </li>
                    <li>
                        <a href="javascript:;">W</a>
                    </li>
                    <li>
                        <a href="javascript:;">X</a>
                    </li>
                    <li>
                        <a href="javascript:;">Y</a>
                    </li>
                    <li>
                        <a href="javascript:;">Z</a>
                    </li>
                </ul>
            </div>

            <ul class="storeResult">
                <li><a href="javascript:;">A Beka Book</a></li>
                <li><a href="javascript:;">A Main Hobbies</a></li>
                <li><a href="javascript:;">A Pea in the Pod</a></li>
                <li><a href="javascript:;">A'GACI</a></li>
                <li><a href="javascript:;">A1Supplements.com</a></li>
                <li><a href="javascript:;">A2 Hosting</a></li>
                <li><a href="javascript:;">AAA</a></li>
                <li><a href="javascript:;">AAFES</a></li>
                <li><a href="javascript:;">Aaron Brothers</a></li>
                <li><a href="javascript:;">AARP</a></li>
                <li><a href="javascript:;">AARP Driver Safety Online Course</a></li>
                <li><a href="javascript:;">Abbott Nutrition</a></li>
                <li><a href="javascript:;">ABCmouse.com Early Learning Academy</a></li>
                <li><a href="javascript:;">AbeBooks</a></li>
                <li><a href="javascript:;">Abercrombie</a></li>
                <li><a href="javascript:;">Abercrombie Kids</a></li>
                <li><a href="javascript:;">About Airport Parking</a></li>
                <li><a href="javascript:;">Absinthe Vegas</a></li>
                <li><a href="javascript:;">Abt</a></li>
                <li><a href="javascript:;">AC Lens</a></li>
                <li><a href="javascript:;">AC Moore</a></li>
                <li><a href="javascript:;">AC Wholesalers</a></li>
                <li><a href="javascript:;">Academy Sports + Outdoors</a></li>
                <li><a href="javascript:;">Accessories4less</a></li>
                <li><a href="javascript:;">Accor Hotels</a></li>
                <li><a href="javascript:;">ACE Cash Express</a></li>
                <li><a href="javascript:;">Ace Hardware</a></li>
                <li><a href="javascript:;">Ace Hotel</a></li>
                <li><a href="javascript:;">Ace Rent a Car</a></li>
                <li><a href="javascript:;">Acer</a></li>
                <li><a href="javascript:;">ACK</a></li>
                <li><a href="javascript:;">acme tools</a></li>
                <li><a href="javascript:;">Acorn Online</a></li>
                <li><a href="javascript:;">A Beka Book</a></li>
                <li><a href="javascript:;">A Main Hobbies</a></li>
                <li><a href="javascript:;">A Pea in the Pod</a></li>
                <li><a href="javascript:;">A'GACI</a></li>
                <li><a href="javascript:;">A1Supplements.com</a></li>
                <li><a href="javascript:;">A2 Hosting</a></li>
                <li><a href="javascript:;">AAA</a></li>
                <li><a href="javascript:;">AAFES</a></li>
                <li><a href="javascript:;">Aaron Brothers</a></li>
                <li><a href="javascript:;">AARP</a></li>
                <li><a href="javascript:;">AARP Driver Safety Online Course</a></li>
                <li><a href="javascript:;">Abbott Nutrition</a></li>
                <li><a href="javascript:;">ABCmouse.com Early Learning Academy</a></li>
                <li><a href="javascript:;">AbeBooks</a></li>
                <li><a href="javascript:;">Abercrombie</a></li>
                <li><a href="javascript:;">Abercrombie Kids</a></li>
                <li><a href="javascript:;">About Airport Parking</a></li>
                <li><a href="javascript:;">Absinthe Vegas</a></li>
                <li><a href="javascript:;">Abt</a></li>
                <li><a href="javascript:;">AC Lens</a></li>
                <li><a href="javascript:;">AC Moore</a></li>
                <li><a href="javascript:;">AC Wholesalers</a></li>
                <li><a href="javascript:;">Academy Sports + Outdoors</a></li>
                <li><a href="javascript:;">Accessories4less</a></li>
                <li><a href="javascript:;">Accor Hotels</a></li>
                <li><a href="javascript:;">ACE Cash Express</a></li>
                <li><a href="javascript:;">Ace Hardware</a></li>
                <li><a href="javascript:;">Ace Hotel</a></li>
                <li><a href="javascript:;">Ace Rent a Car</a></li>
                <li><a href="javascript:;">Acer</a></li>
                <li><a href="javascript:;">ACK</a></li>
                <li><a href="javascript:;">acme tools</a></li>
                <li><a href="#_">Acorn Online</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
