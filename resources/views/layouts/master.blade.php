<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    @yield('title')
    <link rel="apple-touch-icon" href="{{url('backend/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('storage')}}/{{setting('site.favicon')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/bootstrap.css')}}?v={{date('d-m-Y H:i:s')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css" >
    <!-- END: Custom CSS-->

    @yield('css')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    @include('inc.header')
    @include('inc.sidebar')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        @yield('body')
    </div>
    <!-- END: Content-->

    @if($user->pin == "")
        {{-- Add Pin Modal --}}
        <div class="modal fade text-left" id="add-pin-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Create Pin</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="alert alert-success" style="display: none;" role="alert"><p class="alert-body alert-body-success"></p></div>
                            <div class="alert alert-warning" style="display: none;" role="alert"><p class="alert-body alert-body-warning"></p></div>
                            <label>Pin: </label>
                            <div class="form-group">
                                <div class="input-group form-password-toggle">
                                    <input class="form-control form-control-merge border-right" id="pin"
                                        type="password" name="pin" aria-describedby="password" tabindex="2"
                                        maxlength="4" placeholder="Pin" />
                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer">
                                            <i data-feather="eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-create-pin">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Add Pin Modal --}}
    @endif

    @if($user->credits < 1000 || $user->credits == "")
        {{-- Request Credit Modal --}}
        <div class="modal fade text-left" id="add-credit-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Request Credit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="alert alert-success" style="display: none;" role="alert"><p class="alert-body alert-body-success"></p></div>
                            <div class="alert alert-warning" style="display: none;" role="alert"><p class="alert-body alert-body-warning"></p></div>
                            <label>Credit: </label>
                            <div class="form-group">
                                <input id="amount" type="text" placeholder="Amount" class="form-control" />
                            </div>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-request-credit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Request Credit Modal --}}
    @endif

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('inc.footer')


    <!-- BEGIN: Vendor JS-->
    <script src="{{url('backend/app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->


    <!-- BEGIN: Theme JS-->
    <script src="{{url('backend/app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{url('backend/app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
        
        // $('.nav-link-style').on('click', function () {
        //     var layout = localStorage.getItem("layout");
        //     if(layout == "dark"){
        //         $(this).trigger("click");
        //     }
        //     else{
        //         localStorage.setItem("layout" , "dark");
        //     }
        // });
         $(".btn-create-pin").click(function(){
            var pin = $("#pin").val();
            if(pin != ""){
                if(pin > 999){
                    $.ajax({
                    url : "/dashboard/create-pin",
                    type : "POST",
                    data : {
                        pin : pin,
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(response){
                        if(response['status'] == "success"){
                            $(".alert-body-success").html(response['message']);
                            $(".alert-success").slideDown();
                            $(".btn-create-pin").html("Submit");
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        else if(response['status'] == "error"){
                            $(".alert-body-warning").html(response['message']);
                            $(".alert-success").slideUp();
                            $(".alert-warning").slideDown();
                            $(".btn-assign-partner-submit").html("Submit");
                            $(".btn-assign-partner-submit").removeAttr('disabled');
                        }
                    }
                });
                }
                else{
                    $("#pin").focus();
                    $(".alert-body-warning").html("Pin limit is 4 charecter. First charecter 0 is not accepteable.");
                    $(".alert-warning").slideDown();
                }
            }
            else{
                $("#pin").focus();
                $(".alert-body-warning").html("Pin is required.");
                $(".alert-warning").slideDown();
            }
        });

        $(".btn-request-credit").click(function(){
            var amount = $("#amount").val();
            if(amount > 500 && amount != ""){
                $(this).html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");
                $(this).attr("disabled","disabled");
    
                $.ajax({
                    url : "/dashboard/request-credit",
                    type : "POST",
                    data : {
                        amount : amount,
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(response){
                        if(response['status'] == "success"){
                            $(".alert-body-success").html(response['message']);
                            $(".alert-success").slideDown();
                            $(".btn-request-credit").html("Submit");
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
            }
            else{
                $("#amount").focus();
            }
        });

        var inactivityTimeout = 1800000;
        var logoutTimer;

        function resetLogoutTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(logoutUser, inactivityTimeout);
        }
        function logoutUser() {
            window.location.href = '/dashboard/logout';
        }

        $(document).ready(function () {
            resetLogoutTimer();
            $(document).on("mousemove keydown click", function () {
                resetLogoutTimer();
            });
        });
    </script>

    @if($user->pin == "")
        <script>
            setTimeout(() => {
                $("#add-pin-modal").modal('show');
            }, 1000);
        </script>
    @endif

    @yield('javascript')
</body>
<!-- END: Body-->

</html>