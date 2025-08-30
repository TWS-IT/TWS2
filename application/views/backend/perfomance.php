<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="mdi mdi-speedometer"></i> Employee Performance</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Employee Perfomance</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div style="overflow-x:auto;">
                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Employee image</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Project</th>
                                <th>Total Orders</th>
                              
                                <th class="text-center">More Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($performance_data)) {
                                foreach ($performance_data as $row): ?>
                                    <tr>
                                        <td class="text-center">
                                            <img src="<?= $row['em_image']; ?>" alt="<?= $row['full_name']; ?>" width="80"
                                                height="80" style="border-radius: 50%; object-fit: cover;"
                                                onerror="this.onerror=null;this.src='<?= base_url('assets/images/users/user.png'); ?>';">
                                        </td>
                                        <td><?= $row['em_code'] ?></td>
                                        <td><?= $row['full_name'] ?></td>
                                        <td><?= $row['project'] ?></td>
                                        <td><?= $this->Perfomance_model->get_total_orders($row['em_code']); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('Emp_Perfomance/emp_perfomance/' . $row['em_code']); ?>"
                                                class="btn btn-outline-info btn-sm" title="View Performance">
                                                <i class="mdi mdi-chart-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach;
                            } else {
                                echo '<tr><td colspan="6">No data available.</td></tr>';
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php $this->load->view('backend/footer'); ?>

    <script>
        if ($.fn.DataTable.isDataTable('#employees123')) {
            $('#employees123').DataTable().clear().destroy();
        }

        $('#employees123').DataTable({
            paging: false,         
            lengthChange: false,   
            info: false,         
            aaSorting: [[1, 'asc']],
            dom: 'Bfrtip',
          
        });


        $(document).on('click', '.more-details-btn', function () {
            var em_code = $(this).data('emcode');  // get employee code from button data attribute

            $.ajax({
                url: '<?= base_url("Emp_Perfomance/get_emp_details/") ?>' + em_code,
                method: 'GET',
                success: function (html) {
                    // Assuming you have a modal or div to show details
                    $('#detailsModal .modal-body').html(html);
                    $('#detailsModal').modal('show');
                },
                error: function () {
                    alert('Failed to load employee details.');
                }
            });
        });


    </script>
    <?php $this->load->view('backend/footer'); ?>