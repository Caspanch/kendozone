<!DOCTYPE html>
<html lang="en">
<head>
    {{--<script data-cfasync="false">window.civchat = {--}}
            {{--apiKey: "UqQXPuoajzcRnS4VrniDb1JfohA725XdaDtXW7zGThveM640NcmEkDWeXy7ZWHGo",--}}
            {{--name: "",--}}
            {{--email: ""--}}
        {{--};</script>--}}
    {{--<script data-cfasync="false" src="https://widget.userengage.io/widget.js"></script>--}}
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
    <link rel="shortcut icon" href="{{ asset('/favicon_kz-01.png')  }}"/>
    <link rel="apple-touch-icon" href="{{ asset('/favicon_kz-01.png') }}"/>

    <meta property="og:title" content="Create Online Kendo Tournament in instants"/>
    <meta name="twitter:title" content="Kendozone - Create Online Kendo Tournaments in instants"/>
    <?php
    $appName = (app()->environment() == 'local' ? getenv('APP_NAME') : config('app.name'));
    $title = ' <title> ' . $appName . ' </title>';

    $description = '
        <meta name="description" content="Kenzone is a responsive kendo tournaments system. Register the competitors, generate documentation, and begin to score live with your tablet"/>
        <meta property="og:description" content="Get Ready and strike Men" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:description" content="Kenzone is a responsive kendo tournaments system. Register the competitors, generate documentation, and begin to score live with your tablet" />
    ';
    $image = '
        <meta property="og:image" content="https://kendozone.com/wp-content/uploads/2016/04/home.jpg" />
        <meta property="og:image:secure_url" content="https://kendozone.com/wp-content/uploads/2016/04/home.jpg" />
        <meta name="twitter:image" content="https://kendozone.com/wp-content/uploads/2016/04/home.jpg" />
    ';
    ?>

    @yield('image')
    <meta property="og:locale" content="{{ App::getLocale() }}"/>
    <meta property="og:type" content="website"/>
    @yield('title', new Illuminate\Support\HtmlString($title))
    @yield('description', new Illuminate\Support\HtmlString($description))
    @yield('image', new Illuminate\Support\HtmlString($image))

    <meta property="og:url" content="{{ Request::url() }}"/>
    <meta property="og:site_name" content="{{ $appName }}"/>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ app()->environment()=='local' ? getenv('APP_NAME') : config('app.name') }} </title>
    <!-- Global stylesheets -->
    {!! Html::style('css/app.css')!!}
    @yield('scripts')
    @yield('styles')
</head>
{{--sidebar-xs should be out--}}
<body class="sidebar-xs has-detached-right navbar-top">
@if (Auth::check())
    @include('layouts.headmenu')
@endif
<!-- Page container -->
<div class="page-container" id="app">
    <!-- Page content -->
    <div class="page-content">
    @if (Auth::check())
        @include('layouts.sidemenu')
    @endif
    <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content" id="app">
                @yield('content')
                @include('layouts.footer')
                <flash message="{{ session('flash_message')['message'] }}"></flash>
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>

<!-- /page container -->
{{--<script>--}}
    {{--var csrfToken = "{{csrf_token()}}";--}}
{{--</script>--}}
@if(!empty(env('SENTRY_DSN_PUBLIC')))
    <script src="https://cdn.ravenjs.com/3.14.2/raven.min.js"></script>
    <script>
        Raven.config("{{env('SENTRY_PUBLIC')}}").install();
        Raven.setUserContext({
            email: "{!!  Auth::check() ? Auth::user()->email :'' !!}",
            id: "{!!     Auth::check() ? Auth::user()->id : '' !!}"
        })
    </script>
@endif

{!! Html::script('js/bootstrap.js')!!}
{!! Html::script('js/app.js')!!}
{!! Html::script('js/analytics.js') !!}

<script>
    $(document).ready(function () {
        $.protip();
    });
</script>


@include('layouts.flash')
@yield('scripts_footer')

</body>
</html>