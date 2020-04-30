<script>
    function check_unique_slug(){
        var sites = $("#sites").select2("val");
        var input = $(".auto_slug");
        var edit_id = $(".edit_id").val();
        var ths = $(".auto_slug");
        var org_slug = $('.org_slug').val();
        var parent_slug = $('.parent_slug').val();
        var Text = ths.val();
        var slug_model = ths.data('target_controller');
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $.ajax({
            type: 'POST',
            url:  '{{ url("admin/unique_slug") }}',
            data: {
                sites : sites,
                edit_id : edit_id,
                slug : Text,
                org_slug : org_slug,
                slug_model : slug_model,
                parent_slug : parent_slug,
                "_token" : '{{ csrf_token() }}'
            },
            success : function(data) {
                if(data == 0){
                    $.toast({
                        heading: 'Slug Error',
                        text: "Name or Title cannot be empty.",
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 6000,
                        stack: 6
                    });
                }
                var obj = $.parseJSON(data);
                var errorSpan = $('.org_slug').siblings('.errorSpan');
                if(obj.message == 'slug-not-unique'){
                    $('.org_slug').addClass('alert-danger');

                    $('.org_slug').val('');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You won't be able to use this ${obj.return_slug} slug?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#20a8d8',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, do it!'
                    }).then((result) => {
                        if (result.value) {

                            $('.org_slug').val(obj.return_slug);
                            $('.jq-icon-error').hide();

                        }
                    })
                    $(errorSpan).text('This slug is not unique in database. Kindly change slug.');
                    $(errorSpan).removeClass('d-none');
                    $.toast({
                        heading: 'Slug Error',
                        text: "Slug is not unique in database. Kindly change slug.",
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 6000,
                        stack: 6
                    });
                }
                else {
                    $('.org_slug').removeClass('alert-danger');
                    $(errorSpan).addClass('d-none');
                    $(errorSpan).text('');
                    $('.org_slug').val(obj.return_slug);
                }
            },
            error : function() {
                $('.org_slug').addClass('alert-danger');
                var errorSpan = $('.org_slug').siblings('.errorSpan');
                $(errorSpan).text('Something went wrong. Please try again.');
                $.toast({
                    heading: 'Unexpected Error',
                    text: "Something went wrong. Please try again.",
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: 6000,
                    stack: 6
                });
            }
        });
    }

    function check_unique_slug2(){
        var sites = $("#sites").select2("val");
        var input = $(".org_slug");
        var edit_id = $(".edit_id").val();
        var ths = $(".org_slug");
        var org_slug = $('.org_slug').val();
        var parent_slug = $('.parent_slug').val();
        var Text = ths.val();
        var slug_model = $(".auto_slug ").data('target_controller');
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $.ajax({
            type: 'POST',
            url:  '{{ url("admin/unique_slug") }}',
            data: {
                sites : sites,
                edit_id : edit_id,
                slug : Text,
                org_slug : org_slug,
                slug_model : slug_model,
                parent_slug : parent_slug,
                slug_chk : 1,
                "_token" : '{{ csrf_token() }}'
            },
            success : function(data) {
                if(data == 0){
                    $.toast({
                        heading: 'Slug Error',
                        text: "Name or Title cannot be empty.",
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 6000,
                        stack: 6
                    });
                }
                var obj = $.parseJSON(data);
                var errorSpan = $('.org_slug').siblings('.errorSpan');
                if(obj.message == 'slug-not-unique'){
                    $('.org_slug').addClass('alert-danger');

                    $('.org_slug').val('');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You won't be able to use this ${obj.return_slug} slug?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#20a8d8',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, do it!'
                    }).then((result) => {
                        if (result.value) {

                            $('.org_slug').val(obj.return_slug);
                            $('.jq-icon-error').hide();

                        }
                    })
                    $(errorSpan).text('This slug is not unique in database. Kindly change slug.');
                    $(errorSpan).removeClass('d-none');
                    $.toast({
                        heading: 'Slug Error',
                        text: "Slug is not unique in database. Kindly change slug.",
                        showHideTransition: 'fade',
                        icon: 'error',
                        position: 'top-right',
                        hideAfter: 6000,
                        stack: 6
                    });
                }
                else {
                    $('.org_slug').removeClass('alert-danger');
                    $(errorSpan).addClass('d-none');
                    $(errorSpan).text('');
                    $('.org_slug').val(obj.return_slug);
                }
            },
            error : function() {
                $('.org_slug').addClass('alert-danger');
                var errorSpan = $('.org_slug').siblings('.errorSpan');
                $(errorSpan).text('Something went wrong. Please try again.');
                $.toast({
                    heading: 'Unexpected Error',
                    text: "Something went wrong. Please try again.",
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: 6000,
                    stack: 6
                });
            }
        });
    }

    $("#sites").change(function () {
        if ($("#title").val() && $(this).val() && $("input").hasClass("auto_slug")) {
            check_unique_slug();
        }
    });

    $(".auto_slug").change(function(){
        $.toast().reset('all');
        check_unique_slug();
    });

    $(".org_slug").change(function(){
        if ($("#title").val()) {
            $.toast().reset('all');
            check_unique_slug2();
        }
    });

    $(".websites").change(function(){
        $.toast().reset('all');
        check_unique_slug();
    });

    $(".parent_slug").change(function(){
        $.toast().reset('all');
        check_unique_slug();
    });

    $("#slug").change(function(){
        if (!$("#title").val()) {
            $.toast().reset('all');
            check_unique_slug2();
        }
    });

    $(".form_form").submit(function(event) {
        var res = false;
        $.toast().reset('all');
        check_unique_slug();
        var errorSpan = $(document).find('.org_slug').siblings('.errorSpan');
        if($(errorSpan).hasClass('d-none')){
            var res = true;
        }
        return res;
        event.preventDefault();
    });
</script>
