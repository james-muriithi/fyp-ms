<?php
require_once 'notifications.php';

$x = new Notification($conn, $lec);

$notifications = $x->get($lec);
$notArray = [];
foreach ($notifications as $notification) {
//    print_r($notification);
    switch ($notification['notifications'][0]['type']) {
        case 'upload.new':
            $x1 = new NewUploadNotification($conn, $lec);
            $notArray[] = $x1->messageForNotifications($notification['notifications']);
            break;

    }
}
?>

<header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="" height="70">
                            </span>
                        </a>
                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="60" width="70">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <!-- <div class="d-none">
                            <div class="dropdown pt-3 d-inline-block">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Create <i class="mdi mdi-chevron-down"></i>
                                    </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
                                </div>
                            </div>
                        </div> -->
                </div>
                <div class="d-flex">
                    <!-- App Search-->
                     <!-- <form class="app-search d-none d-lg-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="fa fa-search"></span>
                            </div>
                        </form>  -->
                    <!-- <div class="dropdown d-inline-block d-lg-none ml-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-search-dropdown">
                    
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> -->
                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="mdi mdi-fullscreen"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bell-outline"></i>
                            <span class="badge badge-danger badge-pill"><?= count($notArray) ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0 animated fadeInUp notification-show m-t-10" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="m-0 font-size-16"> Notifications (<?= count($notArray) ?>) <span class="badge badge-danger badge-pill float-right p-b-5 p-t-3">New</span></h5>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <?php
                                foreach ($notArray as $notification){
                                    $classArray = [
                                        'icon' => 'fa-info',
                                        'color' => 'text-primary',
                                        'bg' => 'bg-primary'
                                    ];
                                    if ($notification['level'] == 1){
                                        $classArray['icon'] = 'fa-check';
                                        $classArray['color'] = 'text-success';
                                        $classArray['bg'] = 'bg-success';
                                    }elseif ($notification['level'] == 3){
                                        $classArray['icon'] = 'fa-warning';
                                        $classArray['color'] = 'text-danger';
                                        $classArray['bg'] = 'bg-danger';
                                    }
                                    ?>
                                    <a href="#" class="text-reset notification-item">
                                        <div class="media">
                                            <div class="avatar-xs mr-3">
                                            <span class="avatar-title <?= $classArray['bg'] ?> rounded-circle font-size-16">
                                                <i class="fa <?= $classArray['icon'] ?>"></i>
                                            </span>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="mt-0 mb-1 <?= $classArray['color'] ?>"><?= $notification['topic'] ?></h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1"><?= $notification['message'] ?></p>
                                                    <span class="notification-time"><?= $notification['created_at'] ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $uploadDir = 'assets/images/users/';
                    $image = empty($lecDetails['profile']) ? $uploadDir.'avatar-lec.png': $uploadDir. $lecDetails['profile'];
                    if (!file_exists($image)){
                        $image = $uploadDir.'avatar-lec.png';
                    }

                    ?>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect fs-15 text-primary text-bold" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-family: font-family: 'Open Sans', sans-serif;">
                            <?php
                            echo ucfirst(explode(' ',$lecDetails['full_name'])[0]);
                            ?>
                            <img class="rounded-circle header-profile-user m-l-4" src="<?= $image ?>" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a class="dropdown-item" href="user-profile.php"><i class="mdi mdi-account-circle font-size-17 align-middle mr-1"></i> Profile</a>
                            <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i class="mdi mdi-settings font-size-17 align-middle mr-1"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline font-size-17 align-middle mr-1"></i> Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="logout.php"><i class="bx bx-power-off font-size-17 align-middle mr-1 text-danger"></i> Logout</a>
                        </div>
                    </div>
<!--                    <div class="dropdown d-inline-block">-->
<!--                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">-->
<!--                            <i class="mdi mdi-settings-outline"></i>-->
<!--                        </button>-->
<!--                    </div>-->
                </div>
            </div>
        </header>