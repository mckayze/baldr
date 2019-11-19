<!-- Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select v-model="editUserRoles" name="" id="" class="form-control">
                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <br>

                <div class="container">
                    <p>You are about to change the following account/s to the above selected role, are you sure?</p>
                </div>

                <table class="table table-sm table-bordered">
                    <tr v-for="item in selectedRows">
                        <td>@{{ item.username }}: <strong :class="item.id === 1 ? 'text-danger': '' ">@{{ item.roles[0].name }}</strong></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button @click="editRoles" type="button" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
</div>