<template>
    <div class="modal fade" id="renameModal" tabindex="-1" role="dialog" aria-labelledby="renameModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rename Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input @keydown.enter="renameItem" @keyup="formatName" v-model="newName" type="text" class="form-control" :placeholder="selectedName">
                    <small class="small-descriptive-text">
                        Renamed items will automatically have their names stripped of all blank spaces and be replaced
                        with an underscore '_'
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click="renameItem" type="button" class="btn btn-primary">Rename Item</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            selected: Array
        },
        data() {
            return {
                newName: ''
            }
        },
        mounted() {
            console.log('RenameModal Mounted Successfully.');
        },
        methods: {
            // Core
            renameItem(){
                // Decide whether keeping this is viable, removes all leading / trailing '_'.
                // if(this.newFolderName.replace(/^_+|_+$/g, '') === '')
                if(this.newName === '')
                {
                    return;
                }

                this.$emit('renameItem', this.newName);
                this.newName = '';
                $('#renameModal').modal('hide');
            },

            // Helpers
            formatName()
            {
                this.newName = this.newName.replace(/ /g,"_");
            },
        },
        computed:{
            selectedName(){
                return (this.selected.length !== 0) ? this.selected[0].name.replace('.'+this.selected[0].extension, '') : '';
            }
        }
    }
</script>