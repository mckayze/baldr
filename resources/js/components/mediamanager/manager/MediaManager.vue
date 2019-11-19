<template>
    <div class="card mb-0">
        <div class="card-header">
            <div class="row">
                <div class="col-12">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a @click="openFileUpload" href="javascript:void(0);" class="btn btn-info text-white">
                            <i class="fa fa-upload"></i>
                            Upload
                        </a>

                        <input @change="uploadFiles" id="fileUploadForm" type="file" multiple style="display:none !important;">

                        <a href="javascript:void(0);" class="btn btn-info text-white" data-toggle="modal" data-target="#newFolderModal">
                            <i class="fa fa-folder"></i>
                            New Folder
                        </a>
                    </div>

                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button :disabled="noneSelected || multipleSelected" class="btn btn-warning text-white" data-toggle="modal" data-target="#renameModal">
                            <i class="fa fa-pencil"></i>
                            Rename
                        </button>
                        <button :disabled="noneSelected" class="btn btn-warning text-white" data-toggle="modal" data-target="#moveModal">
                            <i class="fa fa-arrow-right"></i>
                            Move
                        </button>
                        <button :disabled="noneSelected" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                            <i class="fa fa-trash"></i>
                            Delete
                        </button>
                    </div>

                    <a @click="getFilesAndFolders(current_path, true)" href="javascript:void(0);" class="btn btn-light">
                        <i class="fa fa-refresh"></i>
                        Refresh
                    </a>

                    <!--<a href="javascript:void(0);" class="btn btn-light">-->
                        <!--<i class="fa fa-download"></i>-->
                        <!--Download-->
                    <!--</a>-->
                </div>
            </div>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-for="(item, key) in paths" :class="['breadcrumb-item', (key === paths.length -1) ? 'active' : '']" aria-current="page">
                    <a class="breadcrumb-item-clickable" v-if="key !== paths.length -1" @click="getFilesAndFolders(item.path)" href="javascript:void(0);">
                        {{ item.name }}
                    </a>
                    <span v-else>
                        {{ item.name }}
                    </span>
                </li>
            </ol>
        </nav>
        <div class="card-body" style="min-height: 250px;">
            <div class="row">
                <div class="col-8 media-manager">
                    <div class="row">
                        <div v-for="directory in directories" class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                            <div class="card item-card" @click="toggleSelectNew(directory)" @dblclick="getFilesAndFolders(directory.path)">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <i class="fa fa-folder fa-3x"></i>
                                    </div>
                                    <div class="col-9" style="padding-top: 7px;">
                                        <h6 style="margin-bottom: 0 !important;overflow: hidden;white-space: nowrap; font-size: 14px;"><strong>{{ directory.name }}</strong></h6>
                                        <small style="font-size: 12px">{{ formatBytes(directory.size) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-for="file in files" class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                            <div class="card item-card" @click="toggleSelectNew(file)">
                                <div class="row">
                                    <div class="col-3">
                                        <i v-if="file.mime.includes('application')" class="fa fa-cog fa-3x"></i>
                                        <i v-else-if="file.mime.includes('audio')" class="fa fa-music fa-3x"></i>
                                        <i v-else-if="file.mime.includes('image')" class="fa fa-file-image-o fa-3x"></i>
                                        <i v-else-if="file.mime.includes('text')" class="fa fa-file-text-o fa-3x"></i>
                                        <i v-else-if="file.mime.includes('video')" class="fa fa-file-video-o fa-3x"></i>
                                        <i v-else class="fa fa-question"></i>
                                    </div>
                                    <div class="col-9" style="padding-top: 7px;">
                                        <h6 style="margin-bottom: 0 !important;overflow: hidden;white-space: nowrap; font-size: 14px;"><strong>{{ file.name }}</strong></h6>
                                        <small style="font-size: 12px">{{ formatBytes(file.size) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="files.length === 0 && directories.length === 0" class="col-12 d-flex justify-content-center">
                           <h1 style="color:darkgrey;">Nothing to see here...</h1>
                        </div>
                    </div>
                    <!--<table class="table table-hover">-->
                        <!--<thead v-if="files.length !== 0 || directories.length !== 0">-->
                        <!--<tr>-->
                            <!--<th scope="col">#</th>-->
                            <!--<th scope="col">Name</th>-->
                            <!--<th scope="col">Size</th>-->
                        <!--</tr>-->
                        <!--</thead>-->
                        <!--<tbody>-->
                            <!--<tr @click="toggleSelect(directory)" @dblclick="getFilesAndFolders(directory.path)" v-for="directory in directories" class="hoverable">-->
                                <!--<td><i class="fa fa-folder"></i></td>-->
                                <!--<td>{{ directory.name }}</td>-->
                                <!--<td>{{ formatBytes(directory.size) }}</td>-->
                            <!--</tr>-->
                            <!--<tr @click="toggleSelect(file)" v-for="file in files" class="hoverable">-->
                                <!--<td>-->
                                    <!--<i v-if="file.mime.includes('application')" class="fa fa-cog"></i>-->
                                    <!--<i v-else-if="file.mime.includes('audio')" class="fa fa-music"></i>-->
                                    <!--<i v-else-if="file.mime.includes('image')" class="fa fa-file-image-o"></i>-->
                                    <!--<i v-else-if="file.mime.includes('text')" class="fa fa-file-text-o"></i>-->
                                    <!--<i v-else-if="file.mime.includes('video')" class="fa fa-file-video-o"></i>-->
                                    <!--<i v-else class="fa fa-question"></i>-->
                                <!--</td>-->
                                <!--<td>{{ file.name }}</td>-->
                                <!--<td>{{ formatBytes(file.size) }}</td>-->
                            <!--</tr>-->
                            <!--<tr v-if="files.length === 0 && directories.length === 0">-->
                                <!--<td class="text-center">-->
                                    <!--<h3>NO FILES OR FOLDERS FOUND IN DIRECTORY</h3>-->
                                <!--</td>-->
                            <!--</tr>-->
                        <!--</tbody>-->
                    <!--</table>-->
                </div>
                <div class="col-4">
                    <div>
                        <img v-if="oneSelected && selected[0].mime.includes('image')" id="img-preview-picture" :src="currentPath" alt="" class="img-fluid">

                        <audio class="no-outline" v-if="oneSelected && selected[0].mime === 'audio/mpeg'" :src="currentPath" controls style="width:100%;">
                            Your browser does not support the audio element.
                        </audio>

                        <video class="no-outline" v-if="oneSelected && selected[0].mime == 'video/mp4'" :src="currentPath" controls></video>
                    </div>
                    <br>
                    <div class="img-preview-information">
                        <div v-if="oneSelected" style="font-size:12px;">
                            <div v-if="selected[0].mime === 'directory'" class="col-12 text-center" style="background: #f6f8f9;height: 210px;margin-top:-21px;display: table;">
                                <i class="fa fa-folder fa-5x" style="color:#76828F;display: table-cell;vertical-align: middle;"></i>
                            </div>
                            <br>
                            <p>
                                <span style="color:#BBBBBB;">Title:</span> {{ selected[0].name }}
                            </p>
                            <p>
                                <span style="color:#BBBBBB;">
                                    Type:
                                </span>
                                {{ selected[0].mime }}
                            </p>
                            <p>
                                <span style="color:#BBBBBB;">
                                    Size:
                                </span> {{ formatBytes(selected[0].size) }}
                            </p>
                            <p>
                                <span style="color:#BBBBBB;">
                                    Public URL:
                                </span><a :href="currentPath" target="_blank">
                                {{ selected[0].path.replace('public/', '/storage/') }}
                                </a>
                            </p>
                            <!--<p>-->
                                <!--<span style="color:#BBBBBB;">-->
                                    <!--Uploaded On:-->
                                <!--</span> 09/08/2018 12:27:21-->
                            <!--</p>-->
                        </div>
                        <h4 class="text-center card" v-else-if="multipleSelected">
                            <div class="col-12 text-center" style="background: #f6f8f9;height: 210px;margin-top:-21px;display: table;">
                                <i class="fa fa-files-o fa-5x" style="color:#76828F;display: table-cell;vertical-align: middle;"></i>
                                <h3 style="display:table-row;">
                                    {{ selected.length }} Files: {{ totalSelectedFileSize }}
                                </h3>
                            </div>
                        </h4>
                        <div v-else>
                            <div class="col-12 text-center" style="background: #f6f8f9;height: 210px;margin-top:-21px;display: table;">
                                <i class="fa fa-mouse-pointer fa-5x" style="color:#76828F;display: table-cell;vertical-align: middle;"></i>
                                <p style="display:table-row;">
                                    Nothing Selected
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isModal" class="card-footer">
            <button data-dismiss="modal" class="btn btn-danger">Cancel</button>
            <button :disabled="!oneFileSelected" @click="selectItem" class="btn btn-success">Select Image</button>
        </div>
        <new-folder-modal @createFolder="createFolder"></new-folder-modal>
        <delete-modal :selected="selected" @deleteFileFolder="deleteFileFolder"></delete-modal>
        <rename-modal :selected="selected" @renameItem="renameItem"></rename-modal>
        <move-modal :directories="everyDirectory" @moveItems="moveItems"></move-modal>
    </div>
</template>

<script>

    import NewFolderModal from '../modals/NewFolderModal.vue';
    import DeleteModal    from '../modals/DeleteModal.vue';
    import RenameModal    from '../modals/RenameModal.vue';
    import MoveModal      from '../modals/MoveModal.vue';

    export default {
        props: {
            isModal: Boolean
        },
        data() {
            return {
                paths: [],
                selected: [],
                current_path: '',
                files: [],
                directories: [],
                everyDirectory: [],
                pathPrefix: '/admin/media/manager'
            }
        },
        mounted() {
            console.log('Media Manager mounted successfully.');
            this.getFilesAndFolders();
        },
        methods: {
            //Core
            getFilesAndFolders(path, refreshed = false){
                this.clearSelected();
                axios.post(this.pathPrefix+'/get-files-folders', {path: path}).then((response) => {
                    this.paths        = response.data.paths;
                    this.files        = response.data.all_files;
                    this.directories  = response.data.all_directories;
                    this.current_path = response.data.current_path;
                    this.everyDirectory = response.data.every_directory;

                    if(refreshed)
                    {
                        toastr.success('Refreshed file manager', 'Success');
                    }
                });
            },
            uploadFiles(){
                let dissun = this;
                let uploadFormData = new FormData();
                let files = event.target.files;
                let errors = [];

                // Iterate through each file
                $.each(files, (index, file) => {
                    uploadFormData.append('files[]', file);
                });

                uploadFormData.append('current_path', this.current_path);

                for(let value in uploadFormData.values())
                {
                    console.log(value);
                }

                axios.post(this.pathPrefix+'/upload', uploadFormData).then(response => {
                    $('#fileUploadForm').val('');
                    dissun.getFilesAndFolders(dissun.current_path);
                    toastr.success('Uploaded file');
                });
            },
            createFolder(name){
                let data = {
                    name: name,
                    current_path: this.current_path
                };

                axios.post(this.pathPrefix+'/create-folder', data).then((response) => {
                    if(response.data.status === 500)
                    {
                        toastr.error(response.data.statusText, 'Error');
                        return;
                    }

                    this.getFilesAndFolders(this.current_path);
                    toastr.success('Created Folder','Success');
                });
            },
            renameItem(newName){
                let data = {
                    new_name: newName,
                    old_name: this.selected[0].name,
                    current_path: this.current_path
                };

                axios.post(this.pathPrefix+'/rename', data).then((response) => {
                    if(response.data.status === 500)
                    {
                        toastr.error(response.data.statusText, 'Error');
                        return;
                    }

                    if(response.data.status === 200)
                    {
                        this.getFilesAndFolders(this.current_path);
                        toastr.success('Renamed Item', 'Success');
                    }
                });
            },
            moveItems(desired_path){
                let data = {
                    selected: this.selected,
                    current_path: this.current_path,
                    desired_path: desired_path
                };
                axios.post(this.pathPrefix+'/move', data).then((response) => {
                    if(response.data.status === 500)
                    {
                        toastr.error(response.data.statusText, 'Whoops');
                    }

                    if(response.data.status === 200)
                    {
                        this.getFilesAndFolders(this.current_path);
                        toastr.success('Moved Item/s', 'Success');
                    }
                });
            },
            deleteFileFolder(){
                let data = {
                    selected: this.selected,
                    current_path: this.current_path
                };

                axios.post(this.pathPrefix+'/delete', data).then((response) => {
                    if(response.data.status === 200)
                    {
                        this.getFilesAndFolders(this.current_path);
                        toastr.success('Deleted Items', 'Success');
                    }
                });
            },
            selectItem(){
                this.$emit('selectedSingleItem', this.selected[0]);
            },

            //Helpers
            openFileUpload(){
                $('#fileUploadForm').click();
            },
            formatBytes(a,b){
                if(0===a)
                {
                    return"0 Bytes";
                }

                let c=1024,d=b || 2 , e=["Bytes","KB","MB","GB","TB","PB","EB","ZB","YB"], f=Math.floor(Math.log(a)/Math.log(c));
                return parseFloat((a/Math.pow(c,f)).toFixed(d))+" "+e[f]
            },
            toggleSelect(item){
                if(event.shiftKey)
                {
                    for (let i = 0; i < this.selected.length; i++) {
                        if (this.selected[i] === item) {
                            $(event.target.parentNode).toggleClass('selected');
                            this.selected.splice(i, 1);
                            return;
                        }
                    }
                } else {
                    this.clearSelected();
                }

                $(event.target.parentNode).toggleClass('selected');
                this.selected.push(item);
            },
            toggleSelectNew(item){
                if(event.shiftKey)
                {
                    for (let i = 0; i < this.selected.length; i++) {
                        if (this.selected[i] === item) {
                            $(event.target).closest('div[class^="card"]').toggleClass('selected');
                            this.selected.splice(i, 1);
                            return;
                        }
                    }
                } else {
                    this.clearSelected();
                }

                $(event.target).closest('div[class^="card"]').toggleClass('selected');
                this.selected.push(item);
            },
            clearSelected(){
                this.selected = [];
                $(".selected").each(function() {
                    $(this).toggleClass('selected');
                });
            },
            publicPath(url) {
                return url.replace('public', '/storage');
            }
        },
        computed: {
            totalSelectedFileSize(){
                let total = 0;

                for(let i=0;i<this.selected.length;i++)
                {
                    total += this.selected[i].size
                }

                return this.formatBytes(total);
            },
            noneSelected(){
                return this.selected.length === 0
            },
            oneSelected(){
                return this.selected.length === 1;
            },
            multipleSelected(){
                return this.selected.length > 1;
            },
            currentPath(){
                return this.selected[0].path.replace('public/', '/storage/');
            },
            oneFileSelected(){
                if(this.selected.length === 1 && this.selected[0].mime !== 'directory'){
                    return true
                }

                return false;
            }
        },
        components: {
            newFolderModal: NewFolderModal,
            deleteModal: DeleteModal,
            renameModal: RenameModal,
            moveModal: MoveModal,
        }
    }
</script>

<style scoped>
    .card-header {
        background-color: #E0DFE0!important;
        border-bottom: 0px !important;
    }
    .info-table-info,.hoverable>td {
        word-break: break-all;
    }

    .hoverable:hover{
        cursor:pointer;
    }

    .table {
        user-select: none;
    }
    .selected {
        color:white !important;
        background:#4da7e8 !important;
    }
    .border-right-light {
        border-right: 1px solid lightgrey;
    }
    .media-manager {
        max-height: 600px !important;
        /*overflow-y: auto;*/
    }
    .breadcrumb {
        border-radius: 0!important;
        padding: 0.5rem 1rem;
        background-color: #F0F0F0 !important;
    }
    .breadcrumb-item-clickable {
        transition: color 0.25s !important;
        color: #4da7e8 !important;
    }
    .breadcrumb-item-clickable:hover {
        transition: color 0.25s !important;
        color: black !important;
        text-decoration:none !important;
    }
    .breadcrumb-item + .breadcrumb-item::before{
        content: ">" !important;
        color: lightgray;
    }
    .item-card {
        color: #76828F;
        padding: 10px;
        cursor: pointer;
        margin-bottom: 15px;
        border-radius: 4px;
        border: 1px solid #ecf0f1;
        background: #f6f8f9;

        min-height: 70px;
        max-height: 70px;
        word-break: keep-all;
        user-select: none;
    }
    .item-card:hover {
        background: #4da7e8;
        color: white;
    }
    .card .card-header:first-child, .card-light .card-header:first-child {
        border-radius: 3px 3px 0 0 !important;
    }
</style>

<style>
    .small-descriptive-text {
        color: grey;
        font-style: italic;
    }
    .no-outline:focus {
        outline:none !important;
    }
</style>