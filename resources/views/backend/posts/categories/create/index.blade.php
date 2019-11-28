@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | Create Post Category</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Create Post Category</h2>
                        <h5 class="text-white op-7 mb-2">
                            Create new post categories to link with your posts
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
                                <label>Name</label>
                                <input v-model="newCategory.name" type="text" class="form-control" placeholder="Skincare, Computing, etc.">
                            </div>
                            <div class="form-group col-12">
                                <label>Description</label>
                                <textarea v-model="newCategory.description" type="text" class="form-control" placeholder="A short description about the category"></textarea>
                            </div>
                            <div class="form-group col-12">
                                <button @click="createPostCategory" class="btn btn-block btn-info">
                                    <i v-if="loading" class="fas fa-spinner fa-spin"></i>
                                    Create Category
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
                newCategory: {
                    name: '',
                    description: ''
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
                createPostCategory(){
                    this.loading = true;

                    axios.post('/admin/posts/categories/create', this.newCategory).then((response) => {
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

                                for(let item in this.newCategory)
                                {
                                    this.newCategory[item] = '';
                                }
                                break;
                        }
                    });
                },
            }
        })
    </script>
@stop