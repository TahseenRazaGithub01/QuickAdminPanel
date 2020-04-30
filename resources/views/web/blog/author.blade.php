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
                <p>more</p>
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
        <h3>FOLLOW US ON</h3>
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
        <!-- blog top category starts here -->
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
                    <p>more</p>
                </a>
            </div>
        </div>

		<!-- blog Author deatial goes here -->
        <div class="authorDet">
            <picture class="image">
                @if(!empty($blogListing[0]['user']['image']['url']))
                <img src="{{ $blogListing[0]['user']['image']['url'] }}" data-src="{{ $blogListing[0]['user']['image']['url'] }}" alt="">
                @else
                <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/user3.png" alt="">
                @endif
            </picture>
            <div class="desc">
				@if(!empty($blogListing[0]['user']['name']))
					<h1>{{ $blogListing[0]['user']['name'] }}</h1>
				@else
					<h1>taylor otwell</h1>
				@endif

                @if(!empty($blogListing[0]['user']['short_description']))
                    {!! $blogListing[0]['user']['short_description'] !!}
                @endif
            </div>
        </div>

    </div>

	<!-- START BLOG AUTHOR SECTION -->
	<div class="blgcontainer">
        <div class="authorPosts">
		{{ csrf_field() }}
            <div id="post_data" class="Flx row">
			@if(!empty($blogListing))
				@foreach($blogListing as $key=>$blog)
                <?php
                $postTitle = substr($blog['title'], 0, 68);
                $postTitleLength = strlen($blog['title']);
                ?>

                <div class="col-3 standard-post">
                    <div class="inner">
                        <div class="post-image">
                            <a href="{{ config('app.app_path') }}/{{ $blog['slugs']['slug'] }}" class="image">
                                @if(!empty($blog['image']['url']))
                                <img src="{{ $blog['image']['url'] }}" alt="">
                                @else
                                <img src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" alt="">
                                @endif
                            </a>
                        </div>
                        <div class="post-details">
                            <a href="{{ config('app.app_path') }}/{{ $blog['slugs']['slug'] }}">
                                <div class="category-details">
                                    <span class="cat-icon">
                                        <img src="{{ $blog['categories'][0]['icon']['url'] }}" data-src="{{ $blog['categories'][0]['icon']['url'] }}">
                                    </span>
                                    <div class="category-title">
                                        <span>{{ $blog['categories'][0]['title'] }}</span>
                                    </div>
                                </div>
                                <div class="post-title">
                                    <h2>{{ $postTitle }} @if($postTitleLength > 68) ... @endif</h2>
                                </div>
                            </a>
                            <span class="btm-line"></span>
                        </div>
                    </div>
                </div>
				 <?php
					$last_id = $blog['id'];
                    $author_id = $blog['user_id'];
                if($key == 2){
                  break;
                }
				?>
				@endforeach
			@endif

            </div>
            
@if(count($blogListing) > 3)
			<div id="load_more">
				<button type="button" id="blog_load_more_button" blog-author-id="{{$author_id}}" data-id="{{ $last_id }}" class="blgLoadMore">LOAD MORE</button>
			</div>
@endif

        </div>
    </div>
	<!-- END BLOG AUTHOR SECTION -->

</section>
@endsection
