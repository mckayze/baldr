@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | Edit Role</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Edit Role</h2>
                        <h5 class="text-white op-7 mb-2">
                            Edit one of your roles
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group col-12">
                                <label>Role Name</label>
                                <input v-model="editRole.name" type="text" class="form-control" placeholder="newuserrole">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <div class="nav flex-column nav-pills nav-primary nav-pills-no-bd nav-pills-icons" id="v-pills-tab-with-icon" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active show mt-0" id="v-pills-home-tab-icons" data-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-home-icons" aria-selected="true">
                                            <i class="flaticon-home"></i>
                                            Dashboard
                                        </a>
                                        <a class="nav-link" id="v-pills-profile-tab-icons" data-toggle="pill" href="#v-pills-users" role="tab" aria-controls="v-pills-profile-icons" aria-selected="false">
                                            <i class="flaticon-user"></i>
                                            Users
                                        </a>
                                        <a class="nav-link" id="v-pills-profile-tab-icons" data-toggle="pill" href="#v-pills-roles" role="tab" aria-controls="v-pills-profile-icons" aria-selected="false">
                                            <i class="flaticon-user-5"></i>
                                            Roles
                                        </a>
                                        <a class="nav-link" id="v-pills-profile-tab-icons" data-toggle="pill" href="#v-pills-all" role="tab" aria-controls="v-pills-profile-icons" aria-selected="false">
                                            <i class="flaticon-internet"></i>
                                            All
                                        </a>
                                    </div>
                                </div>
                                <div class="col-8 col-md-9">
                                    <div class="tab-content" id="v-pills-with-icon-tabContent">
                                        @include('backend.roles.edit.partials.dashboard-tab')
                                        @include('backend.roles.edit.partials.users-tab')
                                        @include('backend.roles.edit.partials.roles-tab')
                                        @include('backend.roles.edit.partials.all-tab')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group col-12">
                                <button @click="saveChanges" :disabled="editRole.name.trim() === ''" class="btn btn-block btn-warning">Save Changes</button>
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
            data: {
                permissions: [],
                editRole: {
                    id: '{{ Request::get('id') }}',
                    name: '',
                    permissions: []
                }
            },
            mounted() {
                toastr.options = {
                    positionClass: "toast-bottom-left",
                    showDuration: 1000,
                };

                this.getPermissions();
            },
            methods: {
                // Core
                getPermissions(){
                    axios.post('/admin/permissions/all').then((response) => {
                        console.log(response.data);

                        this.permissions = response.data;

                        setTimeout(() => {
                            this.getRole();
                            this.initListJS();
                        });
                    });
                },
                getRole(){
                    let data = {
                        id: this.editRole.id
                    };

                    axios.post('/admin/roles/get', data).then((response) => {
                        console.log(response.data.permissions);

                        this.editRole.name = response.data.name;
                        for(let i = 0; i < response.data.permissions.length; i++)
                        {
                            this.editRole.permissions.push(response.data.permissions[i].name);
                        }
                    });
                },
                togglePermission(permission){
                    for(let i = 0; i < this.editRole.permissions.length; i++)
                    {
                        if(this.editRole.permissions[i] === permission)
                        {
                            this.editRole.permissions.splice(i, 1);
                            return;
                        }
                    }

                    this.editRole.permissions.push(permission);
                },
                saveChanges(){
                    if(this.editRole.name === '')
                    {
                        toastr.error('The roles name field must be filled in');
                        return;
                    }

                    axios.post('/admin/roles/edit', this.editRole).then((response) => {
                        console.log(response.data);
                        switch(response.data.status){
                        case 500:
                            for(let error in response.data.errors)
                            {
                                toastr.error(response.data.errors[error]);
                            }
                            break;
                        case 200:
                            toastr.success(response.data.statusText);
                            break;
                        }
                    });
                },

                // Helpers
                checkExists(permission){
                    for(let i = 0; i < this.editRole.permissions.length; i++)
                    {
                        if(this.editRole.permissions[i] === permission)
                        {
                            return true;
                        }
                    }

                    return false;
                },
                initListJS(){
                    let dashboardList = new List('dashboard-list', {valueNames: ['name']});
                    let usersList     = new List('users-list', {valueNames: ['name']});
                    let rolesList     = new List('roles-list', {valueNames: ['name']});
                    let allList       = new List('all-list', {valueNames: ['name']});
                }
            }
        })
    </script>
@stop