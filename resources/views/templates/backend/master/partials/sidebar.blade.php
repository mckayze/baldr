<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="https://via.placeholder.com/50" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::user()->name }}
                            <span class="user-level">{{ Auth::user()->roles[0]->name }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="/admin/profile/own">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="/admin/settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                @can('View Dashboard Page')
                    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <a href="/admin/dashboard">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endcan
                @can('View All Users Page')
                    <li class="nav-item {{ Request::is('admin/users/*') ? 'active submenu' : '' }}">
                        <a data-toggle="collapse" href="#userpages" @if(Request::is('admin/users/*')) aria-expanded="true" @endif>
                            <i class="fas fa-users"></i>
                            <p>Users</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/users/*') ? 'show' : '' }}" id="userpages">
                            <ul class="nav nav-collapse">
                                @can('View All Users Page')
                                    <li class="{{ Request::is('admin/users/all') ? 'active' : '' }}">
                                        <a href="/admin/users/all">
                                            <span class="sub-item">
                                                All
                                            </span>
                                            <span class="badge badge-info pull-right">
                                                {{ count(\App\User::all()) }}
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Create Users')
                                    <li class="{{ Request::is('admin/users/create') ? 'active' : '' }}">
                                        <a href="/admin/users/create">
                                            <span class="sub-item">Create</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('View All Roles Page')
                    <li class="nav-item {{ Request::is('admin/roles/*') ? 'active submenu' : '' }}">
                        <a data-toggle="collapse" href="#rolespages" @if(Request::is('admin/roles/*')) aria-expanded="true" @endif>
                            <i class="fas fa-users-cog"></i>
                            <p>Roles</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/roles/*') ? 'show' : '' }}" id="rolespages">
                            <ul class="nav nav-collapse">
                                @can('View All Roles Page')
                                    <li class="{{ Request::is('admin/roles/all') ? 'active' : '' }}">
                                        <a href="/admin/roles/all">
                                            <span class="sub-item">
                                                All
                                            </span>
                                            <span class="badge badge-info pull-right">
                                                {{ count(\Spatie\Permission\Models\Role::all()) }}
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Create Role')
                                    <li class="{{ Request::is('admin/roles/create') ? 'active' : '' }}">
                                        <a href="/admin/roles/create">
                                            <span class="sub-item">Create</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('View All Roles Page')
                    <li class="nav-item {{ Request::is('admin/media/*') ? 'active submenu' : '' }}">
                        <a data-toggle="collapse" href="#mediamanagerpages" @if(Request::is('admin/roles/*')) aria-expanded="true" @endif>
                            <i class="fas fa-images"></i>
                            <p>Media</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/media/*') ? 'show' : '' }}" id="mediamanagerpages">
                            <ul class="nav nav-collapse">
                                @can('View Media Manager')
                                    <li class="{{ Request::is('admin/media/manager') ? 'active' : '' }}">
                                        <a href="/admin/media/manager">
                                            <span class="sub-item">Media Manager</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('View All Posts Page')
                    <li class="nav-item {{ Request::is('admin/posts/*') ? 'active submenu' : '' }}">
                        <a data-toggle="collapse" href="#postspages" @if(Request::is('admin/roles/*')) aria-expanded="true" @endif>
                            <i class="fas fa-thumb-tack"></i>
                            <p>Posts</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/posts/*') ? 'show' : '' }}" id="postspages">
                            <ul class="nav nav-collapse">
                                @can('View All Posts Page')
                                    <li class="{{ Request::is('admin/posts/all') ? 'active' : '' }}">
                                        <a href="/admin/posts/all">
                                            <span class="sub-item">All</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('Create Post')
                                    <li class="{{ Request::is('admin/posts/create') ? 'active' : '' }}">
                                        <a href="/admin/posts/create">
                                            <span class="sub-item">Create</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                {{--<li class="nav-section">--}}
							{{--<span class="sidebar-mini-icon">--}}
								{{--<i class="fa fa-ellipsis-h"></i>--}}
							{{--</span>--}}
                    {{--<h4 class="text-section">Snippets</h4>--}}
                {{--</li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a data-toggle="collapse" href="#custompages">--}}
                        {{--<i class="fas fa-paint-roller"></i>--}}
                        {{--<p>Custom Pages</p>--}}
                        {{--<span class="caret"></span>--}}
                    {{--</a>--}}
                    {{--<div class="collapse" id="custompages">--}}
                        {{--<ul class="nav nav-collapse">--}}
                            {{--<li>--}}
                                {{--<a href="login.html">--}}
                                    {{--<span class="sub-item">Login & Register 1</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
</div>