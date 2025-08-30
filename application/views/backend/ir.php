<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-file-text"></i> Incident Report</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Incident Report</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <!-- New IR button (opens modal) -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#irModal">
                    <i class="fa fa-plus"></i> New IR
                </button>

                <!-- Resolved IR button (redirects to page) -->
                <a href="<?php echo base_url(); ?>IR/resolved_ir" class="btn btn-info text-white">
                    <i class="fa fa-check-circle"></i> Resolved IR
                </a>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> IR List</h4>
                    </div>




                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="irTable" class="table table-hover">
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
                                        <th>Project</th> <!-- Added Project Column -->
                                        <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                            <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($irview as $value): ?>
                                        <tr>
                                            <td><?php echo $value->em_code; ?></td>
                                            <td><?php echo $value->first_name . ' ' . $value->last_name; ?></td>
                                            <td><?php echo $value->ir_details; ?></td>
                                            <td><?php echo $value->ir_date; ?></td>
                                            <td class="<?php
                                            if ($value->status == 'approved') {
                                                echo 'approved-status';
                                            } elseif ($value->status == 'rejected') {
                                                echo 'rejected-status';
                                            } elseif ($value->status == 'pending') {
                                                echo 'pending-status';
                                            }
                                            ?>">
                                                <?php echo $value->status; ?>
                                            </td>
                                            <td>
                                                <?php echo !empty($value->approved_by) ? $value->approved_by : 'UNKNOWN'; ?>
                                            </td>

                                            <td><?php echo $value->approved_at; ?></td>
                                            <td><?php echo $value->created_at; ?></td>
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
                                            <td class="jsgrid-align-center">
                                                <?php if ($this->session->userdata('user_type') != 'EMPLOYEE'): ?>
                                                    <button class="btn btn-sm btn-warning editbtn"
                                                        data-id="<?php echo $value->id; ?>" data-action="edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-success approvebtn"
                                                        data-id="<?php echo $value->id; ?>" data-action="approve">
                                                        <i class="fa fa-check-circle"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger rejectbtn"
                                                        data-id="<?php echo $value->id; ?>" data-action="reject">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                <?php endif; ?>

                                            </td>

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

    <!-- Modal -->
    <!-- Modal Form -->
    <div class="modal fade" id="irModal" tabindex="-1" role="dialog" aria-labelledby="irModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-file-text"></i> Incident Report</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo base_url('IR/Add_IR'); ?>" id="irForm"
                    enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Employee</label>
                            <select class="form-control custom-select col-md-8" name="emid" id="emid" required>
                                <option value="">Select Here</option>
                                <?php foreach ($employee as $value): ?>
                                    <option value="<?php echo $value->em_code; ?>">
                                        <?php echo $value->first_name . ' ' . $value->last_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Date of Incident</label>
                            <input type="date" name="ir_date" id="ir_date" class="form-control col-md-8" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Details of Incident</label>
                            <input type="text" name="ir_details" id="ir_details" class="form-control col-md-8" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 control-label">Prevent Mistake</label>
                            <textarea name="prevent" id="prevent" class="form-control col-md-8"></textarea>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 control-label">Working Project</label>
                            <select class="form-control custom-select col-md-8" name="project_id" id="project" required>
                                <option value="">Select Project</option>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= $project->id ?>"><?= $project->pro_name ?></option>
                                <?php endforeach; ?>
                            </select>


                        </div>

                        <div class="form-group row">
    <label class="col-md-3 col-form-label">IR File</label>
    <div class="col-md-4">
        <input type="file" name="ir_file" 
            <?php if ($this->session->userdata('user_type') == 'EMPLOYEE') echo 'readonly'; ?>
        class="form-control" aria-invalid="false">

        <?php if (isset($ir) && !empty($ir->ir_file)): ?>
            <small class="form-text text-muted mt-1">
                Current File: <a href="<?= base_url($ir->ir_file); ?>" target="_blank">View</a>
            </small>
        <?php endif; ?>
    </div>
</div>



                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="action" id="action">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitIR" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

<script>
    $(document).ready(function () {

        var table = $('#irTable').DataTable({
            "aaSorting": [[8, 'desc']],
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        $('#statusFilter').on('change', function () {
            var status = $(this).val().toLowerCase();
            table.column(4).search(status).draw();
        });


        $('#submitIR').click(function (e) {
            e.preventDefault();
            var form = $('#irForm')[0]; // Get the form element
            var formData = new FormData(form); // Create FormData object including file

            $('#submitIR').prop('disabled', true);

            $.ajax({
                url: "<?php echo base_url('IR/Add_IR'); ?>",
                type: "POST",
                data: formData,
                processData: false, // Important for file upload
                contentType: false, // Important for file upload
                success: function () {
                    $('#irModal').modal('hide');
                    location.reload(); // Refresh table
                },
                error: function () {
                    alert("Failed to save data.");
                },
                complete: function () {
                    $('#submitIR').prop('disabled', false);
                }
            });
        });

        // Clear form on modal close
        $('#irModal').on('hidden.bs.modal', function () {
            $('#irForm')[0].reset();
            $('#irForm').find('[name="id"]').val('');
        });

        // Handle Approve/Reject/Edit buttons
        $(document).on('click', '.approvebtn, .rejectbtn, .editbtn', function () {
            var action = $(this).data('action');
            var id = $(this).data('id');

            if (action === 'edit') {
                editIncidentReport(id);
            } else {
                var status = action === 'approve' ? 'approved' : 'rejected';
                if (confirm(`Are you sure you want to ${status} this report?`)) {
                    updateIncidentStatus(id, status);
                }
            }
        });

        function editIncidentReport(id) {
            $('#irForm')[0].reset();
            $('#irModal').modal('show');
            $.ajax({
                url: "<?php echo base_url('IR/ir_by_id'); ?>",
                method: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.irvalue) {
                        $('#irForm').find('[name="id"]').val(response.irvalue.id);
                        $('#irForm').find('[name="emid"]').val(response.irvalue.emp_id);
                        $('#irForm').find('[name="ir_date"]').val(response.irvalue.ir_date);
                        $('#irForm').find('[name="ir_details"]').val(response.irvalue.ir_details);
                        $('#irForm').find('[name="prevent"]').val(response.irvalue.prevent);
                        $('#irForm').find('[name="project_id"]').val(response.irvalue.project_id);
                    } else {
                        alert('Failed to load incident data');
                    }
                },
                error: function () {
                    alert("Error loading data.");
                }
            });
        }

        function updateIncidentStatus(id, status) {
            $.ajax({
                url: "<?php echo base_url('IR/update_status'); ?>",
                method: 'POST',
                data: { id: id, status: status },
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    location.reload();
                },
                error: function () {
                    alert("Failed to update status.");
                }
            });
        }
    });



</script>
<script>

    // $(document).ready(function () {
    //     // When the employee dropdown changes
    //     $('#emid').change(function () {
    //         var em_id = $(this).val();  // Get the selected employee ID

    //         if (em_id) {
    //             // AJAX call to fetch the working project for the selected employee
    //             $.ajax({
    //                 url: '<?php echo base_url('ir/get_employee_project/'); ?>' + em_id,
    //                 method: 'GET',
    //                 dataType: 'json',
    //                 success: function (response) {
    //                     if (response.project) {
    //                         // Update the Working Project field with the returned project
    //                         $('#working_project').val(response.project);
    //                     } else {
    //                         // Clear the field if no project is found
    //                         $('#working_project').val('');
    //                     }
    //                 },
    //                 error: function () {
    //                     // Handle any errors here
    //                     alert('Error fetching project data');
    //                 }
    //             });
    //         } else {
    //             // Clear the field if no employee is selected
    //             $('#working_project').val('');
    //         }
    //     });
    // });


</script>

<style>
    .approved-status {
        background-color: transparent;

        color: #155724;

        font-weight: bold;
    }

    .rejected-status {
        background-color: transparent;

        color: #c53645ff;

        font-weight: bold;
    }

    .pending-status {
        background-color: transparent;

        color: #040d85ff;

        font-weight: bold;
    }
</style>
<style>
    .dropdown-3d {
        padding: 3px 8px;
        /* smaller padding */
        font-size: 12px;
        /* smaller font */
        height: 28px;
        /* set exact height */
        line-height: 22px;
        /* align text vertically */
        border: 1px solid #aaa;
        border-radius: 6px;
        background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        appearance: none;
        /* remove default arrow */
        cursor: pointer;
        transition: all 0.2s ease;
        outline: none;
        min-width: 80px;
        /* width of dropdown */
        position: relative;
        /* needed for custom arrow */
    }

    /* Hover effect */
    .dropdown-3d:hover {
        background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
        transform: translateY(-1px);
    }

    /* Focus effect */
    .dropdown-3d:focus {
        border-color: #007bff;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
    }

    /* Optional: smaller options */
    .dropdown-3d option {
        padding: 3px 5px;
        font-size: 12px;
    }

    /* Custom arrow using wrapper for better cross-browser support */
    .dropdown-3d-wrapper {
        display: inline-block;
        position: relative;
    }

    .dropdown-3d-wrapper::after {
        content: "▾";
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        font-size: 12px;
        color: #555;
    }
</style>


<!-- search script -->

<script>
    $(document).ready(function () {
        // Make Employee dropdown searchable inside modal
        $('#emid').select2({
            placeholder: "Select Employee",
            allowClear: true,
            width: '66.8%',
            dropdownParent: $('#irModal'),
            minimumResultsForSearch: 0
        });
        $('#emid').on('select2:open', function () {
            setTimeout(function () {
                document.querySelector('.select2-container--open .select2-search__field').focus();
            }, 100);
        });

    });

</script>

<style>
    /* Style the Select2 container */
    .select2-container--default .select2-selection--single {
        height: 34px;
        /* match input height */
        border: 1px solid #aaa;
        border-radius: 6px;
        background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        font-size: 13px;
        padding-left: 6px;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    /* Arrow styling */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 3px;
        right: 8px;
    }

    /* Hover effect */
    .select2-container--default .select2-selection--single:hover {
        background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
        transform: translateY(-1px);
    }

    /* Focus effect */
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #007bff;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
    }

    /* Dropdown menu */
    .select2-dropdown {
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        font-size: 13px;
    }

    /* Options */
    .select2-results__option {
        padding: 5px 10px;
        font-size: 13px;
    }

    /* Highlighted option */
    .select2-results__option--highlighted {
        background-color: #007bff !important;
        color: #fff !important;
    }


    /* form controll stylr */
    .form-control,
    .select2-container--default .select2-selection--single {
        height: 38px;
        border: 1px solid #aaa;
        border-radius: 6px;
        background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        font-size: 14px;
        padding: 6px 10px;
        transition: all 0.2s ease;
    }

    /* 🔹 Hover & Focus effects */
    .form-control:hover,
    .select2-container--default .select2-selection--single:hover {
        background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
        transform: translateY(-1px);
    }

    .form-control:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #007bff;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
        outline: none;
    }

    /* 🔹 Fix Select2 text alignment */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: 6px;
    }

    /* 🔹 Dropdown styling */
    .select2-dropdown {
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        font-size: 14px;
    }

    .select2-results__option {
        padding: 6px 10px;
    }

    .select2-results__option--highlighted {
        background-color: #007bff !important;
        color: #fff !important;
    }
</style>

<?php $this->load->view('backend/footer'); ?>