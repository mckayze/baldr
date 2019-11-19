<template>
    <div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create A New Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input @keydown.enter="createFolder" @keyup="formatName" v-model="newFolderName" type="text" class="form-control" placeholder="folder_name">
                    <small class="small-descriptive-text">
                        New folder names will automatically have their names stripped of all blank spaces and be replaced
                        with an underscore '_'
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click="createFolder" type="button" class="btn btn-primary">Create Folder</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                newFolderName: ''
            }
        },
        mounted() {
            console.log('NewFolderModal Mounted Successfully.');
        },
        methods: {
            // Core
            createFolder(){
                // Decide whether keeping this is viable, removes all leading / trailing '_'.
                // if(this.newFolderName.replace(/^_+|_+$/g, '') === '')
                if(this.newFolderName === '')
                {
                    return;
                }

                this.$emit('createFolder', this.newFolderName);
                this.newFolderName = '';
                $('#newFolderModal').modal('hide');
            },

            // Helpers
            formatName()
            {
                this.newFolderName = this.newFolderName.replace(/ /g,"_");
            },
        }
    }
</script>