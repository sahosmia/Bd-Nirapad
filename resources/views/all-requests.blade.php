@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@stop

@section('title')
    <title>All Requests</title>
@stop
@section('body')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <div class="content-body pt-2">
            <div class="row">
                <div class="col-xl-12 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search-fields" placeholder="Search Requests">
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-xl-3 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="status">
                            <option selected disabled value="0">Please select</option>
                            <option value="1">Success</option>
                            <option value="2">Refunded</option>
                            <option value="2">Pandding</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <label for="fp-range">Range</label>
                        <input type="text" id="fp-range" class="form-control flatpickr-range"
                            placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                    </div>
                </div>
                <div class="col-xl-2 col-md-6 col-12" style = "margin-top:20px;">
                    <button type="button" class="btn btn-outline-primary waves-effect add-filters"><i
                            class="fa-light fa-magnifying-glass"></i> &nbsp;Search</button>
                </div>
            </div>
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table id="table-user" class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Account Title</th>
                                        <th>Account No</th>
                                        <th>Bank Name</th>
                                        <th>Bank District</th>
                                        <th>Branch Name</th>

                                        @if ($user->role_id == 2)
                                            <th>Sender Previous Balance</th>
                                            <th>Amount</th>
                                            <th>Sender Current Balance</th>

                                            <th>Receiver Previous Balance</th>
                                            <th>Amount</th>
                                            <th>Receiver Current Balance</th>
                                        @endif
                                        @if ($user->role_id != 2)
                                            <th>Previous Balance</th>
                                            <th>Amount</th>
                                            <th>Current Balance</th>
                                        @endif
                                        <th>Sent By</th>
                                        <th>Date/Time</th>
                                        <th>Type</th>
                                        <th>Proof</th>
                                        <th>Comments</th>
                                        @if ($user->role_id == 1 || $user->role_id == 6)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                 <tbody>
                                    @foreach ($allrequests as $all)
                                        <tr>
                                            <td>{{ $all->id }}</td>
                                            <td>
                                                {{ $all->name }}
                                            </td>
                                            <td>{{ $all->number }}</td>
                                            <td>
                                                {{ $all->bank_detail ? $all->bank_detail->title : '' }}
                                            </td>
                                            <td>
                                                {{ $all->bank_district_detail ? $all->bank_district_detail->title : '' }}
                                            </td>
                                            <td>
                                                {{ $all->bank_branch_detail ? $all->bank_branch_detail->title : '' }}
                                            </td>
                                            @if ($user->role_id == 2)
                                                <td>
                                                    @if ($all->status == 2)
                                                        {{ $all->updated_credits }}
                                                    @else
                                                        {{ $all->updated_credits + $all->amount }}
                                                    @endif
                                                </td>
                                                <td>{{ $all->amount }}</td>
                                                <td> {{ $all->updated_credits }}</td>

                                                <td>{{ $all->recivers_user_previous_credits }}</td>
                                                <td>{{ $all->amount }}</td>
                                                <td>
                                                    @if ($all->status == 1)
                                                        {{ $all->recivers_user_previous_credits - $all->amount }}
                                                    @else
                                                        {{ $all->recivers_user_previous_credits }}
                                                    @endif
                                                </td>
                                            @endif


                                            @if ($user->role_id != 2)
                                                <td>
                                                    @if ($all->user_id == $user->id)
                                                        @if ($all->status == 2)
                                                            {{ $all->updated_credits }}
                                                        @else
                                                            {{ $all->updated_credits + $all->amount }}
                                                        @endif
                                                    @endif

                                                    @if ($user->role_id == 6)
                                                        {{ $all->recivers_user_previous_credits }}
                                                    @endif


                                                </td>
                                                <td>{{ $all->amount }}</td>
                                                <td>
                                                    @if ($all->user_id == $user->id)
                                                        {{ $all->updated_credits }}
                                                    @endif

                                                    @if ($user->role_id == 6)
                                                        @if ($all->status == 1)
                                                            {{ $all->recivers_user_previous_credits - $all->amount }}
                                                        @else
                                                            {{ $all->recivers_user_previous_credits }}
                                                        @endif
                                                    @endif

                                                </td>
                                            @endif



                                            <td>{{ $all->user_detail ? $all->user_detail->username : '' }}</td>
                                            <td>
                                                {{ date('d-m-Y', strtotime($all->created_at)) }} /
                                                {{ date('h:i A', strtotime($all->created_at)) }}
                                            </td>
                                            <td>
                                                @if ($all->status == 1)
                                                    <div style="border-radius: 0.25rem !important;"
                                                        class="px-2 badge badge-pill badge-light-success">Credited</div>
                                                @elseif($all->status == 2)
                                                    <div style="border-radius: 0.25rem !important;"
                                                        class="px-2 badge badge-pill badge-light-danger">Refunded</div>
                                                @elseif($all->status == 3)
                                                    <div style="border-radius: 0.25rem !important;"
                                                        class="px-2 badge badge-pill badge-light-warning">Pending</div>
                                                @endif
                                            </td>

                                            <td>
                                                @if (isset($all->request_detail))
                                                    @if (isset($all->request_detail->proof))
                                                        <a target="_blank"
                                                            href = "{{ url('/') }}/{{ $all->request_detail->proof }}"
                                                            class="btn btn-outline-success waves-effect">View Proof</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($all->comment))
                                                    {{ $all->comment }}
                                                @endif
                                            </td>
                                            @if ($user->role_id == 1 || $user->role_id == 6)
                                                <td>
                                                    @if ($all->status == 3)
                                                        <button data-id="{{ $all->id }}"
                                                            data-status = "{{ $all->status }}" type="button"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="Update Status"
                                                            class="btn btn-outline-warning waves-effect mb-1 update-status"><i
                                                                class="fa-light fa-pen"></i></button>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @include('inc.pagination', ['allrequest' => $allrequests])
            </div>
        </div>
    </div>

    {{-- Update Status Modal --}}
    <div class="modal fade text-left" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Update Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <input type="hidden" id="request-id">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
                        <label>Status: </label>
                        <div class="form-group">
                            <select class="form-control form-control-lg" id="update-status">
                                <option selected disabled value="0">Please select</option>
                                <option value="1">Success</option>
                                <option value="2">Refund</option>
                            </select>
                        </div>
                        <div class="form-group transation-proof" style="display: none">
                            <label>Transation Proof: </label>
                            <div class="custom-file">
                                <input type="file" accept="image/png, image/gif, image/jpeg" class="custom-file-input" id="transaction-proof">
                                <label class="custom-file-label" for="transaction-proof">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Comment: </label>
                            <input id="comments" type="text" placeholder="Comments" class="form-control" />
                        </div>

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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-update-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Update Status Modal --}}

@endsection

@section('javascript')
    <script src="{{ url('backend/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('backend/app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <script src="{{ url('backend/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script>
        document.getElementById("search-fields").addEventListener("input", filterTable);

        function filterTable(event) {
            var query = event.target.value.toLowerCase();
            var rows = document.getElementById("table-user").querySelectorAll("tbody tr");
            rows.forEach(function(row) {
                var cells = row.querySelectorAll("td");
                var nameCell = cells[0];
                var match = false;
                if (nameCell.textContent.toLowerCase().includes(query)) {
                    match = true;
                } else {
                    for (var j = 1; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().includes(query)) {
                            match = true;
                            break;
                        }
                    }
                }
                if (match) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        $(document).ready(function() {
            $(".update-status").click(function() {
                $("#status-modal").modal('show');
                var id = $(this).data('id');
                $("#request-id").val(id);
            });
            
            $("#update-status").change(function() {
                var status = $(this).val();
                if (status == 1) {
                    $(".transation-proof").slideDown();
                } else {
                    $(".transation-proof").slideUp();
                }
            });

            $(".add-filters").click(function() {
                var currentUrl = window.location.href;
                var status = $("#status").val();
                var range = $("#fp-range").val();

                function updateUrlParameter(url, paramName, paramValue) {
                    var pattern = new RegExp('([?&])' + paramName + '=.*?(&|$)');
                    if (url.match(pattern)) {
                        return url.replace(pattern, '$1' + paramName + '=' + paramValue + '$2');
                    } else {
                        if (url.indexOf('?') !== -1) {
                            return url + '&' + paramName + '=' + paramValue;
                        } else {
                            return url + '?' + paramName + '=' + paramValue;
                        }
                    }
                }

                var newParams = {
                    status: status,
                    range: range
                };

                var queryString = '';
                for (var key in newParams) {
                    if (newParams[key] !== null && newParams[key] !== "") {
                        if (queryString !== '') {
                            queryString += '&';
                        }
                        queryString += key + '=' + encodeURIComponent(newParams[key]);
                    }
                }

                if (queryString !== "") {
                    // Remove existing query string (if any)
                    var urlWithoutQueryString = currentUrl.split('?')[0];
                    // Construct the new URL with the new query string
                    var newUrl = urlWithoutQueryString + '?' + queryString;
                    // Redirect to the new URL
                    window.location.href = newUrl;
                }
            });

            $(".btn-update-submit").click(function() {
                var id = $("#request-id").val();
                var status = $("#update-status").val();
                var comment = $("#comments").val();
                var pin = $("#pin").val();
                if (pin != "") {
                    if (status != null) {
                        if (status == 1) { // success
                            var img = $("#transaction-proof").get(0);
                            var file = img.files[0];
                            if (file != null) {
                                var formData = new FormData();
                                formData.append("_token", "{{ csrf_token() }}");
                                formData.append("status", status);
                                formData.append("id", id);
                                formData.append("comment", comment);
                                formData.append("pin", pin);

                                var filename = file.name;
                                var fileext = filename.substring(filename.lastIndexOf('.') + 1)
                                    .toLowerCase();
                                var allowext = ['jpg', 'jpeg', 'png'];
                                var size = file.size;
                                var maxsize = 1048576;

                                if (size > maxsize) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'warning',
                                        title: "Your image size is greater than 1 MB",
                                        showConfirmButton: true,
                                    });
                                    return;
                                }

                                if ($.inArray(fileext, allowext) === -1) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'warning',
                                        title: "Only JPG, JPEG & PNG allowed",
                                        showConfirmButton: true,
                                    });
                                    return;
                                }

                                formData.append("image", file);
                                $(this).html(
                                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                    );
                                    $(this).attr("disabled", "disabled");

                                $.ajax({
                                    url: "/dashboard/bank-request-update",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        if (response['status'] == "success") {
                                            $(".alert-body-success").html(response['message']);
                                            $(".alert-success").slideDown();
                                            $(".alert-warning").slideUp();
                                            $(".btn-update-submit").html("Submit");
                                            setTimeout(() => {
                                                location.reload();
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
                                $(".alert-body-warning").html("Transaction Proof must need for Success");
                                $(".alert-warning").slideDown();
                            }

                        } else { //refund
                            if (comment != "") {
                                var formData = new FormData();
                                formData.append("_token", "{{ csrf_token() }}");
                                formData.append("status", status);
                                formData.append("id", id);
                                formData.append("comment", comment);
                                formData.append("pin", pin);
                                var img = $("#transaction-proof").get(0);
                                var file = img.files[0];
                                if (file) {
                                    var filename = file.name;
                                    var fileext = filename.substring(filename.lastIndexOf('.') + 1)
                                        .toLowerCase();
                                    var allowext = ['jpg', 'jpeg', 'png'];
                                    var size = file.size;
                                    var maxsize = 1048576;

                                    if (size > maxsize) {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'warning',
                                            title: "Your image size is greater than 1 MB",
                                            showConfirmButton: true,
                                        });
                                        return;
                                    }

                                    if ($.inArray(fileext, allowext) === -1) {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'warning',
                                            title: "Only JPG, JPEG & PNG allowed",
                                            showConfirmButton: true,
                                        });
                                        return;
                                    }

                                    formData.append("image", file);
                                }

                                $.ajax({
                                    url: "/dashboard/bank-request-update",
                                    type: "POST",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        if (response['status'] == "success") {
                                            $(".alert-body-success").html(response['message']);
                                            $(".alert-success").slideDown();
                                            $(".alert-warning").slideUp();
                                            $(".btn-update-submit").html("Submit");
                                            setTimeout(() => {
                                                location.reload();
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
                                $(".alert-body-warning").html("Comment must need for refund");
                                $(".alert-warning").slideDown();
                            }
                        }
                    } else {
                        $(".alert-body-warning").html("Choose a status");
                        $(".alert-warning").slideDown();
                    }
                } else {
                    $(".alert-body-warning").html("Please enter pin");
                    $(".alert-success").slideUp();
                    $(".alert-warning").slideDown();
                }
            });
        });
    </script>
@stop
