<template>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Files & Folders</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        Are you sure you want to delete {{ (selected.length > 1) ? 'all' : '' }} the selected item{{ (selected.length > 1) ? 's' : '' }}?
                    </p>
                    <h4 class="text-center">
                        A total of <strong>{{ selected.length }}</strong> item{{ (selected.length > 1) ? 's' : '' }}
                    </h4>
                    <table class="table">
                        <tr v-for="item in selected">
                            <td>{{ item.name }}</td>
                        </tr>
                    </table>
                    <!--<hr>-->
                    <small class="small-descriptive-text text-danger">
                        Please double check highlighted files /folders and make sure you wish to delete all these
                        selected files / folders as this action is <strong><u>NOT</u></strong> reversible!
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click="deleteFileFolder" type="button" class="btn btn-danger">Delete Selected</button>
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
        mounted() {
            console.log('DeleteModal Mounted Successfully.');
        },
        methods: {
            // Core
            deleteFileFolder(){
                this.$emit('deleteFileFolder');
                $('#deleteModal').modal('hide');
            }
        }
    }
</script>

<style scoped>
    .table {
        word-break: break-all;
    }
</style>