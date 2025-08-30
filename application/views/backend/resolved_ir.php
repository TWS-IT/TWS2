<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<!-- DataTables Buttons + Export JS -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-check-circle"></i> Resolved Incident Reports</h3>
        </div>

        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Resolved Incident Reports</li>
            </ol>
        </div>
    </div>
    <div class="card-body">
        <a href="<?php echo base_url(); ?>IR" class="btn btn-primary text-white">
            <i class="fa fa-hourglass-half"></i> Pending IR
        </a>
    </div>


    <div class="container-fluid">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Approved & Rejected IR List</h4>
            </div>



            <div class="card-body">
                <div class="compact-dropdown-wrapper">
                    <select id="statusFilter" class="compact-dropdown">
                        <option value="">All</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>



                <div class="table-responsive">
                    <table id="resolvedIrTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee Code</th>
                                <th>Full Name</th>
                                <th>Incident Details</th>
                                <th>Date of Incident</th>
                                <th>Status</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                                <th>Created At</th>
                                <th>IR File</th>
                                <th>Project</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($irview as $value): ?>
                                <tr>
                                    <td><?= $value->em_code; ?></td>
                                    <td><?= $value->first_name . ' ' . $value->last_name; ?></td>
                                    <td><?= $value->ir_details; ?></td>
                                    <td><?= $value->ir_date; ?></td>
                                    <td class="<?php
                                    if ($value->status == 'approved')
                                        echo 'approved-status';
                                    elseif ($value->status == 'rejected')
                                        echo 'rejected-status';
                                    ?>">
                                        <?= ucfirst($value->status); ?>
                                    </td>
                                    <td><?= !empty($value->approved_by) ? $value->approved_by : 'UNKNOWN'; ?></td>
                                    <td><?= $value->approved_at; ?></td>
                                    <td><?= $value->created_at; ?></td>
                                    <td>
                                        <?php if (!empty($value->ir_file)): ?>
                                            <a href="<?php echo base_url($value->ir_file); ?>" target="_blank">
                                                View File
                                            </a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>

                                    <td><?php echo $value->pro_name; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        var table = $('#resolvedIrTable').DataTable({
            "aaSorting": [[7, 'desc']], // sort by Created At
            dom: 'Bfrtip', // add buttons
            buttons: [
                { extend: 'csvHtml5', text: '<i class="fa fa-file-csv"></i> Download CSV', className: 'btn btn-success' },
                { extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf"></i> Download PDF', className: 'btn btn-danger', orientation: 'landscape', pageSize: 'A4' },
                { extend: 'print', text: '<i class="fa fa-print"></i> Print', className: 'btn btn-info' }
            ]
        });

        // Status filter
        $('#statusFilter').on('change', function () {
            var status = $(this).val().toLowerCase();
            table.column(4).search(status).draw(); // column 4 = Status
        });

    });
</script>



<style>
    .approved-status {
        color: #155724;
        font-weight: bold;
    }

    .rejected-status {
        color: #c53645ff;
        font-weight: bold;

    }

    .dt-buttons .btn {
        margin-right: 5px;
        border-radius: 5px;
    }


    .neon-dropdown-wrapper {
        display: inline-block;
        perspective: 1000px;
        margin-bottom: 20px;
    }

    .animated-dropdown-wrapper {
        display: inline-block;
        position: relative;
        width: 220px;
        margin-bottom: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .compact-dropdown-wrapper {
        position: relative;
        width: 160px;
        /* smaller width */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Compact dropdown style */
    .compact-dropdown {
        width: 100%;
        padding: 6px 30px 6px 10px;
        /* smaller padding */
        font-size: 14px;
        border-radius: 8px;
        border: 1.8px solid #3498db;
        background: #fff;
        color: #333;
        cursor: pointer;
        appearance: none;
        transition: all 0.25s ease;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    /* Hover & focus animation */
    .compact-dropdown:hover,
    .compact-dropdown:focus {
        border-color: #2980b9;
        box-shadow: 0 2px 6px rgba(41, 128, 185, 0.3);
        outline: none;
    }

    /* Custom arrow */
    .compact-dropdown-wrapper::after {
        content: '▼';
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        font-size: 12px;
        color: #3498db;
        pointer-events: none;
        transition: transform 0.25s ease, color 0.25s ease;
    }

    /* Rotate arrow on focus */
    .compact-dropdown:focus+.compact-dropdown-wrapper::after {
        transform: translateY(-50%) rotate(180deg);
        color: #2980b9;
    }

    /* Option styling */
    .compact-dropdown option {
        color: #333;
        background: #fff;
    }
</style>






<?php $this->load->view('backend/footer'); ?>