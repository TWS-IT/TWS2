<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-user-tag" style="color:#1976d2"></i> Designation</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Designation</li>
            </ol>
        </div>
    </div>
    <div class="message"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <?php if (isset($editdesignation)) { ?>
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Edit Designation</h4>
                        </div>

                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>



                        <div class="card-body">
                            <form method="post" action="<?php echo base_url(); ?>organization/Update_des"
                                enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Designation Name</label>
                                                <input type="text" name="designation" id="firstName"
                                                    value="<?php echo $editdesignation->des_name; ?>" class="form-control"
                                                    placeholder="">
                                                <input type="hidden" name="id" value="<?php echo $editdesignation->id; ?>">
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                    <!-- <button type="button" class="btn btn-danger">Cancel</button> -->
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>

                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Designation</h4>
                        </div>

                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>



                        <div class="card-body">
                            <form method="post" action="Save_des" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">Designation Name</label>
                                                <input type="text" name="designation" id="firstName" value=""
                                                    class="form-control" placeholder="" minlength="3" required>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <!--/row-->
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                    <!-- <button type="button" class="btn btn-danger">Cancel</button> -->
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-7">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Designation List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="designationTable"
                                class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Designation </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($designation as $value) { ?>
                                        <tr>
                                            <td><?php echo $value->des_name; ?></td>
                                            <td class="jsgrid-align-center ">
                                                <a href="<?php echo base_url(); ?>organization/Edit_des/<?php echo $value->id ?>"
                                                    title="Edit" class="btn btn-sm btn-primary waves-effect waves-light"><i
                                                        class="fa fa-pencil-square-o"></i></a>
                                                <a onclick="return confirm('Are you sure to delete this data?')"
                                                    href="<?php echo base_url(); ?>organization/des_delete/<?php echo $value->id; ?>"
                                                    title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i
                                                        class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
        <form id="designationForm" method="post" action="<?php echo site_url('organization/Save_des'); ?>">
    <input type="hidden" 
            name="<?php echo $this->security->get_csrf_token_name(); ?>" 
            value="<?php echo $this->security->get_csrf_hash(); ?>">
    <div class="form-group">
        <label>Designation Name</label>
        <input type="text" name="designation" class="form-control" required minlength="3">
    </div>
    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
</form>

<!-- Success / error message placeholder -->
<div id="msg"></div>

<script>
$(document).ready(function () {
    $("#designationForm").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                // Show message
                $("#msg").html('<div class="alert alert-success">'+response+'</div>');
                
                // Clear input field
                $("#designationForm")[0].reset();

                // Reload table without refreshing the page
                $("#designationTable").load(location.href + " #designationTable");
            },
            error: function () {
                $("#msg").html('<div class="alert alert-danger">Error saving data.</div>');
            }
        });
    });
});
        </script>

        <?php $this->load->view('backend/footer'); ?>