<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
    <h3 class="text-themecolor"><i class="fa fa-user" style="color:#1976d2"></i> Add Employee</h3>
</div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>employee/view">Employee</a></li>
                <li class="breadcrumb-item active">Add Employee</li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
    <?php $projectvalue = $this->employee_model->getProjects(); ?>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a
                        href="<?php echo base_url(); ?>employee/Employees" class="text-white"><i class=""
                            aria-hidden="true"></i> Employee List</a></button>
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a
                        href="<?php echo base_url(); ?>employee/Disciplinary" class="text-white"><i class=""
                            aria-hidden="true"></i> Disciplinary List</a></button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Add New
                            Employee<span class="pull-right "></span></h4>
                    </div>
                    <?php echo validation_errors(); ?>
                    <?php echo $this->upload->display_errors(); ?>

                    <?php echo $this->session->flashdata('formdata'); ?>

                    <div class="card-body">

                        <form class="row" method="post" action="Save" enctype="multipart/form-data">
                            <div class="form-group col-md-3 m-t-20">
                                <label>First Name</label>
                                <input type="text" name="fname" class="form-control form-control-line"
                                    placeholder="Employee's FirstName" minlength="2" required>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Last Name </label>
                                <input type="text" id="" name="lname" class="form-control form-control-line" value=""
                                    placeholder="Employee's LastName" minlength="2">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Employee ID </label>
                                <input type="text" name="eid" class="form-control form-control-line"
                                    placeholder="Example: 8820">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Project</label>
                                <select name="project_id" class="form-control custom-select" required>
                                    <option value="">Select Project</option>
                                    <?php foreach ($projectvalue as $project): ?>
                                        <option value="<?php echo $project->pro_name; ?>"><?php echo $project->pro_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Department </label>
                                <select name="dept" class="form-control custom-select">
                                    <option>Select Department</option>
                                    <?Php foreach ($depvalue as $value): ?>
                                        <option value="<?php echo $value->id ?>"><?php echo $value->dep_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Designation </label>
                                <select name="deg" class="form-control custom-select" required>
                                    <option>Select Designation</option>
                                    <?Php foreach ($degvalue as $value): ?>
                                        <option value="<?php echo $value->id ?>"><?php echo $value->des_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Role </label>
                                <select name="role" class="form-control custom-select" required>
                                    <option>Select Role</option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="EMPLOYEE">Employee</option>
                                    <!-- <option value="SUPER ADMIN">Super Admin</option> -->
                                </select>
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Gender </label>
                                <select name="gender" class="form-control custom-select" required>
                                    <option>Select Gender</option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                            </div>
                            <!-- <div class="form-group col-md-3 m-t-20">
                                        <label>Select Country</label>
                                        <select name="blood" class="form-control custom-select">
                                            <option>Select Country</option>
                                            <option value="O+">Srilanka</option>
                                            <option value="O-">Malaysia</option>
                                            <option value="A+">Philippines</option>
                                            <option value="A-">Cambodia</option> -->
                            <!--    <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>-->
                            <!-- </select>
                                    </div> -->
                            <!-- <div class="form-group col-md-3 m-t-20">
                                        <label></label>
                                        <input type="text" name="nid" class="form-control" value="" placeholder="(Max. 10)" minlength="10" required> 
                                    </div>  -->
                            <div class="form-group col-md-3 m-t-20">
                                <label>Contact Number </label>
                                <input type="text" name="contact" class="form-control" value="" placeholder="1234567890"
                                    minlength="10" maxlength="15">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>NIC Number </label>
                                <input type="text" class="form-control" placeholder="NIC Number" name="nid" value=""
                                    minlength="10" required>
                            </div>

                            <div class="form-group col-md-3 m-t-20">
                                <label>Date Of Birth </label>
                                <input type="date" name="dob" id="example-email2" name="example-email"
                                    class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Date Of Joining </label>
                                <input type="date" name="joindate" id="example-email2" name="example-email"
                                    class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Address </label>
                                <input type="text" class="form-control" placeholder="Address" name="addr" value=""
                                    minlength="10">
                            </div>
                            <!--  <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Leaving </label>
                                        <input type="date" name="leavedate" id="example-email2" name="example-email" class="form-control" placeholder=""> 
                                    </div> 
                                    -->
                            <!--  <div class="form-group col-md-3 m-t-20">
                                        <label>Username </label>
                                        <input type="text" name="username" class="form-control form-control-line" value="" placeholder="Username"> 
                                    </div>
                                            -->
                            <div class="form-group col-md-3 m-t-20">
                                <label>Email </label>
                                <input type="email" id="example-email2" name="email" class="form-control"
                                    placeholder="email@mail.com" minlength="7" required>
                            </div>


                            <div class="form-group col-md-3 m-t-20">
                                <label>Password </label>
                                <input type="text" name="password" class="form-control" value=""
                                    placeholder="**********">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Confirm Password </label>
                                <input type="text" name="confirm" class="form-control" value=""
                                    placeholder="**********">
                            </div>
                            <div class="form-group col-md-3 m-t-20">
                                <label>Image </label>
                                <input type="file" name="image_url" class="form-control" value="">
                            </div>
                            <div class="form-actions col-md-12">
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="window.location.href='<?php echo base_url(); ?>employee';">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('backend/footer'); ?>