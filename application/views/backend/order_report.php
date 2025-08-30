<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>


<div class="page-wrapper">

  <div class="profile-tab sticky-top" role="tablist" style="z-index: 1020;">
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h5 class="text-themecolor"><i class="mdi mdi-chart-line"></i> Order Report</h5>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
          <li class="breadcrumb-item active">Order Report</li>
        </ol>
      </div>
    </div>

    <div class="d-flex justify-content-center">
      <ul class="nav nav-tabs profile-tab" role="tablist" id="projectTabs">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#all" role="tab" onclick="selectProject('ALL')">All
            Projects</a>
        </li>

        <?php foreach ($projects as $project): ?>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#project<?= $project->id ?>" role="tab"
              onclick="selectProject(<?= (int) $project->id ?>)">
              <?= htmlspecialchars($project->pro_name) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    </div>

    <div class="d-flex justify-content-center">
      <div class="row align-items-end mb-4 g-3 filter-bar p-2 rounded shadow-sm">
        <!-- Add Order Button -->
        <div class="col-md-auto">
          <button type="button" class="btn btn-info-custom d-flex align-items-center" data-toggle="modal"
            data-target="#orderModal">
            <i class="fa fa-plus me-2"></i> Add Order
          </button>
        </div>

        <!-- Date From -->
        <div class="col-md-auto">
          <input type="text" id="date_from" class="form-control" placeholder="From Date" onfocus="this.type='date'"
            onblur="if(!this.value)this.type='text'">
        </div>

        <!-- Date To -->
        <div class="col-md-auto">
          <input type="text" id="date_to" class="form-control" placeholder="To Date" onfocus="this.type='date'"
            onblur="if(!this.value)this.type='text'">
        </div>


        <!-- Shift Filter -->
        <div class="col-md-auto">
          <select id="shift_filter" class="form-select">
            <option value="" disabled selected hidden>Select Shift</option>
            <!-- <option value="ALL">All Shifts</option> -->
            <option value="Morning">Morning</option>
            <option value="Noon">Noon</option>
            <option value="Night">Night</option>
          </select>
        </div>


        <!-- Buttons -->
        <div class="col-md-auto d-flex gap-2">
          <button class="btn btn-info-custom" id="filterDateBtn">
            <i class="fa fa-filter me-1"></i> Filter
          </button>
        </div>

        <div class="col-md-auto d-flex gap-2">
          <button class="btn btn-danger-custom" id="resetDateBtn">
            <i class="fa fa-undo me-1"></i> Reset
          </button>
        </div>
      </div>
    </div>

  <div class="container-fluid">
    <div class="grid-container" style="margin-top: 20px;">


      <div class="card" style="--grad: #FFC107, #FF9800;">
        <center>
          <div class="title">
            <i class="fas fa-users" style="color: #FF9800;"></i>
            <span id="employeesTitle">All Projects Employees</span>
          </div>
        </center>
        <br><br>
        <div class="content">
          <center>
            <h2 id="employeesCount">0</h2>
          </center>
        </div>
      </div>


      <div class="card" style="--grad: #2196F3, #03A9F4;">
        <center>
          <div class="title">
            <i class="fa fa-list-alt" style="color: #03A9F4;"></i> Total Orders
          </div>
        </center>
        <br><br>
        <div class="content">
          <center>
            <h2 id="ordersTotal">0</h2>
          </center>
        </div>
      </div>


      <div class="card" style="--grad: #F44336, #E91E63;">
        <center>
          <div class="title">
            <i class="fa fa-exclamation-triangle" style="color: #E91E63;"></i> Mistakes
          </div>
        </center>
        <br><br>
        <div class="content">
          <center>
            <h2 id="mistakesCount">0</h2>
          </center>
        </div>
      </div>

    </div>
  </div>


  <div class="row">


    <div class="col-md-6">
      <div class="card p-3 text-center">
        <h6 class="section-title" id="reportLabel">Total Orders</h6>
        <span id="totalOrderCount"><?= isset($sum_order_count) ? $sum_order_count : 0 ?></span>
        <div id="lineChart" style="height: 300px;"></div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3 text-center">
        <h6 class="section-title">Mistakes Rate</h6>
        <div class="highlight" id="mistakesRate">0%</div>
        <div id="mistakeChart" style="height: 300px;"></div>
      </div>
    </div>

  </div>


  <!-- Orders table -->
  <div class="col-md-12">
    <div class="card p-3 text-center">
      <div id="orderTable" class="mt-3"></div>
    </div>
  </div>
</div>




<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="orderModalLabel"><i class="mdi mdi-chart-line"></i> Add Order</h4>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <form method="post" action="<?= base_url('Order_report/save_order') ?>" id="orderForm">
        <input type="hidden" name="order_id" id="modal_order_id">
        <input type="hidden" name="project_id" id="modal_project_id">

        <div class="modal-body">
          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Name</label>
              <select id="employee_code" name="employee_code" class="w-100" required>
                <option></option>
                <?php foreach ($employee as $e): ?>
                  <option value="<?= htmlspecialchars($e->em_code) ?>" data-code="<?= htmlspecialchars($e->em_code) ?>"
                    data-search="<?= htmlspecialchars($e->first_name . ' ' . $e->last_name . ' ' . $e->em_code) ?>">
                    <?= htmlspecialchars($e->first_name . ' ' . $e->last_name) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>


            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Code</label>
              <input type="text" id="employee_code_display" class="form-control bg-light" placeholder="Select Employee"
                readonly>
            </div>

            <div class="col-md-6" id="projectSelectWrapper" style="display:none;">
              <label class="form-label fw-bold">Project</label>
              <select class="form-control" id="modal_project_select">
                <option value="">Select Project</option>
                <?php foreach ($projects as $p): ?>
                  <option value="<?= (int) $p->id ?>"><?= htmlspecialchars($p->pro_name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Employee Position</label>
              <input type="text" name="pc_position" id="pc_position" class="form-control" placeholder="AAA203C"
                required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Order Date</label>
              <input type="date" name="order_date" id="order_date" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Shift</label>
              <select class="form-control" name="shift" id="shift" required>
                <option value="">Select Shift</option>
                <option value="Morning">Morning</option>
                <option value="Noon">Noon</option>
                <option value="Night">Night</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Order Count</label>
              <input type="number" name="order_count" id="order_count" class="form-control" min="0"
                placeholder="Order Count" required>
            </div>

          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>


<script>
  let chart = null;
  let currentProjectId = 'ALL';

  function fetchChartData(projectId = 'ALL') {
    currentProjectId = projectId;

    let startDate = document.getElementById('date_from')?.value || '';
    let endDate = document.getElementById('date_to')?.value || '';
    let shift = document.getElementById('shift_filter')?.value || 'ALL';

    let params = new URLSearchParams({
      project_id: projectId,
      date_from: startDate,
      date_to: endDate,
      shiftid: shift
    });

    fetch(`<?= base_url('order_report/get_all_orders_barline_chart') ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (!data || !data.total_orders) return;

        data.total_orders.sort((a, b) => new Date(a.x) - new Date(b.x));
        data.avg_orders.sort((a, b) => new Date(a.x) - new Date(b.x));

        const options = {
          chart: { height: 370, type: 'line', zoom: { enabled: true, type: 'x', autoScaleYaxis: true }, toolbar: { show: true } },
          stroke: { width: [0, 3], curve: 'smooth' },
          colors: ['#4f46e5', ' #3b82f6'],
          series: [
            { name: 'Total Orders', type: 'column', data: data.total_orders.map(d => [new Date(d.x).getTime(), d.y]) },
            { name: 'Average Orders', type: 'line', data: data.avg_orders.map(d => [new Date(d.x).getTime(), d.y]) }
          ],
          xaxis: { type: 'datetime' },
          tooltip: { shared: true, intersect: false, x: { format: 'yyyy-MM-dd HH:mm' } }
        };

        if (chart) chart.updateOptions(options);
        else { chart = new ApexCharts(document.querySelector("#lineChart"), options); chart.render(); }

        document.getElementById('totalOrderCount').textContent = data.total_orders.reduce((sum, d) => sum + d.y, 0);
      })
      .catch(err => console.error("Error fetching chart data:", err));
  }


  function selectProject(projectId) {
    currentProjectId = projectId;
    updateSummary(projectId);
    loadOrders(projectId);
    fetchChartData(projectId);
    fetchMistakeChart(projectId);
  }

  $('#orderModal').on('show.bs.modal', function () {
    const wrapper = document.getElementById("projectSelectWrapper");
    const hiddenInput = document.getElementById("modal_project_id");
    const dropdown = document.getElementById("modal_project_select");

    if (currentProjectId === 'ALL') {
      wrapper.style.display = "block";
      hiddenInput.value = "";
      dropdown.value = "";
    } else {
      wrapper.style.display = "none";
      hiddenInput.value = currentProjectId;
    }
  });

  const projectDropdown = document.getElementById("modal_project_select");
  if (projectDropdown) {
    projectDropdown.addEventListener("change", function () {
      document.getElementById("modal_project_id").value = this.value;
    });
  }
  document.addEventListener("DOMContentLoaded", function () {
    selectProject('ALL');
  });

  function updateSummary(projectId) {
    fetch(`<?= base_url("Order_report/get_summary_counts") ?>?project_id=${projectId}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('employeesTitle').textContent =
          (projectId === 'ALL') ? 'All Projects Employees' : `${data.label} Employees`;
        document.getElementById('employeesCount').textContent = data.employees_count ?? 0;
        document.getElementById('ordersTotal').textContent = data.orders_total ?? 0;
        document.getElementById('mistakesCount').textContent = data.mistakes_count ?? 0;
      });
  }

  function loadOrders(projectId = 'ALL') {
    const startDate = document.getElementById('date_from').value || '';
    const endDate = document.getElementById('date_to').value || '';
    const shift = document.getElementById('shift_filter').value || 'ALL';

    const params = new URLSearchParams({
      project_id: projectId,
      date_from: startDate,
      date_to: endDate,
      shift: shift
    })

    fetch(`<?= base_url("Order_report/get_orders") ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (!data || !data.orders) {
          document.getElementById('orderTable').innerHTML = "<p>No orders found</p>";
          return;
        }

        let html = `<table id="ordersTable" class="display nowrap table table-bordered table-striped" style="width:100%">
                        <thead>
                          <tr>
                            <th>Project</th>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>Total Orders</th>
                            <th>Position</th>
                            <th style="text-align: center;">Action</th>
                          </tr>
                        </thead>
                        <tbody>`;

        data.orders.forEach(o => {
          html += `<tr>
                        <td>${o.pro_name ?? ''}</td>
                        <td>${o.first_name ?? ''} ${o.last_name ?? ''} (${o.em_code ?? ''})</td>
                        <td>${o.order_date ?? ''}</td>
                        <td>${(o.shift ?? '').charAt(0).toUpperCase() + (o.shift ?? '').slice(1)}</td>
                        <td>${o.order_count ?? 0}</td>
                        <td>${o.pc_position ?? ''}</td>
                        <td  style="text-align: center;">
                            <button class="btn btn-sm btn-success btn-edit-order" data-id="${o.order_id}">
                              <i class="bi bi-pencil"></i>
                            </button>
                            
                            <button class="btn btn-sm btn-danger" onclick="deleteOrder(${o.order_id})">
                              <i class="bi bi-trash"></i>
                            </button>
                        </td>

                  </tr>`;
        });

        html += `</tbody></table>`;
        document.getElementById('orderTable').innerHTML = html;

        $('#ordersTable').DataTable({
          dom: 'Bfrtip',
          buttons: [
            { extend: 'copy', text: 'Copy', className: 'custom-dt-btn' },
            { extend: 'csv', text: 'CSV', className: 'custom-dt-btn' },
            { extend: 'excel', text: 'Excel', className: 'custom-dt-btn' },
            { extend: 'pdf', text: 'PDF', className: 'custom-dt-btn' },
            { extend: 'print', text: 'Print', className: 'custom-dt-btn' }
          ],
          responsive: true,
          pageLength: 10,
          scrollX: true,
          fixedHeader: true,
          destroy: true
        });
      })
      .catch(err => {
        console.error("Error loading orders:", err);
        document.getElementById('orderTable').innerHTML = "<p>Failed to load orders</p>";
      });
  }



  document.addEventListener('DOMContentLoaded', () => {
    selectProject('ALL');
  });
</script>


<script>

  document.getElementById('filterDateBtn').addEventListener('click', function () {
    const startDate = document.getElementById('date_from').value;
    const endDate = document.getElementById('date_to').value;
    const shift = document.getElementById('shift_filter').value;

    if (!startDate && !endDate && (shift === 'ALL' || !shift)) {
      alert('Please select a filter to apply.');
      return;
    }

    if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
      alert('Start date cannot be after end date.');
      return;
    }

    loadOrders(currentProjectId);
    fetchChartData(currentProjectId);
    fetchMistakeChart(currentProjectId);
  });



  document.getElementById('resetDateBtn').addEventListener('click', function () {
    const dateFrom = document.getElementById('date_from');
  const dateTo = document.getElementById('date_to');
  const shiftFilter = document.getElementById('shift_filter');

  // Reset both dates
  dateFrom.value = '';
  dateFrom.type = 'text'; // force back to placeholder mode

  dateTo.value = '';
  dateTo.type = 'text'; // force back to placeholder mode

  // Reset shift filter to placeholder
  shiftFilter.selectedIndex = 0;

    loadOrders(currentProjectId);
    fetchChartData(currentProjectId);
    fetchMistakeChart(currentProjectId);
  });

</script>

<script>
  function initEmployeeSelect() {
    var $el = $('#employee_code');

    if ($el.hasClass('select2-hidden-accessible')) {
      $el.select2('destroy');
    }

    $el.select2({
      dropdownParent: $('#orderModal'),
      placeholder: 'Select Employee',
      allowClear: true,
      width: '100%',
      minimumResultsForSearch: 0,

      matcher: function (params, data) {
        if (!params.term || !params.term.trim()) return data;
        if (typeof data.text === 'undefined') return null;

        var term = params.term.toLowerCase();
        var text = (data.text || '').toLowerCase();
        var code = (data.element && data.element.getAttribute) ? (data.element.getAttribute('data-code') || '').toLowerCase() : '';
        var extra = (data.element && data.element.getAttribute) ? (data.element.getAttribute('data-search') || '').toLowerCase() : '';

        return (text.indexOf(term) > -1 || code.indexOf(term) > -1 || extra.indexOf(term) > -1) ? data : null;
      },

      templateResult: function (data) {
        if (!data.id) return data.text;
        var code = data.element ? data.element.getAttribute('data-code') : '';
        var $row = $('<span></span>').text(data.text);
        if (code) $row.append($('<small class="ml-1"></small>').text(' (' + code + ')'));
        return $row;
      },
      templateSelection: function (data) {
        if (!data.id) return data.text;
        var code = data.element ? data.element.getAttribute('data-code') : '';
        return code ? data.text + ' (' + code + ')' : data.text;
      }
    });

    $el.on('change', function () {
      var code = $(this).find(':selected').data('code') || '';
      $('#employee_code_display').val(code);
    });
  }

  $('#orderModal').on('shown.bs.modal', initEmployeeSelect);

</script>

<script>
  function saveOrderAJAX(form) {
    const formData = new FormData(form);

    if (!formData.get('project_id')) {
      alert('Please select a project.');
      return;
    }

    let url = form.action;
    if (formData.get('order_id')) {
      url = "<?= base_url('Order_report/update_order') ?>";
    }

    fetch(url, {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success || data.status === 'success') {
          alert(data.message || "Order saved successfully!");
          $('#orderModal').modal('hide');
          loadOrders(currentProjectId);
          updateSummary(currentProjectId);
          form.reset();
          $('#employee_code').val(null).trigger('change');
          document.getElementById("orderModalLabel").textContent = "Add Order";
          document.getElementById("modal_order_id").value = "";
        } else {
          alert(data.message || "Failed to save order.");
        }
      })
      .catch(err => {
        console.error("Save failed:", err);
        alert("An error occurred while saving the order.");
      });
  }


</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {

    let today = new Date().toISOString().split('T')[0];
    document.getElementById('order_date').value = today;

    const orderForm = document.getElementById("orderForm");
    if (orderForm) {
      orderForm.addEventListener("submit", function (e) {
        e.preventDefault();
        saveOrderAJAX(this);
      });
    }
  });
</script>


<script>
  let mistakeChart = null;

  function fetchMistakeChart(projectId = 'ALL') {
    let startDate = document.getElementById('date_from')?.value || '';
    let endDate = document.getElementById('date_to')?.value || '';
    let shift = document.getElementById('shift_filter')?.value || 'ALL';

    let params = new URLSearchParams({
      project_id: projectId,
      date_from: startDate,
      date_to: endDate,
      shift: shift
    });

    fetch(`<?= base_url('Order_report/get_mistakes_chart') ?>?${params.toString()}`)
      .then(res => res.json())
      .then(data => {
        if (!data) return;

        data.sort((a, b) => new Date(a.x) - new Date(b.x));

        let totalMistakes = data.reduce((sum, d) => sum + (d.y || 0), 0);
        let totalOrders = parseInt(document.getElementById('totalOrderCount')?.textContent || 0);
        let percentage = (totalOrders > 0) ? ((totalMistakes / totalOrders) * 100).toFixed(2) : 0;

        document.getElementById('mistakesRate').textContent = percentage + "%";

        const options = {
          chart: { height: 310, type: 'area', toolbar: { show: true }, zoom: { enabled: true, type: 'x', autoScaleYaxis: true } },
          dataLabels: { enabled: false },
          stroke: { curve: 'smooth' },
          series: [{ name: 'Mistakes', data: data.map(d => [new Date(d.x).getTime(), d.y]) }],
          xaxis: { type: 'datetime', title: { text: 'Date & Time' } },
          yaxis: { title: { text: 'Mistake Count' } },
          colors: ['#FF4560'],
          tooltip: { x: { format: 'yyyy-MM-dd HH:mm' }, shared: true }
        };

        if (mistakeChart) mistakeChart.updateOptions(options);
        else { mistakeChart = new ApexCharts(document.querySelector("#mistakeChart"), options); mistakeChart.render(); }
      })
      .catch(err => console.error("Error fetching mistake chart data:", err));
  }


</script>

<script>
  function deleteOrder(order_id) {
    if (!order_id) {
      alert("Invalid Order ID");
      return;
    }

    if (!confirm("Are you sure you want to delete this order?")) return;

    fetch("<?= base_url('Order_report/delete_order') ?>", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ order_id: order_id })
    })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.status === "success") {
          loadOrders(currentProjectId);
          updateSummary(currentProjectId);
        }
      })
      .catch(err => console.error("Delete failed:", err));
  }


  $('#orderModal').on('hidden.bs.modal', function () {
    document.getElementById("orderModalLabel").textContent = "Add Order";
    document.getElementById("modal_order_id").value = "";
    document.getElementById("modal_project_id").value = "";
    $('#employee_code').val(null).trigger('change');
    document.getElementById("employee_code_display").value = "";
    document.getElementById("pc_position").value = "";
    document.getElementById("order_date").value = new Date().toISOString().split('T')[0];
    document.getElementById("shift").value = "";
    document.getElementById("order_count").value = "";
  });

</script>

<script>
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-edit-order');
    if (!btn) return;

    const orderId = btn.dataset.id;

    document.getElementById("orderForm").reset();
    $('#employee_code').val('').trigger('change');
    document.getElementById("employee_code_display").value = '';

    document.getElementById("orderModalLabel").textContent = "Edit Order";

    $('#orderModal').modal('show');

    fetch(`<?= base_url('Order_report/get_order') ?>?order_id=${orderId}`)
      .then(res => res.json())
      .then(data => {
        if (!data || !data.order) return alert('Order not found!');
        const order = data.order;

        document.getElementById("modal_order_id").value = order.order_id;

        if (currentProjectId === 'ALL') {
          document.getElementById("projectSelectWrapper").style.display = "block";
          document.getElementById("modal_project_select").value = order.project_id;
          document.getElementById("modal_project_id").value = order.project_id;
        } else {
          document.getElementById("projectSelectWrapper").style.display = "none";
          document.getElementById("modal_project_id").value = currentProjectId;
        }

        document.getElementById("pc_position").value = order.pc_position;
        document.getElementById("order_date").value = order.order_date;
        document.getElementById("shift").value = order.shift;
        document.getElementById("order_count").value = order.order_count;

        $('#employee_code').val(order.employee_code).trigger('change');
        document.getElementById("employee_code_display").value = order.employee_code;
      })
      .catch(err => console.error('Error loading order:', err));
  });

</script>

<style>
  #projectTabs {
    /* position: sticky; */
    top: 0;
    z-index: 1050;
    background: linear-gradient(135deg, #eef5f9, #eef5f9);
    padding: 0.75rem 1rem;
    /* display: inline-flex; */
    justify-content: center;
    gap: 0.5rem;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(8px);
    margin: 0 auto;
    border-radius: 20px;
  }

  #projectTabs .nav-link {
    color: #374151;
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    border-radius: 999px;
    transition: all 0.25s ease;
    background: transparent;
    border: none;
  }

  #projectTabs .nav-link:hover {
    background: rgba(37, 99, 235, 0.08);
    color: #2563eb;
  }

  #projectTabs .nav-link.active {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #eef5f9;
    font-weight: 600;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.4);
  }

  @media (max-width: 768px) {
    #projectTabs {
      overflow-x: auto;
      white-space: nowrap;
      justify-content: flex-start;
      scrollbar-width: none;
    }

    #projectTabs::-webkit-scrollbar {
      display: none;
    }
  }

  .page-wrapper {
    min-height: 100vh;
    padding: 20px 30px;
    background: linear-gradient(135deg, #eef5f9, #eef5f9);
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .card {
    border: none;
    border-radius: 16px;
    background: #eef5f9;
    # box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  }

  .card .card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 1rem;
  }

  .card-body {
    padding: 1.5rem;
    font-size: 0.95rem;
    color: #4b5563;
    line-height: 1.6;
  }

  .card-body.text-center {
    text-align: center;
    justify-content: center;
    align-items: center;
  }

  @media (max-width: 768px) {
    .page-wrapper {
      padding: 15px;
    }

    .card-body {
      padding: 1rem;
    }
  }
</style>

<style>
  .select2-container--default .select2-selection--single {
    height: 34px;
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

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 3px;
    right: 8px;
    border-radius: 0 6px 6px 0;
  }

  .select2-container--default .select2-selection--single:hover {
    background: linear-gradient(to bottom, #ffffff 0%, #dcdcdc 100%);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
    transform: translateY(-1px);
  }

  .select2-container--default.select2-container--open .select2-selection--single {
    border-color: #007bff;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
  }

  .select2-dropdown {
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    font-size: 13px;
  }

  .select2-results__option {
    padding: 5px 10px;
    font-size: 13px;
  }

  .select2-results__option--highlighted {
    background-color: #007bff !important;
    color: #fff !important;
  }

  .form-control,
  .select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #aaa;
    border-radius: 8px !important;
    background: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    font-size: 14px;
    padding: 6px 10px;
    transition: all 0.2s ease;
  }

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

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 6px;
    border-radius: 6px;
  }

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

<style>
  .grid-container {
    width: min(90%, 1200px);
    margin-inline: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }

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
    box-shadow: inset -2px 2px #fff, -20px 20px 40px rgba(0, 0, 0, .25);
    font-size: 0.9rem;
  }

  .card .title {
    grid-area: title;
    font-size: 1.4rem;
    font-weight: 600;
    text-transform: uppercase;
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
</style>

<style>
  #orderTable table {
    border-collapse: collapse;
    width: 100%;
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  }

  #orderTable table thead th {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: white;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 10;
    padding: 12px;
    text-align: left;
  }

  #orderTable table tbody td {
    padding: 10px 12px;
    border-bottom: 1px solid #eee;
  }

  #orderTable table tbody tr:hover {
    background-color: #f0f4ff;
    cursor: pointer;
  }

  .dt-button {
    border-radius: 6px;
    padding: 5px 10px;
    margin-right: 5px;
    background-color: #4f46e5;
    color: white !important;
    font-weight: 500;
  }

  .custom-dt-btn {
    background: linear-gradient(135deg, #4f46e5, #3b82f6) !important;
    color: #fff !important;
    font-weight: 600;
    border: none !important;
    border-radius: 3px !important;
    padding: 6px 14px !important;
    margin-right: 5px !important;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1) !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
  }

  .custom-dt-btn:hover {
    background: linear-gradient(135deg, #3b82f6, #4f46e5) !important;
    color: #fff !important;
    transform: translateY(-2px) !important;
  }
</style>


<style>
  .grid-container {
    width: min(90%, 1200px);
    margin-inline: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
  }

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



<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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

<style>
  .btn-sm {
    padding: 4px 10px;
    font-size: 0.85rem;
    border-radius: 6px;
  }

  .btn-success {
    background: linear-gradient(135deg, #4f46e5, #3b82f6);
    color: #fff;
    border: none;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #3b82f6, #4f46e5);
  }

  .btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #ef4444);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
  }

  .btn-info-custom {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-info-custom:hover {
    background: linear-gradient(135deg, #138496, #0d6efd);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
  }

  .btn-success {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: #fff !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 24px;
    font-weight: 600;
    font-size: 0.95rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #138496, #0d6efd);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
  }

  /* Filter bar card look */
  .filter-bar {
    background: linear-gradient(135deg, #eef5f9, #eef5f9);
    border: 1px solid #e4e6ef;
    border-radius: 20px !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    max-width: auto;
    margin: 0 auto;
  }

  /* General input styling */
  .form-control,
  .form-select {
    border-radius: 50px;
    padding: 0.55rem 1rem;
    border: 1px solid #d1d5db;
    transition: all 0.25s ease-in-out;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: #17a2b8;
    box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
  }

  /* Add Order button */
  .btn-info-custom {
    background: linear-gradient(135deg, #17a2b8, #0d8aa7);
    border: none;
    border-radius: 50px;
    padding: 0.6rem 1.2rem;
    color: #fff;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-info-custom:hover {
    background: linear-gradient(135deg, #0d8aa7, #05697a);
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
  }

  /* Reset button */
  .btn-danger-custom {
    background: linear-gradient(135deg, #dc3545, #a71d2a);
    border: none;
    border-radius: 8px !important;
    padding: 0.6rem 1.2rem;
    color: #fff;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-danger-custom:hover {
    background: linear-gradient(135deg, #a71d2a, #7a141f);
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
  }

  /* Best Combo Box (Shift) */
  #shift_filter {
    height: 38px;
    appearance: none;
    background: #f9fafb;
    border: 1px solid #d1d5db;
    padding-right: 2.5rem;
    position: relative;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.25s ease;
    border-radius: 8px;

  }

  #shift_filter:hover {
    background: #f1f5f9;
  }

  #shift_filter:focus {
    border-color: #17a2b8;
    box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.2);
  }

  /* Custom dropdown arrow */
  #shift_filter {
    background-image: url("data:image/svg+xml;utf8,<svg fill='gray' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 0.8rem center;
    background-size: 1rem;
  }
</style>

<?php $this->load->view('backend/footer'); ?>