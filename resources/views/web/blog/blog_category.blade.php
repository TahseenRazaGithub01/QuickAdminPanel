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
                @if(!empty($categoryListingOutput))
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
                @endif

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
    </div>

    <div class="blgcontainer">
        <div class="topCatPost">
            <div class="category-heading">
			@if(!empty($blogCategory))
                <div class="category">
                    <span class="icon">
                        <img src="{{ $blogCategory->icon ? $blogCategory->icon->url : '' }}" data-src="{{ $blogCategory->icon ? $blogCategory->icon->url : '' }}">
                    </span>
                    <div class="title">
                        <span >{{ $blogCategory->title }}</span>
                    </div>
                </div>
                <span class="shortDesc">{!! html_entity_decode($blogCategory->short_description) !!}</span>
			@endif
            </div>
            <div class="Flx row">
			@php
                $blogCount = $blogCategory ? count($blogCategory->blogs) : 0;
                if($blogCount!=0){
                $totalCategoryBlogs = $blogCount;
				$threeCategoryBlogListing = array_slice($blogCategory->blogs ? $blogCategory->blogs->toArray() : [], 0, 3, true);
				$afterSkipCategoryBlogListing = array_slice($blogCategory->blogs ? $blogCategory->blogs->toArray() : [], 3, $totalCategoryBlogs, true);
                }

			@endphp
			@if(!empty($threeCategoryBlogListing))
				@foreach($threeCategoryBlogListing as $threeBlogs)
                @php
                $postTitle = substr($threeBlogs['title'], 0, 68);
                $postTitleLength = strlen($threeBlogs['title']);
                @endphp
                <div class="col-3 standard-post">
                    <div class="inner">
                        <div class="post-image">
                            <a href="{{ config('app.app_path') }}/{{ $threeBlogs['slugs']['slug'] }}" class="image">
                                <img src="{{ $threeBlogs['image']['url'] }}" alt="">
                            </a>
                        </div>
                        <div class="post-details">
                            <a href="{{ config('app.app_path') }}/{{ $threeBlogs['slugs']['slug'] }}">
                                <div class="category-details">
                                    <div class="category-tags">
                                        @if(!empty($threeBlogs['tags']))
                                            <span>{{ $threeBlogs['tags']['title'] }}</span>
                                        @endif
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
				@endforeach
			@endif
            </div>
        </div>
    </div>
    <!-- BUDGET Individual Categories blog ends here -->
    <!-- sha -->
    <div class="blgcontainer">
        <div class="Flx row mainCatBlg">
            <div class="col-large">
                <div class="relatedBlog">
                    <div class="Flx row">

					@if(!empty($afterSkipCategoryBlogListing))
						@php $count = 0; @endphp
						@foreach($afterSkipCategoryBlogListing as $allCategoryBlogListing)

                        @php
                        $postTitle = substr($allCategoryBlogListing['title'], 0, 68);
                        $postTitleLength = strlen($allCategoryBlogListing['title']);
                        @endphp
                        <div class="col-1 standard-post horizontal" >
                            <div class="inner">
                                <div class="post-image">
                                    <a href="{{ config('app.app_path') }}/{{ $allCategoryBlogListing['slugs']['slug'] }}" class="image">
                                        @if(!empty($allCategoryBlogListing['image']['url']))
                                        <img src="{{ $allCategoryBlogListing['image']['url'] }}" alt="">
                                        @else
                                        <img src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" alt="">
                                        @endif
                                    </a>
                                </div>
                                <div class="post-details">
                                    <a href="{{ config('app.app_path') }}/{{ $allCategoryBlogListing['slugs']['slug'] }}">
                                        <div class="category-details">
                                            <div class="category-tags">
                                                @if(!empty($allCategoryBlogListing['tags']))
                                                    <span>{{ $allCategoryBlogListing['tags']['title'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="post-title">
                                            <h2>{{ $postTitle }} @if($postTitleLength > 68) ... @endif</h2>
                                        </div>
                                    </a>
                                </div>
                                <span class="btm-line"></span>
                            </div>
                        </div>
						@php
							$last_id = $allCategoryBlogListing['id'];
							$count++;
						@endphp
						@if($count == 3)
                            @php break; @endphp
                        @endif

						@endforeach
					@endif
                    </div>
					{{ csrf_field() }}
					<div id="post_data"></div>
					@if(!empty($afterSkipCategoryBlogListing))
					<div id="load_more">
						<button type="button" id="load_more_button" blog-category-id="{{ $blogCategory->id }}" data-id="{{ $last_id }}" class="blgLoadMore">{{ trans('sentence.blog_load_more_button') }}</button>
					</div>
					@endif
                </div>
            </div>
            <div class="col-3">
                <div class="blg_search search_blog_field">
                    <form>
                        <input type="text" class="search_blog" placeholder="Search">
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
            </div>
        </div>

    </div>

</section>
@endsection
