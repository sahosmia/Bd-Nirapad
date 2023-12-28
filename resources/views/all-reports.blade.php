@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@stop

@section('title')
    <title>All Reports</title>
@stop
@section('body')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <div class="content-body pt-2">
            <div class="row">
                <div class="col-xl-12 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search-fields" placeholder="Search Report">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <label>Request Type</label>
                        <select class="form-control" id="type">
                            <option selected disabled value="0">Please select</option>
                            @foreach ($form->where('id', '!=', '4') as $f)
                                <option value="{{ $f->id }}">{{ ucwords($f->title) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if ($user->role_id == 1 || $user->role_id == 2)
                    <div class="col-xl-3 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label>User</label>
                            <select class="form-control" id="user-id">
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
                        <select class="form-control" id="status">
                            <option selected disabled value="0">Please select</option>
                            <option value="1">Success</option>
                            <option value="2">Refunded</option>
                            <option value="3">Pandding</option>
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
                <div class="col-xl-2 col-md-6 col-12" style="margin-top:20px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-outline-primary waves-effect add-filters"><i
                                class="fa-regular fa-magnifying-glass"></i> &nbsp;Search</button>
                    </div>
                </div>
            </div>
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table id="table-user" class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">ID</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Request Type</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Method</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">From</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">To</th>                                        
                                        @if ($user->role_id == 2)
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Sender Previous Balance</th>
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Used Amount</th>
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Sender Current Balance</th>

                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Receiver Previous Balance</th>
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Used Amount</th>
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Receiver Current Balance</th>
                                        @endif
                                        @if ($user->role_id != 2)
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Previous Balance</th>
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Used Amount</th>
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Current Balance</th>
                                        @endif
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Date</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Time</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Type</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Proof</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    @foreach ($allreports as $all)
                                        <tr>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->id }}</td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;"> {{ $all->form_detail ? $all->form_detail->title : '' }} </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;"> 
                                                @if($all->form == 1)
                                                    {{$all->bank ? $all->bank->title : ""}}
                                                @elseif($all->form == 2)
                                                    @if($all->service_id == 1)
                                                        Bkash
                                                    @elseif($all->service_id == 2)
                                                        Nagad
                                                    @elseif($all->service_id == 3)
                                                        Rokect
                                                    @endIf
                                                @else
                                                    {{$all->operator ? $all->operator->title : ""}}
                                                @endif
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                {{ $all->user_detail ? $all->user_detail->name : '' }}
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->reciever_detail ? $all->reciever_detail->name : '' }}</td>
                                            @if ($user->role_id == 2)
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                    @if ($all->type == 2)
                                                        {{ $all->updated_credits - $all->amount }}
                                                    @else
                                                        {{ $all->updated_credits + $all->amount }}
                                                    @endif
                                                </td>
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->amount }}</td>
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;"> {{ $all->updated_credits }}</td>

                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->recievers_user_previous_credits }}</td>
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->amount }}</td>
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                    @if ($all->type == 1)
                                                        {{ $all->recievers_user_previous_credits - $all->amount }}
                                                    @else
                                                        {{ $all->recievers_user_previous_credits }}
                                                    @endif
                                                </td>
                                            @endif


                                            @if ($user->role_id != 2)
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                    @if ($all->user_id == $user->id)
                                                        @if ($all->type == 2)
                                                            {{ $all->updated_credits - $all->amount }}
                                                        @else
                                                            {{ $all->updated_credits + $all->amount }}
                                                        @endif
                                                    @endif

                                                    @if ($user->role_id == 6)
                                                        {{ $all->recievers_user_previous_credits }}
                                                    @endif


                                                </td>
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->amount }}</td>
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                    @if ($all->user_id == $user->id)
                                                        {{ $all->updated_credits }}
                                                    @endif

                                                    @if ($user->role_id == 6)
                                                        @if ($all->type == 1)
                                                            {{ $all->recievers_user_previous_credits - $all->amount }}
                                                        @else
                                                            {{ $all->recievers_user_previous_credits }}
                                                        @endif
                                                    @endif

                                                </td>
                                            @endif

                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                {{ date('d-m-Y', strtotime($all->created_at)) }}
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                {{ date('h:i A', strtotime($all->created_at)) }}
                                            </td>

                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if ($all->type == 1)
                                                    <div style="border-radius: 0.25rem !important;"
                                                        class="px-2 badge badge-pill badge-light-success">Credited</div>
                                                @elseif($all->type == 2)
                                                    <div style="border-radius: 0.25rem !important;"
                                                        class="px-2 badge badge-pill badge-light-danger">Refunded</div>
                                                @elseif($all->type == 3)
                                                    <div style="border-radius: 0.25rem !important;"
                                                        class="px-2 badge badge-pill badge-light-warning">Pending</div>
                                                @endif
                                            </td>

                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if (isset($all->proof))
                                                    <a target="_blank" href = "{{ url('/') }}/{{ $all->proof }}"
                                                        class="btn btn-outline-success waves-effect">View Proof</a>
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
                @if (isset($pending))
                    <div class = "col-3">
                        <p class = 'text-warning' style = "font-size:15px;"><strong>Pending : </strong>{{ $pending }}
                        </p>
                    </div>
                @endif

                @include('inc.pagination', ['allrequest' => $allreports])
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


            $(".add-filters").click(function() {
                var currentUrl = window.location.href;
                var type = $("#type").val();
                var status = $("#status").val();
                var range = $("#fp-range").val();
                var user_role_id = {{ $user->role_id }};
                var userid = (user_role_id == 1 || user_role_id == 2) ? $("#user-id").val() : "";

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
                    type: type,
                    userid: userid,
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
        });
    </script>
@stop
