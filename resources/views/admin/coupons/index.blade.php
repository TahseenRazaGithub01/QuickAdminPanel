@extends('layouts.admin')
@section('content')

    @php
        $url = request()->sid ? route('admin.coupons.create', 'sid=' . request()->sid) : route('admin.coupons.create');
    @endphp

    @can('coupon_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-8">
                <a class="btn btn-success" href="{{ $url }}">
                    {{ trans('global.add') }} {{ trans('cruds.coupon.title_singular') }}
                </a>
            </div>
            <div class="col-lg-4">
                <select name="siteOpt" id="siteOpt" class="form-control">
                    @if(COUNT(getAllSites()) > 0)
                        <option value="" selected disabled>Select Site</option>
                        <option value="all">All Site</option>
                        @foreach(getAllSites() as $site)
                            <option value="{{ $site->id }}" {{ in_array($site->id, [getSiteID()]) ? 'selected' : '' }}>{{ $site->name }}</option>
                        @endforeach
                    @else
                        <option value="">No Site Available</option>
                    @endif
                </select>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            @php
                $store = isset($store['name']) ? '- <b>(' . $store['name'] . ')</b>' : '';
            @endphp
            {{ trans('cruds.coupon.title_singular') }} {{ trans('global.list') }} {!! $store !!}
        </div>

        <div class="card-body" id="datatable-Coupon">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Coupon">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.site') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.store') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.created_by') }} /
                        {{ trans('cruds.coupon.fields.created_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.updated_by') }} /
                        {{ trans('cruds.coupon.fields.updated_at') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.date_expiry') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.publish') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.code') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    @php
        $mainurl = isset(request()->test_id) ? route('admin.coupons.index') . '?test_id=1' : route('admin.coupons.index');
        if(isset(request()->cid) && isset(request()->test_id)) {
            $mainurl = $mainurl . "&cid=" . request()->cid;
        } elseif (isset(request()->cid)) {
            $mainurl = $mainurl . "?cid=" . request()->cid;
        }
    @endphp
    <script>

        var url = "{{ $mainurl }}";
        url = url.replace(/&amp;/g, '&');

        function published(id) {
            var published = `#published${id}`;
            var publish = 0;
            if($(published).prop('checked') == true){
                publish = 1
            }
            $.ajax({
                type: 'GET',
                url:  '{{ url("admin/coupon/published") }}',
                data: {id, publish},
                success : function(data) {
                    console.log(data)
                }
            });
        }
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('coupon_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.coupons.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': "{{ csrf_token() }}"},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
                @endcan

            var sid = "{{ request()->sid ? request()->sid : '' }}"

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: false,
                aaSorting: [],
                ajax: {
                    "url": url,
                    "data": {
                        sid
                    }
                },
                columns: [
                    { data: 'placeholder', name: 'placeholder' },
                    { data: 'site', name: 'sites.name' },
                    { data: 'title', name: 'title' },
                    { data: 'store_name', name: 'store.name' },
                    { data: 'created_by', name: 'created_by' },
                    { data: 'updated_by', name: 'updated_by' },
                    { data: 'date_expiry', name: 'date_expiry' },
                    { data: 'publish', name: 'publish' },
                    { data: 'code', name: 'code' },
                    { data: 'actions', name: '{{ trans('global.actions') }}' }
                ],
                order: [[ 2, 'asc' ]],
                pageLength: 10,
                destroy: true,
            };

            $('.datatable-Coupon').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });


            document.getElementById('siteOpt').onchange = function () {
                $("#datatable-Coupon").html("");
                $("#datatable-Coupon").html(`
                        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Coupon">
                            <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.coupon.fields.site') }}
                </th>
                <th>
{{ trans('cruds.coupon.fields.title') }}
                </th>
                <th>
{{ trans('cruds.coupon.fields.store') }}
                </th>
                                    <th>
                                        {{ trans('cruds.store.fields.created_by') }} /
                                        {{ trans('cruds.store.fields.created_at') }}
                </th>
                <th>
{{ trans('cruds.store.fields.updated_by') }} /
                                        {{ trans('cruds.store.fields.updated_at') }}
                </th>
<th>
{{ trans('cruds.coupon.fields.date_expiry') }}
                </th>
                <th>
{{ trans('cruds.coupon.fields.publish') }}
                </th>
                <th>
{{ trans('cruds.coupon.fields.code') }}
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
    </table>
`);

                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                    @can('coupon_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.coupons.massDestroy') }}",
                    className: 'btn-danger',
                    action: function (e, dt, node, config) {
                        var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                            return entry.id
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                headers: {'x-csrf-token': "{{ csrf_token() }}"},
                                method: 'POST',
                                url: config.url,
                                data: { ids: ids, _method: 'DELETE' }})
                                .done(function () { location.reload() })
                        }
                    }
                }
                dtButtons.push(deleteButton)
                    @endcan

                var data = {
                        "siteId": $(this).val(),
                        sid
                    }

                let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: false,
                    aaSorting: [],
                    ajax: {
                        "url": url,
                        "data": data
                    },
                    columns: [
                        { data: 'placeholder', name: 'placeholder' },
                        { data: 'site', name: 'sites.name' },
                        { data: 'title', name: 'title' },
                        { data: 'store_name', name: 'store.name' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'updated_by', name: 'updated_by' },
                        { data: 'date_expiry', name: 'date_expiry' },
                        { data: 'publish', name: 'publish' },
                        { data: 'code', name: 'code' },
                        { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    order: [[ 2, 'asc' ]],
                    pageLength: 10,
                    destroy: true
                };

                $('.datatable-Coupon').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });
            }

        });

    </script>
@endsection
