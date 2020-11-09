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
                                <a href="assign-students.php" class="waves-effect">
                                    <i class="ti-calendar"></i>
                                    <!--                                <span class="badge badge-pill badge-danger float-right">6</span>-->
                                    <span>Assign Supervisors</span>
                                </a>
                            </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-graduation-cap"></i>
                                <span>Students</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="add-student.php">Add Student</a></li>
                                <li><a href="view-students.php">View Students</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-chalkboard-teacher"></i>
                                <span>Supervisors</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php
                                if($_SESSION['level'] === 1){ ?>
                                    <li><a href="add-lecturer.php">Add Lecturer</a></li>
                                <?php }
                                ?>
                                <li><a href="view-lecturer.php">View Lecturers</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">Projects</li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-package"></i>
                                <span>Projects</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="add-project.php">Add Project</a></li>
                                <li><a href="view-projects.php">View Projects</a></li>
                                <?php
                                if($_SESSION['level'] === 1){ ?>
                                    <li><a href="project-categories.php">Project Categories</a></li>
                                <?php }
                                ?>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ti-vector"></i>
                                <span>Manage Milestones</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <?php
                                if($_SESSION['level'] === 1){ ?>
                                    <li><a href="add-upload-category.php">Add Milestone</a></li>
                                <?php }
                                ?>
                                <li><a href="view-upload-category.php">View Milestones</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect">
                                <i class="ti-upload"></i>
<!--                                <span class="badge badge-pill badge-success float-right">6</span>-->
                                <span>Students Uploads</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="view-uploads.php">View Uploads</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="past-deadline.php" class=" waves-effect">
                                <i class="ti-time"></i>
                                <span>Past Deadline</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->