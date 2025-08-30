<!DOCTYPE html>
<html>
<head>
    <title>Login Logs</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .card-body {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            border-radius: 12px;
            max-width: 100%;
            margin: auto;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table.dataTable {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        table.dataTable thead th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        table.dataTable tbody td {
            text-align: center;
            vertical-align: middle;
        }

        table.dataTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        th, td {
            padding: 10px 12px;
            border: 1px solid #ccc;
            white-space: nowrap;
        }

        .dataTables_wrapper .dt-buttons {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h1>Login Logs</h1>

    <div class="card-body">
        <div class="table-responsive">
            <table id="logtable" class="display nowrap table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Role</th>
                        <th>Action</th>
                        <th>Details</th>
                        <!-- <th>IP Address</th>
                        <th>Browser Info</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($logs)) {
                        foreach ($logs as $log) { ?>
                            <tr>
                                <td><?= htmlspecialchars($log->emp_id) ?></td>
                                <td><?= htmlspecialchars($log->emp_name) ?></td>
                                <td><?= htmlspecialchars($log->created_at) ?></td>
                                <td><?= htmlspecialchars($log->role) ?></td>
                                <td><?= htmlspecialchars($log->action) ?></td>
                                <td><?= htmlspecialchars($log->details) ?></td>
                                <!-- <td><?= htmlspecialchars($log->ip_address) ?></td>
                                <td><?= htmlspecialchars($log->browser_info) ?></td>       -->
                            </tr>
                    <?php }
                    } else { ?>
                        <tr><td colspan="8">No logs found</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            $('#logtable').DataTable({
                paging: false,
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                aaSorting: [[2, 'desc']],
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        });
    </script>

</body>
<?php $this->load->view('backend/footer'); ?>
</html>
