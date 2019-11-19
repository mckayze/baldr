<template>
    <div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Move Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">
                        Where would you like to move the selected items to?
                    </p>
                    <select class="form-control select2">
                        <option v-for="directory in directories" :value="directory.path">
                            <span v-html="directory.name"></span>
                        </option>
                    </select>
                    <br>
                    <small class="small-descriptive-text">
                        FileManager will attempt to move the selected files to the new chosen path. If you selected
                        multiple items to move and some items were unable to move, FileManager will move the files that
                        are available to move while leaving those that weren't.
                    </small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click="moveItems" type="button" class="btn btn-primary">Move Items</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            directories: Array,
        },
        data() {
            return {
                desired_path: 'public'
            }
        },
        mounted() {
            this.initializeSelect2();
            console.log('MoveModal Mounted Successfully.');
        },
        methods: {
            // Core
            moveItems(){
                this.$emit('moveItems', this.desired_path);
                $('#moveModal').modal('hide');
            },
            initializeSelect2(){
                let dissun = this;
                $('.select2').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $('#moveModal')
                });

                $('.select2').on('select2:select', function (e) {
                    dissun.desired_path = e.params.data.id;
                });
            },
        },
        computed: {

        },
    }
</script>