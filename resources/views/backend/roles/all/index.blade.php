@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | All Roles</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">All Roles</h2>
                        <h5 class="text-white op-7 mb-2">
                            An overview of all roles for users
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="/admin/roles/create" class="btn btn-success">
                                <i class="fas fa-plus"></i>
                                Create
                            </a>

                            {{--<button class="btn btn-danger pull-right">--}}
                                {{--<i class="fas fa-trash"></i>--}}
                                {{--Delete--}}
                            {{--</button>--}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="roles-table" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Users With Role</th>
                                        <th>Permissions</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ count($role->users) }}</td>
                                                <td>
                                                    @if($role->name === 'Super Administrator')
                                                        All
                                                    @elseif($role->name === 'Custom')
                                                        Custom
                                                    @else
                                                        {{  count($role->getAllPermissions())}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($role->name !== 'Super Administrator' && $role->name !== 'Custom')
                                                        <a href="/admin/roles/edit?id={{ $role->id }}" class="btn btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        new Vue({
            el: '.container',
            data: {},
            mounted() {
                $('#roles-table').dataTable();
            },
            methods: {}
        })
    </script>
@stop