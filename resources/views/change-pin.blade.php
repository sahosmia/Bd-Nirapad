@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/vendors/css/vendors.min.css')}}">
@stop

@section('title')
    <title>Profile Update</title>
@stop
@section('body')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row"></div>
    <div class="content-body">
        <div class="card">
             <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12 mb-1">
                        <div class="alert alert-success" style="display: none;" role="alert"><p class="alert-body alert-body-success"></p></div>
                        <div class="alert alert-warning" style="display: none;" role="alert"><p class="alert-body alert-body-warning"></p></div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="number">Old Pin</label>


                             <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="existing-pin" type="password"
                                    name="existing-pin" placeholder="Enter Existing Pin" aria-describedby="existing-pin"
                                    tabindex="2"maxlength="4" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="number">New Pin</label>
                             <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="pin" type="password"
                                    name="pin" placeholder="Enter Pin" aria-describedby="pin"
                                    tabindex="2" maxlength="4"/>
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="number">Confirm New Pin</label>
                             <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="c-pin" type="password"
                                    name="c-pin" placeholder="Enter Pin Again" aria-describedby="c-pin"
                                    tabindex="2" maxlength="4"/>
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12 mb-1 submit">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light btn-submit">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script src="{{url('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{url('backend/app-assets/vendors/js/ui/jquery.sticky.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous" ></script>
    <script>
        $(document).ready(function(){
            
            $("#existing-pin").mask('9999');
            $("#pin").mask('9999');
            $("#c-pin").mask('9999');
            
               $(".btn-submit").click(function() {
                var pin = $("#pin").val();
                var currpin = $("#existing-pin").val();
                var cpin = $("#c-pin").val();
                if (currpin != "") {
                    if (pin.length == 4 && pin > 999) {
                        if (pin == cpin) {
                            $(this).html(
                                "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                            );
                            $(this).attr("disabled", "disabled");
                            $.ajax({
                                url: "/dashboard/change-pin/submit",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    pin: pin,
                                    currpin: currpin,
                                },
                                success: function(response) {
                                    if (response['status'] == "success") {
                                        $(".alert-body-success").html(response['message']);
                                        $(".alert-success").slideDown();
                                        $(".btn-submit").html("Submit");
                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    } else if (response['status'] == "warning") {
                                        $(".alert-body-warning").html(response['message']);
                                        $(".alert-warning").slideDown();
                                        $(".alert-success").slideUp();
                                        $(".btn-submit").html("Submit");
                                        $(".btn-submit").removeAttr('disabled');
                                    }
                                }
                            });
                        } else {
                            $(".alert-body-warning").html("Pin and Confirm Pin doesnot match");
                            $(".alert-warning").slideDown();
                            $(".alert-success").slideUp();
                        }
                    } else {
                        $(".alert-body-warning").html("New Pin is required. It limit is 4 cracter. First cracter 0 will be not acceptable");
                        $(".alert-warning").slideDown();
                    }
                } else {
                    $(".alert-body-warning").html("Old pin is required");
                    $(".alert-warning").slideDown();
                }

            });
        });
    </script>
@stop