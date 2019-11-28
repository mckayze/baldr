@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | All Post Categories</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">All Post Categories</h2>
                        <h5 class="text-white op-7 mb-2">
                            An overview of your blog posts categories
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
                            @can('Create Posts')
                                <a href="/admin/posts/categories/create" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                    Create
                                </a>
                            @endcan

                            {{--@can('Delete Posts')--}}
                            {{--<button :disabled="selectedRows.length < 1" class="btn btn-danger pull-right">--}}
                            {{--<i class="fas fa-trash"></i>--}}
                            {{--Delete--}}
                            {{--</button>--}}
                            {{--@endcan--}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="categories-table" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Posts With Category</th>
                                        @can('Edit Categories')
                                            <th>Actions</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-if="category.id !== 1" v-for="category in categories">
                                        <td>@{{ category.name }}</td>
                                        <td>@{{ category.description }}</td>
                                        <td>@{{ category.posts.length }}</td>
                                        <td>
                                            @can('Edit Categories')
                                                <a :href="'/admin/posts/categories/edit?id='+category.id" class="btn btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('Delete Categories')
                                                <a @click="toDelete = category" data-toggle="modal" data-target="#delete-modal" href="javascript:void(0);" class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
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

    @include('backend.posts.categories.all.partials.delete-modal')
@stop

@section('javascript')
    <script>
        new Vue({
            el: '.main-panel',
            data: {
                categories: [],
                toDelete: {}
            },
            mounted() {
                this.getCategories();
                toastr.options = {
                    positionClass: "toast-bottom-left",
                    showDuration: 1000,
                };
            },
            methods: {
                // Core
                getCategories(){
                    $('.table').DataTable().destroy();

                    axios.post('/admin/posts/categories/all').then((response) => {
                        this.categories = response.data;
                        setTimeout(() => {
                            this.initDatatable();
                        });
                    });
                },
                deleteCategory(){
                    axios.post('/admin/posts/categories/delete', this.toDelete).then((response) => {
                        console.log(response.data);
                        if(response.data.status === 200)
                        {
                            toastr.success(response.data.statusText, 'Success');

                            $('#delete-modal').modal('hide');

                            this.getCategories();
                        }
                    });
                },

                // Helpers
                initDatatable(){
                    $('#categories-table').dataTable();
                },
            }
        })
    </script>
@stop