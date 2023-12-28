@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
@stop

@section('title')
    <title>Mobile Recharge</title>
@stop
@section('body')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row"></div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xxl">
                        <div class="col-xl-12 col-md-12 col-12 mb-1">
                            <div class="alert alert-success" style="display: none;" role="alert"><p class="alert-body alert-body-success"></p></div>
                            <div class="alert alert-warning" style="display: none;" role="alert"><p class="alert-body alert-body-warning"></p></div>
                        </div>
                        <input type="hidden" id="plan-id">
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-12 mb-1">
                                <div class="form-group">
                                    <label>Select Operators</label>
                                    <select class="form-control form-control-lg" id="operator">
                                        <option selected disabled value="0">Please select</option>
                                        @foreach($operators as $op)
                                            <option value="{{$op->id}}">{{ucwords($op->title)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 mb-1">
                                <div class="form-group">
                                    <label for="number">Number</label>

                                    <input type="text" class="form-control" id="number" placeholder="Enter Number">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 mb-1">
                                <div class="form-group">
                                    <label for="number">Amount</label>
                                    <input type="text" class="form-control" id="amount" placeholder="Enter Amount">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 mb-1">
                                <div class="form-group">
                                    <label for="number">Number Type</label>
                                    <select class="form-control form-control-lg" id="number_type">
                                        <option selected disabled value="0">Please select</option>
                                        <option value="1">Prepaid</option>
                                        <option value="2">Postpaid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-12 mb-1 bank-districts">
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


                            <div class="col-xl-12 col-md-12 col-12 mb-1 submit">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary waves-effect waves-float waves-light btn-submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     {{-- For Plans --}}
        <div class="content-body" >
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title" >Recharge Offer</h3>
                </div>
                <div class="card-body">


                    <div id="mbpackage" >
                        <div class="row">
                            <div class="col-12">
                               <div class="table-responsive">
                                    <table id="package" class="table table-bordered newreqtable text-center">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Details</th>
                                                <th>Validity</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="plan-types">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- For Plans --}}
</div>
@endsection

@section('javascript')
    <script src="{{url('backend/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{url('backend/app-assets/vendors/js/ui/jquery.sticky.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous" ></script>
    <script src="{{url('backend/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#number").mask('999-99999999');

             $("#operator").change(function() {
                var operator = $(this).val();
                var link = '/dashboard/find-operator/' + operator;

                $.get(link, function(res) {
                    if (res['status'] == "success") {
                        var html = "";
                        var planTypes = res.data;
                        for (var i = 0; i < planTypes.length; i++) {

                            var plans = planTypes[i]["plans"];
                            if (plans && plans.length > 0) {
                                for (var j = 0; j < plans.length; j++) {
                                     html += '<tr">';
                                    html += '<td>' + planTypes[i]["planType"]["title"] + '</td>';
                                    html += '<td>' + plans[j]["description"] +'</td>';
                                    html += '<td>' + plans[j]["time"] +'</td>';
                                    html += '<td>' + plans[j]["price"] +'</td>';
                                    html += '<td><button data-id = "'+ planTypes[i]["planType"]["id"] +'" data-price = "'+ plans[j]["price"] +'" type="button" class="btn btn-primary waves-effect waves-float waves-light btn-package-price">Buy Now</button></td>';
                                    html += '</tr>';
                                }
                            } else {
                                html += '<tr><td  colspan="10">No Plans Available. Select another oparetor.</td></tr>';
                            }

                        }
                        $("#plan-types").html(html);
                        $("#plan-types").slideDown();
                    }
                });
            });

            $("#plan-types").on("click", ".package-price", function() {
                var price = $(this).data('price');
                $("#amount").val(price);
                var id = $(this).data('id');
                $("#plan-id").val(id);
                // $("#all-information").slideDown();
            });

            $("#plan-types").on("click", ".btn-package-price", function() {
                var price = $(this).data('price');
                $("#amount").val(price);
                var id = $(this).data('id');
                $("#plan-id").val(id);
                // $("#all-information").slideDown();
            });


              $(".btn-submit").click(function() {
                var operator = $("#operator").val();
                var number = $("#number").val();
                var amount = $("#amount").val();
                var numbertype = $("#number_type").val();
                var pin = $("#pin").val();
                var planid = $("#plan-id").val();
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
                        if (operator != "") {
                            if (number != "" && number.length == 12) {
                                if (amount != "" && amount >= 20 && amount <= 1000) {

                                    if (numbertype != null) {
                                        if (pin != "") {
                                            $(this).html(
                                                "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                            );
                                            $(this).attr("disabled", "disabled");
                                            $.ajax({
                                                url: "/dashboard/mobile-recharge-submit",
                                                type: "POST",
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    operator: operator,
                                                    number: number,
                                                    amount: amount,
                                                    numbertype: numbertype,
                                                    pin: pin,
                                                    planid: planid,
                                                },
                                                success: function(response) {
                                                    if (response['status'] ==
                                                        "success") {
                                                        $(".alert-body-success").html(
                                                            response['message']);
                                                        $(".alert-success").slideDown();
                                                        $(".alert-warning").slideUp();
                                                        $(".btn-submit").html("Submit");
                                                        setTimeout(() => {
                                                            location.reload();
                                                        }, 2000);
                                                    } else if (response['status'] ==
                                                        "warning") {
                                                        $(".alert-body-warning").html(
                                                            response['message']);
                                                        $(".alert-warning").slideDown();
                                                        $(".alert-success").slideUp();
                                                        $(".btn-submit").html("Submit");
                                                        $(".btn-submit").removeAttr(
                                                            "disabled");
                                                    }
                                                }
                                            });
                                        } else {
                                            $("#pin").val();
                                            $("#pin").focus();
                                            $(".alert-body-warning").html("Pin is requierd");
                                            $(".alert-warning").slideDown();
                                        }
                                    } else {
                                        $("#number_type").val();
                                        $("#number_type").focus();
                                        $(".alert-body-warning").html(
                                            "Number Type is required");
                                        $(".alert-warning").slideDown();
                                    }

                                } else {
                                    $("#amount").val();
                                    $("#amount").focus();
                                    $(".alert-body-warning").html(
                                        "Minimum Amount is 20 and Maximum Amount is 1000");
                                    $(".alert-warning").slideDown();
                                }
                            } else {
                                // $("#number").val();
                                // $("#number").focus();
                                $(".alert-body-warning").html("Give me valid number");
                                $(".alert-warning").slideDown();
                            }
                        } else {
                            $("#operator").val();
                            $("#operator").focus();
                            $(".alert-body-warning").html("Oparetor is requierd");
                            $(".alert-warning").slideDown();
                        }
                    }
                });
            });

        });
    </script>
@stop
