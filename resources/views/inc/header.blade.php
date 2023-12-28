 <meta name="csrf-token" content="{{ csrf_token() }}">
 <style>
     #notification-icon {
         cursor: pointer;
     }

     #notification-card {
         position: fixed;
         top: 80px;
         right: 17px;
         width: 300px;
         height: 450px;
         overflow-y: auto;
         background-color: #fff;
         border: 1px solid #ccc;
         border-radius: 5px;
         box-shadow: 0px 3px 21px rgba(0, 0, 0, 0.2);
         padding-top: 10px;
         z-index: 1;
     }

     #notification-card::-webkit-scrollbar {
         width: 0;
     }

     .notification-item {
         padding: 10px;
         border-bottom: 1px solid #eee;
     }

     .notification-item:hover .dropdown-notifications-archive {}

     .dropdown-notifications-actions {
         width: 28px;
         display: flex;
         justify-content: center;
         align-items: center;
     }

     .notification-section .badge {
         padding: 2.1px;
         width: 17px;
         height: 17px;
         top: -3px;
         right: 8px;
     }
 </style>

 <!-- BEGIN: Header-->
 <nav
     class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
     <div class="navbar-container d-flex content">
         <div class="bookmark-wrapper d-flex align-items-center">
             <ul class="nav navbar-nav d-xl-none">
                 <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                             data-feather="menu"></i></a></li>
             </ul>
         </div>
         <ul class="nav navbar-nav align-items-center ml-auto d-flex flex-column flex-md-row">
             @if ($user->credits > 0)
                 @if ($user->role_id != 1 && $user->role_id != 2)
                     <div class="user-nav d-sm-flex">
                         @if ($user->credits > 500)
                             <span class="user-name font-weight-bolder text-success">Credits:
                                 {{ $user->credits }}</span>
                         @elseif($user->credits <= 500)
                             <span class="user-name font-weight-bolder text-warning">Credits:
                                 {{ $user->credits }}</span>
                         @elseif($user->credits == 0)
                             <span class="user-name font-weight-bolder text-danger">Credits: {{ $user->credits }}</span>
                         @endif
                     </div>
                 @endif
             @endif
             <!--<li class="nav-item d-lg-block"><a class="nav-link nav-link-style modes"><i class="ficon" data-feather="moon"></i></a></li>-->

             @php
                 use App\Notification;

                 $notifications = Notification::where('recievers_user_id', $user->id)
                     ->take(10)
                     ->get();
             @endphp

             <li class="nav-item d-flex align-items-center justify-content-center notification-section">
                 <div class="px-1 position-relative">
                     <i id="notification-icon" onclick="toggleNotificationCard()"
                         class="fas fa-bell text-primary fa-2x"></i>


                     <span
                         class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger notification-count">
                         {{ $notifications->count() }}

                     </span>

                     <div id="notification-card" style="display: none">
                         <!--<div class="notification-header d-flex align-items-center border-bottom p-1">-->
                         <!--    <h4 class="text-body mb-0 me-auto">Notification</h5>-->
                         <!--</div>-->
                         @forelse ($notifications as $item)
                             <div id="tr_{{ $item->id }}">
                                 <div class="notification-item d-flex gap-5">
                                     <div class="flex-grow-1">
                                         <p class="mb-0">{{ $item->title }} by
                                             {{ $item->user_detail->username }}</p>
                                         <small class="text-secondary">
                                             @if ($item->created_at->diffInDays() >= 30)
                                                 {{ $item->created_at->format('d M, Y') }}
                                             @elseif ($item->created_at->diffInDays() >= 2)
                                                 {{ $item->created_at->diffForHumans() }}
                                             @else
                                                 {{ $item->created_at->diffForHumans() }}
                                             @endif
                                         </small>
                                     </div>
                                     <div class="flex-shrink-0 dropdown-notifications-actions">
                                         <a href="javascript:void(0)" class="dropdown-notifications-archive"
                                             onclick="handleNotificationClick({{ $item->id }})"><i
                                                 class="fa-solid fa-xmark"></i></a>
                                     </div>
                                 </div>
                             </div>

                         @empty
                             <div class="notification-item">
                                 <h6>Notification is empty</h6>
                             </div>
                         @endforelse
                     </div>
                 </div>


                 <div class=" dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                         id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="false">
                         <div class="user-nav d-sm-flex ">
                             <span class="user-name font-weight-bolder">{{ ucwords($user->name) }}</span><span
                                 class="user-status">{{ $user->role_detail ? $user->role_detail->display_name : '' }}
                                 @if ($user->role_id == 4)
                                     ({{ $user->level_detail ? $user->level_detail->title : '' }})
                                 @endif
                             </span>
                         </div>
                         <span style = "width:30px; height:30px;" class="avatar"><i
                                 class="fa-duotone fa-2x fa-user-tie"></i><span
                                 class="avatar-status-online"></span></span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                         <a class="dropdown-item" href="{{ route('profile') }}"><i class="mr-50"
                                 data-feather="user"></i>
                             Profile</a>
                         {{-- @if ($user->role_id != 4) --}}
                         <div class="dropdown-divider"></div><a class="dropdown-item"
                             href="{{ route('change_password') }}"><i class="fa-light fa-lock mr-50"></i>Password</a>
                         <div class="dropdown-divider"></div><a class="dropdown-item"
                             href="{{ route('change_pin') }}"><i class="fa-light fa-key mr-50"></i>Pin</a>
                         {{-- @endif --}}
                         <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"><i
                                 class="mr-50" data-feather="power"></i> Logout</a>
                     </div>
                 </div>
             </li>
         </ul>
     </div>
 </nav>
 <!-- END: Header-->

 <script>
     function toggleNotificationCard() {
         var notificationCard = document.getElementById('notification-card');
         notificationCard.style.display = notificationCard.style.display === 'none' ? 'block' : 'none';
     }

     function handleNotificationClick(id) {
         $.ajax({
             url : "/dashboard/delete-notification/"+ id,
             type : "DELETE",
             data : {
                "_token": "{{ csrf_token() }}",
             },
             success:function(response){
                if(response['status'] == "success"){
                    $("#" + response['tr']).slideUp("slow");
                    var count = $(".notification-count").text();
                    $(".notification-count").text(count - 1);
                }
                else if(response['status'] == "error"){
                    console.log("sahos");
                }
            }
        });
     }

     // Close the notification card when clicking outside of it
     document.addEventListener('click', function(event) {
         var notificationCard = document.getElementById('notification-card');
         var notificationIcon = document.getElementById('notification-icon');

         if (
             event.target !== notificationCard &&
             event.target !== notificationIcon &&
             !notificationCard.contains(event.target)
         ) {
             notificationCard.style.display = 'none';
         }
     });
 </script>
