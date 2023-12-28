@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css')}}">
@stop

@section('title')
    <title>Reports</title>
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
        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="table-user" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allreports as $all)
                                    <tr>
                                        <td>
                                            {{$all->user_detail ? $all->user_detail->username : ""}}
                                        </td>
                                        <td>{{$all->reciever_detail ? $all->reciever_detail->username : ""}}</td>
                                        <td>
                                            {{number_format($all->amount , 2)}}
                                        </td>
                                        <td>
                                            {{date("d-m-Y" , strtotime($all->created_at))}}
                                        </td>
                                        <td>
                                            {{date('H:i',strtotime($all->created_at))}}
                                        </td>
                                        <td>
                                            @if(isset($all->proof))
                                                <a target="_blank" href = "{{url('/')}}/{{$all->proof}}" class="btn btn-outline-success waves-effect">View Proof</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @include('inc.pagination', ['allrequest' => $allreports])
        </div>
    </div>
</div>
@endsection

@section('javascript')
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
    </script>
@stop
