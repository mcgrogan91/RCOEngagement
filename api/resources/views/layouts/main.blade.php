<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Philly Organizations</title>
        <style>
        .background {
            position: fixed;
            display: block;
            bottom: 0;
            padding: 1rem;
            width: 100%;
            background-color: rgba(70, 73, 76, 1);
            text-align: center;
            color: #d3d3d3;
        }
        .bg-faded {
            background-color: #1985a1;
            background-color: rgba(25, 133, 161, 1);
        }
        .card-title {
          margin-bottom: .75rem;
        }

        .search {
          float: right;
        }


        </style>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- Leaflet Stylesheet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />

    <!-- Mapbox Stylesheet -->
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.35.1/mapbox-gl.css" rel="stylesheet" />

    <!-- Font Awesome CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    @section('header')
        <div>
        <nav class="navbar fixed-top navbar-toggleable-md navbar-light bg-faded">
          <div class="container">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href='/'>RCO Engagement</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href='/search'>Search for RCO</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href='/faq'>FAQ</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href='/about'>About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href='/map'>Map</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        </div>
    @show

    @yield('content')

    @section('footer')
        <div class="background">
          <div class="container">
            <div class="row h-100">
              <a class="col-sm-3 my-auto">RCO Gov't Website</a>
              <div class="col-sm-3 my-auto">Philadelphia City Planning Commission</div>
              <div class="col-sm-3 my-auto">Office of Open Data & Digital Transformation</div>
              <div class="col-sm-3 my-auto">Code for Philly</div>
            </div>
          </div>
        </div>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    @show
    </body>
</html>
