@if(isset($viewCoupon))
    <a class="btn btn-xs btn-success" id="{{ "viewCoupon" . $row->id }}" href="{{ url('/admin/coupons?sid=' . encrypt($row->id)) }}">
        View Coupon
    </a>
@endif

@php
    $sid = request()->sid ? '?sid=' . request()->sid : '';
@endphp

@can($viewGate)
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id . $sid) }}">
        {{ trans('global.view') }}
    </a>
@endcan

@if(request()->sid)
    @can($editGate)
        <a class="btn btn-xs btn-info" href="{{ url('admin/coupons/' . $row->id . '/edit/' . $sid) }}">
            {{ trans('global.edit') }}
        </a>
    @endcan
@else
    @can($editGate)
        <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
            {{ trans('global.edit') }}
        </a>
    @endcan
@endif

@can($deleteGate)
    @php
        $url = isset(request()->test_id) ? route('admin.' . $crudRoutePart . '.destroy', $row->id . $sid) . '?test_id=1' : route('admin.' . $crudRoutePart . '.destroy', $row->id . $sid);
    @endphp

    <form action="{{ $url }}" id="{{ $crudRoutePart . $row->id }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
