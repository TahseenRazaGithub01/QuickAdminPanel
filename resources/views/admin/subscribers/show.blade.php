@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Subscriber Title
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscribers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            Subscriber ID
                        </th>
                        <td>
						{{ $subscriber['id'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email
                        </th>
                        <td>
                            {{ $subscriber['email'] }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Page Link
                        </th>
                        <td>
                            http://127.0.0.1:8000/us
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Longitude
                        </th>
                        <td>
                            89.2323232323
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Latitude
                        </th>
                        <td>
                            90.32323232211
                        </td>
                    </tr>
					<tr>
                        <th>
                            Country
                        </th>
                        <td>
                            PK
                        </td>
                    </tr>
					<tr>
                        <th>
                            City
                        </th>
                        <td>
                            Karachi
                        </td>
                    </tr>
					<tr>
                        <th>
                            Ip
                        </th>
                        <td>
                            198.0.0.12
                        </td>
                    </tr>
					<tr>
                        <th>
                            Client Agent
                        </th>
                        <td>
                            Testing
                        </td>
                    </tr>
					<tr>
                        <th>
                            Site ID
                        </th>
                        <td>
                            1
                        </td>
                    </tr>

                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subscribers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection