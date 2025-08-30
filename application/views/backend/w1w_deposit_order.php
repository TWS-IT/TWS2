<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>



<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h5 class="text-themecolor"><i class="fa fa-archive" aria-hidden="true"></i> W1W Order Report</h>
    </div>

    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item active">W1W Order</li>
      </ol>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row m-b-10">
      <div class="col-12">
        <?php if ($this->session->userdata('user_type') != 'EMPLOYEE') { ?>
          <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#orderModal"
            onclick="resetOrderForm()">
            <i class="fa fa-plus"></i> Add Order
          </button>
        <?php } ?>

      </div>
    </div>



    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="orderModalLabel">
              <i class="fa fa-braille"></i> <span id="modalTitle">Add Order</span>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form method="post" action="<?= base_url('W1W_Deposite_Order/Save_W1W_D') ?>" id="orderForm">
            <div class="modal-body">
              <input type="hidden" name="order_id" id="order_id">


              <div class="row">
                <div class="col-md-6">

                  <div class="form-group">
                    <label>Employee Position</label>
                    <input type="text" name="pc_position" id="pc_position" class="form-control" placeholder="AAA203C"
                      required>
                  </div>

                  <div class="form-group">
                    <label>Employee Name</label>
                    <select id="employee_id" name="employee_id" class="form-control" required>
                      <option value="">Select Here</option>
                      <?php foreach ($employee as $value): ?>
                        <option value="<?= $value->em_code ?>">
                          <?= htmlspecialchars($value->first_name . ' ' . $value->last_name) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Order Date</label>
                    <input type="date" name="order_date" id="order_date" class="form-control" required>
                  </div>

                  <div class="form-group">
                    <label>Shift</label>
                    <select class="form-control" name="shift" id="shift" required>
                      <option value="">Select Shift</option>
                      <option value="Morning">Morning</option>
                      <option value="Noon">Noon</option>
                      <option value="Night">Night</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Order Count</label>
                    <input type="text" name="order_count" id="order_count" class="form-control"
                      placeholder="Enter the Order Count" required>
                  </div>

                </div>
              </div>
            </div>

            <div class="modal-footer">

              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Save</button>

              <div id="feedbackMessage" class="alert alert-success"
                style="display:none; position: fixed; top: 20px; right: 20px; z-index: 1050;"></div>



            </div>
          </form>
        </div>
      </div>
    </div>



    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Filter</h4>
            <div class="d-flex justify-content-center">
              <div class="form-material row w-auto">
                <div class="form-group col-auto">
                  <input type="text" name="date_from" id="date_from" class="form-control mydatetimepickerFull"
                    placeholder="From">
                </div>
                <div class="form-group col-auto">
                  <input type="text" name="date_to" id="date_to" class="form-control mydatetimepickerFull"
                    placeholder="To">
                </div>
                <div class="form-group col-auto">
                  <select name="shiftid" id="shiftid" class="form-control">
                    <option value="" style="color: #03A9F4 ;">Select shift</option>
                    <option value="all">All</option>
                    <option value="morning">Morning</option>
                    <option value="noon">Noon</option>
                    <option value="night">Night</option>
                  </select>

                </div>
                <div class="form-group col-auto">
                  <button id="filterChart()" class="btn btn-success" onclick="filterChart()">Apply Filter</button>
                  <button id="filterChart" class="btn btn-danger" onclick="resetAndReload()">Reset Filter</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>









    <div class="container-fluid">

      <div class="grid-container" style="margin-top: 20px;">
        <div class="card" style="--grad: #FFC107, #FF9800;">
          <center>
            <div class="title">
              <i class="fas fa-users" style="color: #FF9800;"></i> W1W Project Employees
            </div>
          </center>
          <br>
          <br>
          <div class="content">
            <center>
              <h2>
                <?php
                $this->db->where('status', 'ACTIVE');
                $this->db->where('project', 'W1W Deposit');
                $this->db->from("employee");
                echo $this->db->count_all_results();
                ?>
              </h2>
            </center>
          </div>
        </div>

        <!-- ORDERS -->
        <div class="card" style="--grad: #2196F3, #03A9F4;">
          <center>
            <div class="title"> <i class="fa fa-list-alt" style="color: #03A9F4;"></i> Total Orders</div>
          </center>
          <br>
          <br>
          <div class="content">
            <center>
              <h2>
                <?= isset($sum_order_count) ? $sum_order_count : 0 ?>
              </h2>
            </center>
          </div>
        </div>

        <!-- MISTAKES -->
        <div class="card" style="--grad: #F44336, #E91E63;">
          <center>
            <div class="title"> <i class="fa fa-exclamation-triangle" style="color: #E91E63;"></i> Mistakes</div>
          </center>
          <br>
          <br>
          <div class="content">
            <center>
              <h2>
                <?php
                $this->db->from("ir");
                echo $this->db->count_all_results();
                ?>
              </h2>
            </center>
          </div>
        </div>
      </div>


      <style>
        .grid-container {
          width: min(90%, 1200px);
          margin-inline: auto;
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
          gap: 2rem;
          margin-top: 2rem;
        }

        /* @keyframes shake {
    0% { transform: translate(0px, 0px); }
    20% { transform: translate(-2px, 0px); }
    40% { transform: translate(2px, 0px); }
    60% { transform: translate(-2px, 0px); }
    80% { transform: translate(2px, 0px); }
    100% { transform: translate(0px, 0px); }
}

.card:hover {
    animation: shake 0.5s ease-in-out;
} */
        .card {
          --grad: red, blue;
          padding: 1rem;

          background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
          border-radius: 1rem;

          display: grid;
          grid-template-areas:
            "title icon"
            "content content"
            "bar bar";
          grid-template-columns: 1fr auto;
          gap: 0.5rem;

          color: #444;
          box-shadow: inset -2px 2px hsl(0 0 100% / 1), -20px 20px 40px hsl(0 0 0 / .25);
          font-size: 0.9rem;

        }

        .card .title {
          grid-area: title;
          font-size: 1.4rem;
          font-weight: 600;
          text-transform: uppercase;


        }

        .card .icon {
          grid-area: icon;
          font-size: 2.5rem;
          color: transparent;
          background: linear-gradient(to right, var(--grad));
          background-clip: text;
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }

        .card .content {
          grid-area: content;
        }

        .card::after {
          content: "";
          grid-area: bar;
          height: 2px;
          background-image: linear-gradient(90deg, var(--grad));
        }

        .custom-dropdown {
          background: #f8f9fa;
          border: 1px solid #ccc;
          border-radius: 8px;
          padding: 6px 10px;
          font-size: 14px;
          color: #333;
          appearance: none;

          -webkit-appearance: none;
          -moz-appearance: none;
          background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23666' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
          background-repeat: no-repeat;
          background-position: right 0.5rem center;
          background-size: 10px 10px;
          transition: border-color 0.3s ease;
        }

        .custom-dropdown:focus {
          outline: none;
          border-color: #007bff;
          box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
        }

        .custom-dropdown:hover {
          border-color: #007bff;
          cursor: pointer;
        }
      </style>


      <script>



        $(document).ready(function () {
          function loadMistakeCount(position = '') {
            $.ajax({
              url: "<?php echo base_url('Dashboard/mistake_count'); ?>",
              type: "POST",
              data: { position: position },
              success: function (response) {
                $('.card .title:contains("Mistakes")').siblings('.content').find('h2').text(response);
              },
              error: function (xhr) {
                console.log("Error:", xhr.responseText);
              }
            });
          }


          loadMistakeCount();


          $('#positionFilter').on('change', function () {
            const selectedPosition = $(this).val();
            loadMistakeCount(selectedPosition);
          });
        });
      </script>










      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard</title>


        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">


        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        <style>
          body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f5fc;
            color: #333;
          }

          .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
          }

          .card h6 {
            font-size: 14px;
            font-weight: 600;
            color: #555;
          }

          .highlight {
            font-size: 24px;
            font-weight: 600;
            color: #ef6789ff;
            background-color: transparent;

            padding: 8px 12px;
            border-radius: 8px;

            display: inline-block;

          }


          .chart-box {
            height: 160px;
          }

          .section-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 10px;
          }

          .profile {
            text-align: right;
          }

          .profile span {
            display: block;
            font-size: 14px;
            color: #888;
          }
        </style>
      </head>

      <body>


        <div class="row">

          <div class="col-md-6">
            <div class="card p-3 text-center">
              <h6 class="section-title" id="reportLabel">Total Orders</h6>
              <span id="totalOrderCount"><?= isset($sum_order_count) ? $sum_order_count : 0 ?></span> Total Orders
              <div id="lineChart" style="height: 300px;"></div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card p-3 text-center shadow-sm rounded">
              <h6 class="section-title">Mistakes Rate</h6>
              <div class="highlight" id="mistakesRate">0%</div>
              <p class="text-muted small">Total mistakes of the employees</p>

              <!-- Area Chart -->
              <div id="areaChart" style="height: 200px;"></div>


            </div>
          </div>
        </div>




        <div class="row">
          <div class="col-12">
            <div class="card p-3">
              <h6 class="section-title">Employee List</h6>

              <table id="ordersTable" class="display nowrap" style="width:100%; border: 1px solid #ccc;">

                <thead>
                  <tr>

                    <th>Employee Name</th>
                    <th>Order Date</th>
                    <th>Shift</th>
                    <th>Order Count</th>
                    <th>PC Position</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($w1w_deposit_order as $order): ?>
                    <tr>

                      <td><?= htmlspecialchars($order->first_name . ' ' . $order->last_name) ?></td>
                      <td><?= $order->order_date ?></td>
                      <td><?= $order->shift ?></td>
                      <td><?= $order->order_count ?></td>
                      <td><?= $order->pc_position ?></td>
                      <td>
                        <button class="btn btn-outline-success btn-sm me-1"
                          onclick='editOrder(<?= json_encode($order) ?>)'>
                          <i class="bi bi-pencil-square"></i> </button>


                        <a href="<?= base_url("W1W_Deposite_Order/Delete_W1W_D/{$order->order_id}") ?>"
                          onclick="return confirm('Are you sure you want to delete this order?')"
                          class="btn btn-outline-danger btn-sm"> <i class="bi bi-trash"></i> </a>

                      </td>
                    </tr>
                  <?php endforeach; ?>

                </tbody>
              </table>

            </div>
          </div>
        </div>
    </div>




    <script>
      $(document).ready(function () {
        $('#ordersTable').DataTable({
          dom: 'Bfrtip',
          buttons: ['copy', 'csv', 'excel', 'print'],
          responsive: true,
          pageLength: 10,
          order: [[0, 'desc']]
        });
      });
    </script>



    <style>
      table.dataTable {
        border-collapse: collapse !important;
      }

      table.dataTable th,
      table.dataTable td {
        border: 1px solid #ccc !important;
        padding: 8px;
      }

      .highlight {
        font-size: 1.5rem;
        font-weight: bold;
      }

      .section-title {
        font-size: 1rem;
        font-weight: 500;
      }

      .chart-box {
        margin-top: 10px;
      }
    </style>





    <script>
      let chart;

      function getChartOptions(data) {
        return {
          chart: {
            type: 'line',
            height: 350,
            zoom: {
              enabled: true,
              type: 'x',
              autoScaleYaxis: true
            },
            toolbar: {
              tools: {
                zoom: true,
                zoomin: true,
                zoomout: true,
                pan: true,
                reset: true
              }
            },
            events: {
              zoomed: function (chartContext, { xaxis }) {
                const oneDay = 24 * 60 * 60 * 1000;
                const zoomRange = xaxis.max - xaxis.min;
                if (zoomRange < oneDay) {
                  chartContext.updateOptions({
                    xaxis: {
                      min: xaxis.min,
                      max: xaxis.min + oneDay
                    }
                  }, false, false);
                }
              }
            }
          },
          colors: ['#7267EF', '#c7d9ff'],
          stroke: {
            width: [0, 3],
            curve: 'smooth'
          },
          plotOptions: {
            bar: {
              columnWidth: '60%'
            }
          },
          xaxis: {
            type: 'datetime',
            title: { text: 'Date' },
            labels: { datetimeUTC: false },
            tooltip: { format: 'dd MMM yyyy' }
          },
          yaxis: {
            title: { text: 'Order Count' }
          },
          series: [
            {
              name: 'Total Orders',
              type: 'column',
              data: data.total_orders
            },
            {
              name: 'Average Orders',
              type: 'line',
              data: data.avg_orders
            }
          ],
          tooltip: {
            shared: true,
            intersect: false,
            x: { format: 'dd MMM yyyy' }
          }
        };
      }
    </script>




    <script>
      function fetchChartData() {
        let url = `<?= base_url('W1W_Deposite_Order/get_all_orders_barline_chart') ?>?shiftid=ALL`;

        fetch(url)
          .then(res => res.json())
          .then(data => {
            data.total_orders.sort((a, b) => new Date(a.x) - new Date(b.x));
            data.avg_orders.sort((a, b) => new Date(a.x) - new Date(b.x));
            chart = new ApexCharts(document.querySelector("#lineChart"), getChartOptions(data));
            chart.render();
          })
          .catch(() => alert("Failed to load chart data."));
      }

      document.addEventListener("DOMContentLoaded", fetchChartData);

    </script>

    <script>

      function filterChart() {
        let startDate = document.getElementById('date_from').value;
        let endDate = document.getElementById('date_to').value;
        let shiftid = document.getElementById('shiftid').value;

        if (!startDate || !endDate) {
          alert("Please select both start and end dates.");
          return;
        }

        let params = new URLSearchParams({
          date_from: startDate,
          date_to: endDate,
          shiftid: shiftid
        });


        let url = `<?= base_url('W1W_Deposite_Order/get_all_orders_barline_chart') ?>?${params.toString()}`;
        console.log(url)

        fetch(url)
          .then(response => response.json())
          .then(data => {
            if (!data.total_orders || !data.avg_orders) {
              alert("No valid chart data received.");
              return;
            }

            data.total_orders.sort((a, b) => new Date(a.x) - new Date(b.x));
            data.avg_orders.sort((a, b) => new Date(a.x) - new Date(b.x));

            if (chart) {
              chart.updateOptions(getChartOptions(data));
            } else {
              chart = new ApexCharts(document.querySelector("#lineChart"), getChartOptions(data));
              chart.render();
            }
          })
          .catch(error => {
            console.error("Error fetching chart data:", error);
            alert("Something went wrong while fetching chart data.");
          });


        let totalUrl = `<?= base_url('W1W_Deposite_Order/get_filtered_order_sum') ?>?${params.toString()}`;

        fetch(totalUrl)
          .then(res => res.json())
          .then(data => {
            document.getElementById("totalOrderCount").textContent = data.total ?? 0;
          })
          .catch(error => {
            console.error("Error fetching total orders:", error);
            alert("Failed to update total order count.");
          });

        // === Update report label ===
        const reportLabel = document.getElementById('reportLabel');
        if (reportLabel) {
          const start = new Date(startDate);
          const end = new Date(endDate);
          const diffTime = Math.abs(end - start);
          const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

          reportLabel.textContent = `Order Duration for W1W Deposit Project ${startDate} to ${endDate} (${diffDays} day${diffDays > 1 ? 's' : ''})`;
        }
      }



    </script>
    <script>
      function resetAndReload() {
        // Reset date inputs
        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';

        // Destroy chart if exists
        if (chart) {
          chart.destroy();
        }

        // Re-fetch and render full chart data
        fetchChartData();

        // === Reset Total Order Count ===
        fetch(`<?= base_url('W1W_Deposit_model/get_filtered_order_sum') ?>`)
          .then(res => res.json())
          .then(data => {
            document.getElementById("totalOrderCount").textContent = data.total ?? 0;
          })
          .catch(error => {
            console.error("Error resetting total orders:", error);
            alert("Failed to reset total order count.");
          });

        // === Reset Label ===
        const reportLabel = document.getElementById('reportLabel');
        if (reportLabel) {
          reportLabel.textContent = "Total Orders";
        }
      }
    </script>




    <script>
      function resetAndReload() {

        document.getElementById('date_from').value = '';
        document.getElementById('date_to').value = '';


        if (chart) {
          chart.destroy();
        }

        fetchChartData();

        fetch(`<?= base_url('W1W_Order/get_filtered_order_sum') ?>`)
          .then(res => res.json())
          .then(data => {
            document.getElementById("totalOrderCount").textContent = data.total ?? 0;
          })
          .catch(error => {
            console.error("Error resetting total orders:", error);
            alert("Failed to reset total order count.");
          });


        const reportLabel = document.getElementById('reportLabel');
        if (reportLabel) {
          reportLabel.textContent = "Total Orders";
        }
      }
    </script>



    <script>
      $('#orderForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const actionUrl = form.attr('action');

        $.ajax({
          url: actionUrl,
          method: 'POST',
          data: form.serialize(),
          success: function (response) {
            const res = typeof response === "string" ? JSON.parse(response) : response;

            if (res.status === 'success') {
              $('#feedbackMessage').text(res.message).fadeIn();
              setTimeout(() => $('#feedbackMessage').fadeOut(), 3000);

              if (actionUrl.includes('Save_W1W')) {

                $('#orderForm')[0].reset();
              } else if (actionUrl.includes('Update_W1W')) {

                $('#orderForm')[0].reset();
                $('#orderModal').modal('hide');
              }


              fetchOrdersTable();
            } else {
              alert(res.message);
            }
          },
          error: function () {
            alert("Something went wrong. Please try again.");
          }
        });
      });

    </script>


    <script>
      $('#orderModal').on('hidden.bs.modal', function () {
        location.reload();
      });
    </script>




    <script>
      const project = 'W1W Deposit';
      fetch(`<?= base_url('Atas_Order/showMistakeChart') ?>/${encodeURIComponent(project)}`)

        .then(res => res.json())
        .then(data => {
          if (!data || !data.length) return;

          // Total mistakes
          document.getElementById('mistakesRate').innerText = data.length + ' mistakes';

          // Prepare daily series (date: count)
          const dailyCounts = {};
          data.forEach(d => {
            const date = new Date(d.date);
            const key = date.getFullYear() + '-' +
              (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
              date.getDate().toString().padStart(2, '0');
            dailyCounts[key] = (dailyCounts[key] || 0) + 1;
          });

          // Convert to ApexCharts series
          const seriesData = Object.keys(dailyCounts)
            .sort((a, b) => new Date(a) - new Date(b))
            .map(date => [new Date(date).getTime(), dailyCounts[date]]);

          // ApexCharts options
          const options = {
            chart: {
              type: 'area',
              height: 300,
              zoom: { enabled: true },
              toolbar: { autoSelected: 'zoom' }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            series: [{ name: 'Mistakes', data: seriesData }],
            xaxis: { type: 'datetime', title: { text: 'Date' } },
            yaxis: { title: { text: 'Mistakes' } },
            tooltip: { x: { format: 'dd MMM yyyy' } },
            fill: { type: 'gradient', gradient: { shadeIntensity: 0.5, opacityFrom: 0.6, opacityTo: 0 } },
            colors: ['#FF0000']
          };

          new ApexCharts(document.querySelector("#areaChart"), options).render();
        })
        .catch(err => console.error("Error fetching mistakes data:", err));
    </script>



    <style>
      table.dataTable {
        border-collapse: collapse !important;
      }

      table.dataTable th,
      table.dataTable td {
        border: 1px solid #ccc !important;
        padding: 8px;
      }

      .highlight {
        font-size: 1.5rem;
        font-weight: bold;
      }

      .section-title {
        font-size: 1rem;
        font-weight: 500;
      }

      .chart-box {
        margin-top: 10px;
      }
    </style>





    </body>

    </html>






    <?php $this->load->view('backend/footer'); ?>