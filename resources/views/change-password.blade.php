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
                            <div class="alert alert-success" style="display: none;" role="alert">
                                <p class="alert-body alert-body-success"></p>
                            </div>
                            <div class="alert alert-warning" style="display: none;" role="alert">
                                <p class="alert-body alert-body-warning"></p>
                            </div>
                        </div>
                    </div>
                        
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="number">Old Password</label>

                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="existing-password"
                                    type="password" name="existing-password" placeholder="Enter Existing Password"
                                    aria-describedby="existing-password" tabindex="2" />
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
                            <label for="number">New Password</label>

                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="password" type="password"
                                    name="password" placeholder="Enter Password" aria-describedby="password"
                                    tabindex="2" />
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
                            <label for="number">Confirm New Password</label>

                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="c-password" type="password"
                                    name="c-password" placeholder="Enter Confirm Password" aria-describedby="c-password"
                                    tabindex="2" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                       <div class="col-xl-12 col-md-12 col-12 mb-1">
                        <h6>Password Requirements:</h6>
                        <ul class="ps-3 mb-0">
                            <li class="mb-1">Minimum 8 characters long - the more, the better</li>
                            <li class="mb-1">At least one lowercase character</li>
                            <li>At least one number, symbol, or whitespace character</li>
                        </ul>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12 mb-1 submit">
                        <div class="form-group">
                            <button type="button"
                                class="btn btn-primary waves-effect waves-float waves-light btn-submit">Update</button>
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
            $(".btn-submit").click(function(){
                var password = $("#password").val();
                var cpassword = $("#c-password").val();
                var isValidLength = password.length >= 8;
                var hasUppercase = /[A-Z]/.test(password);
                var hasLowercase = /[a-z]/.test(password);
                var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
                var currpassword = $("#existing-password").val();
                // $(this).attr("disabled","disabled");
                // $(this).html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>");
                if (currpassword != "") {
                    if (password != "") {
                        if (isValidLength && hasUppercase && hasLowercase && hasSpecialChar) {
                            if (password == cpassword) {
                                $.ajax({
                                    url: "/dashboard/change-password/submit",
                                    type: "POST",
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        password: password,
                                        currpassword: currpassword,
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
                                $(".alert-body-warning").html(
                                    "Password and confirm password doesnot match");
                                $(".alert-warning").slideDown();
                                $(".btn-submit").html("Submit");
                                $(".btn-submit").removeAttr('disabled');
                                $("#password").focus();
                            }
                        } else {
                            $(".alert-body-warning").html(
                                "Minimum 8 characters,At least one uppercase letter,At least one lowercase letter,At least one number,At least one special character"
                            );
                            $(".alert-warning").slideDown();
                            $(".btn-submit").html("Submit");
                            $(".btn-submit").removeAttr('disabled');
                            $("#password").focus();
                        }
                    } else {
                        $(".alert-body-warning").html("New Password is required");
                        $(".alert-warning").slideDown();
                    }
                } else {
                    $(".alert-body-warning").html("Give the current password");
                    $(".alert-warning").slideDown();
                }
            });
        });
    </script>
@stop