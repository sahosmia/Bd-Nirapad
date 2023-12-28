@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">

@stop

@section('title')
    <title>Bank Form</title>
@stop
@section('body')
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row"></div>
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="alert alert-success" style="display: none;" role="alert"><p class="alert-body alert-body-success"></p></div>
                        <div class="alert alert-warning" style="display: none;" role="alert"><p class="alert-body alert-body-warning"></p></div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="name">Account Holder Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Account Holder Name">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="number">Account Number</label>
                            <input type="number" class="form-control" id="number" placeholder="Enter Account Number">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="number">Amount</label>
                            <input type="number" class="form-control" id="amount" placeholder="Enter Amount">
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label>Select Bank</label>
                            <select class="form-control form-control-lg" id="banks">
                                <option selected disabled value="0">Please select</option>
                                @foreach($banks as $b)
                                    <option value="{{$b->id}}">{{ucwords($b->title)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1 bank-districts" style="display: none;">
                        <div class="form-group">
                            <label for="name">Bank Districts</label>
                            <select class="form-control form-control-lg" id="banks-districts"></select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1 bank-branches" style="display: none;">
                        <div class="form-group">
                            <label for="name">Bank Branches</label>
                            <select class="form-control form-control-lg" id="banks-branches"></select>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1 bank-pin" style="display: none;">
                        <div class="form-group">
                            <label for="number">Pin</label>
                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="pin"
                                    type="password" name="pin" aria-describedby="pin" tabindex="2"
                                    maxlength="4" placeholder="Pin" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-12 mb-1 submit" style="display: none;float:left;">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light btn-submit">Submit</button>
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
            $("#banks").change(function(){
                var id = $(this).val();
                var link = '/dashboard/bank-districts/' + id;
                $.get(link , function(res){
                    if(res["status"] == "success"){
                        var html = "";
                        var bankdistricts = res.bankdistricts;
                        html += "<option selected disabled value = 0>Select Bank District</option>";
                        for(var i = 0; i < bankdistricts.length; i++){
                            html += "<option value = "+ bankdistricts[i]['id'] +">"+ bankdistricts[i]['title'] +"</option>";
                        }
                        $("#banks-districts").html(html);
                        $(".bank-districts").slideDown();
                    }
                });
            });

            $(".bank-districts").on("change", "#banks-districts", function() {
                var id = $(this).val();
                var link = '/dashboard/bank-branches/' + id;
                $.get(link , function(res){
                    if(res["status"] == "success"){
                        var html = "";
                        var bankbranches = res.bankbranches;
                        html += "<option selected disabled value = 0>Select Bank District</option>";
                        for(var i = 0; i < bankbranches.length; i++){
                            html += "<option value = "+ bankbranches[i]['id'] +">"+ bankbranches[i]['title'] +"</option>";
                        }
                        $("#banks-branches").html(html);
                        $(".bank-branches").slideDown();
                        $(".bank-pin").slideDown();
                        $(".submit").slideDown();
                    }
                });
            });

            $(".btn-submit").click(function() {
                var name = $("#name").val();
                var number = $("#number").val();
                var banks = $("#banks").val();
                var pin = $("#pin").val();
                var amount = $("#amount").val();
                var district = $("#banks-districts").val();
                var branch = $("#banks-branches").val();
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
                        if (pin != "") {
                            if (amount >= 30000 && amount <= 1000000) {
                                if (name != "") {
                                    if (number != "") {
                                        if (banks != null) {
                                            if (district != null) {
                                                if (branch != null) {
                                                    $(this).html(
                                                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                                    );
                                                    $(this).attr("disabled", "disabled");
                                                    $.ajax({
                                                        url: "/dashboard/bank-request-submit",
                                                        type: "POST",
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            name: name,
                                                            number: number,
                                                            banks: banks,
                                                            district: district,
                                                            branch: branch,
                                                            pin: pin,
                                                            amount: amount,
                                                        },
                                                        success: function(response) {
                                                            if (response['status'] ==
                                                                "success") {
                                                                $(".alert-body-success")
                                                                    .html(response[
                                                                        'message']);
                                                                $(".alert-success")
                                                                    .slideDown();
                                                                $(".alert-warning")
                                                                    .slideUp();
                                                                $(".btn-update-submit")
                                                                    .html("Submit");
                                                                setTimeout(() => {
                                                                    location
                                                                        .reload();
                                                                }, 2000);
                                                            } else if (response[
                                                                    'status'] ==
                                                                "warning") {
                                                                $(".alert-body-warning")
                                                                    .html(response[
                                                                        'message']);
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
                                                    $("#banks-branches").val();
                                                    $("#banks-branches").focus();
                                                    $(".alert-body-warning").html(
                                                        "Select the branch");
                                                    $(".alert-warning").slideDown();
                                                }
                                            } else {
                                                $("#banks-districts").val();
                                                $("#banks-districts").focus();
                                                $(".alert-body-warning").html(
                                                    "Select the district");
                                                $(".alert-warning").slideDown();
                                            }
                                        } else {
                                            $("#banks").val();
                                            $("#banks").focus();
                                            $(".alert-body-warning").html("Select a bank");
                                            $(".alert-warning").slideDown();
                                        }
                                    } else {
                                        $("#number").val();
                                        $("#number").focus();
                                        $(".alert-body-warning").html("Account number is requierd");
                                        $(".alert-warning").slideDown();
                                    }
                                } else {
                                    $("#name").val();
                                    $("#name").focus();
                                    $(".alert-body-warning").html(
                                        "Account holder name is requierd");
                                    $(".alert-warning").slideDown();
                                }
                            } else {
                                $("#amount").val();
                                $("#amount").focus();
                                $(".alert-body-warning").html(
                                    "Amount should be Minimum 30,000 to Maximum 10,00,000");
                                $(".alert-warning").slideDown();
                            }
                        } else {
                            $("#pin").val();
                            $("#pin").focus();
                            $(".alert-body-warning").html("Pin is requierd");
                            $(".alert-warning").slideDown();
                        }
                    }
                });
            });
        });
    </script>
@stop
