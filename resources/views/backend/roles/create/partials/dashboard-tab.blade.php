<div class="tab-pane fade active show" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-home-tab-icons">
    <div id="dashboard-list">
        <input class="search form-control" placeholder="Search" />

        <br>

        <ul class="list list-group list-group-bordered">
            <li v-for="permission in permissions.dashboard" class="list-group-item d-flex justify-content-between align-items-center">
                <span class="name">@{{ permission.name }}</span>
                <input :checked="checkExists(permission.name)" @click="togglePermission(permission.name)" type="checkbox">
            </li>
        </ul>
    </div>
</div>