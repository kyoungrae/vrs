<!DOCTYPE html>
<html lang="ko">
<head>
    @include('Includes.head')
    <style>
        .demo-wrap-shell {
            max-width: 920px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e4e7ec;
            border-radius: 10px;
            padding: 24px;
        }
        .demo-title { font-size: 22px; margin-bottom: 8px; }
        .demo-muted { color: #6b7280; font-size: 14px; }
        .demo-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            margin-top: 14px;
            word-break: break-all;
            font-size: 13px;
        }
        .demo-actions .btn { margin-right: 8px; margin-top: 8px; }
    </style>
</head>
<body class="az-body flexcroll">
<div class="avtoteeverPreloader"></div>
<div class="containerBody" style="display: none;">
    <div class="az-iconbar az-iconbar-primary">
        @include('Includes.menu')
    </div>
    <div class="az-iconbar-aside az-iconbar-aside-primary">
        @include('Includes.menulist')
    </div>
    <div class="az-content az-content-dashboard-ten">
        <div class="az-header">
            @include('Includes.top')
        </div>
        <div class="az-content-body">
            <div class="az-content-body-left" style="padding: 10px;">
                @yield('demo_content')
            </div>
        </div>
        @include('Includes.footer')
    </div>
</div>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('js/vrs.js') }}"></script>
<script src="{{ asset('js/avtoteever.js') }}"></script>
<script>
(function ($) {
    'use strict';
    $(document).ready(function () {
        $('.az-iconbar .nav-link').on('click', function (e) {
            var href = $(this).attr('href') || '';
            if (href.indexOf('#') !== 0) {
                return;
            }
            e.preventDefault();
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            $('.az-iconbar-aside').addClass('show');
            var targ = href;
            $(targ).addClass('show');
            $(targ).siblings('.az-iconbar-pane').removeClass('show');
        });

        $('.az-iconbar-toggle-menu').on('click', function (e) {
            e.preventDefault();
            if (window.matchMedia('(min-width: 992px)').matches) {
                $('.az-iconbar .nav-link.active').removeClass('active');
                $('.az-iconbar-aside').removeClass('show');
            } else {
                $('body').removeClass('az-iconbar-show');
            }
        });

        $('#azIconbarShow').on('click', function (e) {
            e.preventDefault();
            $('body').toggleClass('az-iconbar-show');
            var targ = $('.az-iconbar .nav-link.active').attr('href');
            if (targ && targ.indexOf('#') === 0) {
                $(targ).addClass('show');
            }
        });

        $(document).on('click touchstart', function (e) {
            var azContent = $(e.target).closest('.az-content').length;
            var azIconBarMenu = $(e.target).closest('.az-header-menu-icon').length;
            if (azContent) {
                $('.az-iconbar-aside').removeClass('show');
                if (!azIconBarMenu) {
                    $('body').removeClass('az-iconbar-show');
                }
            }
        });

        var asideId = <?php echo json_encode(isset($demoAsideId) ? $demoAsideId : null); ?>;
        if (asideId) {
            $('.az-iconbar-aside').addClass('show');
            $('#' + asideId).addClass('show').siblings('.az-iconbar-pane').removeClass('show');
            $('.az-iconbar .nav-link[href="#' + asideId + '"]').addClass('active');
        }
    });

    $(document).ready(function () {
        $('.avtoteeverPreloader').fadeOut();
        $('.containerBody').fadeIn();
    });
})(jQuery);
</script>
</body>
</html>
