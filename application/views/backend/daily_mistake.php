<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Select2 CSS + JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




<div class="page-wrapper">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
                <i class="fa fa-question-circle" style="color:#1976d2"></i> Daily Mistake Record
            </h3>

        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item active">Daily Mistake Record</li>
            </ol>
        </div>
    </div>

    <div class="message"></div>

    <!-- Add Entry Modal -->
    <div class="modal fade" id="mistakeModal" tabindex="-1" role="dialog" aria-labelledby="mistakeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mistakeModalLabel"><i class="fa fa-question-circle"></i> Add Daily Mistake Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post"
                    action="<?= isset($mistake) ? site_url('Daily_Mistake/update_mistake') : site_url('Daily_Mistake/save_mistake') ?>"
                    id="mistakeForm">
                    <div class="modal-body">
                        <!-- Hidden ID field for edit -->
                        <?php if (isset($mistake)): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($mistake->id) ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Employee</label>
                            <select id="employeeSelect" name="emp_id" class="form-control" required>
                                <option value="">Select Employee</option>
                                <?php foreach ($employee as $emp): ?>
                                    <option value="<?= htmlspecialchars($emp->em_code) ?>" <?= (isset($mistake) && $mistake->emp_id == $emp->em_code) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($emp->first_name . ' ' . $emp->last_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <label for="mistake_type">Mistake Type</label>
                        <select name="mistake_type" id="mistake_type" class="form-control" required>
                            <option value="">Select Mistake Type</option>
                            <?php
                            $types = [
                                "Wrong Key in Amount",
                                "Wrong Key in Bank Code",
                                "Wrong Key - No Reference",
                                "Wrong Key - Double Key in",
                                "Wrong Key - Wrong Account",
                                "Wrong Key - Reversal",
                                "Double Payout",
                                "custom"
                            ];
                            foreach ($types as $type):
                                ?>
                                <option value="<?= htmlspecialchars($type) ?>" <?= (isset($mistake) && $mistake->mistake_type == $type) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="form-group">
                            <br>
                            <label>PC Number</label>
                            <input type="text" name="pc_number" class="form-control" placeholder="Enter PC Number"
                                required value="<?= isset($mistake) ? htmlspecialchars($mistake->pc_number) : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" required
                                value="<?= isset($mistake) ? htmlspecialchars($mistake->date) : '' ?>">
                        </div>


                        <label>Project</label>
                        <select name="project_id" class="form-control custom-select">
                            <option value="ALL">All Projects</option>
                            <?php if (!empty($projects)): ?>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= htmlspecialchars($project->id) ?>" <?= (isset($mistake) && $mistake->project_id == $project->id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($project->pro_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>







                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit"
                            class="btn btn-primary"><?= isset($mistake) ? 'Update Entry' : 'Save Entry' ?></button>
                    </div>


                </form>

            </div>
        </div>
    </div>

    <!-- Add Entry Button -->
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mistakeModal">
                    <i class="fa fa-plus"></i> Add Entry
                </button>
            </div>
        </div>

        <!-- Mistake Records Table -->
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-question-circle" aria-hidden="true"></i> Daily Mistake Record</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="employees123"
                                class="display nowrap table table-hover table-striped table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Employee ID</th>
                                        <th>Mistake Type</th>
                                        <th>PC Position</th>
                                        <th>Date</th>
                                        <th>Updated At</th>
                                        <th>Project</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($mistakes) && is_array($mistakes) || is_object($mistakes)): ?>
                                        <?php foreach ($mistakes as $mistake): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($mistake->employee_name) ?></td>
                                                <td><?= htmlspecialchars($mistake->emp_id) ?></td>
                                                <td><?= htmlspecialchars($mistake->mistake_type) ?></td>
                                                <td><?= htmlspecialchars($mistake->pc_number) ?></td>
                                                <td><?= htmlspecialchars($mistake->date) ?></td>
                                                <td><?= htmlspecialchars($mistake->updated_at) ?></td>
                                                <td><?= htmlspecialchars($mistake->project) ?></td>
                                                <td>
                                                    <button class="btn btn-outline-success btn-sm me-1"
                                                        onclick='editMistake(<?= json_encode($mistake) ?>)'>
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <?php if (in_array($this->session->userdata('user_type'), ['SUPER ADMIN', 'ADMIN'])): ?>

                                                        <a href="<?= base_url("Daily_Mistake/delete_mistake/{$mistake->id}") ?>"
                                                            onclick="return confirm('Are you sure you want to delete this Mistake?')"
                                                            class="btn btn-outline-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No mistakes found.</td>
                                        </tr>
                                    <?php endif; ?>
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
    function editMistake(mistake) {
        $('#mistakeForm').attr('action', '<?= site_url("Daily_Mistake/update_mistake") ?>');
        $('input[name="id"]').remove();
        $('#mistakeForm').prepend(`<input type="hidden" name="id" value="${mistake.id}">`);
        $('select[name="emp_id"]').val(mistake.emp_id);
        $('select[name="mistake_type"]').val(mistake.mistake_type);
        $('input[name="pc_number"]').val(mistake.pc_number);
        $('input[name="date"]').val(mistake.date);
        $('select[name="project_id"]').val(mistake.project_id);
        $('#mistakeModal').modal('show');
    }

</script>

<?php $this->load->view('backend/footer'); ?>

<script>
    $('#employees123').DataTable({
        "aaSorting": [[1, 'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>

<script>
    (function ($) {
        var $modal = $('#mistakeModal');
        var $emp = $('#employeeSelect');


        function mountSelect2() {
            // if already initialized, destroy first (avoids duplicates on re-open)
            if ($emp.hasClass('select2-hidden-accessible')) {
                $emp.select2('destroy');
            }

            $emp.select2({
                placeholder: 'Select Employee',
                allowClear: true,
                width: '100%',
                dropdownParent: $modal,      // IMPORTANT for modals
                minimumResultsForSearch: 0   // always show search
            });

            // Auto-focus the search box when dropdown opens
            $emp.on('select2:open', function () {
                setTimeout(function () {
                    var input = document.querySelector('.select2-container .select2-search__field');
                    if (input) input.focus();
                }, 0);
            });
        }

        // Init when the modal is shown (reliable with hidden modals)
        $modal.on('shown.bs.modal', function () {
            mountSelect2();
        });

        // If the modal might already be open (e.g., edit flow), mount immediately too
        if ($modal.is(':visible')) {
            mountSelect2();
        }

    })(jQuery);
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

    /* form controll style */
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

<!-- <script>
    $(document).ready(function () {
    // Employee Dropdown
    $('#employeeSelect').select2({
        placeholder: "Select Employee",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#mistakeModal'),
        minimumResultsForSearch: 0
    });

    // Mistake Type Dropdown
    $('#mistake_type').select2({
        placeholder: "Select Mistake Type",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#mistakeModal'),
        minimumResultsForSearch: 0
    });
});

</script> -->