    <script src="../assets/libs/jquery/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/node-waves/waves.min.js"></script>
    <!-- Peity chart-->
    <script src="../assets/libs/peity/jquery.peity.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <!-- Plugin Js-->
    <script src="../assets/libs/chartist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/chartist-plugin-tooltip.min.js"></script>
    <script src="../assets/js/pages/dashboard.init.js"></script>
    <script src="../assets/js/app.js"></script>
    <script type="text/javascript">
        let inProgress = false;

        let preloader = function() {
            if (inProgress) return false;
            inProgress = true;
            $('#layout-wrapper').css({
                'opacity': '0.5',
                'pointer-events': 'none'
            });

            $('#layout-wrapper').addClass('disabled');
            $('.la-anim-1').addClass('la-animate bg-warning')
            setTimeout(function() {
                $('#layout-wrapper').css({
                    opacity: '1',
                    'pointer-events': 'auto'
                });
                $('#layout-wrapper').removeClass('disabled');
                $('.la-anim-1').removeClass('la-animate');
                inProgress = false;
            }, 1800);
        }
    </script>