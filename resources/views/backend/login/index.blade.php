<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend.login.partials.head')
</head>

<body class="login">
    <div class="wrapper wrapper-login wrapper-login-full p-0">
        <!-- Left Side Image -->
        <div class="login-aside login-background w-50 d-flex flex-column align-items-center justify-content-center text-center bg-secondary-gradient"></div>

        <!-- Right Side Login Form -->
        <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
            <div class="container container-login container-transparent animated fadeIn">
                <h3 class="text-center">Sign In To Admin Panel</h3>
                <div class="login-form">
                    <div class="form-group">
                        <label for="username" :class="['placeholder', (login.email.hasError) ? 'text-danger': '']"><b>Email</b></label>
                        <input v-model="login.email.value" id="username" name="username" type="text" class="form-control">
                        <small v-if="login.email.hasError" class="text-danger">That email has not been found!</small>
                    </div>
                    <div class="form-group">
                        <label for="password" :class="['placeholder', (login.password.hasError) ? 'text-danger': '']"><b>Password</b></label>
                        <div class="position-relative">
                            <input v-model="login.password.value" @keyup.enter="postLogin" id="password" name="password" type="password" class="form-control">
                            <small v-if="login.password.hasError" class="text-danger">Your password was invalid, please try again!</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <button @click="postLogin" :disabled="loading" class="btn btn-info btn-block fw-bold">
                            <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                            Sign In
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('backend.login.partials.javascript')
</body>
</html>