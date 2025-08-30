<aside class="left-sidebar">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <?php
        $id = $this->session->userdata('user_login_id');


        $basicinfo = $this->employee_model->GetBasic($id);
        ?>

        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img text-center">
                <?php
                $image_name = $basicinfo->em_image ?? '';
                $image_path = 'assets/images/users/' . $image_name;
                $full_path = FCPATH . $image_path;

                $profile_link = base_url() . 'employee/view?I=' . base64_encode($basicinfo->em_id);

                if (!empty($image_name) && file_exists($full_path)) {
                    // Clickable image (same tab)
                    echo '<a href="' . $profile_link . '">
            <img src="' . base_url($image_path) . '" alt="user" style="cursor:pointer;" />
          </a>';
                } else {
                    // Clickable icon (same tab)
                    echo '<a href="' . $profile_link . '">
            <i class="fa fa-user-circle" style="font-size: 60px; color: #ccc; cursor:pointer;"></i>
          </a>';
                }
                ?>

            </div>

            <!-- User profile text-->
            <div class="profile-text">
                <h5><?php echo $basicinfo->first_name . ' ' . $basicinfo->last_name; ?></h5>
                <!-- <a href="<?php echo base_url(); ?>settings/Settings" class="dropdown-toggle u-dropdown" role="button"
                    aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a> -->
                <a href="<?php echo base_url(); ?>login/logout" class="" data-toggle="tooltip" title="Logout"><i
                        class="mdi mdi-power"></i></a>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <div class="nav-scroll">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-devider"></li>
                    <li> <a href="<?php echo base_url(); ?>"><i class="mdi mdi-gauge"></i><span
                                class="hide-menu">Dashboard </span></a></li>
                    <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') { ?>
                        <li> <a class="has-arrow waves-effect waves-dark"
                                href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id); ?>"
                                aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span
                                    class="hide-menu">Employees </span></a>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
                                <li><a href="<?php echo base_url(); ?>leave/EmApplication"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li>
                            </ul>
                        </li>
                        <!-- Side bar project add feature -->




                    <?php } else { ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>organization/Department">Department </a></li>
                                <li><a href="<?php echo base_url(); ?>organization/Designation">Designation</a></li>
                                <li><a href="<?php echo base_url(); ?>Projects/All_Projects">Project</a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Projects/view">Project</a></li> -->
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>

                                <li> <a href="<?php echo base_url() ?>Perfomance/index"><span
                                            class="hide-menu">Perfomance<span class="hide-menu"></a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Inactive_Employee">Inactive User </a></li>
                                <li><a href="<?php echo base_url('IR/resolved_ir'); ?>"> Resolved Incident Reports</a></li>

                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="mdi mdi-clipboard-text"></i><span class="hide-menu">Attendance </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>attendance/Attendance">Attendance List </a></li>
                                <li><a href="<?php echo base_url(); ?>attendance/Save_Attendance">Add Attendance </a></li>
                                <li><a href="<?php echo base_url(); ?>attendance/Attendance_Report">Attendance Report </a>
                                </li>
                                <li><a href="<?php echo base_url(); ?>leave/Earnedleave">Earn Balance</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report">Report</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                    class="mdi mdi-clipboard-text"></i><span class="hide-menu">Leaves </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>leave/leavetypes">Leave List</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Application">Application List</a></li>

                            </ul>
                        </li>












                    <?php } ?>
                    <!-- <li>
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-briefcase-check"></i><span class="hide-menu">Project</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">

                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <span class="hide-menu">W Project</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url('W_Order/W_order_count') ?>">Order Report</a></li>
                                    <li><a href="<?= base_url('Projects/All_Tasks') ?>">Shortage</a></li>
                                </ul>
                            </li>


                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <span class="hide-menu">Atas Project</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url('Atas_Order/Atas_order') ?>">Order Report</a></li>
                                    <li><a href="<?= base_url('Projects/All_Tasks') ?>">Shortage</a></li>
                                </ul>
                            </li>


                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <span class="hide-menu">W1W Deposit</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url('W1W_Deposite_Order/W1W_Deposite_order') ?>">Order
                                            Report</a></li>
                                    <li><a href="<?= base_url('Projects/All_Tasks') ?>">Shortage</a></li>
                                </ul>
                            </li>


                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <span class="hide-menu">W1W Withdrawal</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url('W1W_W/W1W_W_order') ?>">Order Report</a></li>
                                    <li><a href="<?= base_url('Projects/All_Tasks') ?>">Shortage</a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <span class="hide-menu">K8 Deposit</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url('K8_D/K8_D') ?>">Order Report</a></li>
                                    <li><a href="<?= base_url('Projects/All_Tasks') ?>">Shortage</a></li>
                                </ul>
                            </li>


                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <span class="hide-menu">K8 Withdrawal</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= base_url('K8_W/K8_W_order') ?>">Order Report</a></li>
                                    <li><a href="<?= base_url('Projects/All_Tasks') ?>">Shortage</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <li>


                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-close-circle"></i>
                            <span class="hide-menu">Mistakes</span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url('Daily_Mistake/daily_mistake'); ?>">Daily Mistake
                                    Record</a></li>


                            <li><a href="<?php echo base_url(); ?>employee/Disciplinary">Disciplinary </a></li>
                            <li><a href="<?php echo base_url(); ?>IR"> Incident Reports Pending</a></li>
                            <li><a href="<?php echo base_url(); ?>Warning"> Warning Letter</a></li>


                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo base_url('Order_report'); ?>">
                            <i class="mdi mdi-chart-line"></i>
                            <span class="hide-menu">Order Report</span>
                        </a>
                    </li>


                    <li> <a href="<?php echo base_url() ?>notice/All_notice"><i class="mdi mdi-clipboard"></i><span
                                class="hide-menu">Notice <span class="hide-menu"></a></li>
                    <!-- <li> <a href="<?php echo base_url(); ?>settings/Settings" ><i class="mdi mdi-settings"></i><span class="hide-menu">Settings <span class="hide-menu"></a></li> -->
                    <?php
                    $user_type = $this->session->userdata('user_type');

                    if ($user_type === 'SUPER ADMIN'): ?>
                        <li>
                            <a href="<?php echo base_url('login/Sup_logs1'); ?>">
                                <i class="mdi mdi-history"></i>
                                <span class="hide-menu">Logs</span>
                            </a>
                        </li>

                    <?php elseif ($user_type === 'ADMIN'): ?>
                        <li>
                            <a href="<?php echo base_url('login/view_logs'); ?>">
                                <i class="mdi mdi-history"></i>
                                <span class="hide-menu">Logs</span>
                            </a>
                        </li>
                    <?php endif; ?>





                </ul>
        </div>
        </nav>
        <!-- End Sidebar navigation -->
    </div>

    <style>
        /* Sidebar Container */
        /* SIDEBAR CONTAINER */

        /* SIDEBAR CONTAINER */
        .left-sidebar {
            width: 250px;
            background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', sans-serif;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid #e4e7eb;
        }

        body {
            background-color: #f5f9fc;
        }

        .scroll-sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .nav-scroll {
            flex-grow: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .nav-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .nav-scroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }


        /* Adjust main layout */
        .main-wrapper,
        .page-wrapper {
            margin-left: 250px;
            transition: margin 0.3s ease;
        }

        /* User profile styling */
        .user-profile {
            padding: 1rem;
            margin: 1rem;
            background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
            border-radius: 1.5rem;
            display: grid;
            flex-direction: column;
            align-items: center;
            text-align: center;
            grid-template-areas:
                "title icon"
                "content content"
                "bar bar";
            grid-template-columns: 1fr auto;
            gap: 1rem;
            color: #444;
            box-shadow: inset -2px 2px hsl(0 0 100% / 1), -20px 20px 40px hsl(0 0 0 / .25);

        }

        .profile-img img,
        .profile-img i.fa-user-circle {
            width: 70px;
            height: 70px;
            border-radius: 0%;
            margin-bottom: 0.5rem;
        }

        .profile-text h5 {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.3rem;
        }

        .profile-text a {
            margin: 0 6px;
            color: #999;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .profile-text a:hover {
            color: #007bff;
        }

        /* Navigation menu */
        .sidebar-nav ul#sidebarnav {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar-nav li {
            margin: 0.2rem 0;

        }

        .sidebar-nav a {
            display: flex;
            box-shadow: inset -2px 2px #fff, 0 20px 40px rgba(0, 0, 0, 0.1);
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            border-right: 1px solid #e4e7eb;
            padding: 0.7rem 1.2rem;
            border-radius: 0 2rem 2rem 0;
            color: #333;
            font-weight: 500;
            text-decoration: column;
            padding: 1.2rem 0.8rem;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .sidebar-nav a i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Colored hover styles using nth-child */
        .sidebar-nav li:nth-child(1) a:hover {
            background-color: #ffe6e6;
            color: #d9534f;
        }

        .sidebar-nav li:nth-child(2) a:hover {
            background-color: #fff2cc;
            color: #f0ad4e;
        }

        .sidebar-nav li:nth-child(3) a:hover {
            background-color: #e2f0cb;
            color: #5cb85c;
        }

        .sidebar-nav li:nth-child(4) a:hover {
            background-color: #d9edf7;
            color: #5bc0de;
        }

        .sidebar-nav li:nth-child(5) a:hover {
            background-color: #e6e6ff;
            color: #7a71d4;
        }

        .sidebar-nav li:nth-child(6) a:hover {
            background-color: #fce4ec;
            color: #ec407a;
        }

        .sidebar-nav li:nth-child(7) a:hover {
            background-color: #f3e5f5;
            color: #9c27b0;
        }

        .sidebar-nav li:nth-child(8) a:hover {
            background-color: #e8f5e9;
            color: #43a047;
        }

        .sidebar-nav li:nth-child(9) a:hover {
            background-color: #fff3e0;
            color: #fb8c00;
        }

        /* Add more as needed for deeper items */

        .sidebar-nav a.active,
        .sidebar-nav a[aria-expanded="true"] {
            background: #dbeeff;
            color: #007bff;
        }

        /* Submenu */
        .sidebar-nav ul.collapse {
            padding-left: 1rem;
            background-color: #f9f9f9;
            border-left: 2px solid #007bff;
            border-radius: 6px;
            margin: 0.2rem 0;
        }

        .sidebar-nav ul.collapse li a {
            padding: 0.45rem 1rem;
            font-size: 14px;
            display: block;
            border-radius: 6px;
            color: #666;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .sidebar-nav ul.collapse li a:hover {
            background-color: #e3f2fd;
            color: #007bff;


        }
    </style>

    <!-- End Sidebar scroll-->
</aside>