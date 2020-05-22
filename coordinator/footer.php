			<footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            © <script>document.write(new Date().getFullYear())</script> FYPMS<span class="d-none d-sm-inline-block">
                        </div>
                    </div>
                </div>
            </footer>
            <?php
            if (isset($_SESSION['error'])){
                echo '<script>toastr.error("'.$_SESSION['error'].'", "Ooops!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });</script>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])){
                echo '<script>toastr.success("'.$_SESSION['success'].'", "Bravoo!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });</script>';
                unset($_SESSION['success']);
            }

            function extractRegNo($project){
                return $project['reg_no'];
            }

            include_once '../api/classes/Project.php';
            include_once '../api/classes/Student.php';
            $project1 = new Project($conn);
            $chatList = [];
            $lec = new Lecturer($conn);

            $supervisorStudents = array_map('extractRegNo', $project1->getLecturerProjects($_SESSION['username']));

            foreach ($supervisorStudents as $supervisorStudent) {
                $student = new Student($conn);
                $student->setUsername($supervisorStudent);
                $temp['user'] = $student->getUser();

                $temp['unread'] = count($messages->getSenderAllUnreadMessages($supervisorStudent));
                $temp['status'] = 'offline';

//                profile image
                $uploadDir = '../student/assets/images/users/';
                $image = empty($temp['user']['profile']) ? $uploadDir.'avatar-st.png': $uploadDir. $temp['user']['profile'];
                if (!file_exists($image)){
                    $image = $uploadDir.'avatar-st.png';
                }
                $temp['user']['profile'] = $image;
                $chatList[] = $temp;

            }
            function cmp($a, $b){
                if ($a['unread'] == $b['unread']) return 0;
                return ($a['unread'] > $b['unread']) ? -1 : 1;
            }
            usort($chatList, 'cmp');
            ?>

            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-search-box">
                                <a class="back_friendlist">
                                    <i class="mdi mdi-close"></i>
                                </a>
                                <div class="right-icon-control">
                                    <div class="input-group input-group-button">
                                        <input type="text" id="search-friends" name="footer-email" class="form-control" placeholder="Search Friend">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light py-0" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <?php
                                $id = 1;
                                foreach ($chatList as $friend){
                                    $bg = $friend['status'] == 'offline' ? 'bg-default' : 'bg-success';
                                    ?>
                                    <div class="media userlist-box waves-effect waves-light" data-recipient="<?= $_SESSION['username'] ?>" data-profile="<?= $friend['user']['profile'] ?>"
                                         data-username="<?= $friend['user']['full_name'] ?>" data-regno="<?= $friend['user']['reg_no']  ?>">
                                        <a class="media-left" href="#!">
                                            <img class="media-object img-radius img-radius" src="<?= $friend['user']['profile'] ?>" alt="Generic placeholder image ">
                                            <div class="live-status <?= $bg ?>"></div>
                                        </a>
                                        <div class="media-body">
                                            <div class="chat-header"><?= $friend['user']['full_name'] ?>
                                                <?php
                                                if ((int) $friend['unread'] > 0){ ?>
                                                    <span class="badge badge-success bo-cir"><?= $friend['unread'] ?></span>
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $id++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="showChat_inner">
                <div class="media chat-inner-header row align-items-start mb-0 pb-3 pl-0 ml-0">
                    <a class="back_chatBox">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                    <div class="w-100 row">
                        <a class="media-left photo-table col-4 pr-0" href="#!">
                            <img class="media-object img-radius img-radius m-t-5" src="assets/images/users/avatar-st.png" alt="Generic placeholder image">
                        </a>
                        <span class="col-8 user-name float-l row align-items-center text-bold text-white" style="text-transform: capitalize">

                        </span>
                    </div>
                </div>
                <div class="main-friend-chat mt-2 pb-3">

                </div>
                <div class="chat-reply-box pr-1">
                    <form id="chat-form">
                        <div class="right-icon-control">
                            <div class="row">
                                <div class="col-9 px-0">
                                    <textarea name="message" id="chat-message" placeholder="Type message here..." rows="1"></textarea>
                                </div>
                                <div class="col-3 pr-1 row justify-content-center align-items-center">
                                    <button class="waves-effect waves-light btn-send py-0 mb-3" type="submit">
                                        <i class="mdi mdi-send text-primary fs-23"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
