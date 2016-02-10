<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <span class="copyright">Copyright &copy; {{ $teamData->name }} {{ date('Y', time()) }}</span>
            </div>
            <div class="col-md-4">
                <ul class="list-inline social-buttons">
                    <li><a href="{{ $teamData->link }}"><i class="fa fa-life-ring"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 pull-right">
                <ul class="list-inline quicklinks">
                    <li>
                        <a href="http://vk.com/mls_od_ua" target="_blank">
                            <img src="{{ asset('/img/vk-logo.jpeg') }}" height="40px">
                        </a>
                    </li>
                    <li class="mls-logo">
                        <a href="http://mls.od.ua/" target="_blank">
                            <img src="{{ asset('/img/mls-logo.png') }}" height="40px">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>