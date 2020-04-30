@extends('layouts.admin')
@section('content')
    @can('store_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-8">
                <a class="btn btn-success" href="{{ route("admin.stores.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.store.title_singular') }}
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
            {{ trans('cruds.store.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body" id="datatable-Store">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Store">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.store.fields.site') }}
                    </th>
                    <th>
                        {{ trans('cruds.store.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.store.fields.coupon_count') }}
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
                        {{ trans('cruds.store.fields.sort') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.publish') }}
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
        $url = isset(request()->test_id) ? route('admin.stores.index') . '?test_id=1' : route('admin.stores.index');
        if(isset(request()->stid) && isset(request()->test_id)) {
            $url = $url . "&stid=" . request()->stid;
        } elseif (isset(request()->stid)) {
            $url = $url . "?stid=" . request()->stid;
        }
    @endphp
    <script>

        var url = "{{ $url }}";
        url = url.replace(/&amp;/g, '&');

        function published(id) {
            var published = `#published${id}`;
            var publish = 0;
            if($(published).prop('checked') == true){
                publish = 1
            }
            $.ajax({
                type: 'GET',
                url:  '{{ url("admin/store/published") }}',
                data: {id, publish},
                success : function(data) {
                    console.log(data)
                }
            });
        }
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('store_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.stores.massDestroy') }}",
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

            let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    aaSorting: [],
                    ajax: url,
                    columns: [
                        { data: 'placeholder', name: 'placeholder' },
                        { data: 'site', name: 'sites.name' },
                        { data: 'name', name: 'name' },
                        { data: 'coupon_count', name: 'coupon_count' },
                        { data: 'created_by', name: 'created_by' },
                        { data: 'updated_by', name: 'updated_by' },
                        { data: 'sort', name: 'sort' },
                        { data: 'publish', name: 'publish' },
                        { data: 'actions', name: '{{ trans('global.actions') }}' }
                    ],
                    order: [[ 2, 'asc' ]],
                    pageLength: 10,
                };
            $('.datatable-Store').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            document.getElementById('siteOpt').onchange = function () {
                $("#datatable-Store").html("");
                $("#datatable-Store").html(`
                        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Store">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.store.fields.site') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.store.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.store.fields.coupon_count') }}
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
                                        {{ trans('cruds.store.fields.sort') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.coupon.fields.publish') }}
                                    </th>
                                    <th>

                                    </th>
                                    </tr>
                                </thead>
                            </table>
                        `);

                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('store_delete')
                    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                    let deleteButton = {
                        text: deleteButtonTrans,
                        url: "{{ route('admin.stores.massDestroy') }}",
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

                let dtOverrideGlobals = {
                        buttons: dtButtons,
                        processing: true,
                        serverSide: true,
                        retrieve: true,
                        aaSorting: [],
                        ajax: {
                            "url": url,
                            "data": {
                                "siteId": $(this).val()
                            }
                        },
                        columns: [
                            { data: 'placeholder', name: 'placeholder' },
                            { data: 'site', name: 'sites.name' },
                            { data: 'name', name: 'name' },
                            { data: 'coupon_count', name: 'coupon_count' },
                            { data: 'created_by', name: 'created_by' },
                            { data: 'updated_by', name: 'updated_by' },
                            { data: 'sort', name: 'sort' },
                            { data: 'publish', name: 'publish' },
                            { data: 'actions', name: '{{ trans('global.actions') }}' }
                        ],
                        order: [[ 2, 'asc' ]],
                        pageLength: 10,
                    };
                $('.datatable-Store').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });
            }
        });

    </script>
@endsection
