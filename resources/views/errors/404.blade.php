@extends('frontend.layouts.master')

@section('body-class','page-404')

@section('content')

    <div class="section-container">
        <section class="page-404">

            <div class="section-content">
                <div class="error-page">
                    <div>
                        <!--h1(data-h1='400') 400-->
                        <!--p(data-p='BAD REQUEST') BAD REQUEST-->
                        <!--h1(data-h1='401') 401-->
                        <!--p(data-p='UNAUTHORIZED') UNAUTHORIZED-->
                        <!--h1(data-h1='403') 403-->
                        <!--p(data-p='FORBIDDEN') FORBIDDEN-->
                        <h1 data-h1="404">404</h1>
                        <p data-p="The page you requested was not found">The page you requested was not found</p>
                        <!--h1(data-h1='500') 500-->
                        <!--p(data-p='SERVER ERROR') SERVER ERROR-->
                    </div>
                </div>
                <div id="particles-js"></div>
                <a href="/" class="bt bt-red">Return to home</a>

            </div>


        </section>
    </div>

@endsection

@push('js')

    <script type="text/javascript" src="vendor/bower/particles.js/particles.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 5,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#fcfcfc"
                    },
                    "shape": {
                        "type": "circle",
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": false,
                            "speed": 1,
                            "opacity_min": 0.2,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 140,
                        "random": false,
                        "anim": {
                            "enable": true,
                            "speed": 10,
                            "size_min": 40,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": false,
                    },
                    "move": {
                        "enable": true,
                        "speed": 8,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": false,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": false
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": true
                    }
                },
                "retina_detect": true
            });

        });

    </script>

@endpush
