@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        @foreach($sites as $key => $site)
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex p-10 no-block">
                                            <div class="align-slef-center">
                                                <h6 class="text-muted m-b-0">
                                                    <a href="javascript:void(0)" onclick="setSiteId({{ $site->id ?? '' }})">{{ ucwords($site->name) ?? '' }}
                                                    </a>
                                                </h6>
                                            </div>
                                            <div class="align-self-center display-6 ml-auto">
                                                <i class="text-danger icon-Contrast"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height:3px;">
                                            <span class="sr-only">100% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setSiteId(id) {
        $.ajax({
            method: 'GET',
            url: '{{ URL('admin/set-id') }}',
            data: { id }})
            .done(function () {
                location.reload()
            })
    }
</script>
@endsection
@section('scripts')
@parent

@endsection
