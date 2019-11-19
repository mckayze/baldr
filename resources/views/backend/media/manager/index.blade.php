@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | Media Manager</title>
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Media Manager</h2>
                        <h5 class="text-white op-7 mb-2">
                            Manage all your site media from here.
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-12">
                    <media-manager></media-manager>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="/js/app.js"></script>
    <script>
        new Vue({
            el: '.main-panel',
            data: {},
            mounted() {
                console.log('mounted');
            },
            methods: {
                
            }
        })
    </script>
@stop