@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | All Users</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">All Users</h2>
                        <h5 class="text-white op-7 mb-2">
                            An overview of your websites users
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
                            @can('Create Users')
                                <a href="/admin/users/create" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Create
                                </a>
                            @endcan

                            @can('Edit Roles')
                                <button :disabled="selectedRows.length < 1" class="btn btn-warning" data-toggle="modal" data-target="#editRoleModal">
                                    <i class="fas fa-edit"></i>
                                    Edit Roles
                                </button>
                            @endcan

                            {{--@can('Delete Users')--}}
                                {{--<button :disabled="selectedRows.length < 1" class="btn btn-danger pull-right">--}}
                                    {{--<i class="fas fa-trash"></i>--}}
                                    {{--Delete--}}
                                {{--</button>--}}
                            {{--@endcan--}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="users-table" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input :checked="allSelected" @click="toggleAll" type="checkbox">
                                            </th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Role</th>
                                            <th>Posts</th>
                                            <th>Verified</th>
                                            <th>2FA</th>
                                            @can('Edit Users')
                                            <th>Actions</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users">
                                            <td>
                                                <input :checked="isSelected(user)" @click="toggleSelected(user)" type="checkbox">
                                            </td>
                                            <td>@{{ user.username }}</td>
                                            <td>@{{ user.name }}</td>
                                            <td>@{{ user.email }}</td>
                                            <td>@{{ user.roles[0].name }}</td>
                                            <td>0</td>
                                            <td>@{{ user.email_verified_at ? 'Yes' : 'No' }}</td>
                                            <td>No</td>
                                            @can('Edit Users')
                                            <td>
                                                <a :href="'/admin/users/edit?id='+user.id" class="btn btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            @endcan
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.users.all.partials.edit-role-modal')
@stop

@section('javascript')
    <script>
        new Vue({
            el: '.main-panel',
            data: {
                users: [],
                selectedRows: [],
                editUserRoles: 'Administrator'
            },
            mounted() {
                this.getUsers();
                toastr.options = {
                    positionClass: "toast-bottom-left",
                    showDuration: 1000,
                };
            },
            methods: {
                // Core
                getUsers(){
                    axios.post('/admin/users/all').then((response) => {
                        this.users = response.data;
                        setTimeout(() => {
                            this.initDatatable();
                        });
                    });
                },
                toggleSelected(row){
                    for (let i=0; i < this.selectedRows.length; i++) {
                        if (this.selectedRows[i].id === row.id) {
                            this.selectedRows.splice(i, 1);
                            return;
                        }
                    }

                    this.selectedRows.push(row);
                },
                toggleAll(){
                    if(this.allSelected)
                    {
                        this.selectedRows = [];
                    } else {
                        this.selectedRows = $.extend(true,[], this.users);
                    }
                },
                editRoles(){
                    if(this.containsFirstUser())
                    {
                        toastr.error('Cannot edit the role of the first user!');
                        return;
                    }

                    let data = {
                        users: this.selectedRows,
                        role: this.editUserRoles
                    };

                    axios.post('/admin/users/roles/edit', data).then((response) => {
                        console.log(response.data);
                        if(response.data.status === 200)
                        {
                            this.getUsers();
                            this.selectedRows = [];
                            $('#editRoleModal').modal('hide');
                        }
                    });
                },

                // Helpers
                initDatatable(){
                    $('#users-table').dataTable();
                },
                isSelected(row) {
                    for (let i=0; i < this.selectedRows.length; i++) {
                        if (this.selectedRows[i].id === row.id) {
                            return true;
                        }
                    }

                    return false;
                },
                containsFirstUser(){
                    console.log(this.selectedRows);
                    for(let i=0;i<this.selectedRows.length;i++) {
                        if (this.selectedRows[i].id === 1) {
                            return true;
                        }
                    }

                    return false;
                }
            },
            computed:{
                allSelected(){
                    if(this.selectedRows.length === this.users.length)
                    {
                        return true;
                    }

                    return false;
                },
            }
        })
    </script>
@stop