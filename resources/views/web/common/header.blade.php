<?php ob_start(); ?>
<?php //header('X-Robots-Tag: noindex, nofollow'); ?>
<?php $imgHolder = 'data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';?>
<!DOCTYPE html>
<html lang="en">
	<head>
        @php
		$description = (isset($meta['description'])) ? $meta['description'] : 'Voucherwing'  ;
		$title = (isset($meta['title'])) ? $meta['title'] : 'Voucherwing'  ;
		$keywords = (isset($meta['keywords'])) ? $meta['keywords'] : 'Voucherwing'  ;
		@endphp
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script> dataLayer = [{ 'pageCategory': '{{ isset($detail['name']) ? $detail['name'] : url()->full() }}', 'couponViewUrl' : '{{ url()->full() }}', 'visitorType': 'high-value' }]; </script>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NWC6L7H');</script>
		<!--<link rel="shortcut icon" href="../build/images/favicon.png" type="image/png" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
		<meta name="viewport" content="width=device-width, initial-scale=1, initial-scale=1.0">
		
		<meta name="description" content="{{ $description }}" />
        <meta name="keywords" content="{{ $keywords }}">
		<!-- Chrome, Firefox OS and Opera
		<meta name="theme-color" content="#3a7cd5">
		Windows Phone
		<meta name="msapplication-navbutton-color" content="#3a7cd5">
		iOS Safari
		<meta name="apple-mobile-web-app-status-bar-style" content="#3a7cd5"> -->
                {!! isset($site_wide_data['html_tags']) ? $site_wide_data['html_tags'] : '' !!}
		<link rel="icon" href="{{ isset($site_wide_data['favicon']) ? $site_wide_data['favicon']['url'] : '' }}" type="image/x-icon">

		<title>{{ $title }}</title>
		<style>
            <?php
			if(isset($pageCss)){
				$css = asset("build/css/$pageCss.css");
				readfile("build/css/$pageCss.css");
			}else{
				$css = asset("build/css/main.css");  
				readfile("build/css/main.css");
			}
			?>
		</style>
	</head>
	<body><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NWC6L7H"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<div class="mainWrapper">
			
			<header class="header">
				<div class="Top">
					<div class="flexWrapper">
						<span id="#nav-icon3" class="menu">
							<i class="lm_menu"></i>
						</span>
						<div class="logo">
							<a href="{{ config('app.app_path') }}">
                                <img class="lazy" src="{{ isset($site_wide_data['logo']) ? $site_wide_data['logo']['url'] : '' }}" data-src="{{ isset($site_wide_data['logo']['url']) ? $site_wide_data['logo']['url'] : '' }}" alt="logo">
				
							</a>
						</div>
						<span class="searchRes">
							<i class="lm_search"></i>
						</span>
						<div class="searchPanel">
							<div class="searchfield" style="overflow: visible;">
                                <form id="store_search_form" style="height: 100%;">
								<input type="text" class="search_term_store" placeholder="Search">
								<button type="submit"><i class="lm_search"></i></button>
                                    </form>
							</div>
						</div>
                        
                        
						<nav class="links">
							<div class="flexWrapper">
								<a href="{{ config('app.app_path') }}" class="active">Home</a>
								<a href="{{ config('app.app_path') }}/sitemap">Stores</a>
								<a href="{{config('app.app_path')}}/category">Categories</a>
								<a href="{{ config('app.app_path') }}/contact_us">Contact</a>
								<a href="{{ config('app.app_path') }}/blog" >Blog</a>
							</div>
						</nav>
					</div>
				</div>
				<div class="navigationBar sidenav">
					<!-- <div class="sideBarLogo">
						<a href="javascript:;" class="logo">
							<img class="lazy" src="build/images/buzzsprout_logo.png" alt="">
						</a>
					</div> -->
					<ul>
						<li>
							<a href="{{ config('app.app_path') }}">Home</a></li>
						<li>
							<a href="{{ config('app.app_path') }}/sitemap">Stores</a>
						</li>
						<li>
							<a href="{{config('app.app_path')}}/category">Categories</a>
						</li>
						<li>
							<a href="{{ config('app.app_path') }}/contact_us">Contact</a>
						</li>
						<li>
							<a href="{{ config('app.app_path') }}/blog" >Blog</a>
						</li>
					</ul>
				</div>
			</header>

			