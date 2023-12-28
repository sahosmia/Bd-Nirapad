@extends('/layouts/master')
@section('credit-request', 'active')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@stop

@section('title')
    <title>Credit Request</title>
@stop
@section('body')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <div class="content-body pt-2">
            <div class="row">
                <div class="col-xl-10 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search-fields" placeholder="Search Credit Requests">
                    </div>
                </div>
            </div>

            {{-- Filter Pert  --}}
               <div class = "row">
                @if ($user->role_id == 1 || $user->role_id == 2)
                    <div class="col-xl-3 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label>All Users</label>
                            <select class="form-control" id="all-users">
                                <option selected disabled value="0">Please select</option>
                                @foreach ($allusers as $u)
                                    <option value="{{ $u->id }}">{{ ucwords($u->username) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                <div class="col-xl-3 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" id="type">
                            <option selected disabled value="0">Please select</option>
                            <option value="1">Credited</option>
                            <option value="2">Refunded</option>
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
                            class="fa-regular fa-magnifying-glass"></i> &nbsp;Search</button>
                </div>
            </div>
            {{-- Filter Pert end --}}


             <div class="row" id="table-head">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="table-user" class="table table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Id</th>
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">User Name</th>
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;"> To </th>

                                    @if ($user->role_id == 2 || $user->role_id == 1)
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Sender Previous Balance</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Used Amount</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Sender Current Balance</th>

                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Receiver Previous Balance</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Used Amount</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Receiver Current Balance</th>
                                    @else
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Previous Balance</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Used Amount</th>
                                        <th  style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Current Balance</th>
                                    @endif
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Type</th>
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Date</th>
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Time</th>
                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allrequest as $all)
                                    <tr>
                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->id }}</td>
                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->user_detail ? $all->user_detail->username : '' }}</td>
                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                            @if (isset($all->sender_details))
                                                {{ $all->sender_details ? $all->sender_details->username : '' }}
                                            @endif
                                        </td>
                                        @if ($user->role_id == 2 || $user->role_id == 1)
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if($all->user_id == $user->id)
                                                    Unlimited
                                                @else 
                                                    {{ $all->user_previous_credits }}</td>
                                                @endif
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->amount }}</td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if($all->user_id == $user->id)
                                                    Unlimited
                                                @else
                                                    @if ($all->type == 1)
                                                        {{ $all->user_previous_credits - $all->amount }}
                                                    @elseif($all->type == 2)
                                                        {{ $all->user_previous_credits + $all->amount }}
                                                    @endif
                                                @endif
                                            </td>



                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if ($all->type == 1)
                                                    {{ $all->updated_credits - $all->amount }}
                                                @elseif($all->type == 2)
                                                    {{ $all->updated_credits + $all->amount }}
                                                @endif
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->amount }}</td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->updated_credits }}</td>
                                        @endif



                                        @if ($user->role_id != 2)
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if ($all->recievers_id == $user->id)
                                                    @if ($all->type == 1)
                                                        {{ $all->updated_credits - $all->amount }}
                                                    @elseif($all->type == 2)
                                                        {{ $all->updated_credits + $all->amount }}
                                                    @endif
                                                @endif

                                                @if ($all->user_id == $user->id)
                                                    {{ $all->user_previous_credits }}
                                                @endif

                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->amount }}</td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if ($all->recievers_id == $user->id)
                                                    {{ $all->updated_credits }}
                                                @endif

                                                @if ($all->user_id == $user->id)
                                                    @if ($all->type == 1)
                                                        {{ $all->user_previous_credits - $all->amount }}
                                                    @elseif($all->type == 2)
                                                        {{ $all->user_previous_credits + $all->amount }}
                                                    @endif
                                                @endif

                                            </td>
                                        @endif



                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                            @if ($all->type == 1)
                                                <div style="border-radius: 0.25rem !important;"
                                                    class="px-2 badge badge-pill badge-light-success">Credited</div>
                                            @elseif($all->type == 2)
                                                <div style="border-radius: 0.25rem !important;"
                                                    class="px-2 badge badge-pill badge-light-danger">Refunded</div>
                                            @endif
                                        </td>
                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                            {{ date('d-m-Y', strtotime($all->created_at)) }}
                                        </td>
                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                            {{ date('h:i A', strtotime($all->created_at)) }}
                                        </td>
                                        <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                            @if (isset($all->comment))
                                                {{ $all->comment }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if (isset($success))
                <div class = "col-3">
                    <p class = 'text-success' style = "font-size:15px;"><strong>Success : </strong>{{ $success }}
                    </p>
                </div>
            @endif

            @if (isset($refunded))
                <div class = "col-3">
                    <p class = 'text-danger' style = "font-size:15px;"><strong>Refunded : </strong>{{ $refunded }}
                    </p>
                </div>
            @endif

            @include('inc.pagination', ['allrequest' => $allrequest])
        </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="{{ url('backend/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('backend/app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
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

            $(".btn-update-submit").click(function() {
                var id = $("#request-id").val();
                var status = $("#status").val();
                var comment = $("#comments").val();
                if (status != "") {
                    var formData = new FormData();
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("status", status);
                    formData.append("id", id);
                    formData.append("comment", comment);
                    var img = $("#transaction-proof").get(0);
                    var file = img.files[0];
                    if (file) {
                        var filename = file.name;
                        var fileext = filename.substring(filename.lastIndexOf('.') + 1).toLowerCase();
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

                    $(this).html(
                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                    );
                    $(this).attr("disabled", "disabled");
                    $.ajax({
                        url: "/dashboard/credit-request-update",
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
                            }
                        }
                    });
                }
            });

            $(".add-filters").click(function() {
                var currentUrl = window.location.href;
                var page = {{ $allrequest->currentPage() }};
                var type = $("#type").val();
                var userid = $("#all-users").val();
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
                    page: page,
                    type: type,
                    range: range,
                };

                if (userid) {
                    newParams.userid = userid;
                }

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

        });
    </script>
@stop
