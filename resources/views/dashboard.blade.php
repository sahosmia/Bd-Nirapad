@extends('/layouts/master')
@section('css')
@stop

@section('title')
    <title>Dashboard</title>
@stop
@section('body')
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row"></div>
        <div class="content-body">
            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row match-height">

                    <!-- Contact Card -->
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="card card-statistics" style="background-color: 	#E6E6FA;">
                            <div class="card-header">
                                <h4 class="card-title" style="color: #7367f0;">Welcome to BD Nirapad</h4>
                                <div class="d-flex align-items-center">
                                    <p class="card-text font-small-2 mr-25 mb-0" style="color: #7367f0;">Updated on {{ date('H:i') }}</p>
                                </div>
                            </div>
                            <div class="card-header">
                                <p class="card-text font-medium-1">
                                    <marquee behavior="scroll" direction="left">
                                        <span style="color: #7367f0;"> বিডি নিরাপদ ডট কমে </span>
                                        <span style="color: #7367f0;">আপনাকে স্বাগতম ।</span>
                                        <span style="color: #7367f0;"> বিডি নিরাপাদ আপনার বিশ্বস্ততার ঠিকানা । আশা করি আমাদের সাথে আপনার ব্যবসা আনন্দদায়ক হবে ইনশাআল্লাহ্‌ । সুস্থ থাকুন, নিরাপদে থাকুন, আমাদের সার্ভিস সংক্রান্ত যেকোনো তথ্য এর জন্য সাপোর্ট ডেস্কে দেয়া নাম্বারে যোগাযোগ  করুন ।</span>
                                        <span style="color: #7367f0;"> ধন্যবাদ </span>
                                    </marquee>
                                </p>
                            </div>

                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-xl-4 col-md-4 col-12 mb-2 mb-md-0">
                                        <div class="media bg-gradient-danger">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content text-light">
                                                    <i class="fa-light fa-mobile"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h6 class="font-weight-bolder card-text font-medium-3 mb-1 text-light">
                                                    মোবাইল ব্যাংকিং
                                                    এবং রিচার্জ</h6>
                                                <p class="mb-0 text-light">সকাল 9:30 হইতে রাত 10:00 পর্যন্ত সার্ভিস প্রদান করা হবে 
                                                    (বাংলাদেশ সময়) 30 মিনিটের মধ্যে, সকল রিকুয়েস্ট সম্পূর্ণ করা
                                                    হবে</p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-4 col-12 mb-2 mb-md-0">
                                        <div class="media bg-gradient-danger">
                                            <div class="avatar bg-light-info mr-2">
                                                <div class="avatar-content text-light">
                                                    <i class="fa-light fa-building-columns"></i>
                                                </div>
                                            </div>
                                            <div class="media-body my-auto">
                                                <h6 class="font-weight-bolder card-text font-medium-3 mb-1 text-light">
                                                    ব্যাংকিং</h6>
                                                <p class="mb-0 text-light">আমাদের বিডি নিরাপাদ এর ব্যাংকিং সার্ভিস 24 ঘণ্টার মধ্যে ( ব্যাংক এর কর্মদিবস, বাংলাদেশ
                                                    স্ট্যান্ডার্ড টাইম, সব রিকুয়েস্ট এই সময়ে সম্পূর্ণ করা হবে )</p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-md-4 col-12 mb-2 mb-md-0">

                                        <button type="button"
                                            class="btn btn-gradient-success waves-effect modal-btn1 mb-1">Support</button>
                                        <button type="button" class="btn btn-gradient-success waves-effect modal-btn2 mb-1">Notice</button>
                                        <button type="button"
                                            class="btn btn-gradient-success waves-effect modal-btn3 mb-1">Payment</button>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Contact Card -->



                    <!-- Statistics Card -->
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">Statistics</h4>
                                <div class="d-flex align-items-center">
                                    <p class="card-text font-small-2 mr-25 mb-0">Updated on {{ date('H:i') }}</p>
                                </div>
                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0 ">
                                        <a href="{{ route('all_reports', $user->ref_key) }}">
                                            <div class="media bg-primary">
                                                <div class="avatar bg-light-info mr-2">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-trending-up avatar-icon text-light">
                                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                            <polyline points="17 6 23 6 23 12"></polyline>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto">
                                                    <h4 class="font-weight-bolder mb-0 text-light">{{ $allrequests }}</h4>
                                                    <p class="card-text font-small-3 mb-0 text-light">Request</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <a href="{{ route('all_reports', $user->ref_key) }}?status=1">
                                            <div class="media bg-primary">
                                                <div class="avatar bg-light-info mr-2">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-dollar-sign avatar-icon text-light">
                                                            <line x1="12" y1="1" x2="12"
                                                                y2="23"></line>
                                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto">
                                                    <h4 class="font-weight-bolder mb-0 text-light">{{ $allrequestssuccess }}
                                                    </h4>

                                                    <p class="card-text font-small-3 mb-0 text-light">Success</p>

                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <a href="{{ route('all_reports', $user->ref_key) }}?status=3">
                                            <div class="media bg-primary">
                                                <div class="avatar bg-light-info mr-2">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-user avatar-icon text-light">
                                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="12" cy="7" r="4"></circle>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto">
                                                    <h4 class="font-weight-bolder mb-0 text-light">
                                                        {{ $allrequestspending }}</h4>
                                                    <p class="card-text font-small-3 mb-0 text-light">Pending</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <a href="{{ route('all_reports', $user->ref_key) }}?status=2">
                                            <div class="media bg-primary">
                                                <div class="avatar bg-light-info mr-2">
                                                    <div class="avatar-content">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-box avatar-icon text-light">
                                                            <path
                                                                d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                            </path>
                                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                            <line x1="12" y1="22.08" x2="12"
                                                                y2="12"></line>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="media-body my-auto">
                                                    <h4 class="font-weight-bolder mb-0 text-light">
                                                        {{ $allrequestsrefunded }}</h4>
                                                    <p class="card-text font-small-3 mb-0 text-light">Refunded</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics Card -->


                </div>
                @if ($user->role_id == 1 || $user->role_id == 2)
                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Name</th>
                                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Role</th>
                                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Sales</th>
                                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Credit</th>
                                                    <th style="background-color: #7367f0; color: #fff; padding: 8px; text-align: left; border: 2px solid #fff;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($latestusers as $latestusers)
                                                    <tr>
                                                        <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <div class="font-weight-bolder">
                                                                        {{ $latestusers->name }}</div>
                                                                    <div class="font-small-2 text-muted">
                                                                        {{ $latestusers->email }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">
                                                            <div class="d-flex align-items-center">
                                                                <span>{{ $latestusers->role_detail ? $latestusers->role_detail->display_name : '' }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="text-nowrap" style="border: 1px solid #3366cc; padding: 8px; text-align: left;">
                                                            <div class="d-flex flex-column">
                                                                @php
                                                                    if ($user->role_id == 5 || $user->role_id == 6) {
                                                                        $amount = $latestusers->master_sales->sum('amount');
                                                                    } else {
                                                                        $amount = $latestusers->user_sales->sum('amount');
                                                                    }

                                                                    if ($amount >= 10000) {
                                                                        $formattedAmount = number_format($amount / 1000, 0) . 'k';
                                                                    } else {
                                                                        $formattedAmount = $amount;
                                                                    }
                                                                @endphp
                                                                <span
                                                                    class="font-weight-bolder mb-25">{{ $formattedAmount }}</span>
                                                                <span class="font-small-2 text-muted">All Time</span>
                                                            </div>
                                                        </td>
                                                        <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">
                                                            @if ($latestusers->role_id == 2 || $latestusers->role_id == 1)
                                                                @if ($latestusers->credits == '')
                                                                    Unlimited
                                                                @elseif($latestusers->credits != '')
                                                                    {{ $latestusers->credits }}
                                                                @endif
                                                            @elseif($latestusers->role_id != 2)
                                                                {{ $latestusers->credits }}
                                                            @endif
                                                        </td>
                                                        <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">
                                                            <div class="d-flex align-items-center">
                                                                @if ($latestusers->status == 1)
                                                                    <div style="border-radius: 0.25rem !important;"
                                                                        class="px-2 badge badge-pill badge-light-success">
                                                                        Active</div>
                                                                @elseif($latestusers->status == 0)
                                                                    <div style="border-radius: 0.25rem !important;"
                                                                        class="px-2 badge badge-pill badge-light-danger">
                                                                        In Active</div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Company Table Card -->
                    </div>
                @endif


            </section>
            <!-- Dashboard Ecommerce ends -->

        </div>
    </div>

    {{-- Modal 1 --}}
    <div class="modal fade text-left" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel401"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel401">Support</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

<div class="modal-body">
    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px; text-align: center;">
        <h3 style="color: #333;">WhatsApp সাপোর্ট নাম্বার</h3>
        <p><strong style="color: #007bff;">+8801727175535</strong></p>
        <p><strong style="color: #007bff;">+986 78779006</strong></p>
        <p><strong style="color: #007bff;">+986 78275348</strong></p>
        <p><strong style="color: #007bff;">+968 94288615</strong></p>
        <p><strong style="color: #007bff;">+968 94288615</strong></p>
        <p style="color: #333;">*** শুধু মাত্র ভয়েস ম্যাসেজ এবং টেক্সট ম্যাসেজ করবেন ***</p>
        <p style="color: #333;">সফটওয়্যার ইঞ্জিনার এর সাথে যোগাযোগ করতে : <strong style="color: #007bff;">+8801977175535</strong></p>
    </div>
</div>


            </div>
        </div>
    </div>
    {{-- Modal 1 --}}

    {{-- Modal 2 --}}
    <div class="modal fade text-left" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel402"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel402">Notice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                
                    <p style="color: #7367F0;">বিডি নিরাপদ ডট কমে আপনাকে স্বাগতম । </p>
                    <p> নিরাপদে টাকা পাঠান আপনার প্রিয়জনের কাছে, আমরা আপনার প্রিয়জনের কাছে নিরাপদে টাকা পাঠাতে সহায়তা করে থাকি। আপনার পাঠানো অর্থ আমরা অতিদ্রুত পৌঁছে দেওয়ার জন্য বদ্ধপরিকর। আপনার লেনদেন স্বচ্ছতা ও জবাবদিহিতা প্রদানে আমরা নিয়োজিত থাকবো ইনশাআল্লাহ। </p>
                    <br>
                    <p style="color: #7367F0;"> সার্ভিস সময়সূচি </p>
                    <br>
                    <p>আমাদের সার্ভিস বাংলাদেশ সময় সকাল ৯:৩০ থেকে রাত ১০:০০ পর্যন্ত বিরতিহীন চালু থাকবে। প্রতি শুক্রবার বিকাল ৪:০০ থেকে রাত ১১:০০ টা পর্যন্ত সার্ভিস প্রদান করা হবে। </p>
                    <br>
                    <p>উত্তম সেবা আমাদের বৈশিষ্ট্য </p>
                    <br>
                    <p>আমরা সর্বদা সর্বোত্তম সেবা প্রদানের জন্য চেষ্টা করি। আমাদের লক্ষ্য হলো আপনার লেনদেনকে ঝামেলাবিহীন ও নিরাপদ করা। </p>
                    <br>
                    <p style="color: #7367F0;">সম্মানিত রিসেলারবৃন্দের জন্য কতিপয় নির্দেশনা </p>
                    <br>
                    <p>⇢ রিকোয়েস্ট পাঠানোর সময় বিশেষভাবে মনোযোগ দিন, যাতে নাম্বার ভুল না হয়। </p>
                    <p>⇢ আপনার নাম্বার ভুল দেওয়ার কারণে যদি টাকা ভুল নাম্বারে চলে যায়, তাহলে বিডি নিরাপদ কর্তৃপক্ষ কোন প্রকার দায়ী থাকবে না। </p>
                    <p>⇢ আপনার নিজ নিজ পাসওয়ার্ড ও পিন অন্য কারো সাথে শেয়ার করবেন না। </p>
                    <p>⇢ আপনার পাসওয়ার্ড বা পিন ভুলে গেলে, তাহলে এডমিনকে অবহিত করুন। এডমিন আপনার পাসওয়ার্ড বা পিন রিসেট করে দিবে। তারপর আপনি পুনরায় নতুন করে পাসওয়ার্ড বা পিন তৈরি করে নিতে পারবেন। </p>
                    <p>⇢ আপনার পাসওয়ার্ড বা পিন এডমিন সহ কেউ দেখতে পায় না। </p>
                    <p>⇢ বিডি নিরাপদ কর্তৃপক্ষের কোন প্রতিনিধি, আপনার পাসওয়ার্ড বা পিন কখনো জানতে চাইবে না। কেউ চাইলে ও আপনি তা দেবেন না। </p>
                    <p>⇢ পর পর তিন বার পাসওয়ার্ড বা পিন ভুল ব্যবহার করলে আপনার আইডি ৩০ মিনিটের জন্য ব্লক হয়ে যাবে। </p>
                    <p style="color: #FF0000;">⇢ কোনো ব্যাংক অথবা ব্যাংক এর ব্রাঞ্চ যদি খুজে না পান তবে Support এ দেয়া নাম্বারে যোগাযোগ করুন । </p>
                    <p style="border: 1px solid #FF0000; padding: 8px; text-align: left;">⇢ আপনার পেনেলে সবসময় ৫০০ টাকা ব্যালেন্স থাকবে। যা কখনো ব্যবহার করতে পারবেন না। </p>
<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th style="border: 1px solid #3366cc; background-color: #3366cc; color: white; padding: 8px; text-align: left;">সার্ভিস এর নাম</th>
            <th style="border: 1px solid #3366cc; background-color: #3366cc; color: white; padding: 8px; text-align: left;">সার্ভিস এর লিমিট</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">ব্যাংক</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">৩০ হাজার থেকে ১০ লক্ষ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">মোবাইল ব্যাংকিং</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">৫০০-৩০,০০০ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">মোবাইল রিচার্জ</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">২০-১,০০০ টাকা</td>
        </tr>
        <tr>
    </tbody>
</table>
<br>
<h5 style="border: 1px solid #3366cc; padding: 8px; text-align: left;">মোবাইল ব্যাংকিং এর ক্ষেত্রে লিমিট এর থেকে বেশি টাকার রিকুয়েস্ট করতে অন্য একটি পার্সোনাল নাম্বার ব্যবহার করুন । </h5>
<br>
<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th style="border: 1px solid #3366cc; background-color: #3366cc; color: white; padding: 8px; text-align: left;">মোবাইল ব্যাংকিং</th>
            <th style="border: 1px solid #3366cc; background-color: #3366cc; color: white; padding: 8px; text-align: left;">ক্যাশ আউট চার্জ (প্রতি হাজারে)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">বিকাশ</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১৮.৫০ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">বিকাশ প্রিয় এজেন্ট</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১৪.৫০ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">বিকাশ (ব্রাক ব্যাংক এটিএম বুথ)</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১০ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">রকেট</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১৫ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">রকেট (ডাচ বাংলা ব্যাংক এটিএম বুথ)</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১০ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">নগদ</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১৪.৫০ টাকা</td>
        </tr>
        <tr>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">নগদ মোবাইল অ্যাপ</td>
            <td style="border: 1px solid #3366cc; padding: 8px; text-align: left;">১২.৫০ টাকা</td>
        </tr>
    </tbody>
</table>
<br>
                    <p>আপনার ব্যবসা নিরাপদ রাখতে আমাদের এই প্রচেষ্টা অব্যাহত থাকবে। ইনশাআল্লাহ  </p> 
                    <p>ধন্যবাদ 💜</p>
                </div>

            </div>
        </div>
    </div>
    {{-- Modal 2 --}}

    {{-- Modal 3 --}}
    <div class="modal fade text-left" id="modal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel403"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel403">Payment</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                    <h4 style="color: #7367f0;"> আমাদেরকে ব্যাংক এর মাধ্যমে পেমেন্ট করার ক্ষেত্রে প্রতি ১ লক্ষ টাকাতে ৫০০ টাকা সার্ভিস চার্জ হিসেবে এক্সট্রা প্রদান করতে হইবে । </h4> </div>
                    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                        <h3 style="color: #7367F0;">UCB Bank - Savings Account</h3>
                        <p><strong>Account Name: Md Abu Moosa </strong></p>
                        <p><strong>Account No: 1123201000017370 </strong></p>
                        <p><strong>Uttar Khan Branch, Dhaka </strong></p>
                    </div>
                
                    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                        <h3 style="color: #7367F0;">Brac Bank - Savings Account</h3>
                        <p><strong>Account Name: Md Abu Moosa </strong></p>
                        <p><strong>Account No: 1024180210001 </strong></p>
                        <p><strong>Uttara Branch, Dhaka </strong></p>
                    </div>
                
                    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                        <h3 style="color: #7367F0;">Shahjalal Islami Bank - Savings Account</h3>
                        <p><strong>Name: Md Abu Moosa </strong></p>
                        <p><strong>Account No: 406812100000224 </strong></p>
                        <p><strong>Uttar Khan Branch, Dhaka </strong></p>
                    </div>
                    <div style="background-color: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                        <h3 style="color: #7367F0;">Janata Bank - Savings Account</h3>
                        <p><strong>Name: Md Abu Moosa </strong></p>
                        <p><strong>Account No: 0100251607529 </strong></p>
                        <p><strong>Dakshin Khan Branch, Dhaka </strong></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- Modal 3 --}}
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $(".modal-btn1").click(function() {
                $("#modal1").modal('show');
            });

            $(".modal-btn2").click(function() {
                $("#modal2").modal('show');
            });

            $(".modal-btn3").click(function() {
                $("#modal3").modal('show');
            });
        });
    </script>
@stop
