<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Administratora - SwiatRolnika.info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
          <script src="https://kit.fontawesome.com/1a73d2b916.js" crossorigin="anonymous"></script>

          <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <link href="https://swiatrolnika.info/images/favicon/favicon.ico" rel="shortcut icon" type="image/x-icon">

    <link href="{{asset('css/admin.css')}}" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/g7ts48kr5911y07rvlgt87tsw0wb1efyn1v27ondy84vp8po/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>

  <body>
    <nav class="m-0 p-0 navbar navbar-expand-lg">
      <div class="container-fluid mx-3">
        <a class="navbar-brand" href="/"><img src="{{ asset('storage/images/loga/sr-logo-biale.svg') }}" alt="logo" width="200" height="40"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <div class="dropdown">
            <button class="btn text-white dropdown-toggle" type="button" id="dropdownUserMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Witaj, {{Auth::user()->name}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownUserMenuButton" style="width: 100%;">
                {{-- <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a> --}}
                <span class="dropdown-item">
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        <button class="btn btn-link p-0 text-dark" type="submit" style="width: 100%;">Wyloguj</button>
                    </form>
                </span>

            </div>
        </div>
        </div>
    </div>
    </nav>
    <header id="header" class="container-fluid py-4">
            <h1 class="m-0"><i class="fas fa-cog mr-1"></i> {{$title}}</h1>
    </header>
    <section id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <div class="list-group">
              <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                @if(Auth::user()->CheckAccessForUser('administrator.dashboard'))
                  <li class="nav-item">
                    <a href="{{route('administrator.dashboard')}}" class="list-group-item d-flex {{(Route::is('administrator.dashboard')) ? 'active main-color-bg' : 'text-dark'}} ">
                      <div><i class="fas fa-cog mr-1"></i>Kokpit</div>
                    </a>
                  </li>
                @endif
                @if(Auth::user()->CheckAccessForUser('administrator.article.index') OR Auth::user()->CheckAccessForUser('administrator.article.create'))
                  <li class="nav-item">
                    <a href="#" data-toggle="collapse" data-target="#collapseArticles" aria-expanded="true" aria-controls="collapseArticles" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between {{(Route::is('administrator.article.*')) ? 'active main-color-bg' : 'text-dark'}}">
                      <div>
                        <i class="far fa-newspaper mr-1"></i>
                        Artykuły
                      </div>
                      <span class="badge badge-secondary ml d-flex align-items-center">{{$count['article']}}</span>
                    </a>
                  </li>
                  <div id="collapseArticles" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white collapse-inner rounded d-flex flex-column">
                      @if(Auth::user()->CheckAccessForUser('administrator.article.index'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.article.index') }}">Wszystkie</a>
                      @endif
                      @if(Auth::user()->CheckAccessForUser('administrator.article.create'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.article.create') }}">Utwórz nowy</a>
                      @endif
                    </div>
                  </div>
                @endif
                @if(Auth::user()->CheckAccessForUser('administrator.category.index') OR Auth::user()->CheckAccessForUser('administrator.category.create'))
                  <li class="nav-item">
                    <a href="#" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between {{(Route::is('administrator.category.*')) ? 'active main-color-bg' : 'text-dark'}}">
                      <div>
                        <i class="far fa-folder-open mr-1"></i>
                        Kategorie
                      </div>
                      <span class="badge badge-secondary ml d-flex align-items-center">{{$count['category']}}</span>
                    </a>
                  </li>
                  <div id="collapseCategories" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white collapse-inner rounded d-flex flex-column">
                      @if(Auth::user()->CheckAccessForUser('administrator.category.index'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.category.index') }}">Wszystkie</a>
                      @endif
                      @if(Auth::user()->CheckAccessForUser('administrator.category.create'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.category.create') }}">Utwórz nową</a>
                      @endif
                    </div>
                  </div>
                @endif
                {{-- @if(Auth::user()->CheckAccessForUser('administrator.menu.index') OR Auth::user()->CheckAccessForUser('administrator.menu.create'))
                  <li class="nav-item">
                    <a href="#" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseMenu" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between {{(Route::is('administrator.menu.*')) ? 'active main-color-bg' : 'text-dark'}}">
                      <div>
                        <i class="far fa-compass"></i>
                        Menu
                      </div>
                      <span class="badge badge-secondary ml d-flex align-items-center">{{$count['menu']}}</span>
                    </a>
                  </li>
                  <div id="collapseMenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white collapse-inner rounded d-flex flex-column">
                      @if(Auth::user()->CheckAccessForUser('administrator.menu.index'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.menu.index') }}">Wszystkie</a>
                      @endif
                      @if(Auth::user()->CheckAccessForUser('administrator.menu.create'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.menu.create') }}">Utwórz nowe</a>
                      @endif
                    </div>
                  </div>
                @endif --}}
                @if(Auth::user()->CheckAccessForUser('administrator.users.index') OR Auth::user()->CheckAccessForUser('administrator.users.create') OR Auth::user()->CheckAccessForUser('administrator.user.groups.index' OR Auth::user()->CheckAccessForUser('administrator.user.groups.create')))
                  <li class="nav-item">
                    <a href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between {{(Route::is('administrator.users.*')) ? 'active main-color-bg' : 'text-dark'}}">
                      <div>
                        <i class="far fa-user mr-1"></i>
                        Użytkownicy
                      </div>
                      <span class="badge badge-secondary ml d-flex align-items-center">{{$count['user']}}</span>
                    </a>
                  </li>
                  <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white collapse-inner rounded d-flex flex-column">
                      @if(Auth::user()->CheckAccessForUser('administrator.users.index'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.users.index') }}">Wszyscy</a>
                      @endif
                      @if(Auth::user()->CheckAccessForUser('administrator.users.create'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.users.create') }}">Utwórz nowego</a>
                      @endif
                      @if(Auth::user()->CheckAccessForUser('administrator.user.groups.index' OR Auth::user()->CheckAccessForUser('administrator.user.groups.create')))
                        <li class="nav-item">
                          <a href="#" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between text-dark">
                            <div>
                              <i class="fas fa-user-friends"></i>
                              Grupy
                            </div>
                            <span class="badge badge-secondary ml d-flex align-items-center">{{$count['usergroups']}}</span>
                          </a>
                        </li>
                        <div>
                          <div class="bg-white collapse-inner rounded d-flex flex-column">
                            @if(Auth::user()->CheckAccessForUser('administrator.user.groups.index'))
                              <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.user.groups.index') }}">Wszystkie</a>
                            @endif
                            @if(Auth::user()->CheckAccessForUser('administrator.user.groups.create'))
                              <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.user.groups.create') }}">Utwórz nową</a>
                            @endif
                          </div>
                        </div>
                      @endif
                    </div>
                  </div>
                @endif
                @if(Auth::user()->CheckAccessForUser('administrator.polls.index') OR Auth::user()->CheckAccessForUser('administrator.polls.create'))
                  <li class="nav-item">
                    <a href="#" data-toggle="collapse" data-target="#collapseSonda" aria-expanded="true" aria-controls="collapseSonda" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between {{(Route::is('administrator.polls.*')) ? 'active main-color-bg' : 'text-dark'}}">
                      <div>
                        <i class="fas fa-poll"></i>
                        Sondy
                      </div>
                      <span class="badge badge-secondary ml d-flex align-items-center">{{$count['polls']}}</span>
                    </a>
                  </li>
                  <div id="collapseSonda" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white collapse-inner rounded d-flex flex-column">
                      @if(Auth::user()->CheckAccessForUser('administrator.polls.index'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.polls.index') }}">Wszystkie</a>
                      @endif
                      @if(Auth::user()->CheckAccessForUser('administrator.polls.create'))
                        <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.polls.create') }}">Utwórz nową</a>
                      @endif
                    </div>
                  </div>
                @endif

                <li class="nav-item">
                <a href="#" data-toggle="collapse" data-target="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig" class="px-4 nav-link collapsed list-group-item d-flex justify-content-between {{(Route::is('administrator.config.*')) ? 'active main-color-bg' : 'text-dark'}}">
                    <div>
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Konfiguracja
                    </div>
                    {{-- <span class="badge badge-secondary ml d-flex align-items-center">{{$count['polls']}}</span> --}}
                </a>
                </li>
                <div id="collapseConfig" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white collapse-inner rounded d-flex flex-column">
                    <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.config.menu.index') }}">Menu</a>
                    <a class="collapse-item pl-5 nav-link list-group-item d-flex justify-content-between text-dark" href="{{ route('administrator.config.module.index') }}">Moduły</a>
                </div>
                </div>

            </div>
          </div>
          <div class="col-md-10">
          @if(session()->has('message'))
            <div class="alert alert-{{session()->get('type')}}">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4 class="alert-heading">Wiadomość</h4>
                <div class="alert-message">{{ session()->get('message') }}</div>
            </div>
          @endif
              <div class="panel-body">
                  @yield('content')
              </div>
          </div>
        </div>
      </div>
    </section>

    <footer id="footer" class="">
      <p>Copyright Światrolnika.info, &copy; 2022</p>
    </footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  </body>
</html>
