@section('sidebar')
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="/webmap/admin"><i class="fa fa-dashboard fa-fw"></i> Administration</a>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-users fa-fw"></i> Pôles commerciaux<span class="fa arrow"></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/webmap/admin/posts">Voir</a>
                    </li>
                    <li>
                        <a href="/webmap/admin/revisions">En attente</a>
                    </li>
                    <li>
                        <a href="/webmap/create">Créer</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="/webmap"><i class="fa fa-map fa-fw"></i>Revenir à la carte</a>
            </li>
        </ul>
    </section>
</aside>
@stop