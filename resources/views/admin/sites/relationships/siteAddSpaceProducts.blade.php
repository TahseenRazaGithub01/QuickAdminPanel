@can('add_space_product_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.add-space-products.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.addSpaceProduct.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.addSpaceProduct.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-AddSpaceProduct">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.site') }}
                        </th>
                        <th>
                            {{ trans('cruds.addSpaceProduct.fields.product') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addSpaceProducts as $key => $addSpaceProduct)
                        <tr data-entry-id="{{ $addSpaceProduct->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $addSpaceProduct->id ?? '' }}
                            </td>
                            <td>
                                @foreach($addSpaceProduct->sites as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($addSpaceProduct->products as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('add_space_product_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.add-space-products.show', $addSpaceProduct->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('add_space_product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.add-space-products.edit', $addSpaceProduct->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('add_space_product_delete')
                                    <form action="{{ route('admin.add-space-products.destroy', $addSpaceProduct->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('add_space_product_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.add-space-products.massDestroy') }}",
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

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  $('.datatable-AddSpaceProduct:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
