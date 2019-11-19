<template>
    <div id="media-manager-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <media-manager :isModal="true" @selectedSingleItem="emitSelectedItem"></media-manager>
            </div>
        </div>
    </div>
</template>

<script>

    import MediaManager from '../manager/MediaManager.vue'

    export default {
        data() {
            return {

            }
        },
        mounted() {
            console.log('Component Mounted Successfully.');
        },
        methods: {
            emitSelectedItem(item){
                this.$emit('item-chosen', item)
            }
        },
        components: {
            mediaManager: MediaManager,
        }
    }
</script>

<style scoped>
    .modal-xl {
        max-width: 90% !important;
    }
</style>