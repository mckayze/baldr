@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | All Posts</title>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">All Posts</h2>
                        <h5 class="text-white op-7 mb-2">
                            An overview of your websites blog posts
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
                                <a href="/admin/posts/create" class="btn btn-success">
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
                                <table id="posts-table" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <input :checked="allSelected" @click="toggleAll" type="checkbox">
                                            </th>
                                            <th>Title</th>
                                            <th>Subtitle</th>
                                            <th>User</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            @can('Edit Posts')
                                            <th>Actions</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="post in posts">
                                            <td>
                                                <input :checked="isSelected(post)" @click="toggleSelected(post)" type="checkbox">
                                            </td>
                                            <td>@{{ post.title }}</td>
                                            <td>@{{ post.subtitle }}</td>
                                            <td>@{{ post.user.name }}</td>
                                            <td>@{{ post.category }}</td>
                                            <td>@{{ post.status }}</td>
                                            @can('Edit Posts')
                                            <td>
                                                <a :href="'/admin/posts/edit?id='+post.id" class="btn btn-warning">
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

    {{--@include('backend.posts.all.partials.edit-role-modal')--}}
@stop

@section('javascript')
    <script>
        new Vue({
            el: '.main-panel',
            data: {
                posts: [],
                selectedRows: [],
                editUserRoles: 'Administrator'
            },
            mounted() {
                this.getPosts();
                toastr.options = {
                    positionClass: "toast-bottom-left",
                    showDuration: 1000,
                };
            },
            methods: {
                // Core
                getPosts(){
                    axios.post('/admin/posts/all').then((response) => {
                        this.posts = response.data;
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
                        this.selectedRows = $.extend(true,[], this.posts);
                    }
                },
                editRoles(){
                    if(this.containsFirstUser())
                    {
                        toastr.error('Cannot edit the role of the first post!');
                        return;
                    }

                    let data = {
                        posts: this.selectedRows,
                        role: this.editUserRoles
                    };

                    axios.post('/admin/posts/roles/edit', data).then((response) => {
                        console.log(response.data);
                        if(response.data.status === 200)
                        {
                            this.getPosts();
                            this.selectedRows = [];
                            $('#editRoleModal').modal('hide');
                        }
                    });
                },

                // Helpers
                initDatatable(){
                    $('#posts-table').dataTable();
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
                    if(this.selectedRows.length === this.posts.length)
                    {
                        return true;
                    }

                    return false;
                },
            }
        })
    </script>
@stop