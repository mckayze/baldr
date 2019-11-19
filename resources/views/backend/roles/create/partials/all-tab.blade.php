<div class="tab-pane fade" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-home-tab-icons">
    <div id="all-list">
        <input class="search form-control" placeholder="Search" />

        <br>

        <ul class="list list-group list-group-bordered">
            <li v-for="permission in permissions.dashboard" class="list-group-item d-flex justify-content-between align-items-center">
                <span class="name">@{{ permission.name }}</span>
                <input :checked="checkExists(permission.name)" @click="togglePermission(permission.name)" type="checkbox">
            </li>
            <li v-for="permission in permissions.users" class="list-group-item d-flex justify-content-between align-items-center">
                <span class="name">@{{ permission.name }}</span>
                <input :checked="checkExists(permission.name)" @click="togglePermission(permission.name)" type="checkbox">
            </li>
            <li v-for="permission in permissions.roles" class="list-group-item d-flex justify-content-between align-items-center">
                <span class="name">@{{ permission.name }}</span>
                <input :checked="checkExists(permission.name)"@click="togglePermission(permission.name)" type="checkbox">
            </li>
        </ul>
    </div>
</div>