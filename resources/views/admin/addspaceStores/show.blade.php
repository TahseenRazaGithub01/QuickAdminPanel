@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.addspaceStore.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.addspace-stores.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.id') }}
                        </th>
                        <td>
                            {{ $addspaceStore->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.site') }}
                        </th>
                        <td>
                            @foreach($addspaceStore->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.horizontal_add_script') }}
                        </th>
                        <td>
                            {{ $addspaceStore->horizontal_add_script }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.vertical_add_script') }}
                        </th>
                        <td>
                            {{ $addspaceStore->vertical_add_script }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.stores') }}
                        </th>
                        <td>
                            @foreach($addspaceStore->stores as $key => $stores)
                                <span class="label label-info">{{ $stores->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.created_by') }}
                        </th>
                        <td>
                            {{ $addspaceStore->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.addspaceStore.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $addspaceStore->updated_by }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.addspace-stores.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection