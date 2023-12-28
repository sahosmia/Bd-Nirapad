@extends('/layouts/master')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/css/plugins/extensions/ext-component-sweet-alerts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ url('backend/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
@stop

@section('title')
    <title>Users</title>
@stop
@section('body')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <div class="content-body pt-2">
            <div class="row">
                {{-- search input  --}}
                <div class="col-xl-8 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <input type="text" class="form-control" id="search-fields" placeholder="Search User">
                    </div>
                </div>

                @if ($user->role_id == 4)
                    @if ($user->level != 1)
                        <div class="col-xl-2 col-md-6 col-12 mb-1">
                            <button type="button" class="btn btn-outline-primary waves-effect add-user"><i
                                    class="fa-light fa-user"></i> &nbsp;Add User</button>
                        </div>
                    @endif
                @elseif($user->role_id != 5 || $user->role_id != 5)
                    <div class="col-xl-2 col-md-6 col-12 mb-1">
                        <button type="button" class="btn btn-outline-primary waves-effect add-user"><i
                                class="fa-light fa-user"></i> &nbsp;Add User</button>
                    </div>
                @endif
            </div>
            {{-- Filter Section  --}}
            <div class="row">
                {{-- Roles  --}}
                @if ($user->role_id == 1 || $user->role_id == 2)
                    <div class="col-xl-3 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label>Roles</label>
                            <select class="form-control" id="filter-roles">
                                <option selected disabled value="0">Please select</option>
                                @foreach ($allroles as $r)
                                    <option value="{{ $r->id }}">{{ ucwords($r->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                {{-- Status  --}}
                <div class="col-xl-3 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="status">
                            <option selected disabled value="">Please select</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                </div>

                {{-- Created By --}}
                @if ($user->role_id == 1 || $user->role_id == 2)
                    <div class="col-xl-3 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label>Created By</label>
                            <select class="form-control" id="created-by">
                                <option selected disabled value="">Please select</option>
                                @foreach ($created_users as $u)
                                    @if ($u->role_id != 1)
                                        <option value="{{ $u->id }}">{{ ucwords($u->username) }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                {{-- Range  --}}
                <div class="col-xl-3 col-md-6 col-12 mb-1">
                    <div class="form-group">
                        <label for="fp-range">Range</label>
                        <input type="text" id="fp-range" class="form-control flatpickr-range"
                            placeholder="YYYY-MM-DD to YYYY-MM-DD" />
                    </div>
                </div>

                {{-- Button  --}}
                <div class="col-xl-2 col-md-6 col-12 mb-1 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-primary waves-effect add-filters "><i
                            class="fa-light fa-filter"></i> &nbsp;Search</button>
                </div>
            </div>
            {{-- Filter Section end  --}}

            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table id="table-user" class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Name</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Role</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Sales</th>
                                        @if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3)
                                            <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Partners</th>
                                        @endif
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Credit</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Status</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Created</th>
                                        <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alluser as $all)
                                        <tr>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">

                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="font-weight-bolder">{{ ucwords($all->name) }}</div>
                                                        <div class="font-small-2 text-muted">Email: {{ $all->email }}
                                                        </div>
                                                        <div class="font-small-2 text-muted">Username: {{ $all->username }}
                                                        </div>
                                                        <div class="font-small-2 text-muted">Contact: {{ $all->contact_no }}
                                                        </div>
                                                        @if (isset($all->level))
                                                            <div class="font-small-2 text-muted">Type:
                                                                {{ $all->level_detail ? $all->level_detail->title : '' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                {{ $all->role_detail ? $all->role_detail->display_name : '' }}
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;"style="border: 1px solid #7367f0; padding: 8px; text-align: left;"v>
                                                @php
                                                    if ($all->role_id == 5 || $all->role_id == 6) {
                                                        $amount = $all->master_sales->sum('amount');
                                                    } else {
                                                        $amount = $all->user_sales->sum('amount');
                                                    }

                                                    if ($amount >= 10000) {
                                                        $formattedAmount = number_format($amount / 1000, 0) . 'k';
                                                    } else {
                                                        $formattedAmount = $amount;
                                                    }
                                                @endphp
                                                {{ $formattedAmount }}
                                            </td>
                                            @if ($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3)
                                                <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">{{ $all->partner_detail ? $all->partner_detail->name : '' }}</td>
                                            @endif
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if ($all->role_id == 2 || $all->role_id == 1)
                                                    @if ($all->credits == '')
                                                        Unlimited
                                                    @elseif($all->credits != '')
                                                        {{ $all->credits }}
                                                    @endif
                                                @elseif($all->role_id != 2)
                                                    @if (isset($all->credits))
                                                        {{ $all->credits }}
                                                    @else
                                                        {{ 0 }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                <div class="d-flex align-items-center">
                                                    @if ($all->status == 1)
                                                        <div style="border-radius: 0.25rem !important;"
                                                            class="px-2 badge badge-pill badge-light-success">Active</div>
                                                    @elseif($all->status == 0)
                                                        <div style="border-radius: 0.25rem !important;"
                                                            class="px-2 badge badge-pill badge-light-danger">In Active</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                @if (isset($all->created_by))
                                                    {{ $all->userdetail ? $all->userdetail->name : '' }}
                                                @endif
                                            </td>
                                            <td style="border: 1px solid #7367f0; padding: 8px; text-align: left;">
                                                {{-- Deactivate Account --}}
                                                @if ($all->role_id != 6)
                                                    @if ($all->status == 1)
                                                        <button data-userid = "{{ $all->id }}" type="button"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="Deactivate Account"
                                                            class="btn btn-outline-danger waves-effect mb-1 deactive-account"><i
                                                                class="fa-regular fa-ban"></i></button>
                                                    @else
                                                        <button data-userid = "{{ $all->id }}" type="button"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="Activate Account"
                                                            class="btn btn-outline-success waves-effect mb-1 active-account"><i
                                                                class="fa-light fa-lock"></i></button>
                                                    @endif
                                                @endif
                                                
                                                {{-- Assign Partner only super admin --}}
                                                @if ($user->role_id == 1 || $user->role_id == 2)
                                                    @if ($all->role_id == 3 || $all->role_id == 4)
                                                        <button data-userid = "{{ $all->id }}" type="button"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="Assign Partner"
                                                            class="btn btn-outline-warning waves-effect mb-1 assign-partner"><i
                                                                class="fa-thin fa-user"></i></button>
                                                    @endif
                                                @endif
                                                
                                                {{-- Add Credit --}}
                                                <button type="button" data-userid = "{{ $all->id }}"
                                                    data-toggle="tooltip" data-placement="top"
                                                    data-original-title="Add Credit"
                                                    class="btn btn-outline-success waves-effect mb-1 add-credit"><i
                                                        class="fa-light fa-dollar-sign"></i>
                                                </button>

                                                {{-- Refund Credit --}}
                                                @if ($all->credits > 0)
                                                    <button data-userid = "{{ $all->id }}" type="button"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="Refund Credit"
                                                        class="btn btn-outline-danger waves-effect mb-1 refund-credit"><i
                                                            class="fa-thin fa-money-check-dollar-pen"></i></button>
                                                @endif


                                                {{-- View Pin only super admin --}}
                                                @if ($user->role_id != 4 && $user->role_id != 3)
                                                    <button data-toggle="tooltip" data-placement="top"
                                                        data-original-title="View Pin" type="button"
                                                        data-name = "{{ ucwords($all->username) }}"
                                                        data-pin = "{{ $all->pin }}"
                                                        class="btn btn-outline-success waves-effect mb-1 pin-view"><i
                                                            class="fa-light fa-key"></i></button>
                                                @endif

                                                {{-- Reset Pin --}}
                                                @if (isset($all->pin))
                                                    <button data-userid="{{ $all->id }}" type="button"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="Reset Pin"
                                                        class="btn btn-outline-warning waves-effect mb-1 reset-pin"><i
                                                            class="fa-light fa-rotate-right"></i></button>
                                                @endif

                                                
                                                

                                                {{-- Reset Password --}}
                                                @if ($user->role_id != 4)
                                                    <button data-userid = "{{ $all->id }}" type="button"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="Reset Password"
                                                        class="btn btn-outline-primary waves-effect mb-1 reset-password"><i
                                                            class="fa-light fa-eye"></i></button>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               @include('inc.pagination', ['allrequest' => $alluser])
            </div>
        </div>
    </div>

    {{-- Add User Modal --}}
    <div class="modal fade text-left" id="add-user-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
                        <label>Name: </label>
                        <div class="form-group">
                            <input id="name" type="text" placeholder="Name" class="form-control" />
                            <div class="feedback" style="display: none;"></div>
                        </div>
                        <label>Username: </label>
                        <div class="form-group">
                            <input id="username" type="text" placeholder="Username" class="form-control" />
                            <div class="feedback" style="display: none;"></div>
                        </div>
                        <label>Email: </label>
                        <div class="form-group">
                            <input id="email" type="email" placeholder="Email Address" class="form-control" />
                        </div>
                        <label>Phone: </label>
                        <div class="form-group">
                            <input id="phone" type="text" placeholder="Phone Number" class="form-control" />
                        </div>
                        <label>Password: </label>
                        <div class="form-group">
                            <div class="input-group form-password-toggle">
                                <input id="password" type="password" placeholder="Password" class="form-control" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label>Role: </label>
                        <div class="form-group">
                            <select class="form-control" id="user-roles">
                                <option value="0" selected disabled>Please Select</option>
                                @foreach ($roles as $r)
                                    <option value = "{{ $r->id }}">{{ $r->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group levels" style="display: none;">
                            <label>Levels: </label>
                            <select class="form-control" id="levels">
                                <option value="0" selected disabled>Please Select</option>
                                @foreach ($level as $l)
                                    <option value="{{ $l->id }}">{{ $l->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add User Modal --}}

    {{-- Add Credit Modal --}}
    <div class="modal fade text-left" id="add-credit-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Credit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <input type="hidden" id="recivers-id-credit">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
                        <label>Amount: </label>
                        <div class="form-group">
                            <input id="amount-credit" type="text" placeholder="Amount" class="form-control" />
                        </div>
                        <label>Comment: </label>
                        <div class="form-group">
                            <input id="comment" type="text" placeholder="Comment" class="form-control" />
                        </div>
                        <div class="form-group" style = "display:none;">
                            <label>Transation Proof: </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="transaction-proof">
                                <label class="custom-file-label" for="transaction-proof">Choose file</label>
                            </div>
                        </div>
                        <label for="pin-credit">Pin :</label>
                        <div class="form-group">

                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="pin-credit"
                                    type="password" name="pin-credit" aria-describedby="password" tabindex="2"
                                    maxlength="4" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-add-credit-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Add Credit Modal --}}

    {{-- Refund Credit Modal --}}
    <div class="modal fade text-left" id="refund-credit-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Refund Credit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <input type="hidden" id="recivers-id-refund">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
                        <label>Amount: </label>
                        <div class="form-group">
                            <input id="amount-refund" type="text" placeholder="Amount" class="form-control" />
                        </div>
                        <label>Comment: </label>
                        <div class="form-group">
                            <input id = "refund-comment" type="text" placeholder="Comment" class="form-control" />
                        </div>
                        <label for="pin-refund">Pin :</label>
                        <div class="form-group">
                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="pin-refund"
                                    type="password" name="pin-refund" aria-describedby="password" tabindex="2"
                                    maxlength="4" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-add-refund-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Refund Credit Modal --}}

    {{-- Assign Partner Modal --}}
    <div class="modal fade text-left" id="assign-partner-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Assign Partner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <input type="hidden" id="user-id">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
                        <label>Partner: </label>
                        <div class="form-group">
                            <select class="form-control form-control-lg" id="partners">
                                <option selected disabled value="0">Please select</option>
                                @foreach ($partners as $p)
                                    <option value="{{ $p->id }}">{{ ucwords($p->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-assign-partner-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Assign Partner Modal --}}


    {{-- Reset Pin Modal --}}
    <div class="modal fade text-left" id="reset-pin-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Reset Pin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <input type="hidden" id="reset-pin-user-id">
                    <div class="modal-body">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
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
                        <button type="button" class="btn btn-primary btn-reset-pin-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Reset Pin Modal --}}

    {{-- Reset Password Modal --}}
    <div class="modal fade text-left" id="reset-password-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#">
                    <input type="hidden" id="reset-password-user-id">
                    <div class="modal-body">
                        <div class="alert alert-success" style="display: none;" role="alert">
                            <p class="alert-body alert-body-success"></p>
                        </div>
                        <div class="alert alert-warning" style="display: none;" role="alert">
                            <p class="alert-body alert-body-warning"></p>
                        </div>
                        <label>Password: </label>
                        <div class="form-group">
                            <div class="input-group form-password-toggle">
                                <input class="form-control form-control-merge border-right" id="change-password"
                                    type="password" name="change-password" aria-describedby="password" tabindex="2"
                                    placeholder="change-password" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-reset-password-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Reset Password Modal --}}
@endsection

@section('javascript')
    <script src="{{ url('backend/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha256-yE5LLp5HSQ/z+hJeCqkz9hdjNkk1jaiGG0tDCraumnA=" crossorigin="anonymous"></script>
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
            $("#phone").mask('99999999999');

            $(".pin-view").click(function() {
                var pin = $(this).data('pin');
                var name = $(this).data('name');
                if (pin != "") {
                    Swal.fire({
                        title: name + " Pin is " + pin,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Sorry! Pin not found',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                }
            });

            $(".add-user").click(function() {
                $("#add-user-modal").modal('show');
            });

            $(".add-credit").click(function() {
                $("#add-credit-modal").modal('show');
                var userid = $(this).data('userid');
                $("#recivers-id-credit").val(userid);
            });

            $(".refund-credit").click(function() {
                $("#refund-credit-modal").modal('show');
                var userid = $(this).data('userid');
                $("#recivers-id-refund").val(userid);
            });

            $(".add-filters").click(function() {
                $("#add-filter-modal").modal('show');
            });

            $(".assign-partner").click(function() {
                $("#assign-partner-modal").modal('show');
                var id = $(this).data('userid');
                $("#user-id").val(id);
            });

            $(".reset-pin").click(function() {
                $("#reset-pin-modal").modal('show');
                var id = $(this).data('userid');
                $("#reset-pin-user-id").val(id);
            });

            $(".reset-password").click(function() {
                $("#reset-password-modal").modal('show');
                var id = $(this).data('userid');
                $("#reset-password-user-id").val(id);
            });

            $("#user-roles").change(function() {
                var id = $(this).val();
                if (id == 4) {
                    $(".levels").slideDown();
                } else {
                    $(".levels").slideUp();
                }
            });

            $("#username").blur(function() {
                var value = $(this).val();
                var link = '/dashboard/check?username=' + value;
                $.get(link, function(res) {
                    if (res['status'] == "success") {
                        if ($("#username").hasClass('is-invalid')) {
                            $("#username").removeClass('is-invalid');
                        }
                        $(".btn-submit").removeAttr("disabled");
                        $("#username").addClass('is-valid');
                    } else if (res['status'] == "warning") {
                        if ($("#username").hasClass('is-valid')) {
                            $("#username").removeClass('is-valid');
                        }
                        $("#username").addClass('is-invalid');
                        $(".btn-submit").attr("disabled", "disabled");
                    }
                });
            });

            $("#email").blur(function() {
                var value = $(this).val();
                var link = '/dashboard/check?email=' + value;
                $.get(link, function(res) {
                    if (res['status'] == "success") {
                        if ($("#email").hasClass('is-invalid')) {
                            $("#email").removeClass('is-invalid');
                        }
                        $("#email").addClass('is-valid');
                        $(".btn-submit").removeAttr("disabled");


                    } else if (res['status'] == "warning") {
                        if ($("#email").hasClass('is-valid')) {
                            $("#email").removeClass('is-valid');
                        }
                        $("#email").addClass('is-invalid');
                        $(".btn-submit").attr("disabled", "disabled");

                    }
                });
            });

            $(".deactive-account").click(function() {
                var userid = $(this).data('userid');
                var link = '/dashboard/deactive-account/' + userid;
                $.get(link, function(res) {
                    if (res['status'] == 'success') {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });

            $(".active-account").click(function() {
                var userid = $(this).data('userid');
                var link = '/dashboard/active-account/' + userid;
                $.get(link, function(res) {
                    if (res['status'] == 'success') {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                });
            });

            // check white space function
            function containsWhitespace(username) {
                return /\s/.test(username);
            }

            $(".btn-submit").click(function() {
                var name = $("#name").val();
                var username = $("#username").val();
                var email = $("#email").val();
                var phone = $("#phone").val();
                var password = $("#password").val();
                var isValidLength = password.length >= 8;
                var hasUppercase = /[A-Z]/.test(password);
                var hasLowercase = /[a-z]/.test(password);
                var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                var role = $("#user-roles").val();
                var level = $("#levels").val();
                if (name != "") {
                    if (username != "") {
                        // check have any space in username
                        if (!containsWhitespace(username)) {
                            if (email != "") {
                                if (phone != "" && phone.length == 11) {
                                    if (password != "") {
                                        if (isValidLength && hasUppercase && hasLowercase &&
                                            hasSpecialChar) {
                                            if (role != null) {
                                                if (role == 4) {
                                                    if (level != null) {
                                                        $(this).html(
                                                            "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                                        );
                                                        $(this).attr("disabled", "disabled");
                                                        $.ajax({
                                                            url: "/dashboard/user/submit",
                                                            type: "POST",
                                                            data: {
                                                                "_token": "{{ csrf_token() }}",
                                                                name: name,
                                                                username: username,
                                                                email: email,
                                                                phone: phone,
                                                                password: password,
                                                                role: role,
                                                                level: level,
                                                            },
                                                            success: function(response) {
                                                                if (response['status'] ==
                                                                    "success") {
                                                                    $(".alert-body-success")
                                                                        .html(
                                                                            response['message']
                                                                        );
                                                                    $(".alert-success")
                                                                        .slideDown();
                                                                    $(".btn-submit").html(
                                                                        "Submit");
                                                                    setTimeout(() => {
                                                                        location
                                                                            .reload();
                                                                    }, 2000);
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        $(".alert-body-warning").html("Level is required");
                                                        $(".alert-warning").slideDown();
                                                    }
                                                } else {
                                                    $(this).html(
                                                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                                                    );
                                                    $(this).attr("disabled", "disabled");
                                                    $.ajax({
                                                        url: "/dashboard/user/submit",
                                                        type: "POST",
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            name: name,
                                                            username: username,
                                                            email: email,
                                                            phone: phone,
                                                            password: password,
                                                            role: role,

                                                        },
                                                        success: function(response) {
                                                            if (response['status'] ==
                                                                "success") {
                                                                $(".alert-body-success").html(
                                                                    response['message']);
                                                                $(".alert-success").slideDown();
                                                                $(".btn-submit").html("Submit");
                                                                setTimeout(() => {
                                                                    location.reload();
                                                                }, 2000);
                                                            }
                                                        }
                                                    });
                                                }
                                            } else {
                                                $(".alert-body-warning").html("Choose the role for user");
                                                $(".alert-warning").slideDown();
                                            }
                                        } else {
                                            $(".alert-body-warning").html(
                                                "Minimum 8 characters,At least one uppercase letter,At least one lowercase letter,At least one number,At least one special character"
                                            );
                                            $(".alert-warning").slideDown();
                                            $("#password").focus();
                                        }
                                    } else {
                                        $(".alert-body-warning").html("Password is required");
                                        $(".alert-warning").slideDown();
                                    }
                                } else {
                                    $(".alert-body-warning").html(
                                        "Give me a valid Phone Number. It should be 11 number");
                                    $(".alert-warning").slideDown();
                                }
                            } else {
                                $(".alert-body-warning").html("Give a valid email address");
                                $(".alert-warning").slideDown();
                            }
                        } else {
                            $(".alert-body-warning").html("Please remove all space from your User Name.");
                            $(".alert-warning").slideDown();
                        }
                    } else {
                        $(".alert-body-warning").html("Username is required");
                        $(".alert-warning").slideDown();
                    }
                } else {
                    $(".alert-body-warning").html("Name is required");
                    $(".alert-warning").slideDown();
                }
            });

            $(".btn-add-credit-submit").click(function() {
                var amount = $("#amount-credit").val();
                var id = $("#recivers-id-credit").val();
                var pin = $("#pin-credit").val();
                var comment = $("#comment").val();
                if (pin != "") {
                    if (amount >= 500) {
                        var formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("amount", amount);
                        formData.append("pin", pin);
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
                            url: '/dashboard/add-credit',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response['status'] == "success") {
                                    $(".alert-body-success").html(response['message']);
                                    $(".alert-success").slideDown();
                                    $(".alert-warning").slideUp();
                                    $(".btn-add-credit-submit").html("Submit");
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                } else if (response['status'] == "warning") {
                                    $(".alert-body-warning").html(response['message']);
                                    $(".alert-warning").slideDown();
                                    $(".alert-success").slideUp();
                                    $(".btn-add-credit-submit").html("Submit");
                                    $(".btn-add-credit-submit").removeAttr('disabled');
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: "Credit less than 500 can't be added.",
                            showConfirmButton: true,
                        });
                    }
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: "Please enter pin",
                        showConfirmButton: true,
                    });
                }
            });

            $(".btn-add-refund-submit").click(function() {
                var amount = $("#amount-refund").val();
                var id = $("#recivers-id-refund").val();
                var pin = $("#pin-refund").val();
                var comment = $("#refund-comment").val();
                if (amount >= 1) {
                    if (comment != "") {
                        if (pin !== "") {
                            var formData = new FormData();
                            formData.append("_token", "{{ csrf_token() }}");
                            formData.append("amount", amount);
                            formData.append("pin", pin);
                            formData.append("comment", comment);
                            formData.append("id", id);


                            $(this).html(
                                "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                            );
                            $(this).attr("disabled", "disabled");

                            $.ajax({
                                url: '/dashboard/refund-credit',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response['status'] == "success") {
                                        $(".alert-body-success").html(response['message']);
                                        $(".alert-success").slideDown();
                                        $(".alert-warning").slideUp();
                                        $(".btn-add-refund-submit").html("Submit");
                                        setTimeout(() => {
                                            location.reload();
                                        }, 2000);
                                    } else if (response['status'] == "warning") {
                                        $(".alert-body-warning").html(response['message']);
                                        $(".alert-warning").slideDown();
                                        $(".alert-success").slideUp();
                                        $(".btn-add-refund-submit").html("Submit");
                                        $(".btn-add-refund-submit").removeAttr('disabled');
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: "Pin must be need",
                                showConfirmButton: true,
                            });
                        }
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: "Comment must be need",
                            showConfirmButton: true,
                        });
                    }
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: "Credit less than 1 can't be added",
                        showConfirmButton: true,
                    });
                }
            });

            $(".btn-assign-partner-submit").click(function() {
                var partners = $("#partners").val();
                var userid = $("#user-id").val();
                if (partners != "") {
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                    );
                    $(this).attr("disabled", "disabled");
                    $.ajax({
                        url: "/dashboard/add-partner-submit",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            userid: userid,
                            partners: partners,
                        },
                        success: function(response) {
                            if (response['status'] == "success") {
                                $(".alert-body-success").html(response['message']);
                                $(".alert-success").slideDown();
                                $(".alert-warning").slideUp();
                                $(".btn-assign-partner-submit").html("Submit");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                        }
                    });
                }
            });

            $(".btn-reset-pin-submit").click(function() {
                var pin = $("#pin").val();
                var userid = $("#reset-pin-user-id").val();
                if (pin != "") {
                    $(this).html(
                        "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                    );
                    $(this).attr("disabled", "disabled");
                    $.ajax({
                        url: "/dashboard/reset-pin-submit",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            userid: userid,
                            pin: pin,
                        },
                        success: function(response) {
                            if (response['status'] == "success") {
                                $(".alert-body-success").html(response['message']);
                                $(".alert-success").slideDown();
                                $(".alert-warning").slideUp();
                                $(".btn-assign-partner-submit").html("Submit");
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else if (response['status'] == "error") {
                                $(".alert-body-warning").html(response['message']);
                                $(".alert-success").slideUp();
                                $(".alert-warning").slideDown();
                                $(".btn-assign-partner-submit").html("Submit");
                                $(".btn-assign-partner-submit").removeAttr('disabled');
                            }
                        }
                    });
                }
            });

            $(".btn-reset-password-submit").click(function() {
                var password = $("#change-password").val();
                var userid = $("#reset-password-user-id").val();
                var isValidLength = password.length >= 8;
                var hasUppercase = /[A-Z]/.test(password);
                var hasLowercase = /[a-z]/.test(password);
                var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
                if (password != "") {
                    if (isValidLength && hasUppercase && hasLowercase && hasSpecialChar) {
                        $(this).html(
                            "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>"
                        );
                        $(this).attr("disabled", "disabled");
                        $.ajax({
                            url: "/dashboard/reset-password-submit",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                userid: userid,
                                password: password,
                            },
                            success: function(response) {
                                if (response['status'] == "success") {
                                    $(".alert-body-success").html(response['message']);
                                    $(".alert-success").slideDown();
                                    $(".alert-warning").slideUp();
                                    $(".btn-assign-partner-submit").html("Submit");
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    } else {
                        $("#change-password").focus();
                        $(".alert-body-warning").html(
                            "Minimum 8 characters,At least one uppercase letter,At least one lowercase letter,At least one number,At least one special character"
                        );
                        $(".alert-warning").slideDown();
                    }
                }
            });

            $(".add-filters").click(function() {
                var currentUrl = window.location.href;
                var user_role_id = {{ $user->role_id }};

                var role = (user_role_id == 1 || user_role_id == 2 ) ? $("#filter-roles").val() : "";
                var createdby = (user_role_id == 1 || user_role_id == 2 ) ? $("#created-by").val() : "";

                var status = $("#status").val();
                var range = $("#fp-range").val();


                function buildQueryString(params) {
                    var queryString = '';
                    for (var key in params) {
                        if (params[key] !== null && params[key] !== "") {
                            if (queryString !== '') {
                                queryString += '&';
                            }
                            queryString += key + '=' + encodeURIComponent(params[key]);
                        }
                    }
                    return queryString;
                }

                var newParams = {
                    role: role,
                    createdby: createdby,
                    status: status,
                    range: range
                };

                var queryString = buildQueryString(newParams);

                // Remove existing query string (if any)
                var urlWithoutQueryString = currentUrl.split('?')[0];

                if (queryString !== "") {
                    // Construct the new URL with the new query string
                    var newUrl = urlWithoutQueryString + '?' + queryString;
                    // Redirect to the new URL
                    window.location.href = newUrl;
                }
            });
        });
    </script>
@stop
