@extends('layouts.admin')
@section('content')
    @can('category_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-8">
                <a class="btn btn-success" href="{{ route("admin.categories.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.category.title_singular') }}
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
            {{ trans('cruds.category.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive" id="datatable-Category">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Category">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.category.fields.site') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.title') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.sort') }}
                            </th>
                            <th>
                                {{ trans('cruds.category.fields.publish') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    @php
        $url = isset(request()->test_id) ? route('admin.categories.index') . '?test_id=1' : route('admin.categories.index');
        if(isset(request()->cid) && isset(request()->test_id)) {
            $url = $url . "&cid=" . request()->cid;
        } elseif (isset(request()->cid)) {
            $url = $url . "?cid=" . request()->cid;
        }
    @endphp
    <script>

        var url = "{{ $url }}";
        url = url.replace(/&amp;/g, '&');

        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('category_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.categories.massDestroy') }}",
                    className: 'btn-danger',
                    action: function (e, dt, node, config) {
                        var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
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
                                data: {ids: ids, _method: 'DELETE'}
                            })
                                .done(function () {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: false,
                    aaSorting: [],
                    ajax: url,
                    columns: [
                        {data: 'placeholder', name: 'placeholder'},
                        {data: 'site', name: 'sites.name'},
                        {data: 'title', name: 'title'},
                        {data: 'sort', name: 'sort'},
                        {data: 'publish', name: 'publish'},
                        {data: 'actions', name: '{{ trans('global.actions') }}'}
                    ],
                    order: [[ 2, 'asc' ]],
                    pageLength: 10,
                    destroy: true
                };

            $('.datatable-Category').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            document.getElementById('siteOpt').onchange = function () {
                $("#datatable-Category").html("");
                $("#datatable-Category").html(`
                        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Category">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.category.fields.site') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.category.fields.title') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.category.fields.sort') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.category.fields.publish') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    `);

                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('category_delete')
                    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                    let deleteButton = {
                        text: deleteButtonTrans,
                        url: "{{ route('admin.categories.massDestroy') }}",
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
                        retrieve: false,
                        aaSorting: [],
                        ajax: {
                            "url": url,
                            "data": {
                                "siteId": $(this).val()
                            }
                        },
                        columns: [
                            {data: 'placeholder', name: 'placeholder'},
                            {data: 'site', name: 'sites.name'},
                            {data: 'title', name: 'title'},
                            {data: 'sort', name: 'sort'},
                            {data: 'publish', name: 'publish'},
                            {data: 'actions', name: '{{ trans('global.actions') }}'}
                        ],
                        order: [[ 2, 'asc' ]],
                        pageLength: 10,
                        destroy: true
                    };

                $('.datatable-Category').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });
            }

        });

    </script>
@endsection
