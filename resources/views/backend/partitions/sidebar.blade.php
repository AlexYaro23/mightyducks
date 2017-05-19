<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('admin.team') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.teams') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.users') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.roles') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.roles') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.players') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.players') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.games') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.games') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.stats') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.stats') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.results') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.results') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.tournaments') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.tournaments') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.leagues') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.leagues') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.visits') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.visits') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.trainings') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.trainings') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.trainingvisits') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('backend.menu.training_visits') }}</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->