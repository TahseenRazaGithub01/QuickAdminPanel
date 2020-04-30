@can('page_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.pages.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.page.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.page.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Page">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.page.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.page.fields.site') }}
                        </th>
                        <th>
                            {{ trans('cruds.page.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.page.fields.publish') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $key => $page)
                        <tr data-entry-id="{{ $page->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $page->id ?? '' }}
                            </td>
                            <td>
                                @foreach($page->sites as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $page->title ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $page->publish ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $page->publish ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('page_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pages.show', $page->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('page_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pages.edit', $page->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('page_delete')
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('page_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.pages.massDestroy') }}",
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
  $('.datatable-Page:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
