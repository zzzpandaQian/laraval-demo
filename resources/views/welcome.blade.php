<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ATCMS</title>

        <!-- Styles -->
        <style>
            html, body {
                background: -moz-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(204,204,204,1) 100%);
                background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,1)), color-stop(100%, rgba(204,204,204,1)));
                background: -webkit-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(204,204,204,1) 100%);
                background: -o-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(204,204,204,1) 100%);
                background: -ms-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(204,204,204,1) 100%);
                background: radial-gradient(ellipse at center, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(204,204,204,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#cccccc', GradientType=1 );
                color: #636b6f;
                font-family: "PingFang SC", "Adobe Heiti Std", "Microsoft Yahei", arial, helvetica, "Hei Ti", 微软雅黑体, FangSong, 仿宋, clean, sans-serif;
                font-weight: 100;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 80px;
                line-height: 1;
            }
            .title sup{
                font-size: 32px;
                line-height: 1;
                position: absolute;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                z-index: 9999;
                position: relative;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    ATCMS 2018<sup>(laravel)</sup>
                </div>

                <div class="links">
                    <a href="http://anttoweb.com" target="_blank">Anttoweb design</a>
                    <a href="http://www.anttoweb.com/portfolio/" target="_blank">Portfolio</a>
                    <a href="http://www.anttoweb.com/services/" target="_blank">Services</a>
                    <a href="http://www.anttoweb.com/contact/" target="_blank">Contact</a>
                </div>

            </div>
        </div>
    </body>
</html>
