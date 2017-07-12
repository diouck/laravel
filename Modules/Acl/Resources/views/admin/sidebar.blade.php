@section('sidebar')
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Tableau de bord</a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-users fa-fw"></i> Utilisateurs<span class="fa arrow"></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/user">Voir</a>
                    </li>
                    <li>
                        <a href="/admin/user/create">Créer</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-tasks fa-fw"></i> Applications<span class="fa arrow"></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/application">Voir</a>
                    </li>
                    <li>
                        <a href="/admin/application/create">Créer</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-legal fa-fw"></i> Rôles<span class="fa arrow"></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/role">Voir</a>
                    </li>
                    <li>
                        <a href="/admin/role/create">Créer</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-object-ungroup fa-fw"></i> Périmètres<span class="fa arrow"></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/perimeter">Voir</a>
                    </li>
                    <li>
                        <a href="/admin/perimeter/create">Créer</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-lock fa-fw"></i> Autorisations<span class="fa arrow"></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/authorization">Voir</a>
                    </li>
                    <li>
                        <a href="/admin/authorization/create">Créer</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </section>
</aside>
@stop