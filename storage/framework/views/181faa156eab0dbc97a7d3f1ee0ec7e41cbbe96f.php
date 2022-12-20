<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name')); ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset_url('assets/images/favicon.ico')); ?>">

    <!-- DataTables -->
    <link href="<?php echo e(asset_url('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset_url('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset_url('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert -->
    <link href="<?php echo e(asset_url('plugins/sweet-alert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset_url('plugins/animate/animate.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset_url('plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet">

    <!-- Select2 -->
    <link href="<?php echo e(asset_url('plugins/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Apex Charts -->
    <link href="<?php echo e(asset_url('plugins/apexcharts/dist/apexcharts.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Datepicker -->
    
    <link href="<?php echo e(asset_url('plugins/timepicker/bootstrap-material-datetimepicker.css')); ?>" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowgroup/1.2.0/css/rowGroup.dataTables.min.css" rel="stylesheet">

    <!-- Autocomplete jQuery -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css"
        rel="stylesheet">


    <!-- App css -->
    <link href="<?php echo e(asset_url('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset_url('assets/css/jquery-ui.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset_url('assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset_url('assets/css/metisMenu.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset_url('assets/css/app.min.css')); ?>" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset_url('assets/css/custom.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset_url('plugins/daterangepicker/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />
    <style>
        :root {

            --main_background_color: #001b31;
            --secondary_background_color: #05e4bf;
            --back-of-all: #001b31cf;
        }

        /* put back-of-all color as background of each element under page-wrapper */
        /* .page-wrapper {
            background-color: var(--back-of-all);
        }



        .left-sidenav,
        .topbar,
        .navbar-custom,
        .left-sidenav .leftbar-profile,
        .left-sidenav .topbar-left {
            background: var(--main_background_color);

            color: #fff;
        }

        .navbar-custom {
            min-height: unset;
        }



        button.button-menu-mobile.nav-link {
            margin-top: 10px;
        }

        .navbar-custom .nav-link {
            line-height: 50px;

        }

        body.mm-active.active.enlarge-menu .long {
            display: none;
        }


        li.short .responsive-logo {
            display: block;
        }



        .enlarge-menu .topbar-left .long,
        li.short {
            display: none;
        }

        .enlarge-menu .short {
            display: block;
            position: absolute;
            display: block;
            width: auto;
            top: 15px;
            left: -50px;
            z-index: 9999999999;
        }

        .borderbox {
            width: 100%;
            display: flex;
            padding: 15px;
            box-shadow: 2px 3px 5px 0px rgba(0, 0, 0, 0.71);
            -webkit-box-shadow: 2px 3px 5px 0px rgba(0, 0, 0, 0.71);
            -moz-box-shadow: 2px 3px 5px 0px rgba(0, 0, 0, 0.71);
        }

        .has-submenu:not(.mm-active) .submenu {
            display: none !important;
        }

        body.enlarge-menu .metismenu .mm-collapse.mm-show,
        body.enlarge-menu .metismenu li.mm-active>a {
            background: var(--main_background_color) !important;
        }

        .left-sidenav-menu li:hover .vertical-menu-icon.icon-dual-vertical,
        .left-sidenav-menu li.mm-active>a .vertical-menu-icon.icon-dual-vertical,
        .left-sidenav-menu .active:not(.has-submenu) .vertical-menu-icon.icon-dual-vertical {
            color: #fff;
        }

        .left-sidenav-menu .active:not(.has-submenu),
        .left-sidenav-menu li:hover:not(.has-submenu),
        .left-sidenav li .mm-active,
        body.enlarge-menu .left-sidenav .left-sidenav-menu .leftbar-menu-item:hover .menu-link {
            background: var(--secondary_background_color) !important;
        }

        .btn-primary,
        button.swal2-confirm.swal2-styled {
            background: var(--secondary_background_color) !important;
            border-color: var(--secondary_background_color);
        }

        .bg-info {
            background: var(--secondary_background_color) !important;
        }

        .left-sidenav-menu li>a,
        .topbar-left h4 {
            color: #fff !important;
        }

        #toast-container>.toast-error {
            background-color: #BD362F;
        }

        .btn-secondary {
            color: #fff;
            background-color: #001b31;
            border-color: #001b31;
            box-shadow: unset;
        }

        .btn-secondary:hover,
        .btn-secondary.active {
            color: #fff;
            background-color: var(--secondary_background_color) !important;
            border-color: var(--secondary_background_color) !important;
        } */
        #toast-container>.toast-success {
            background-color: #5cb85c;
        }

        #toast-container>.toast-error {
            background-color: #5cb85c;
        }

        .left-sidenav-menu li .active {
            background-color: #001b31;
            color: white !important;
        }


        .btn-primary,
        button.swal2-confirm.swal2-styled {
            background: var(--secondary_background_color) !important;
            border-color: var(--secondary_background_color);
        }

        .logo-sm {
            margin-top: -8px !important;
        }

        .loading {
            z-index: 999999999 !important;
        }
    </style>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <!-- Left Sidenav -->
    <div class="left-sidenav" style="position: fixed">
        <!-- LOGO -->
        <div class="topbar-left">
            <?php echo $__env->make('admin.components.logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!--end logo-->
        <?php echo $__env->make('admin.components.left-nav-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.components.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <!-- end left-sidenav-->

    <!-- Top Bar Start -->
    <?php echo $__env->make('admin.components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Top Bar End -->
    <div class="page-wrapper">
        <!-- Page Content-->
        <div class="page-content-tab">

            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div><!-- container -->
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>


    <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form"><?php echo csrf_field(); ?></form>
    <div class="loading">Loading&#8230;</div>


    <!-- jQuery  -->
    <script src="<?php echo e(asset_url('assets/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('assets/js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('assets/js/metismenu.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('assets/js/waves.js')); ?>"></script>
    <script src="<?php echo e(asset_url('assets/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('assets/js/jquery.slimscroll.min.js')); ?>"></script>

    <script src="<?php echo e(asset_url('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    

    <script src="<?php echo e(asset_url('plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    <!-- Sweet-Alert  -->
    <script src="<?php echo e(asset_url('plugins/sweet-alert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('/plugins/dropify/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset_url('/plugins/uppy/uppy.min.js')); ?>"></script>

    <!-- Select2 -->
    <script src="<?php echo e(asset_url('plugins/select2/select2.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js"
        integrity="sha512-mBsoM2hTemSjQ1ETLDLBYvw6WP9QV8giiD33UeL2Fzk/baq/AibWjI75B36emDB6Td6AAHlysP4S/XbMdN+kSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/ui/trumbowyg.min.css"
        integrity="sha512-K87nr2SCEng5Nrdwkb6d6crKqDAl4tJn/BD17YCXH0hu2swuNMqSV6S8hTBZ/39h+0pDpW/tbQKq9zua8WiZTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/fontfamily/trumbowyg.fontfamily.min.js"
        integrity="sha512-47ciyqHJ9LZeAW+JQVmDp/P0PHZdnp9Eu4UBptyP8P2o/e2BP8nDu0PwpRy5hBe5cxMAA3uEzTtAhh7WsEX4TA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/colors/ui/trumbowyg.colors.min.css"
        integrity="sha512-VCJM62+9ou73PDL8ROa9D+lZKG9qrbGv91WxlU3Hyb4lfdnT5wBnLvX45vd45ENRU271iRI9xa1fYJbrVed8Jw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/table/ui/trumbowyg.table.min.css"
        integrity="sha512-T7ZLvoAZHn+QNrzmQCDlSf1ocLQ3oBXSKH8zORXaYQYJFcKPgqf2O4hQdqncExv1+dBSWyLsZl864lB7y7VHYw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/resizimg/trumbowyg.resizimg.min.js"
        integrity="sha512-ZFWCpQ44IAcwGKAV1TSNslN5jZBbLOanbtKXGpi/EDwW7HGAYbueYKe8JzwxkZ048btwFX+18O/d3TrRx8+jzA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/pasteembed/trumbowyg.pasteembed.min.js"
        integrity="sha512-cc99fAVMJJomU5mEXMh5qrkcMTE9ekk+l1fBDPi2fsECAGKvLMAR11FZJQFr2HL3SvfQWWqvLKYZIbips4TJUg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"
        integrity="sha512-t4CFex/T+ioTF5y0QZnCY9r5fkE8bMf9uoNH2HNSwsiTaMQMO0C9KbKPMvwWNdVaEO51nDL3pAzg4ydjWXaqbg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Datepicker  -->
    
    <script src="<?php echo e(asset_url('plugins/moment/moment.js')); ?>"></script>
    <script src="<?php echo e(asset_url('plugins/daterangepicker/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(asset_url('plugins/timepicker/bootstrap-material-datetimepicker.js')); ?>"></script>

    <!-- Autocomplete jQuery  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <script src="<?php echo e(asset_url('plugins/apexcharts/dist/apexcharts.js')); ?>"></script>
    <!-- App js -->
    <script src="<?php echo e(asset_url('assets/js/app.js')); ?>"></script>

    <script>
        window.usetifulTags = {
            userId: "<?php echo e(auth()->user()->id); ?>",
            role: "<?php echo e(auth()->user()->role_id); ?>",
            firstName: "<?php echo e(auth()->user()->name); ?>",
        };
    </script>

    <script src="<?php echo e(asset_url('assets/js/scripts.js')); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder1.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.2.0/js/dataTables.rowGroup.min.js"></script>

    <?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <script>
        <?php
            $error_messages = new stdClass();
            $error_messages->errors = $errors->getMessages();
            $error_messages = json_decode(json_encode($error_messages));
            
        ?>
        var invalid = 'is-invalid';


        function autoSelect() {
            $.each($('.auto-select'), function(index, t) {
                var v = $(t).attr('data-selected');
                if (v) {
                    console.log(v);
                    $(t).val(v);
                    $(t).trigger('change');
                }

            });
        }

        function removeInvalid(all = null) {
            if (all) {
                $(all).removeClass(invalid);
                $(all).closest('.form-group').find('.error').remove();
                $(all).closest('.form-group').find('.invalid-feedback').remove();
            } else {
                $('form *').removeClass(invalid);
                $('form .error').remove();
                $('form .invalid-feedback').remove();
            }

        }

        function addInvalid(selector, message) {
            $(selector).addClass(invalid);
            //form-group
            $(selector).closest('div').append('<span class="error text-danger"><strong>' + message + '</strong></span>');
        }

        function processErrors(data) {
            if (data.hasOwnProperty('responseJSON')) {
                data = data.responseJSON;
            }

            if (!data.hasOwnProperty('errors')) {
                return;
            }


            removeInvalid();
            Object.keys(data.errors).forEach((key, index) => {
                var key2 = key;
                var elem = null;
                var value = data.errors[key][0];
                console.log(value);
                if (key.includes('.')) {
                    var key1 = key.split('.');
                    key2 = key1[0];
                    if ('technician_id' == key1[0]) {
                        key2 += '[' + key1[1] + ']';
                        //    console.log(key2);
                    }
                    value = value.replaceAll(key, key1[0]);

                    value = value.replaceAll('_', ' ');
                    key2 += "[]";
                    elem = $(`[name="${key2}"]`);
                    elem = elem[key1[1]];


                } else {
                    elem = $(`[name="${key2}"]`);
                }
                addInvalid(elem, value);
            })
        }

        processErrors(<?php echo json_encode($error_messages, 15, 512) ?>);

        $('body').on('input change', 'input,textarea,select', function() {
            removeInvalid(this);
        });

        function appendName(str) {
            var st = $(str).find(
                'option:selected').text();
            $(str).closest('.form-group').find('input[type=hidden]').val(st);
        }


        function process_ajax(url, data = '', callback = null, method = 'GET') {
            $.ajax({
                url: url,
                type: method,
                data: data,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (typeof callback == 'function') {
                        callback(data);
                    }
                    if (data.status == 'success') {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function(data) {
                    processErrors(data);
                },
                complete: function() {
                    $('.loading').hide();
                }
            });
        }


        function process_ajax_form(url, form, callback = null, method = 'GET') {
            $.each($(form).find('select'), function(key, t) {
                appendName($(t));
            });
            var data = new FormData(form);
            process_ajax(url, data, callback, method);
        }

        function initSelect2(elem = '.select2', isdestroy = false) {
            if ($(elem).length) {
                $('.select2-container--default').remove();
                $(elem).select2({
                    width: '100%'
                });
            }
        }
        initSelect2();
        $(".dropify").dropify();
        try {
            getCalendarSlots();
        } catch (error) {

        }
        if ($(".datepicker").length) {
            $(".datepicker").bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false,
                format: 'DD-MM-YYYY',
                minDate: new Date()
            });
        }
        if ($(".filter").length) {
            $(".filter").bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false,
                format: 'DD-MM-YYYY',

            });
        }

        function filterDatePicker(days) {

            $(".datepicker").bootstrapMaterialDatePicker({
                weekStart: 0,
                time: false,
                format: 'DD-MM-YYYY',
                minDate: new Date(),
                beforeShowDay: function(date) {
                    if (days.indexOf(formatDate(date)) < 0)
                        return {
                            enabled: false
                        }
                    else
                        return {
                            enabled: true
                        }
                },
            });

        }


        function copyText(selector, isHidden = false) {
            try {
                var copyText = document.querySelector(selector);
                copyText.style.display = "block";
                copyText.select();
                copyText.setSelectionRange(0, 99999); /* For mobile devices */
                if (isHidden) {
                    copyText.style.display = "none";
                }
                //
                navigator.clipboard.writeText(copyText.value);
                toastr.success('Copied Successfully');
            } catch (error) {

            }
        }

        function deleteMsg(url) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    location.href = url;
                }
            })
        }

        function statusMsg(url) {
            swal.fire({
                title: 'Are you sure?',
                text: "Don't Worry ! It Can be Revert",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change the Status!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    location.href = url;
                }
            })
        }

        function defaultMsg(url) {
            swal.fire({
                title: 'Are you sure?',
                text: "Don't Worry ! It Can be Revert",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Make it default!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    location.href = url;
                }
            })
        }
        /*================================
            Fullscreen Page
            ==================================*/
        if ($('#full-view').length) {

            var requestFullscreen = function(ele) {
                if (ele.requestFullscreen) {
                    ele.requestFullscreen();
                } else if (ele.webkitRequestFullscreen) {
                    ele.webkitRequestFullscreen();
                } else if (ele.mozRequestFullScreen) {
                    ele.mozRequestFullScreen();
                } else if (ele.msRequestFullscreen) {
                    ele.msRequestFullscreen();
                } else {
                    console.log('Fullscreen API is not supported.');
                }
            };

            var exitFullscreen = function() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else {
                    console.log('Fullscreen API is not supported.');
                }
            };

            var fsDocButton = document.getElementById('full-view');
            var fsExitDocButton = document.getElementById('full-view-exit');

            fsDocButton.addEventListener('click', function(e) {
                e.preventDefault();
                requestFullscreen(document.documentElement);
                $('body').addClass('expanded');
            });

            fsExitDocButton.addEventListener('click', function(e) {
                e.preventDefault();
                exitFullscreen();
                $('body').removeClass('expanded');
            });
        }

        $(".float-field").on('keypress', function(event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
                (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $(".int-field").on('keypress', function(event) {
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        if ($(".select2-ajax").length) {
            $('.select2-ajax').each(function(i, obj) {

                var display2 = "",
                    where2 = "";
                if (typeof $(this).data('display2') !== "undefined") {
                    display2 = "&display2=" + $(this).data('display2');
                }
                if (typeof $(this).data('where2') !== "undefined") {
                    where2 = "&where2=" + $(this).data('where2');
                }

                $(this).select2({
                    ajax: {
                        url: _url + '?table=' + $(this).data('table') + '&value=' + $(this).data('value') +
                            '&display=' + $(this).data('display') + display2 + '&where=' + $(this).data(
                                'where') + where2,
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        }
                    }
                });

            });
        }

        //Auto Selected
        if ($(".auto-select").length) {
            $('.auto-select').each(function(i, obj) {
                $(this).val($(this).data('selected')).trigger('change');
            })
        }

        if ($(".auto-multiple-select").length) {
            $('.auto-multiple-select').each(function(i, obj) {
                var values = $(this).data('selected');
                $(this).val(values).trigger('change');
            })
        }

        if ($(".summernote").length > 0) {
            $('.summernote').trumbowyg();
        };
    </script>

    <?php echo $__env->yieldContent('js'); ?>

</body>

</html>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/layouts/app.blade.php ENDPATH**/ ?>