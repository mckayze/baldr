@extends('templates.backend.master.index')

@section('head')
    <title>{{ env('APP_NAME') }} | Create Post</title>
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .hidden {
            display: none !important;
        }
    </style>
@stop

@section('content')
    <div class="container">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Create Post</h2>
                        <h5 class="text-white op-7 mb-2">
                            Create a new post or draft here
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-inner mt--5">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Post Title <span class="text-danger"><strong>*</strong></span></label>
                                        <input v-model="newPost.title" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Post Subtitle</label>
                                        <input v-model="newPost.subtitle" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Post Content</label>
                                        <div id="summernote"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <a @click="createPost" href="javascript:void(0);" class="btn btn-block btn-info">
                                            Publish Post
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- Details -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">URL Slug</label>
                                <input v-model="newPost.url_slug" type="text" class="form-control" placeholder="my-custom-post-slug-2019">
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select v-model="newPost.status" name="" id="" class="form-control">
                                    <option value="published">Published</option>
                                    <option value="pending">Pending</option>
                                    <option value="draft">Draft</option>
                                    <option value="scheduled">Scheduled</option>
                                </select>
                            </div>
                            <div :class="{ hidden: !isScheduledPost, 'form-group': true }">
                                <label>Scheduled Date</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="post-date" name="datepicker">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <label>Scheduled Time</label>
                                <div class="input-group">
                                    <input v-model="newPost.scheduled_time" type="text" class="form-control" id="post-time" name="timepicker">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Categories</label>
                                <select v-model="newPost.category" name="" id="" class="form-control">
                                    <option value="" selected disabled>Select a category</option>
                                    <option value="1">Category 1</option>
                                    <option value="2">Category 2</option>
                                    <option value="3">Category 3</option>
                                    <option value="4">Category 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Featured Image -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Featured Image</h3>
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button click="openMediaModal('featured-image')" class="btn btn-outline-primary" type="button">Choose</button>
                                </div>
                                <input v-model="newPost.featured_image" type="text" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                            <div class="input-group">
                                <img :src="newPost.featured_image" alt="" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                    <!-- SEO -->
                    <div class="card">
                        <div class="card-header">
                            <h3>SEO</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">SEO Title</label>
                                <input v-model="newPost.seo_title" type="text" class="form-control" placeholder="my-custom-post-slug-2019">
                            </div>
                            <div class="form-group">
                                <label for="">Meta Keywords</label>
                                <textarea v-model="newPost.meta_keywords" type="text" class="form-control" placeholder="new,post,idea,games" style="resize: vertical;"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Meta Description</label>
                                <textarea v-model="newPost.meta_description" type="text" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <media-modal @item-chosen="handleItem"></media-modal>
    </div>
@stop

@section('javascript')
    <script src="/js/app.js"></script>
    <script>
        new Vue({
            el: '.main-panel',
            data: {
                imageFor: '',
                loading: false,
                newPost: {
                    title:'title',
                    subtitle: 'subtitle',
                    content: 'content',
                    url_slug: 'url_slug',
                    status: 'scheduled',
                    scheduled_date: moment().format('DD/MM/YYYY'),
                    scheduled_time: moment().add(1, 'hours').format('HH:mm'),
                    category: '1',
                    featured_image: '',
                    seo_title: '',
                    meta_description: '',
                    meta_keywords: '',
                }
            },
            mounted(){
                this.initializeSummernote();
            },
            methods: {
                // Core
                createPost(){
                    this.loading = true;

                    this.newPost.content = $('#summernote').summernote('code');

                    axios.post('/admin/posts/create', this.newPost).then((response) => {
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
//                                for(let item in this.newPost)
//                                {
//                                    if(item !== 'role')
//                                    {
//                                        this.newPost[item].value = '';
//                                    }
//                                }
                                break;
                        }
                    });
                },
                handleItem(item){
                    $('#media-manager-modal').modal('hide');

                    switch(this.imageFor)
                    {
                        case 'post-content':
                            $('#summernote').summernote('insertImage', item.path.replace('public/', '/storage/'), item.name);
                            break;
                        case 'featured-image':
                            this.newPost.featured_image = item.path.replace('public/', '/storage/');
                            break;
                    }
                },

                // Helpers
                initializeSummernote(){
                    let dissun = this;
                    let MediaManagerButton = (context) => {
                        let ui = $.summernote.ui;

                        // create button
                        let button = ui.button({
                            contents: '<i class="fas fa-images"/> Media Manager',
                            tooltip: 'Media Manager',
                            container: false,
                            click: function () {
                                // invoke insertText method with 'hello' on editor module.
//                                context.invoke('editor.insertText', 'hello');
                                dissun.openMediaModal('post-content')
                            }
                        });

                        return button.render();   // return button as jquery object
                    };

                    $('#summernote').summernote({
                        height: '250px',
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                            ['custom', ['mediaManager']]
                        ],

                        buttons: {
                            mediaManager: MediaManagerButton()
                        }
                    });

                    setTimeout(() => {
                        this.initializeDatetimePicker();
                    })
                },
                initializeDatetimePicker(){
                    let dissun = this;

                    $('#post-date').datetimepicker({
                        defaultDate: moment(),
                        format: 'DD/MM/YYYY',
                        minDate: new Date(),
                    });
                    $('#post-time').datetimepicker({
                        defaultDate: moment().add(1, 'hours'),
                        format: 'HH:mm',
                        minDate: new Date(),
                    });

                    $('#post-date').on('dp.change', function(){
                        dissun.newPost.scheduled_date = $(this).val();
                    });
                    $('#post-time').on('dp.change', function(){
                        dissun.newPost.scheduled_time = $(this).val();
                    });
                },
                openMediaModal(forItem){
                    console.log('sad');
                    $('#media-manager-modal').modal('show');
                    this.imageFor = forItem;
                }
            },
            computed: {
                isScheduledPost(){
                    return this.newPost.status === 'scheduled';
                }
            }
        })
    </script>
@stop