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
            @if(!empty($categoryListingOutput))
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
            @endif

            <li class="moreCat">
                <a href="javascript:;">
                    <picture>
                        <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/blog/more.png" alt="more_category" />
                    </picture>
                    <p>{{ trans('sentence.blog_more_button') }}</p>
                </a>
                <ul class="catSubMenu">
                    @if(!empty($afterSkipCategories))
                        @foreach($afterSkipCategories as $moreCategories)
                            @php
                                $arr = explode('/', $moreCategories['slugs']['slug']);
                                $categoryNameLink = $arr[1] ;
                            @endphp
                            <li><a href="{{ config('app.app_path') }}/blog?category={{ $moreCategories['slugs']['slug'] }}">{{ $moreCategories['title'] }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
        @php
            $encodeUrl = urlencode(url()->current());
        @endphp
        <div class="sclSidePanl">
            <h3>{{ trans('sentence.blog_follow_us_on') }}</h3>
            <a href="//www.facebook.com/sharer.php?u={{$encodeUrl}}" target="_blank" class="soclicn">
                <i class="lm_facebook"></i>
            </a>
            <a href="//twitter.com/share?text=blogs&url={{$encodeUrl}}" target="_blank" class="soclicn">
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
                                            <img src="<?php echo $imgHolder ?>" data-src="{{ $categoryList['icon']['url'] }}" alt="{{ $categoryList['title'] }}" />
                                        @else
                                            <img src="<?php echo $imgHolder ?>" data-src="{{config('app.image_path')}}/build/images/placeholder.png" alt="{{ $categoryList['title'] }}" />
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

            

            <div class="Flx row mainBlogCnt">
                <div class="col-large">
                    <div class="topPost">
                        <div class="Flx row">
                            <div class="col-1 standard-post full-post">
                                <div class="inner">
                                @if(!empty($blogWithCategory[0]['image']['url']))
                                <div class="post-image">
                                    <a href="{{config('app.app_path')}}/{{ $blogWithCategory[0]['slugs']['slug'] }}" class="image">
                                        <img src="{{ $blogWithCategory[0]['image'] ? $blogWithCategory[0]['image']['url'] : '' }}" data-src="{{ $blogWithCategory[0]['image'] ? $blogWithCategory[0]['image']['url'] : ''}}" alt="">
                                    </a>
                                </div>
                                @endif
                                    @if(!empty($blogWithCategory))
                                        <div class="post-details">
                                            <a href="{{config('app.app_path')}}/{{ $blogWithCategory[0]['slugs']['slug'] }}">
                                            <div class="category-details">
                                                <span class="cat-icon">
                                                    @if(!empty($blogWithCategory[0]['categories'][0]['icon']['url']))
                                                    <img src="{{ $blogWithCategory[0]['categories'][0]['icon']['url'] }}" data-src="{{ $blogWithCategory[0]['categories'][0]['icon']['url'] }}" alt="">
                                                    @endif
                                                </span>
                                                    <div class="category-title">
                                                        <span>{{ $blogWithCategory[0]['categories'][0]['title'] }}</span>
                                                    </div>
                                            </div>
                                    

                                                @php
                                                $postTitle = substr($blogWithCategory[0]['title'], 0, 60);
                                                $postTitleLength = strlen($blogWithCategory[0]['title']);
                                                @endphp


                                                <div class="post-title">
                                                    <h2>{{ $postTitle }} @if($postTitleLength > 60) ... @endif </h2>
                                                </div>
                                            </a>
                                            <span class="btm-line"></span>
                                        </div>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="latestPost">
                        <h3>The Latest</h3>
                        <div class="Flx row">
                            @if(!empty($latestBlog))
                                @foreach($latestBlog as $latest)

                                    @php
                                        $postTitle = substr($latest['title'], 0, 60);
                                        $postTitleLength = strlen($latest['title']);
                                    @endphp

                                    <div class="col-2 standard-post">
                                        <div class="inner">
                                            <div class="post-image">
                                                <a href="{{ config('app.app_path') }}/{{ $latest['slugs']['slug'] }}" class="image">
                                                    @if(!empty($latest['image']['url']))
                                                        <img src="{{ $latest['image']['url'] }}" data-src="{{ $latest['image']['url'] }}" alt="">
                                                    @else
                                                        <img src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" alt="">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="post-details">
                                                <a href="{{ config('app.app_path') }}/{{ $latest['slugs']['slug'] }}">
                                                    <div class="category-details">
                                                <span class="cat-icon">
                                                    <img src="{{ isset($latest['categories'][0]['icon']['url']) ? $latest['categories'][0]['icon']['url'] : '' }}" data-src="{{ isset($latest['categories'][0]['icon']['url']) ? $latest['categories'][0]['icon']['url'] : '' }}" alt="">
                                                </span>
                                                        <div class="category-title">
                                                            <span>{{ isset($latest['categories'][0]['title']) ? $latest['categories'][0]['title'] : '' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="post-title">
                                                        <h2>{{ $postTitle }} @if($postTitleLength > 60) ... @endif</h2>
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
                <div class="col-3">
                    <div class="trending">
                        <h4>{{ trans('sentence.blog_trending') }}</h4>
                        <div class="trndMain">
                            @php $serialNumber = 0; @endphp
                            @if(!empty($trendingBlog))
                                @foreach($trendingBlog as $trending)

                                    @php
                                        $postTitle = substr($trending['title'], 0, 60);
                                        $postTitleLength = strlen($trending['title']);
                                    @endphp

                                    <div class="trending-post">
                                        <div class="post-image">
                                            <span class="count">@php echo $serialNumber+=1; @endphp</span>
                                            <a href="{{ config('app.app_path') }}/{{ $trending['slugs']['slug'] }}" class="image">
                                                @if(!empty($trending['image']['url']))
                                                    <img src="{{ $trending['image']['url'] }}" data-src="{{ $trending['image']['url'] }}" alt="">
                                                @else
                                                    <img src="{{config('app.image_path')}}/build/images/blog/imagePlaceHolder336.png" alt="">
                                                @endif
                                            </a>
                                        </div>
                                        <a href="{{ config('app.app_path') }}/{{ $trending['slugs']['slug'] }}" class="post-title">{{ $postTitle }} @if($postTitleLength > 60) ... @endif</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="blg_search search_blog_field">
                        <form>
                            <input type="text" class="search_blog" placeholder="Search">
                            <!--<button type="submit"><i class=""></i></button>-->
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
                            @endphp

                            <ul>
                                <li><a href="http://www.facebook.com/sharer.php?u={{$encodeUrl}}" target="_blank"><i class="lm_facebook"></i></a></li>
                                <li><a href="//twitter.com/share?text=blogs&url={{$encodeUrl}}" target="_blank"><i class="lm_twitter"></i></a></li>
                                <li><a href="https://plus.google.com/share?url={{$encodeUrl}}" target="_blank"><i class="lm_google_plus"></i></a></li>
                                <li><a href="http://www.linkedin.com/shareArticle?mini=true&url={{$encodeUrl}}" target="_blank"><i class="lm_linkedin"></i></a></li>
                                <li><a href="http://pinterest.com/pin/create/button/?url={{$encodeUrl}}" target="_blank"><i class="lm_pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="blgcontainer">
            <div class="indiCategories">
                @foreach($list as $blogCategoryList)
                    @if(!empty($blogCategoryList['blogs']))
                        <div class="category-heading">
                            <div class="category">
                    <span class="icon">
                        <img src="{{ $blogCategoryList['icon']['url'] }}" data-src="{{ $blogCategoryList['icon']['url'] }}" alt="">
                    </span>
                                <div class="title">
                                    <span>{{ $blogCategoryList['title'] }}</span>
                                </div>
                            </div>
                            @php
                                $arr = explode('/', $blogCategoryList['slugs']['slug']);
                                $categoryNameLink = $arr[1] ;
                            @endphp

                            <a href="{{ config('app.app_path') }}/blog?category={{ $blogCategoryList['slugs']['slug'] }}" class="viewBtn">{{ trans('sentence.blog_view_all') }}<span>>></span></a>
                        </div>
                        <div class="Flx row">
                            @php $count = 0; @endphp
                            @foreach($blogCategoryList['blogs'] as $blog)
                                <div class="col-3 standard-post">
                                    <div class="inner">
                                        <div class="post-image">
                                            <a href="{{ config('app.app_path') }}/{{ $blog['slugs']['slug'] }}" class="image">
                                                <img src="{{ $blog['banner_image'] ? $blog['banner_image']['url'] : ''  }}" data-src="{{ $blog['banner_image'] ? $blog['banner_image']['url'] : '' }}" alt="">
                                            </a>
                                        </div>
                                        <div class="post-details">
                                            <a href="{{ config('app.app_path') }}/{{ $blog['slugs']['slug'] }}">
                                                <div class="category-details">
                                                    <div class="category-tags">
                                                        @if(!empty($blog['tags']))
                                                            <span>{{ $blog['tags'][0]['title'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="post-title">
                                                    @php
                                                        $postTitle = substr($blog['title'], 0, 68);
                                                        $postTitleLength = strlen($blog['title']);
                                                    @endphp
                                                    <h2>{{ $postTitle }} @if($postTitleLength > 68) ... @endif</h2>
                                                </div>
                                            </a>
                                            <span class="btm-line"></span>
                                        </div>
                                    </div>
                                </div>
                                @php $count++; @endphp
                                @if($count == 3)
                                    @php break; @endphp
                                @endif


                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    </section>

@endsection
