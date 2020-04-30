@extends('web.layouts.app')
@section('content')
@php
$imgHolder = 'data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
@endphp
<div class="overlayCatMenu"></div>
@php
    $totalCategories = count($list);
    $categoryListingOutput = array_slice($list, 0, 6, true);
    $afterSkipCategories = array_slice($list, 6, $totalCategories, true);
@endphp
<div class="catSideMenu">
    <div class="Flx topHead">
        <a href="javascript:;" class="logo">
            <picture>
                <img src="<?php echo $imgHolder ?>" data-src="{{ $site_wide_data['logo']['url'] }}" alt="logo">
            </picture>
        </a>
        <div class="close">
            <i class="lm_close" aria-hidden="true"></i>
        </div>
    </div>
    <ul>
	@foreach($categoryListingOutput as $categoryList)
	@php
	$arr = explode('/', $categoryList['slugs']['slug']);
	$categoryNameLink = $arr[1] ;
	@endphp
        <li>
            <a href="{{ config('app.app_path') }}/blog?category={{ $categoryList['slugs']['slug'] }}">
                <picture>
                    @if(!empty($categoryList['icon']))
                        <img src="<?php echo $imgHolder ?>" data-src="{{ $categoryList['icon']['url'] }}" alt="tavel_category" />
                    @else
                        <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/placeholder.png" alt="tavel_category" />
                    @endif
                </picture>
                <p>{{ $categoryList['title'] }}</p>
            </a>
        </li>
	@endforeach
        <li class="moreCat">
            <a href="javascript:;">
                <picture>
                    <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/blog/more.png" alt="more_category" />
                </picture>
                <p>{{ trans('sentence.blog_more_button') }}</p>
            </a>
            <ul class="catSubMenu">
                @foreach($afterSkipCategories as $moreCategories)
				@php
                $arr = explode('/', $moreCategories['slugs']['slug']);
                $categoryNameLink = $arr[1] ;
                @endphp
                    <li><a href="{{ config('app.app_path') }}/blog?category={{ $moreCategories['slugs']['slug'] }}">{{ $moreCategories['title'] }}</a></li>
                @endforeach
            </ul>
        </li>
    </ul>
	@php
    $encodeUrl = urlencode(url()->current());
    $title = "blogs";
    @endphp
    <div class="sclSidePanl">
        <h3>{{ trans('sentence.blog_follow_us_on') }}</h3>
        <a href="//www.facebook.com/sharer.php?u={{$encodeUrl}}" target="_blank" class="soclicn">
            <i class="lm_facebook"></i>
        </a>
        <a href="//twitter.com/share?text=$title&url={{$encodeUrl}}" target="_blank" class="soclicn">
            <i class="lm_twitter"></i>
        </a>
        <a href="//plus.google.com/share?url={{$encodeUrl}}" target="_blank" class="soclicn">
            <i class="lm_google_plus"></i>
        </a>
        <a href="//pinterest.com/pin/create/button/?url={{$encodeUrl}}" target="_blank" class="soclicn">
            <i class="lm_pinterest"></i>
        </a>
        <a href="//www.linkedin.com/shareArticle?mini=true&url={{$encodeUrl}}" target="_blank" class="soclicn">
            <i class="lm_linkedin"></i>
        </a>
    </div>
</div>
<section class="blogWarp" data-bgimage>
    <div class="blgcontainer">

        <div class="catBlogMain">
            <div class="catList">
                @foreach($categoryListingOutput as $categoryList)
				@php
                $arr = explode('/', $categoryList['slugs']['slug']);
                $categoryNameLink = $arr[1] ;
                @endphp
                    <div class="catBlog">
                        <a href="{{ config('app.app_path') }}/blog?category={{ $categoryList['slugs']['slug'] }}">
                            <picture>
                                @if(!empty($categoryList['icon']))
                                    <img src="<?php echo $imgHolder ?>" data-src="{{ $categoryList['icon']['url'] }}" alt="tavel_category" />
                                @else
                                    <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/placeholder.png" alt="tavel_category" />
                                @endif

                            </picture>
                            <p>{{ $categoryList['title'] }}</p>
                        </a>
                    </div>
                @endforeach

            </div>
            <div class="catBlog catMenu">
                <a href="javascript:;">
                    <picture>
                        <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/blog/more.png" alt="more_category" />
                    </picture>
                    <p>{{ trans('sentence.blog_more_button') }}</p>
                </a>
            </div>
        </div>
        <div class="Flx row detailBlgMain">
            <div class="col-large">
			@if(!empty($detail))
                <div class="blgDetail">
                    <div class="Flx row">
                        <div class="col-1 blog-detail-post">
                            <div class="inner">
                                <div class="post-details">
                                    @php
                                    $postTitle = substr($detail['title'], 0, 60);
                                    $postTitleLength = strlen($detail['title']);
                                    @endphp

                                    <div class="post-title">
                                        <h2>{{ $postTitle }} @if($postTitleLength > 60) ... @endif </h2>
                                    </div>

                                    <div class="category-details">
                                        <div class="category-title">
                                            <a href="{{ config('app.app_path') }}/blog?category={{ $detail['categories'][0]['slugs']['slug'] }}" class="catlink" >{{ isset($detail['categories'][0]['title']) ? $detail['categories'][0]['title'] : '' }}</a>

                                            @php
                                                $authorNameLink = $detail['user']['name'];
                                                if($authorNameLink != "Admin") {
                                                    $authorNameLink = strtolower($authorNameLink);
                                                }
                                            @endphp
                                            <a href="{{ config('app.app_path') }}/blog/author/{{ $authorNameLink }}" class="auther">{{ $detail['user']['name'] }}</a>
                                            @php
                                                $temp = explode(' ',$detail['created_at']);
                                                $blogCreateDate = date('d-M-yy', strtotime($temp[0]));
                                            @endphp
                                            <div class="date">{{ $blogCreateDate }}</div>
                                        </div>
                                        <span class="cat-icon">
                                            <img src="{{ isset($detail['categories'][0]['icon']['url']) ? $detail['categories'][0]['icon']['url'] : '' }}" data-src="{{ isset($detail['categories'][0]['icon']['url']) ? $detail['categories'][0]['icon']['url'] : '' }}">
                                        </span>
                                    </div>
                                    <span class="btm-line"></span>
                                </div>
                                <div class="post-image">
                                    <div class="image">
                                        @if(!empty($detail['image']['url']))
                                        <img src="{{ $detail['image']['url'] }}" alt="">
                                        @else
                                        <img src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder760.jpg" alt="">
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			@endif
                <div class="blogTxtCnt">
					{!! html_entity_decode($detail['long_description']) !!}
                </div>

                @if(!empty($detail['tags']))
                <div class="tag-title">
                    @foreach($detail['tags'] as $tag)
                        <a href="javascript:;">{{ $tag['title'] }}</a>
                    @endforeach
                </div>
                @endif

				@php
				$encodeUrl = urlencode(url()->current());
				$title = $detail['title'] ;
				@endphp
                <div class="shareBlogPost">
                    <h6>{{ trans('sentence.blog_share_this_article') }}</h6>
                    <ul>
                        <li>
                            <a href="//www.facebook.com/sharer.php?u={{$encodeUrl}}" class="facebook">
                                <i class="lm_facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="//twitter.com/share?text=$title&url={{$encodeUrl}}" class="twitter">
                                <i class="lm_twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="//pinterest.com/pin/create/button/?url={{$encodeUrl}}" class="pinterest">
                                <i class="lm_pinterest"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="ShareLink">
                        <input id="input_output" class="code" type="text" value="{{ Request::url() }}" readonly="">
                        <a id="copyCodeBtn" href="" class="copyLink"><i class="lm_copy"></i></a>
                    </div>
                </div>


                <div class="autherShtDesc">
                    <picture class="image">
                        @if(!empty($detail['user']['image']['url']))
                        <img src="<?php echo $imgHolder ?>" data-src="{{ $detail['user']['image']['url'] }}" alt="">
                        @else
                        <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/user3.png" alt="">
                        @endif
                    </picture>
					@php
						$authorNameLink = $detail['user']['name'];
						if($authorNameLink != "Admin") {
                            $authorNameLink = strtolower($authorNameLink);
                        }
					@endphp
                    <div class="desc">
                        <a href="{{ config('app.app_path') }}/blog/author/{{ $authorNameLink }}">{{ $detail['user']['name'] }}</a>

                        @if(!empty($detail['user']['short_description']))
                            {!! $detail['user']['short_description'] !!}
                        @endif


                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="trending">
                    <h4>{{ trans('sentence.blog_detail_trending') }}</h4>
                    <div class="trndMain">
					@if(!empty($trendingBlog))
						@php $serialNumber = 0; @endphp
						@foreach($trendingBlog as $trending)

                        @php
                        $postTitle = substr($trending['title'], 0, 60);
                        $postTitleLength = strlen($trending['title']);
                        @endphp

                        <div class="trending-post">
                            <div class="post-image">
                                <span class="count">@php echo $serialNumber+=1; @endphp</span>
                                <a href="{{ config('app.app_path') }}/{{ $trending['slugs']['slug'] }}" class="image">
                                    <img src="{{ $trending['image']['url'] ? $trending['image']['url'] : url('/build/images/blog/imagePlaceHolder760.jpg') }}" data-src="{{ $trending['image']['url'] ? $trending['image']['url'] : url('/build/images/blog/imagePlaceHolder760.jpg') }}" alt="">
                                </a>
                            </div>
                            <a href="{{ config('app.app_path') }}/{{ $trending['slugs']['slug'] }}" class="post-title">{!! $postTitle !!} @if($postTitleLength > 60) ... @endif</a>
                        </div>
						@endforeach
					@endif

                    </div>
                </div>
                <div class="blg_search search_blog_field">
                    <form>
                        <input type="text" class="search_blog" placeholder="{{ trans('sentence.blog_search') }}">
                        <button type="submit"><i class=""></i></button>
                    </form>
                </div>
                <div class="blg_subscribe">
                    <h6>{{ trans('sentence.blog_subscribe_and_follow') }}</h6>
                    <div class="inner">
                        <p>{{ trans('sentence.blog_we_will_make_sure') }}</p>
                        <form class="subBox">
                            <input type="email" data-name="blog" class="subBoxEmail" id="1blog" name="subBoxEmail" required="required" placeholder="{{ trans('sentence.blog_your_email_place_holder') }}">
                            <div id="blog">
                            </div>
                            <button class="submit" data-name="blog" type="button">{{ trans('sentence.blog_subscribe') }}</button>
                        </form>
                        @php
                        $encodeUrl = urlencode(url()->current());
                        $title = "blogs";
                        @endphp

                        <ul>
                            <li><a href="//www.facebook.com/sharer.php?u={{$encodeUrl}}" target="_blank"><i class="lm_facebook"></i></a></li>
                            <li><a href="//twitter.com/share?text=$title&url={{$encodeUrl}}" target="_blank"><i class="lm_twitter"></i></a></li>
                            <li><a href="//plus.google.com/share?url={{$encodeUrl}}" target="_blank"><i class="lm_google_plus"></i></a></li>
                            <li><a href="//www.linkedin.com/shareArticle?mini=true&url={{$encodeUrl}}" target="_blank"><i class="lm_linkedin"></i></a></li>
                            <li><a href="//pinterest.com/pin/create/button/?url={{$encodeUrl}}" target="_blank"><i class="lm_pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="lstShrtBlg">
                    <h3>{{ trans('sentence.blog_the_latest') }}</h3>
                    <div class="Flx row">
					@if(!empty($latestBlog))
						@foreach($latestBlog as $latest)
                        <div class="col-1 standard-post sideblog">
                            <div class="inner">
                                <div class="post-image">
                                    <a href="{{ config('app.app_path') }}/{{ $latest['slugs']['slug'] }}" class="image">
                                        <img src="{{ $latest['image']['url'] }}" data-src="{{ $latest['image']['url'] ? $latest['image']['url'] : url('/build/images/blog/imagePlaceHolder760.jpg') }}" alt="">
                                    </a>
                                </div>
                                <div class="post-details">
                                    <a href="{{ config('app.app_path') }}/{{ $latest['slugs']['slug'] }}">
                                        <div class="category-details">
                                            <span class="cat-icon">
                                                <img src="{{ isset($latest['categories'][0]['icon']['url']) ? $latest['categories'][0]['icon']['url'] : url('/build/images/blog/imagePlaceHolder760.jpg') }}" data-src="{{ isset($latest['categories'][0]['icon']['url']) ? $latest['categories'][0]['icon']['url'] : '' }}">
                                            </span>
                                            <div class="category-title">
                                                <span >{{ isset($latest['categories'][0]['title']) ? $latest['categories'][0]['title'] : '' }}</span>
                                            </div>
                                        </div>
                        @php
                        $postTitle = substr($latest['title'], 0, 68);
                        $postTitleLength = strlen($latest['title']);
                        @endphp
                                        <div class="post-title">
                                            <h2>{{ $postTitle }} @if($postTitleLength > 68) ... @endif</h2>
                                        </div>
                                    </a>
                                    <span class="btm-line"></span>
                                </div>
                            </div>
                        </div>
						@endforeach
					@endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blgcontainer">
        <div class="relBlgCat">
            <h4>{{ trans('sentence.blog_read_more') }}</h4>
            <div class="Flx row">
            @if(!empty($blogWithCategory))
				@foreach($blogWithCategory as $readMoreBlog)
                <div class="col-3 standard-post">
                    <div class="inner">
                        <div class="post-image">
                            <a href="{{ config('app.app_path') }}/{{ $readMoreBlog['slugs']['slug'] }}" class="image">
                                <img src="{{ $readMoreBlog['image']['url'] ? $readMoreBlog['image']['url'] : url('/build/images/blog/imagePlaceHolder760.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="post-details">
                            <a href="{{ config('app.app_path') }}/{{ $readMoreBlog['slugs']['slug'] }}">
                                <div class="category-details">
                                    <span class="cat-icon">
                                        <img src="{{ isset($readMoreBlog['categories'][0]['icon']['url']) ? $readMoreBlog['categories'][0]['icon']['url'] : '' }}" data-src="{{ isset($readMoreBlog['categories'][0]['icon']['url']) ? $readMoreBlog['categories'][0]['icon']['url'] : '' }}">
                                    </span>
                                    <div class="category-title">
                                        <span >{{ isset($readMoreBlog['categories'][0]['title']) ? $readMoreBlog['categories'][0]['title'] : '' }}</span>
                                    </div>
                                </div>
                        @php
                        $postTitle = substr($readMoreBlog['title'], 0, 68);
                        $postTitleLength = strlen($readMoreBlog['title']);
                        @endphp

                                <div class="post-title">
                                    <h2>{{ $postTitle }} @if($postTitleLength > 68) ... @endif</h2>
                                </div>
                            </a>
                            <span class="btm-line"></span>
                        </div>
                    </div>
                </div>
				@endforeach
            @endif
            </div>
        </div>
    </div>

</section>


@endsection
