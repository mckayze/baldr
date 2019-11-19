<script src="/backend/themes/atlantis/default/js/core/jquery.3.2.1.min.js"></script>
<script src="/backend/themes/atlantis/default/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="/backend/themes/atlantis/default/js/core/popper.min.js"></script>
<script src="/backend/themes/atlantis/default/js/core/bootstrap.min.js"></script>
<script src="/backend/themes/atlantis/default/js/atlantis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script>
    new Vue({
        el: '.wrapper',
        data: {
            login: {
                email: {
                    value: 'admin@admin.com',
                    hasError: false
                },
                password: {
                    value: 'password',
                    hasError: false
                },
            },
            loading: false
        },
        mounted() {
            console.log('working');
        },
        methods: {
            postLogin(){
                // Reset errors
                this.login.email.hasError = false;
                this.login.password.hasError = false;

                // Check basic information has been submitted
                if(!this.login.email.value || !this.login.password.value)
                {
                    return;
                }

                // Start loading
                this.loading = true;

                // Post data / handle response
                axios.post('/admin/login', this.login).then((response) => {
                    if(response.data.status === 404)
                    {
                        if(response.data.emailError)
                        {
                            this.login.email.hasError = true;
                            this.loading = false;
                            return;
                        }

                        if(response.data.passwordError)
                        {
                            this.login.password.hasError = true;
                            this.loading = false;
                            return;
                        }
                    }

                    // Redirect to dashboard
                    window.location.href = '/admin/dashboard';
                });
            }
        }
    })
</script>