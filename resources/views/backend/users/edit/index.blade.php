@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | Edit User</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Edit User</h2>
                        <h5 class="text-white op-7 mb-2">
                            Edit one of your existing users
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group col-12">
                                <label>Username</label>
                                <input v-model="editUser.username" type="text" class="form-control" placeholder="itsjaniedoe">
                            </div>
                            <div class="form-group col-12">
                                <label>Name</label>
                                <input v-model="editUser.name" type="text" class="form-control" placeholder="Janie Doe">
                            </div>
                            <div class="form-group col-12">
                                <label>Email Address</label>
                                <input v-model="editUser.email" type="email" class="form-control" placeholder="jane@doe.com">
                            </div>
                            <div class="form-group col-12">
                                <label>Password</label>
                                <input v-model="editUser.password" type="text" class="form-control" placeholder="secret">
                                <small style="font-size: 10px;color:grey;">Only fill in this password field if you intend to change the password.</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Password Confirmation</label>
                                <input v-model="editUser.password_confirmation" type="text" class="form-control" placeholder="secret">
                            </div>
                            @if(Request::get('id') != 1)
                                <div class="form-group col-12">
                                    <label>Role</label>
                                    <select v-model="editUser.role" class="form-control">
                                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div class="form-group col-12">
                                <button @click="postEdit" class="btn btn-block btn-warning">
                                    <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                                    Edit User
                                </button>
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
                loading: false,
                editUser: {
                    id: "{{ Request::get('id') }}",
                    username: '',
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role: ''
                }
            },
            mounted(){
                this.getUser();
            },
            methods: {
                // Core
                getUser(){
                    let data = {
                        id: this.editUser.id,
                    };

                    axios.post('/admin/users/get-by-id', data).then((response) => {
                        console.log(response.data);
                        this.editUser.username = response.data.username;
                        this.editUser.name = response.data.name;
                        this.editUser.email = response.data.email;
                        this.editUser.role = response.data.roles[0].name;
                    });
                },
                postEdit(){
                    this.loading = true;
                    axios.post('/admin/users/edit', this.editUser).then((response) => {
                        console.log(response.data);
                        this.loading = false;

                        toastr.options = {
                            positionClass: "toast-bottom-left",
                            showDuration: 1000,
                        };

                        switch(response.data.status){
                            case 500:
                                for(let error in response.data.errors)
                                {
                                    toastr.error(response.data.errors[error]);
                                }
                                break;
                            case 200:
                                toastr.success(response.data.statusText);

                                for(let item in this.editUser)
                                {
                                    if(item !== 'role')
                                    {
                                        this.editUser[item].value = '';
                                    }
                                }
                                break;
                        }
                    });
                },
                // Helpers
            }
        })
    </script>
@stop