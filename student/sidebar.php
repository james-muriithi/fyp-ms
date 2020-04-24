<!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Main</li>
                        <li>
                            <a href="index.php" class="waves-effect">
                                <i class="ti-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-title">Users</li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Students</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="view-students.php">View Students</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-user"></i>
                                <span>Supervisors</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="view-lecturer.php">View Lecturers</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">Project</li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-package"></i>
                                <span>Projects</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="add-project.php">Add Project</a></li>
                                <li><a href="view-projects.php">View Projects</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-vector"></i>
                                <span>Upload Categories</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php
                                if($_SESSION['level'] === 1){ ?>
                                    <li><a href="add-upload-category.php">Add Category</a></li>
                                <?php }
                                ?>
                                <li><a href="view-upload-category.php">View Categories</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="ti-upload"></i>
                                <span class="badge badge-pill badge-success float-right">6</span>
                                <span>My Uploads</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="view-uploads.php">View Uploads</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class=" waves-effect">
                                <i class="ti-time"></i>
                                <span>Past Deadline</span>
                            </a>
                        </li>

                        <li class="menu-title">Manage Notification</li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-bell"></i>
                                <span>Notifications</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="tables-basic.html">Send Notifications</a></li>
                                <li><a href="tables-datatable.html">View Notifications</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">Extras</li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="ti-face-smile"></i>
                                <span>Timeline</span>
                            </a>
                            
                        </li>
                        
                        <!-- <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-more"></i>
                                <span>Multi Level</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li><a href="javascript: void(0);">Level 1.1</a></li>
                                <li><a href="javascript: void(0);" class="has-arrow">Level 1.2</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="javascript: void(0);">Level 2.1</a></li>
                                        <li><a href="javascript: void(0);">Level 2.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->