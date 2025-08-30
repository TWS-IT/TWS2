<?php $this->load->view('backend/header'); ?>

<?php $this->load->view('backend/sidebar'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Log Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      background: #f9f9f9;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
      font-size: 14px;
    }
    th {
      background: #f0f0f0;
    }
    tr:nth-child(even) {
      background: #fafafa;
    }
  </style>
</head>
<body>

 
  <h2>Login Log Report</h2>
  <div class="table-responsive" style="height:400px; overflow-y:auto; overflow-x:auto;">
<table class="table table-bordered table-hover earning-box" style="width: 100%;">
    <tr>
        <th>#</th>
        <th>Email</th>
        <th>Status</th>
        <th>IP Address</th>
        <th>User Agent</th>
        <th>Login Time</th>
    </tr>
    <?php foreach($logs as $i => $log): ?>
    <tr>
        <td><?= $i+1 ?></td>
        <td><?= $log->em_email ?></td>
        <td><?= $log->login_status ?></td>
        <td><?= $log->ip_address ?></td>
        <td><?= $log->user_agent ?></td>
        <td><?= $log->login_time ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<div>


</body>
</html>
