<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ URL::asset('css/materialize.min.css') }}" rel="stylesheet" />
        <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <title>
            {{ $viewModel->titleTag }}
        </title>

        <link id="twentytwelve-fonts-css"
              rel="stylesheet"
              href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&amp;subset=latin,latin-ext"
              type="text/css" media="all">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <script type="text/javascript" src="{{ URL::asset('js/jquery-3.5.1.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/materialize.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <style type="text/css" id="custom-background-css">
            body.custom-background {
                background-color: #fcfcfc;
            }
        </style>

        <script type="text/javascript">
            jQuery(document).ready(function() {
                /**
                 * Expands and collapses the the side menu when you click on the hamburger icon.
                 */
                document.addEventListener('DOMContentLoaded', function() {
                    var elems = document.querySelectorAll('.sidenav');
                    var instances = M.Sidenav.init(elems, options);
                });
            });

            jQuery(document).ready(function(){
                $('.sidenav').sidenav();
            });
        </script>
    </head>

    <body class="home blog custom-background full-width custom-font-enabled single-author">

    <nav class="grey">
        <div class="nav-wrapper">
            <a href="#!" class="brand-logo" id="TestRailTopNavTitle" style="padding-left:12px;">TestRail</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li class="<?php if (isset($navBarActive['home'])) {
                        echo 'active';
                        }?>">
                    <a href="{{ URL::route('home') }}">
                        Projects
                    </a>
                </li>
                <li class="<?php if (isset($navBarActive['groups'])) {
                        echo 'active';
                        }?>">
                    <a href="{{ URL::route('groups') }}">
                        Groups
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-demo">
        <li><a href="{{ URL::route('home') }}">Projects</a></li>
        <li><a href="{{ URL::route('groups') }}">Groups</a></li>
    </ul>
    @yield('content')
</body>

</html>