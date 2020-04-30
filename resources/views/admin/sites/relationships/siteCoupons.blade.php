@can('coupon_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.coupons.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.coupon.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.coupon.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Coupon">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.site') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.title') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.custom_image_title') }}
                    </th>
                    <th>
                        {{ trans('cruds.coupon.fields.store') }}
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
                <tbody>
                @foreach($coupons as $key => $coupon)
                    <tr data-entry-id="{{ $coupon->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $coupon->id ?? '' }}
                        </td>
                        <td>
                            @foreach($coupon->sites as $key => $item)
                                <span class="badge badge-info">{{ $item->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{ $coupon->title ?? '' }}
                        </td>
                        <td>
                            {{ $coupon->custom_image_title ?? '' }}
                        </td>
                        <td>
                            {{ $coupon->store->name ?? '' }}
                        </td>
                        <td>
                            <span style="display:none">{{ $coupon->publish ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $coupon->publish ? 'checked' : '' }}>
                        </td>
                        <td>
                            {{ $coupon->code ?? '' }}
                        </td>
                        <td>
                            @can('coupon_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.coupons.show', $coupon->id) }}">
                                    {{ trans('global.view') }}
                                </a>
                            @endcan

                            @can('coupon_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.coupons.edit', $coupon->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('coupon_delete')
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                @can('coupon_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.coupons.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[ 1, 'desc' ]],
                pageLength: 10,
            });
            $('.datatable-Coupon:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
