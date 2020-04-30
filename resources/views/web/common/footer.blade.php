		<footer class="footer">
			<div class="quickLinks">
				<div class="flexWrapper">
					<div class="newsLetter">
						<div class="subscribeBox">
							<h5>{{ trans('sentence.home_news_letter_heading') }}</h5>
							<p>{{ trans('sentence.home_news_letter_description') }}</p>
							<form class="subBox">
								<input type="email" class="subBoxEmail" data-name="footer" name="subBoxEmail" id="1footer" name="subBoxEmail" placeholder="{{ trans('sentence.home_enter_your_Valid_email') }}" required="">
                                <div id="footer" style="color:white;margin-top:10px"></div>
								<br>

								<button class="submit" data-name="footer"  type="button">{{ trans('sentence.home_subscribe') }}</button>
							</form>
							<p class="successful">Congratulations! You’ll be the first to receive our latest Vouchers & Deals.</p>
						</div>
					</div>
					<div class="footerLinks resFooterMenu">
						<h5>{{ trans('sentence.home_general_heading') }}</h5>
						<ul>
                            @if (isset($pages))
                                @foreach($pages as $page)
                                    @if($page['bottom'] == 1)
                                        <li><a href="{{ config('app.app_path') }}/{{ $page['slugs']['slug'] }}">{{ $page['title'] }}</a></li>
                                    @endif
                                @endforeach
                            @endif
							<li><a href="{{ config('app.app_path') }}/contact_us">{{ trans('sentence.home_contact_page_link') }}</a></li>
							<li><a href="{{ config('app.app_path') }}/blog" >{{ trans('sentence.home_blog_page_link') }}</a></li>
							<li><a href="{{ config('app.app_path') }}/sitemap">{{ trans('sentence.home_site_map') }}</a></li>
						</ul>
					</div>
					<div class="footerLinks">
						<h5>{{ trans('sentence.home_speciality_pages_heading') }}</h5>
            @if(!empty($bottom_event))
						<ul>
              @foreach($bottom_event as $event)
							<li><a href="{{ config('app.app_path') }}/{{ $event['slugs']['slug'] }}">{{ $event['title'] }}</a></li>
              @endforeach
						</ul>
            @endif
					</div>

					<div class="footerLinks">
						<h5>{{ trans('sentence.home_connect_page_heading') }}</h5>
						<ul>
							<li><a href="{{ $site_wide_data['facebook'] ?? ''}}">{{ trans('sentence.home_facebook_heading') }}</a></li>
							<li><a href="{{ $site_wide_data['twitter'] ?? ''}}">{{ trans('sentence.home_twitter_heading') }}</a></li>
							<li><a href="{{ $site_wide_data['linked_in'] ?? ''}}">{{ trans('sentence.home_instagram_heading') }}</a></li>
						</ul>
						<div class="social">
							<h5>{{ trans('sentence.home_join_us_heading') }}</h5>
							<a href="{{ $site_wide_data['facebook'] ?? ''}}" target="_blank"><i class="lm_facebook"></i></a>
							<a href="{{ $site_wide_data['twitter'] ?? ''}}" target="_blank"><i class="lm_twitter"></i></a>
							<a href="{{ $site_wide_data['linked_in'] ?? ''}}" target="_blank"><i class="lm_linkedin"></i></a>
							<a href="{{ $site_wide_data['youtube'] ?? ''}}" target="_blank"><i class="lm_youtube"></i></a>
						</div>
					</div>
				</div>
				<div class="flexWrapper resSoc">
					<div class="social">
						<a href="{{ $site_wide_data['facebook'] ?? ''}}" target="_blank"><i class="lm_facebook"></i></a>
						<a href="{{ $site_wide_data['twitter'] ?? ''}}" target="_blank"><i class="lm_twitter"></i></a>
						<a href="{{ $site_wide_data['linked_in'] ?? ''}}" target="_blank"><i class="lm_linkedin"></i></a>
						<a href="{{ $site_wide_data['youtube'] ?? ''}}" target="_blank"><i class="lm_pinterest"></i></a>
					</div>
				</div>
			</div>
		</footer>
		<div class="copyright">
			<div class="flexWrapper">
				<p>{{ trans('sentence.home_footer_all_rights_reserved') }}</p>
			</div>
		</div>
		</div>

		<?php if(isset($_GET['copy'])){?>
			@php
				$couponRecord = getCouponRecord($_GET['copy']);
				@endphp
                @if($couponRecord == null)
                @else
			<div id="copycode" class="overlayWrapper" style="display: flex;">
				<div class="popupWrpr">
					<div class="overlayBgReset"></div>
					<div class="overlayContainer">
						<div class="head">
							<a href="javascript:;" class="logo">
								<img src="{{ $site_wide_data['logo']['url'] }}" alt="">
							</a>
							<span class="closeOverlay">
								<i class="lm_close"></i>
					        </span>
						</div>
				        <div class="logoBox">
				        	<div class="logoImage">
                            @if( config("app.routename")=='events') 
                    <img src="{{ config('app.image_path') }}/build/images/placeholder.png" data-src="{{ isset($couponRecord['image']['url']) ? $couponRecord['image']['url'] : ( (isset($couponRecord['store']['image']['url'])) ? $couponRecord['store']['image']['url'] : config('app.image_path') . '/build/images/placeholder.png' ) }}" alt="">
                    @else
                    @if(!empty($couponRecord['custom_image_title']))
                    <div class="cupnsOffrs">
                        <span class="percent">{!! $couponRecord['custom_image_title'] !!}</span>
                    </div>
                    @else
						<img src="{{ config('app.image_path') }}/build/images/placeholder.png" data-src="{{ isset($couponRecord['image']['url']) ? $couponRecord['image']['url'] : ( (isset($couponRecord['store']['image']['url'])) ? $couponRecord['store']['image']['url'] : config('app.image_path') . '/build/images/placeholder.png' ) }}" alt="">
                    @endif
                    @endif
				        	</div>
				        	<div class="desc">
					        	<h4>{!! $couponRecord['title'] !!}{!! ($couponRecord['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' !!}</h4>
                                <p>{!! html_entity_decode($couponRecord['description']) !!}</p>
					        	<!-- <p>Great promo 10% discount code for all products so hurry up!</p> -->
					        	<div class="date">
	           @php
             if (date("Y", strtotime($couponRecord['date_expiry'])) >= '2090') {
                    $expiryDate = 'On Going';
            } else {
                $expiryDate = date("M-j-Y", strtotime($couponRecord['date_expiry']));
            }
            @endphp
            <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>
	                            </div>
					        </div>
				        </div>
				        <div class="codeCopySec">
                            <div class="inputWrp">
					        	<input id="input_output" class="code" type="text" value="{{ $couponRecord['code'] }}" readonly>
					        </div>
			            	<a id="copyCodeBtn" href="javascript:;" class="copyBtn copyCodeButton">COPY</a>
				        </div>
					</div>
				</div>
			</div>
        @endif
		<?php } ?>

		<?php if(isset($_GET['deal'])){?>
			@php
            $couponRecord = getCouponRecord($_GET['deal']);
            @endphp
            @if($couponRecord == null)
            @else
			<div id="copycode" class="overlayWrapper" style="display: flex;">
				<div class="popupWrpr">
					<div class="overlayBgReset"></div>
					<div class="overlayContainer">
						<div class="head">
							<a href="javascript:;" class="logo">
								<img class="lazy" src="{{config('app.image_path')}}/build/images/placeholder.png" data-src="{{ $site_wide_data['logo']['url'] }}" alt="">
							</a>
							<span class="closeOverlay">
								<i class="lm_close"></i>
					        </span>
						</div>
				        <div class="logoBox">
				        	<div class="logoImage">
	                    @if(  config("app.routename")=='events') 
                    <img src="{{ config('app.image_path') }}/build/images/placeholder.png" data-src="{{ isset($couponRecord['image']['url']) ? $couponRecord['image']['url'] : ( (isset($couponRecord['store']['image']['url'])) ? $couponRecord['store']['image']['url'] : config('app.image_path') . '/build/images/placeholder.png' ) }}" alt="">
                    @else
                    @if(!empty($couponRecord['custom_image_title']))
                    <div class="cupnsOffrs">
                        <span class="percent">{!! $couponRecord['custom_image_title'] !!}</span>
                    </div>
                    @else
						<img src="{{ config('app.image_path') }}/build/images/placeholder.png" data-src="{{ isset($couponRecord['image']['url']) ? $couponRecord['image']['url'] : ( (isset($couponRecord['store']['image']['url'])) ? $couponRecord['store']['image']['url'] : config('app.image_path') . '/build/images/placeholder.png' ) }}" alt="">
                    @endif
                    @endif

				        	</div>
				        	<div class="desc">
					        	<h4>{{ $couponRecord['title'] }}{!! ($couponRecord['free_shipping'] == 1) ? trans('sentence.free_shipping') : '' !!}</h4>
                                <p> {!! html_entity_decode($couponRecord['description']) !!} </p>
					        	<!-- <p>Great promo 10% discount code for all products so hurry up!</p> -->
					        	<div class="date">
                            @php
                             if (date("Y", strtotime($couponRecord['date_expiry'])) >= '2090') {
                                    $expiryDate = 'On Going';
                                } else {
                                    $expiryDate = date("M-j-Y", strtotime($couponRecord['date_expiry']));
                                }
                            @endphp
                          <i class="lm_clock"></i><span>{{ trans('sentence.home_expiry_date') }} {{ $expiryDate }}</span>
                      </div>
					        </div>
				        </div>
				        <div class="codeCopySec">
				        	<div class="noCode">No Code Requried</div>
				        	<div class="inputWrp">
					        	<a href="{{addhttps($couponRecord['store']['store_url'])}}" class="gotoBtn">{{ trans('sentence.home_footer_coupon_continue_to_text') }} {{ $couponRecord['store']['name'] }}</a>
					        </div>
			            	<p>{{ trans('sentence.home_footer_goto_store') }}  {{ $couponRecord['store']['name'] }} {{ trans('sentence.home_footer_and_get_discount') }}</p>
				        </div>
					</div>
				</div>
			</div>
        @endif
		<?php } ?>


	</body>
</html>



<?php
$ob_get_clean_css = ob_get_clean();

$cssmain  = preg_replace(array('/ {2,}/','/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'),array(' ',''),$ob_get_clean_css);

echo $cssmain;
?>
<script  src="{{ asset('build/js/all.js')}}"></script>
<link rel="stylesheet" href="{{ asset('build/css/jquery-ui.min.css')}}">
{!! isset($site_wide_data['javascript_tags']) ? $site_wide_data['javascript_tags'] : '' !!}
  <script src="{{ asset('build/js/jquery-ui.min.js')}}"></script>
<script>
var baseTitle = window.document.title;
window.onblur = function () { document.title = 'Back to {{$site_wide_data['name'] ? $site_wide_data['name'] : ''}}'; }
window.onfocus = function () {   document.title = baseTitle; };


    $( ".submit" ).click(function(event) {
        event.preventDefault();
        var form = $(this);
        var sub_name = form.attr('data-name');
        var email =   $( "#1"+sub_name ).val();
        subscribe(form,sub_name,email);
        $( "#1"+sub_name ).removeClass('error');
        $( "#1"+sub_name ).val('');

    });

    $( ".subBoxEmail" ).keypress(function(e) {
        if(e.which == 13) {     
            event.preventDefault();
            var form = $(this);
            var sub_name = form.attr('data-name');
            var email =  form.val();
            subscribe(form,sub_name,email);
            form.val('');
        }
    });

    function subscribe(form,sub_name,email){
        $.ajax({
            url: '{{ route('submitsubscribe') }}',
            type: 'POST',
            data: {
                "_token"    : "{{ csrf_token() }}",
                "dataType"  : "JSON",
                'data'      : {
                    'email' : email
                },
            },
            success : function(data) {
                $("#"+sub_name).html(data.msg);

            },
            error : function(data) {
                console.log(data);
            }
        });
    }

    $("#subscribeNeverMisId").keypress(function(e) 
    {
        if(e.which == 13) {
            event.preventDefault();
            var form = $(this);
            $.ajax({
                url: '{{ config("app.app_path")."/_subscribe" }}',
                type: 'POST',
                data: {
                    "_token"    : "{{ csrf_token() }}",
                    "dataType"  : "JSON",
                    'data'      : {
                        'email' : $("#subscribeNeverMis").val()
                    },
                },
                success : function(data) {
                    $('.subscribeNeverMisNewLetter').html(data.msg);
                    $("#subscribeNeverMis").val('');
                },
                error : function(data) {
                    console.log(data);
                }
            });
        }
    });

$(document).on('submit', '#contactBox', function() {
    event.preventDefault();
    var form = $(this);
    $.ajax({
      url: '{{ route('contact.store') }}',
      type: 'POST',
      data: {
        "_token" : "{{ csrf_token() }}",
        "dataType" : "JSON",
        'data' : {
          'name' : $('#name').val(),
          'email' : $('#email').val(),
          'contact' : $('#contact').val(),
          'subject' : $('#subject').val(),
          'message' : $('#message').val()
        },
      },
      success : function(data) {
      	$('#msgcontact').html(data.msg);
      },
      error : function(data) {
        console.log(data);
      }
    });
});

  $(document).on('click', '.sortalpha', function(e){

    var target  = $(this).attr('data-target2');

    window.location.href= '{{ config("app.app_path") }}' +target;
  });
  $(document).on('click', '.baseurlappend', function(e){

    var varName = $(this).attr('data-id');
    var vartarg = $(this).attr('data-var');
    var varstor = $(this).data("store");
    var post_url = "{!! config('app.app_path').'/update-coupon-views' !!}";
    $_token = "{{ csrf_token() }}";
    $.ajax({
      url : post_url,
      type: 'GET',
      data: {"data_id" : varName}
    }).done(function(response){
        console.log(response);
    });
      window.open('{{ url()->current() }}' + "?"+vartarg+"=" + varName);
      location.replace(varstor);
 });


  $(".search_term_store").autocomplete({
    autoFocus: true,
    appendTo: $(".search_term_store").closest('.searchfield'),
    source: function (request, response) {
      var input = this.element;
      var search = request.term;
      $.ajax({
        url: '{{config("app.app_path")."/search_store" }}',
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          search : search
        },
        success: function (data) {
          if(data == 0) {
            var result = [{
              label: 'No matches found',
              value: response.term
            }];
            response(result);
          } else {
            response($.map(data, function(item) {
              return {
                value: item['title'],
                url:item['url']
              }
            }));
          }
        }
      });
    },
    select: function (event, ui) {
      if(ui.item.url) {
          window.location.href = ui.item.url;
          $(this).val('');
      }
      else {
          setTimeout(() => {
              $(this).val('');
          }, 1)
      }
    },
    minLength: 1
  });

  $(".search_blog").autocomplete({
    autoFocus: true,
    appendTo: $(".search_blog").closest('.search_blog_field'),
    source: function (request, response) {
      var input = this.element;
      var search = request.term;
      $.ajax({
        url: '{{config("app.app_path")."/search_blog" }}',
        type: 'GET',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          search : search
        },
        success: function (data) {
          if(data == 0) {
            var result = [{
              label: 'No matches found',
              value: response.term
            }];
            response(result);
          } else {
            response($.map(data, function(item) {
              return {
                value: item['title'],
                url:item['url']
              }
            }));
          }
        }
      });
    },
    select: function (event, ui) {
      if(ui.item.url) {
          window.location.href = ui.item.url;
          $(this).val('');
      }
      else {
          setTimeout(() => {
              $(this).val('');
          }, 1)
      }
    },
    minLength: 1
  });

  $(document).on('click', '#load_more_button', function(e){

    var id = $(this).attr('data-id');
    var category_id = $(this).attr('blog-category-id');
    $('#load_more_button').html('<b>Loading...</b>');
    var post_url = "{!! config('app.app_path').'/load-more-data' !!}";
    $_token = "{{ csrf_token() }}";
    $.ajax({
      url : post_url,
      type: 'POST',
      data: {
      	"_token": "{{ csrf_token() }}",
      	"data_id" : id,
      	"category_id" : category_id
      }
    }).done(function(response){
    	$('#load_more_button').remove();
    	$('#post_data').append(response);
      	console.log(response);
    });

 });

  $(document).on('click', '#blog_load_more_button', function(e){

    var id = $(this).attr('data-id');
    var author_id = $(this).attr('blog-author-id');
    $('#blog_load_more_button').html('<b>Loading...</b>');
    var post_url = "{!! config('app.app_path').'/author-load-more-data' !!}";
    $_token = "{{ csrf_token() }}";
    $.ajax({
      url : post_url,
      type: 'POST',
      data: {
      	"_token": "{{ csrf_token() }}",
      	"data_id" : id,
      	"author_id" : author_id
      }
    }).done(function(response){
    	$('#blog_load_more_button').remove();
    	$('#post_data').append(response);
      	console.log(response);
    });

 });

//$('.buzzSliderSlide').slick();
//$('.buzzSliderSlide').slick({
//        lazyLoad: 'ondemand',
//        dots: true,
//        arrows: true,
//        infinite: true,
//        autoplay: true,
//        autoplaySpeed: 2000,
//        slidesToShow: 1,
//    });

 // if ('serviceWorker' in navigator) {
 //      navigator.serviceWorker
 //           .register('{{config('app.image_path')}}/sw.js')
 //           .then(function() { console.log("Service Worker Registered"); });


 // }
</script>
