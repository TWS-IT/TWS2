<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-exclamation-triangle"></i> Warning Management</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Warnings</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <a href="<?php echo base_url('Warning/create'); ?>" class="btn btn-warning-custom">
                    <i class="fa fa-plus"></i> New Warning
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Warning List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="warningTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Reason</th>
                                        <th>Sub Reason</th>
                                        <th>Skip Supervisor Approval</th>
                                        <th>Date</th>
                                        <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                            <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($warnings as $value): ?>
                                        <tr>
                                            <td><?php echo $value->employee_id; ?></td>
                                            <td><?php echo $value->employee_name; ?></td>
                                            <td><?php echo $value->designation; ?></td>
                                            <td><?php echo $value->reason_for_warning; ?></td>
                                            <td><?php echo $value->sub_reasons; ?></td>
                                            <td><?php echo $value->skp_requested_approval; ?></td>
                                            <td><?php echo $value->date; ?></td>
                                            <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                                <td class="jsgrid-align-center">
                                                    <a href="<?php echo base_url('Warning/details/' . $value->id); ?>"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>

                                                    <a href="<?php echo base_url('Warning/edit/' . $value->id); ?>"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger deletebtn"
                                                        data-id="<?php echo $value->id; ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#warningTable').DataTable({
            "aaSorting": [],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        // Handle Delete
        $(document).on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this warning?")) {
                $.ajax({
                    url: "<?php echo base_url('Warning/delete_warning'); ?>",
                    type: "POST",
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function () {
                        alert("Failed to delete.");
                    }
                });
            }
        });
    });
</script>

<style>
/* ========== GENERAL PAGE WRAPPER ========== */
.page-wrapper {
    background: #f7f9fc;
    min-height: 100vh;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ========== PAGE TITLE SECTION ========== */
.page-titles {
    margin-bottom: 20px;
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

/* ========== CUSTOM BUTTON (NEW WARNING) ========== */
.btn-warning-custom {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important; /* pill-style */
    padding: 10px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-warning-custom:hover {
    background: linear-gradient(135deg, #138496, #0d6efd);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
}

/* Small action buttons in table */
.table .btn {
    border-radius: 6px !important;
    padding: 6px 10px;
    transition: 0.2s;
}

.table .btn:hover {
    transform: scale(1.05);
}

/* ========== CARD STYLING ========== */
.card {
    border-radius: 16px;
    overflow: hidden;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.card-header {
    background: linear-gradient(135deg, #17a2b8, #138496);
    border-bottom: none;
    padding: 15px 20px;
}

.card-header h4 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
}

/* ========== TABLE STYLING ========== */
.table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.table thead th {
    background: #f1f3f6;
    font-weight: 600;
    color: #555;
    padding: 12px;
    border: none;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.table tbody tr {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: 0.2s ease-in-out;
}

.table tbody tr:hover {
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.table td {
    padding: 12px;
    vertical-align: middle;
    border-top: none;
    font-size: 0.9rem;
    color: #333;
}

/* Align action buttons center */
.jsgrid-align-center {
    text-align: center;
}

/* ========== DATATABLE BUTTONS ========== */
.dt-buttons .btn {
    border-radius: 20px !important;
    background: #17a2b8 !important;
    border: none;
    color: #fff !important;
    font-weight: 500;
    margin: 3px;
    padding: 6px 14px;
    transition: 0.3s;
}

.dt-buttons .btn:hover {
    background: #138496 !important;
}

</style>

<?php $this->load->view('backend/footer'); ?>