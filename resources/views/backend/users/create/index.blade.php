@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | Create User</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Create User</h2>
                        <h5 class="text-white op-7 mb-2">
                            Create new users to have access to this admin panel
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
                                <input v-model="newUser.username.value" type="text" class="form-control" placeholder="itsjaniedoe">
                                <small v-if="newUser.username.hasError" class="text-danger text-small">Username field must be filled in!</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Name</label>
                                <input v-model="newUser.name.value" type="text" class="form-control" placeholder="Janie Doe">
                                <small v-if="newUser.name.hasError" class="text-danger text-small">Name field must be filled in!</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Email Address</label>
                                <input v-model="newUser.email.value" type="email" class="form-control" placeholder="jane@doe.com">
                                <small v-if="newUser.email.hasError" class="text-danger text-small">Email address field must be filled in!</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Password</label>
                                <input v-model="newUser.password.value" type="text" class="form-control" placeholder="secret">
                                <small v-if="newUser.password.hasError" class="text-danger text-small">Password field must be filled in!</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Password Confirmation</label>
                                <input v-model="newUser.password_confirmation.value" type="text" class="form-control" placeholder="secret">
                                <small v-if="newUser.password_confirmation.hasError" class="text-danger text-small">Password Confirmation field must be filled in!</small>
                                <small v-if="newUser.password_confirmation.matchError" class="text-danger text-small">These password does not match!</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Role</label>
                                <select v-model="newUser.role.value" class="form-control">
                                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <small v-if="newUser.role.hasError" class="text-danger text-small">Roles field must be filled in!</small>
                            </div>
                            <div class="form-group col-12">
                                <button @click="createUser" class="btn btn-block btn-info">
                                    <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                                    Create User
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
                newUser: {
                    username: {
                        value: '',
                        hasError: false
                    },
                    name: {
                        value: '',
                        hasError: false
                    },
                    email: {
                        value: '',
                        hasError: false
                    },
                    password: {
                        value: '',
                        hasError: false
                    },
                    password_confirmation: {
                        value: '',
                        hasError: false,
                        matchError: false
                    },
                    role: {
                        value: 'Contributor',
                        hasError: false
                    },
                }
            },
            mounted(){
                toastr.options = {
                    positionClass: "toast-bottom-left",
                    showDuration: 1000,
                };
            },
            methods: {
                // Core
                createUser(){
                    this.userCheck();
                    let users = this.buildUsers();

                    this.loading = true;
                    axios.post('/admin/users/create', users).then((response) => {
                        this.loading = false;

                        switch(response.data.status){
                            case 500:
                                for(let error in response.data.errors)
                                {
                                    toastr.error(response.data.errors[error]);
                                }
                                break;
                            case 200:
                                toastr.success(response.data.statusText);

                                for(let item in this.newUser)
                                {
                                    if(item !== 'role')
                                    {
                                        this.newUser[item].value = '';
                                    }
                                }
                                break;
                        }
                    });
                },
                // Helpers
                userCheck(){
                    // Removes any current error messages before checking again
                    for(let item in this.newUser)
                    {
                        this.newUser[item].hasError = false;

                        if(item === 'password_confirmation')
                        {
                            this.newUser.password_confirmation.matchError = false;
                            return;
                        }
                    }

                    // Checks for any existing error messages
                    for(let item in this.newUser)
                    {
                        if(this.newUser[item].value === '')
                        {
                            this.newUser[item].hasError = true;
                            return;
                        }
                    }

                    // Checks passwords match on user create
                    if(this.newUser.password.value !== this.newUser.password_confirmation.value)
                    {
                        this.newUser.password_confirmation.matchError = true;
                        return;
                    }
                },
                buildUsers(){
                    return {
                        username: this.newUser.username.value,
                        name: this.newUser.name.value,
                        email: this.newUser.email.value,
                        password: this.newUser.password.value,
                        password_confirmation: this.newUser.password_confirmation.value,
                        role: this.newUser.role.value,
                    }
                }
            }
        })
    </script>
@stop