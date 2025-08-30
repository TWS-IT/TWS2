<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-exclamation-triangle"></i> Warning Details</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>Warning">Warning Management</a>
                </li>
                <li class="breadcrumb-item active">Warnings</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div id="print-warning">
            <div class="profile-card">
                <div class="row">
                    <!-- Employee Image -->
                    <div class="col-md-3 text-center">
                        <?php if (isset($employee) && !empty($employee->em_image)): ?>
                            <img src="<?php echo base_url('assets/images/users/' . $employee->em_image); ?>"
                                alt="<?php echo $employee->first_name ?>" title="<?php echo $employee->first_name ?>"
                                class="profile-img" />
                        <?php else: ?>
                            <img src="<?php echo base_url('assets/images/users/user.png'); ?>" alt="No Image"
                                class="profile-img" />
                        <?php endif; ?>
                    </div>
                    <!-- <div class="col-md-3 text-center">
                <?php echo isset($employee) ? $employee->first_name . ' ' . $employee->last_name : $warning->employee_name; ?>
                    </div>
                <div class="col-md-3 text-center">
                    <?php echo isset($employee) ? $employee->em_phone : ''; ?>
                </div>
                <div class="col-md-3 text-center">
                    <?php echo isset($employee) ? $employee->em_email : ''; ?>
                </div> -->

                    <!-- Details Table -->
                    <div class="col-md-12">
                        <table class="table profile-table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <th><i class="fa fa-user"></i> Employee Name</th>
                                    <td><?php echo isset($employee) ? $employee->first_name . ' ' . $employee->last_name : $warning->employee_name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-id-badge"></i> Employee Code</th>
                                    <td><?php echo isset($employee) ? $employee->em_code : $warning->employee_id; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-briefcase"></i> Designation</th>
                                    <td><?php echo isset($employee) ? $employee->em_role : $warning->designation; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-exclamation-circle"></i> Reason for Warning</th>
                                    <td><span class="badge-warning"><?php echo $warning->reason_for_warning; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-info-circle"></i> Sub Reason</th>
                                    <td><span class="badge-subreason"><?php echo $warning->sub_reasons; ?></span></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-file-alt"></i> Brief Explanation</th>
                                    <td><?php echo $warning->brief_explanation; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-comments"></i> Supervisor Comments</th>
                                    <td><?php echo $warning->supervisors_comments; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-user-check"></i> Skip Supervisor Approval</th>
                                    <td><?php echo $warning->skp_requested_approval; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-user-shield"></i> Divisional Head Approval</th>
                                    <td><?php echo $warning->dh_requested_approval; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-check-circle"></i> Acknowledgement</th>
                                    <td><?php echo $warning->acknowledgement; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-calendar-alt"></i> Date Issued</th>
                                    <td><?php echo $warning->date; ?></td>
                                </tr>
                                <tr>
                                    <th><i class="fa fa-paperclip"></i> Attachment</th>
                                    <td>
                                        <?php if (!empty($warning->attachment)): ?>
                                            <a href="<?php echo base_url('assets/war_attachment/' . $warning->attachment); ?>"
                                                target="_blank">
                                                <?php echo $warning->attachment; ?>
                                            </a>
                                        <?php else: ?>
                                            No file attached
                                        <?php endif; ?>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                        <button onclick="printWarning()" class="btn btn-secondary">
    <i class="fa fa-print"></i> Print
</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printWarning() {
    var printContents = document.getElementById('print-warning').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // reload to restore any JS functionality
}
</script>



<style>
    /* ================= PAGE WRAPPER ================= */
    .page-wrapper {
        background: #f7f9fc;
        min-height: 100vh;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ================= PAGE HEADER ================= */
    .page-titles {
        margin-bottom: 25px;
    }

    .page-titles h3 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #34495e;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-titles h3 i {
        color: #e67e22;
    }

    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .breadcrumb-item a {
        color: #17a2b8;
        font-weight: 500;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #6c757d;
        font-weight: 600;
    }

    /* ================= PROFILE CARD ================= */
    .profile-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin: 0 auto;
        max-width: 1000px;
    }

    /* ================= PROFILE IMAGE ================= */
    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #17a2b8;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        margin-bottom: 20px;
    }

    /* ================= DETAILS TABLE ================= */
    .profile-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .profile-table th {
        width: 260px;
        font-weight: 600;
        color: #34495e;
        vertical-align: middle;
        padding: 12px 15px;
        font-size: 0.95rem;
        background: #f1f3f6;
        border-radius: 10px 0 0 10px;
        white-space: nowrap;
    }

    .profile-table td {
        color: #2c3e50;
        padding: 12px 15px;
        font-size: 0.95rem;
        back
    }
</style>

<?php $this->load->view('backend/footer'); ?>