<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{setting('general.site_name')}} - {{$pageName}}</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <!-- =======================================================
  * Template Name: ZenBlog
  * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
  * Updated: Aug 08 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <!-- Favicons -->
  <link href="{{ asset('bible/images/favicon.png') }}" rel="icon">
  <link href="{{ asset('bible/images/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('bible/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('bible/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('bible/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('bible/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@event-calendar/build/dist/event-calendar.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@event-calendar/build/dist/event-calendar.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="{{ asset('bible/css/leaflet.css') }}">

  <!-- Main CSS File -->
  <link href="{{ asset('bible/css/main.css') }}" rel="stylesheet">
  <style>
    h4.ec-event-title {
      font-size: 11pt;
    }
  </style>
</head>
<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="{{url('/')}}" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="{{ asset('bible/images/header.png') }}" alt="">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>
          <li><a href="{{url('/about')}}">About</a></li>
          <li><a href="{{url('/groups')}}">Groups</a></li>
          <li><a href="{{url('/projects')}}">Projects</a></li>
          <li><a href="{{url('/venues')}}">Venues</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none text-white bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        <a href="{{setting('general.linkedin')}}" target="_blank" class="linkedin"><i class="text-white bi bi-linkedin"></i></a>
      </div>

    </div>
  </header>
  <main class="main">
    <div class="container mb-5">
      <div class="row mt-3"> 
        {{$slot}}
      </div>
    </div>
  </main>
  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <img src="{{ asset('bible/images/header.png') }}" alt="">
          </a>
          <div class="footer-contact pt-3">
            {{setting('general.physical_address')}}
            <p class="mt-3"><strong>Phone:</strong> <span>{{setting('general.phone')}}</span></p>
            <p><strong>Email:</strong> <span>{{setting('general.email')}}</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="{{setting('general.linkedin')}}" target="_blank"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-8 col-md-6 footer-links">
          <div id="mapid" style="height:250px;"></div>
          @if (setting('general.map_location'))
          <script>
              var coords;
              coords = [{{setting('general.map_location')['lat']}},{{setting('general.map_location')['lng']}}];
              var mymap = L.map('mapid').setView(L.latLng(coords), 15);
              L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
              attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
              maxZoom: 18,
              id: 'mapbox/streets-v11',
              tileSize: 512,
              zoomOffset: -1,
              accessToken: '{{setting('services.mapbox_token')}}'
              }).addTo(mymap);
              var marker = L.marker(L.latLng(coords)).addTo(mymap);
          </script>
          @endif
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by {{setting('general.site_name')}}<br>based on a <a href="https://bootstrapmade.com/">BootstrapMade</a> template from <a href=“https://themewagon.com>ThemeWagon
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('bible/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('bible/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('bible/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('bible/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('bible/js/main.js') }}"></script>
</body>
</html>