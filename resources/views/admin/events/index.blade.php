@extends('layouts.admin')
@section('content')
    @can('event_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-8">
                <a class="btn btn-success" href="{{ route("admin.events.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.event.title_singular') }}
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
            {{ trans('cruds.event.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive" id="datatable-Event">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.event.fields.site') }}
                            </th>
                            <th>
                                {{ trans('cruds.event.fields.title') }}
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
        $url = isset(request()->test_id) ? route('admin.events.index') . '?test_id=1' : route('admin.events.index');
        if(isset(request()->eid) && isset(request()->test_id)) {
            $url = $url . "&eid=" . request()->eid;
        } elseif (isset(request()->eid)) {
            $url = $url . "?eid=" . request()->eid;
        }
    @endphp
    <script>
        console.log($('#stores option').val() + 1)
        $('#stores').val($('#stores option').val() + 1).trigger('change.select2')
        var url = "{{ $url }}";
        url = url.replace(/&amp;/g, '&');

        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('event_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.events.massDestroy') }}",
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
                        {data: 'actions', name: '{{ trans('global.actions') }}'}
                    ],
                    order: [[2, 'asc']],
                    pageLength: 10,
                    destroy: true
                };

            $('.datatable-Event').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            document.getElementById('siteOpt').onchange = function () {
                $("#datatable-Event").html("");
                $("#datatable-Event").html(`
                        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Event">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.event.fields.site') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.event.fields.title') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    `);

                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('event_delete')
                    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                    let deleteButton = {
                        text: deleteButtonTrans,
                        url: "{{ route('admin.events.massDestroy') }}",
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
                            {data: 'actions', name: '{{ trans('global.actions') }}'}
                        ],
                        order: [[ 2, 'asc' ]],
                        pageLength: 10,
                        destroy: true
                    };

                $('.datatable-Event').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                    $($.fn.dataTable.tables(true)).DataTable()
                        .columns.adjust();
                });
            }

        });

    </script>
@endsection
