@extends('templates.backend.master.index')

@section('content')



    {{--<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">--}}
    {{--<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    {{--<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>--}}
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>--}}
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.4.0/lang/en-gb.js"></script>--}}
    {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js"></script>--}}

    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class='col-sm-6'>--}}
                {{--<div class="form-group">--}}
                    {{--<div class='input-group date' >--}}
                        {{--<input type='text' class="form-control"id='datetimepicker1' />--}}
                        {{--<span class="input-group-addon">--}}
                        {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                    {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<script type="text/javascript">--}}
                {{--$(function () {--}}
                    {{--$('#datetimepicker1').datetimepicker({--}}
{{--//                        format: 'DD/MM/YYYY H:i'--}}
                    {{--});--}}
                {{--});--}}
            {{--</script>--}}
        {{--</div>--}}
    {{--</div>--}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <input class="form-control" type="text" id="flatpickr">
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '.container',
            data: {},
            mounted() {
                $('#flatpickr').flatpickr({
                    format: 'DD/MM/YYYY'
                });
            },
            methods: {}
        })
    </script>
@stop