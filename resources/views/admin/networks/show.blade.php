@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.network.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.networks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.id') }}
                        </th>
                        <td>
                            {{ $network->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.site') }}
                        </th>
                        <td>
                            @foreach($network->sites as $key => $site)
                                <span class="label label-info">{{ $site->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.name') }}
                        </th>
                        <td>
                            {{ $network->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.api_key') }}
                        </th>
                        <td>
                            {{ $network->api_key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.secret_key') }}
                        </th>
                        <td>
                            {{ $network->secret_key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.affiliate') }}
                        </th>
                        <td>
                            {{ $network->affiliate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.publish') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $network->publish ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.created_by') }}
                        </th>
                        <td>
                            {{ $network->created_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.network.fields.updated_by') }}
                        </th>
                        <td>
                            {{ $network->updated_by }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.networks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection