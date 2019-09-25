<nav class="navbar navbar-light bg-light">

    <form class="form-inline" method="post" action="">
        {{csrf_field()}}
        <input name="search_username" id="search_filed" class="form-control mr-sm-2" onchange="suggest()" type="text" placeholder="Search" aria-label="Search">
    </form>
    <a  class="navbar-brand" href="{{route('user.logout')}}">Logout</a>
</nav>