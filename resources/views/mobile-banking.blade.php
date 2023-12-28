@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
@stop

@section('title')
    <title>Mobile Banking</title>
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
                    <div class="col-xl-6 col-md-12 col-12 mb-1">
                        <div class="form-group">
                            <label for="name">Select Service</label>
                            <select class="form-control form-control-lg" id="service">
                                <option selected disabled value="0">Please select</option>
                                @foreach($services as $s)
                                    <option data-digits="{{$s->digits}}" value="{{$s->id}}">{{ucwords($s->title)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="name">Select Type</label>
                            <select class="form-control form-control-lg" id="type">
                                <option selected disabled value="0">Please select</option>
                                <option value="1">Personal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="name">Number</label>
                            <input type="text" disabled class="form-control" id="number" placeholder="Enter Number">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="name">Amount</label>
                            <input type="text" class="form-control" id="amount" placeholder="Enter Amount">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label class="form-label" for="pin">Pin :</label>
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
                    <div class="col-xl-6 col-md-6 col-12 mb-1 d-flex align-items-center">
                            <div class="form-group mb-0">
                                <button type="button"
                                    class="btn btn-primary waves-effect waves-float waves-light btn-submit">Submit</button>
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
    <script src="{{url('backend/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#service").change(function(){
                var digit = $(this).find('option:selected').data('digits');
                $("#number").prop("maxlength", digit);
                $("#number").removeAttr('disabled');
            });

            $(".btn-submit").click(function() {
                var service = $("#service").val();
                var type = $("#type").val();
                var number = $("#number").val();
                var amount = $("#amount").val();
                var pin = $("#pin").val();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to submit the form!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit it!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ml-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        if (service != null) {
                            if (type != null) {
                                if (number != "") {
                                    if (amount >= 500 && amount <= 30000) {
                                        if (pin != "") {
                                            if (service == 1 || service == 2) {
                                                if (number.length == 11) {
                                                    $(this).html(
                                                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                                    );
                                                    $(this).attr("disabled", "disabled");
                                                    $.ajax({
                                                        url: "/dashboard/mobile-banking-submit",
                                                        type: "POST",
                                                        data: {
                                                            service: service,
                                                            type: type,
                                                            number: number,
                                                            amount: amount,
                                                            pin: pin,
                                                            "_token": "{{ csrf_token() }}",
                                                        },
                                                        success: function(response) {
                                                            if (response['status'] ==
                                                                "success") {
                                                                $(".alert-body-success")
                                                                    .html(
                                                                        response[
                                                                            'message']
                                                                    );
                                                                $(".alert-success")
                                                                    .slideDown();
                                                                $(".alert-warning")
                                                                    .slideUp();
                                                                $(".btn-submit").html(
                                                                    "Submit");
                                                                setTimeout(() => {
                                                                    location
                                                                        .reload();
                                                                }, 2000);
                                                            } else if (response[
                                                                    'status'] ==
                                                                "warning") {
                                                                $(".alert-body-warning")
                                                                    .html(
                                                                        response[
                                                                            'message']
                                                                    );
                                                                $(".alert-warning")
                                                                    .slideDown();
                                                                $(".alert-success")
                                                                    .slideUp();
                                                                $(".btn-submit").html(
                                                                    "Submit");
                                                                $(".btn-submit")
                                                                    .removeAttr(
                                                                        "disabled");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    $(".alert-body-warning").html(
                                                        "Number will be 11 number");
                                                    $(".alert-warning").slideDown();
                                                }
                                            } else if (service == 3) {
                                                if (number.length == 12) {
                                                    $(this).html(
                                                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                                    );
                                                    $(this).attr("disabled", "disabled");
                                                    $.ajax({
                                                        url: "/dashboard/mobile-banking-submit",
                                                        type: "POST",
                                                        data: {
                                                            service: service,
                                                            type: type,
                                                            number: number,
                                                            amount: amount,
                                                            pin: pin,
                                                            "_token": "{{ csrf_token() }}",
                                                        },
                                                        success: function(response) {
                                                            if (response['status'] ==
                                                                "success") {
                                                                $(".alert-body-success")
                                                                    .html(
                                                                        response[
                                                                            'message']
                                                                    );
                                                                $(".alert-success")
                                                                    .slideDown();
                                                                $(".alert-warning")
                                                                    .slideUp();
                                                                $(".btn-submit").html(
                                                                    "Submit");
                                                                setTimeout(() => {
                                                                    location
                                                                        .reload();
                                                                }, 2000);
                                                            } else if (response[
                                                                    'status'] ==
                                                                "warning") {
                                                                $(".alert-body-warning")
                                                                    .html(
                                                                        response[
                                                                            'message']
                                                                    );
                                                                $(".alert-warning")
                                                                    .slideDown();
                                                                $(".alert-success")
                                                                    .slideUp();
                                                                $(".btn-submit").html(
                                                                    "Submit");
                                                                $(".btn-submit")
                                                                    .removeAttr(
                                                                        "disabled");
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    $(".alert-body-warning").html(
                                                        "Rokect Number will be minimum 12 number"
                                                    );
                                                    $(".alert-warning").slideDown();
                                                }

                                            }
                                        } else {
                                            $(".alert-body-warning").html(
                                                "Sorry! Pin number is wrong");
                                            $(".alert-warning").slideDown();
                                        }
                                    } else {
                                        $(".alert-body-warning").html(
                                            "Minimum 500 & maximum 30000 amount need");
                                        $(".alert-warning").slideDown();
                                    }
                                } else {
                                    $(".alert-body-warning").html("Give me a valid number");
                                    $(".alert-warning").slideDown();
                                }
                            } else {
                                $(".alert-body-warning").html("Select any type");
                                $(".alert-warning").slideDown();
                            }
                        } else {
                            $(".alert-body-warning").html("Select any service");
                            $(".alert-warning").slideDown();
                        }
                    }
                });
            });
        });
    </script>
@stop
