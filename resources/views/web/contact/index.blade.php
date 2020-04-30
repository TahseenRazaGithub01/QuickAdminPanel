@extends('web.layouts.app')
@section('content')
<div class="breadcrumb">
    <ul>
        <li>
            <a href="{{ config('app.app_path') }}"><i class="lm_home"></i> Home</a>
        </li>
        <li>
            <a href="{{ config('app.app_path') }}/contact_us">{{ trans('sentence.contact_page_name') }}</a>
        </li>
    </ul>
</div>
<h1 class="contactHeading">{{ trans('sentence.contact_page_name') }}</h1>

<div class="map">

    <img class="lazy" src="{{ config('app.image_path') }}/build/images/contactfullmap.jpg" alt="">

</div>
<div class="innerContainer" style="margin-top:50px">

    <div class="contentWrpr">

        <div class="flexWrap">

            <div class="formWrapper">

                <h2>{{ trans('sentence.contact_send_your_message') }}</h2>

                <div class="rowbar">

                    <form id="contactBox" action="{{ route("contact.store") }}" enctype="multipart/form-data">

                        <div class="inputWrapper halfColumn">

                            <input type="text" name="name" value="" placeholder="{{ trans('sentence.contact_full_name') }}" id="name" required="">

                        </div>

                        <div class="inputWrapper halfColumn">

                            <input type="email" name="email" value="" placeholder="{{ trans('sentence.contact_email_address') }}" id="email" required="">

                        </div>

                        <div class="inputWrapper halfColumn">

                            <input type="text" name="contact" id="contact" placeholder="{{ trans('sentence.contact_phone') }}" value="">

                        </div>

                        <div class="inputWrapper halfColumn">

                            <input type="text" name="subject" id="subject" placeholder="{{ trans('sentence.contact_subject') }}" value="" required="">

                        </div>

                        <div class="inputWrapper fullColumn">

                            <textarea name="message" rows="10" placeholder="{{ trans('sentence.contact_your_comments') }}" id="message" required=""></textarea>

                        </div>

                        <div class="fullColumn">

               <div id='msgcontact'>
                    </div>
                            <button type="submit">{{ trans('sentence.contact_send_message') }}</button>

                        </div>
                    </form>

                </div>

            </div>


        </div>

    </div>

</div>
@endsection