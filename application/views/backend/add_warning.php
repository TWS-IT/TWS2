<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-exclamation-triangle"></i> New Warning</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('Warning'); ?>">Warnings</a></li>
                <li class="breadcrumb-item active">New Warning</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card card-outline-info">
            <div class="card-body">
                <form method="post" action="<?php echo base_url('Warning/save'); ?>" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="emid">Employee</label>
                            <select name="emid" id="emid" class="form-control select2" required>
                                <option value="">-- Select Employee --</option>
                                <?php foreach ($employee as $emp): ?>
                                    <option value="<?php echo $emp->em_id; ?>" <?php echo (isset($warning) && $warning->employee_id == $emp->em_code) ? 'selected' : ''; ?>>
                                        <?php echo $emp->first_name . ' ' . $emp->last_name . ' (' . $emp->em_code . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="employee_id">Employee ID</label>
                            <input type="text" name="employee_id" id="employee_id" class="form-control"
                                value="<?php echo isset($warning) ? $warning->employee_id : ''; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" readonly
                                value="<?php echo isset($warning) ? $warning->designation : ''; ?>">
                        </div>

                    </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="reason_for_warning">Reason for Warning</label>
                    <select name="reason_for_warning" id="reason_for_warning" class="form-control" required>
                        <option value="">-- Select Reason --</option>
                        <option value="Performance" <?php echo (isset($warning) && $warning->reason_for_warning == 'Performance') ? 'selected' : ''; ?>>Performance
                        </option>
                        <option value="Disciplinary" <?php echo (isset($warning) && $warning->reason_for_warning == 'Disciplinary') ? 'selected' : ''; ?>>Disciplinary
                        </option>
                        <option value="SOP Violations / Poor quality of work" <?php echo (isset($warning) && $warning->reason_for_warning == 'SOP Violations / Poor quality of work') ? 'selected' : ''; ?>>SOP Violations / Poor quality of work</option>
                        <option value="Punctuality" <?php echo (isset($warning) && $warning->reason_for_warning == 'Punctuality') ? 'selected' : ''; ?>>Punctuality
                        </option>
                        <option value="Termination" <?php echo (isset($warning) && $warning->reason_for_warning == 'Termination') ? 'selected' : ''; ?>>Termination
                        </option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="sub_reasons">Sub Reason</label>
                    <select name="sub_reasons" id="sub_reasons" class="form-control" required>
                        <option value="">-- Select Sub Reason --</option>
                        <?php if (isset($warning)): ?>
                            <option value="<?php echo $warning->sub_reasons; ?>" selected>
                                <?php echo $warning->sub_reasons; ?>
                            </option>
                        <?php endif; ?>
                    </select>
                </div>


                <div class="form-group col-md-4">
                    <label for="date">Warning Date</label>
                    <input type="date" name="date" id="date" class="form-control"
                        value="<?php echo isset($warning->date) ? $warning->date : date('Y-m-d'); ?>" required>
                </div>
            </div>



            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="brief_explanation">Brief Explanation</label>
                    <textarea name="brief_explanation" id="brief_explanation" class="form-control" rows="4"
                        placeholder="Enter detailed explanation..."><?php echo isset($warning) ? $warning->brief_explanation : ''; ?></textarea>
                </div>


                <div class="form-group col-md-6">
                    <label for="supervisors_comments">Supervisor Comments</label>
                    <textarea name="supervisors_comments" id="supervisors_comments" class="form-control" rows="4"
                        placeholder="Enter detailed explanation..."><?php echo isset($warning) ? $warning->supervisors_comments : ''; ?></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Skip Supervisor Approval</label>
                    <input type="text" name="skp_requested_approval" class="form-control" placeholder="Skip Supervisor"
                        value="<?php echo isset($warning) ? $warning->skp_requested_approval : ''; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label>Divisional Head Approval</label>
                    <input type="text" name="dh_requested_approval" class="form-control" placeholder="Divisional Head"
                        value="<?php echo isset($warning) ? $warning->dh_requested_approval : ''; ?>">
                </div>

                <div class="form-group col-md-4">
                    <label>Acknowledgement</label>
                    <input type="text" name="acknowledgement" class="form-control" placeholder="Acknowledgement"
                        value="<?php echo isset($warning) ? $warning->acknowledgement : ''; ?>">
                </div>

            </div>

<div class="form-group col-md-4">
    <label for="attachment">Attachment</label>
    <div class="material-file-input">
        <input type="file" id="attachment" name="attachment">
        <label for="attachment">
            <i class="fa fa-upload"></i>
            <span class="file-text">Choose file</span>
        </label>
    </div>

    <?php if (isset($warning) && $warning->attachment): ?>
        <div class="current-file">
            <i class="fa fa-file-alt"></i>
            <span>Current file:</span>
            <a href="<?php echo base_url('assets/war_attachment/' . $warning->attachment); ?>" target="_blank">
                <?php echo $warning->attachment; ?>
            </a>
        </div>
    <?php endif; ?>
</div>



            <input type="hidden" name="id" value="<?php echo isset($warning->id) ? $warning->id : ''; ?>">

            <div class="form-group row">
                <div class="col-md-9 offset-md-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="<?php echo base_url('Warning'); ?>" class="btn btn-danger">Cancel</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const reasonDropdown = document.getElementById("reason_for_warning");
        const subReasonDropdown = document.getElementById("sub_reasons");

        const subReasons = {
            "Performance": [
                "Failure to meet individual KPI's",
                "Failure to meet team KPI's"
            ],
            "Disciplinary": [
                "Verbal Harassment",
                "Physical Harassment",
                "Sleep during work hours",
                "Consuming food at workstation"
            ],
            "SOP Violations / Poor quality of work": [
                "Non-compliance with the established protocol",
                "Breach of confidential information"
            ],
            "Punctuality": [
                "Late Reporting",
                "Early Exits",
                "Break time violation",
                "Unauthorized Absence",
                "Failure to punch attendance"
            ],
            "Termination": [
                "Sexual Harassment",
                "Alcohol / drugs abuse"
            ]
        };

        reasonDropdown.addEventListener("change", function () {
            const selectedReason = this.value;
            subReasonDropdown.innerHTML = '<option value="">-- Select Sub Reason --</option>';

            if (subReasons[selectedReason]) {
                subReasons[selectedReason].forEach(function (reason) {
                    const option = document.createElement("option");
                    option.value = reason;
                    option.text = reason;
                    subReasonDropdown.appendChild(option);
                });
            }
        });

        // Trigger change if editing
        if (reasonDropdown.value) {
            reasonDropdown.dispatchEvent(new Event("change"));
            <?php if (isset($warning)): ?>
                subReasonDropdown.value = "<?php echo $warning->sub_reasons; ?>";
            <?php endif; ?>
        }
    });
</script>


<!-- employee name with code select script -->
<script>
    $(document).ready(function () {
        // enable select2 search
        $('#emid').select2({
            placeholder: "-- Select Employee --",
            allowClear: true
        });

        // auto load employee code & designation
        $('#emid').on('change', function () {
            const empId = $(this).val();
            if (empId) {
                fetch("<?php echo base_url('Warning/get_employee_details/'); ?>" + empId)
                    .then(res => res.json())
                    .then(data => {
                        $('#employee_id').val(data.em_code || "");
                        $('#designation').val(data.designation || "");
                    });
            } else {
                $('#employee_id').val("");
                $('#designation').val("");
            }
        });

        // trigger once if editing existing warning
        if ($('#emid').val()) {
            $('#emid').trigger('change');
        }
    });
</script>


<!-- Typing script -->

<script>
    $(document).ready(function () {
        // enable select2 search
        $('#emid').select2({
            placeholder: "-- Select Employee --",
            allowClear: true
        });

        // auto load employee code when selecting employee
        $('#emid').on('change', function () {
            const empId = $(this).val();
            if (empId) {
                fetch("<?php echo base_url('Warning/get_employee_code/'); ?>" + empId)
                    .then(res => res.json())
                    .then(data => {
                        $('#employee_id').val(data.em_code || "");
                    });
            } else {
                $('#employee_id').val("");
            }
        });

        // trigger once if editing
        if ($('#emid').val()) {
            $('#emid').trigger('change');
        }
    });
</script>


<!-- text Area  -->

<script>
    $(document).ready(function () {
        $('#brief_explanation').summernote({
            placeholder: 'Enter detailed explanation...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                //['insert', ['picture', 'link', 'video']],
                // ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        $('#supervisors_comments').summernote({
            placeholder: 'Enter detailed explanation...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['insert', ['picture', 'link', 'video']],
                // ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>

<style>
/* ---------------------- PAGE WRAPPER ---------------------- */
.page-wrapper {
    background: #eef2f7; /* soft background for contrast */
    min-height: 100vh;
    padding: 25px 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ---------------------- PAGE TITLES ---------------------- */
.page-titles h3 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2c3e50; /* darker text for readability */
    display: flex;
    align-items: center;
    gap: 10px;
}

.page-titles h3 i {
    color: #e67e22; /* fresh teal accent */
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-item a {
    color: #3498db; /* soft blue for links */
    font-weight: 500;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #7f8c8d; /* gray for current page */
    font-weight: 600;
}

/* ---------------------- CARD ---------------------- */
.card.card-outline-info {
    border-radius: 16px;
    border: none;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    background: #ffffff; /* pure white card */
}

/* .card.card-outline-info .card-header {
    background: linear-gradient(135deg, #1abc9c, #16a085);
    color: #ffffff;
    font-weight: 600;
    font-size: 1.25rem;
    border-bottom: none;
    border-radius: 16px 16px 0 0;
} */

/* ---------------------- FORM CONTROLS ---------------------- */
.form-control,
.select2-container--default .select2-selection--single,
textarea.form-control {
    width: 100%;
    height: 44px;
    padding: 10px 14px;
    font-size: 14px;
    border-radius: 10px !important; 
    border: 1px solid #ced4da; /* soft gray border */
    background: #fdfdfd; /* slightly off-white for input */
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: all 0.25s ease;
    box-sizing: border-box;
}

.form-control:focus,
.select2-container--default.select2-container--open .select2-selection--single,
textarea.form-control:focus {
    border-color: #1abc9c;
    box-shadow: 0 4px 12px rgba(26, 188, 156, 0.25);
    outline: none;
}

/* ---------------------- SELECT2 ---------------------- */
.select2-container--default .select2-selection--single {
    width: 100%;
    height: 44px;
    border-radius: 10px;
    padding: 4px 12px;
    display: flex;
    align-items: center;
    border: 1px solid #ced4da;
    background: #fdfdfd;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
}

/* ---------------------- TEXTAREAS ---------------------- */
textarea.form-control {
    min-height: 160px;
    resize: vertical;
    background: #fefefe;
}

/* ---------------------- FILE INPUT ---------------------- */
.material-file-input {
    position: relative;
    width: 100%;
    height: 50px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #ced4da;
    background-color: #f8f9fa;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.material-file-input input[type="file"] {
    width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    cursor: pointer;
}

.material-file-input label {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    cursor: pointer;
    color: #495057;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
}

.material-file-input label i {
    margin-right: 10px;
    font-size: 18px;
}

.material-file-input:hover {
    border-color: #1abc9c;
    box-shadow: 0 4px 12px rgba(26, 188, 156, 0.15);
}

.material-file-input label:hover {
    color: #16a085;
}

/* Current file display */
.current-file {
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #495057;
}

.current-file i {
    color: #7f8c8d;
    font-size: 16px;
}

.current-file a {
    color: #1abc9c;
    text-decoration: underline;
    transition: all 0.2s ease;
}

.current-file a:hover {
    color: #16a085;
    text-decoration: none;
}

/* ---------------------- BUTTONS ---------------------- */
.btn {
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.25s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.btn-success {
    background: #1abc9c;
    border: 1px solid #16a085;
    color: #fff;
}

.btn-success:hover {
    background: #16a085;
    border-color: #149174;
    box-shadow: 0 4px 12px rgba(26, 188, 156, 0.25);
}

.btn-danger {
    background: #e74c3c;
    border: 1px solid #c0392b;
    color: #fff;
}

.btn-danger:hover {
    background: #c0392b;
    border-color: #a93226;
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25);
}

/* ---------------------- RESPONSIVE ---------------------- */
@media (max-width: 768px) {
    .form-group.col-md-4,
    .form-group.col-md-6 {
        padding-left: 5px;
        padding-right: 5px;
    }
    .select2-container--default .select2-selection--single {
        height: 40px;
    }
}


</style>




<?php $this->load->view('backend/footer'); ?>