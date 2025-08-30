<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<!-- CSS & JS Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<div class="page-wrapper modern-dashboard">
    <div class="container-fluid">

        <!-- PROFILE SECTION -->

        <div class="profile-card">
            <div class="profile-image">
                <img src="<?= htmlspecialchars($profile_img ?? base_url('assets/images/users/user.png')) ?>"
                    alt="<?= htmlspecialchars(($first_name ?? 'N/A') . ' ' . ($last_name ?? '')) ?>"
                    onerror="this.src='<?= base_url('assets/images/users/user.png'); ?>'">
            </div>
            <div class="profile-details">
                <h2 class="profile-name"><?= htmlspecialchars(($first_name ?? 'N/A') . ' ' . ($last_name ?? '')) ?></h2>
                <h4 class="profile-project">Project: <?= htmlspecialchars($pro_name ?? 'N/A') ?></h4>
                <div class="profile-stats">
                    <div class="stat">
                        <span class="stat-number"><?= $total_orders ?? 0 ?></span>
                        <small class="stat-label">Total Orders</small>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?= $total_mistakes ?? 0 ?></span>
                        <small class="stat-label">Total Mistakes</small>
                    </div>

                    <div class="stat">
                        <span class="stat-number"><?= $total_ir ?? 0 ?></span>
                        <small class="stat-label">Total IR</small>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?= $efficiency ?? 0 ?>%</span>
                        <small class="stat-label">Efficiency</small>
                    </div>


                </div>
            </div>
        </div>

        <br>

        <!-- CHART SECTION -->
        <div class="chart-section card">
            <div class="chart-header">
                <div class="chart-buttons">
                    <button id="one_month" class="btn">1M</button>
                    <button id="six_months" class="btn">6M</button>
                    <button id="one_year" class="btn">1Y</button>
                    <button id="ytd" class="btn">YTD</button>
                    <button id="all" class="btn active">All</button>
                </div>
            </div>
            <div id="chart-timeline" style="height: 350px;"></div>
        </div>

        <!-- SHIFT ORDER TABLE -->
        <div class="table-section card">
            <div class="table-header">
                <div class="shift-filters">
                    <button class="shift-filter active" data-shift="">All</button>
                    <button class="shift-filter" data-shift="morning">Morning</button>
                    <button class="shift-filter" data-shift="noon">Noon</button>
                    <button class="shift-filter" data-shift="night">Night</button>
                </div>
                <div class="shift-total">
                    Shift Total Orders: <span id="shift-total-orders">0</span>
                </div>
            </div>
            <div class="table-responsive">
                <table id="shift-order-table" class="table table-striped table-hover modern-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shift</th>
                            <th>PC Position</th>
                            <th>Order Count</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<style>
    /* ===== GENERAL STYLES ===== */
    body {
        font-family: 'Poppins', sans-serif;
        background: #f6f8fa;
        margin: 0;
        color: #333;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        padding: 20px;
    }

    /* ===== PROFILE CARD ===== */
    .profile-section {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }

    .profile-card {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 20px;
        border-radius: 15px;
        background: linear-gradient(135deg, #e0f7fa, #ffffff);
        /* soft light gradient */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        color: #333;
        transition: transform 0.2s ease;
    }

    .profile-card:hover {
        transform: translateY(-3px);
    }

    .profile-image img {
        border-radius: 50%;
        width: 130px;
        height: 130px;
        object-fit: cover;
        border: 3px solid #80deea;
    }

    /* ===== PROFILE DETAILS ===== */
    .profile-details h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 600;
    }

    .profile-project {
        color: #666;
        margin-bottom: 12px;
    }

    .profile-stats {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .stat {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-weight: 700;
        font-size: 18px;
        color: #00796b;
        /* soft teal */
    }

    .stat-label {
        font-size: 12px;
        color: #555;
    }

    /* ===== BUTTONS ===== */
    .btn {
        background: #e0f7fa;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s, transform 0.2s;
    }

    .btn.active {
        background: #26a69a;
        color: #fff;
    }

    .btn:hover {
        transform: scale(1.05);
    }

    /* ===== TABLE ===== */
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    table.modern-table th,
    table.modern-table td {
        text-align: center;
        padding: 12px;
    }

    table.modern-table th {
        background: #f0f7f7;
    }

    table.modern-table tbody tr:hover {
        background: #d0f0f0;
    }

    /* ===== SHIFT FILTERS ===== */
    .shift-filters {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin: 20px 0;
    }

    .shift-filter {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.2s, opacity 0.2s, background 0.2s;
    }

    .shift-filter[data-shift="morning"] {
        background-color: #80deea;
        color: #004d40;
    }

    .shift-filter[data-shift="noon"] {
        background-color: #ffe082;
        color: #bf360c;
    }

    .shift-filter[data-shift="night"] {
        background-color: #b0bec5;
        color: #263238;
    }

    .shift-filter.active {
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .shift-filter:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
</style>

<!-- Modal for Mistake Details -->
<div id="mistakeModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
    <div style="background:#fff; margin:10% auto; padding:20px; width:400px; border-radius:8px; position:relative;">
        <span id="closeModal" style="position:absolute; top:10px; right:15px; cursor:pointer; font-weight:bold;">&times;</span>
        <h3>Mistake Details</h3>
        <div id="mistakeContent"></div>
    </div>
</div>

<script>
    // -----------------------
    // ApexCharts Timeline with Orders & Mistakes
    // -----------------------
    const chartOptions = {
        series: [
            { name: "Orders", type: 'area', data: [] },
            { name: "Mistakes", type: 'scatter', data: [], color: '#ff4d4f' }
        ],
        chart: {
            height: 350,
            type: 'area',
            zoom: { enabled: true, autoScaleYaxis: true },
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    if(config.seriesIndex === 1) { // Mistakes series
                        const d = chartContext.w.globals.initialSeries[1].data[config.dataPointIndex];
                        showMistakeModal(d);
                    }
                }
            }
        },
        xaxis: { type: 'datetime', labels: { datetimeUTC: false } },
        yaxis: { title: { text: 'Order Count' } },
        tooltip: {
            shared: true,
            intersect: false,
            custom: ({ seriesIndex, dataPointIndex, w }) => {
                const d = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                return `
                    <div>
                        <strong>Date:</strong> ${new Date(d.x).toLocaleDateString()}<br>
                        <strong>Orders:</strong> ${d.orders ?? 0}<br>
                        <strong>Mistakes:</strong> ${d.mistakes ?? 0}<br>
                        <strong>Type:</strong> ${d.mistake_types ?? '-'}<br>
                        <strong>Approved IRs:</strong> ${d.approved_ir ?? 0}
                    </div>`;
            }
        },
        annotations: {
            yaxis: [
                { y: 25, borderColor: '#ff4d4f', label: { text: 'Low performance', style: { color: '#fff', background: '#ff4d4f' } } },
                { y: 150, borderColor: '#52c41a', label: { text: 'High performance', style: { color: '#fff', background: '#52c41a' } } }
            ]
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart-timeline"), chartOptions);
    chart.render();


    const setZoomRange = (start, end, btn) => {
        document.querySelectorAll('.chart-section .btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        chart.zoomX(start, end);
    };

    const ranges = {
        one_month: () => { const end = Date.now(); const start = new Date(); start.setMonth(start.getMonth() - 1); return [start.getTime(), end]; },
        six_months: () => { const end = Date.now(); const start = new Date(); start.setMonth(start.getMonth() - 6); return [start.getTime(), end]; },
        one_year: () => { const end = Date.now(); const start = new Date(); start.setFullYear(start.getFullYear() - 1); return [start.getTime(), end]; },
        ytd: () => { const today = new Date(); const start = new Date(today.getFullYear(), 0, 1); return [start.getTime(), today.getTime()]; },
        all: () => { const data = chart.w.globals.initialSeries[0].data; return data.length ? [data[0].x, data[data.length - 1].x] : [0, 0]; }
    };

    Object.keys(ranges).forEach(id => {
        document.querySelector(`#${id}`).addEventListener('click', e => setZoomRange(...ranges[id](), e.target));
    });

    // -----------------------
    // Fetch chart data
    // -----------------------
    const em_code = "<?= $em_code ?>";

    fetch(`<?= base_url('Emp_Perfomance/json_chart_data/') ?>${em_code}`)
        .then(res => res.json())
        .then(data => {
            if (!data.length) return;

            const maxOrder = Math.max(...data.map(d => d.orders));
            const paddedMax = Math.ceil((maxOrder + 20) / 25) * 25;
            chart.updateOptions({ yaxis: { min: 0, max: paddedMax, tickAmount: paddedMax / 25 } });

            const ordersSeries = data.map(d => ({
                x: new Date(d.x).getTime() + (5.5*3600000),
                y: d.orders,
                orders: d.orders,
                mistakes: d.mistakes,
                mistake_types: d.mistake_types,
                approved_ir: d.approved_ir,
            }));

            const mistakesSeries = data.filter(d => d.mistakes > 0).map(d => ({
                x: new Date(d.x).getTime() + (5.5*3600000),
                y: d.orders,
                mistakes: d.mistakes,
                mistake_types: d.mistake_types
            }));

            chart.updateSeries([
                { name: "Orders", data: ordersSeries },
                { name: "Mistakes", type: 'scatter', data: mistakesSeries, color: '#ff4d4f' }
            ]);
        });

    // -----------------------
    // SHIFT ORDER TABLE
    // -----------------------
    const loadShiftOrders = (shift = '') => {
        fetch(`<?= base_url('Emp_Perfomance/get_shift_order_data/') ?>${em_code}/${shift}`)
        
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#shift-order-table tbody');
                tbody.innerHTML = '';
                let totalOrders = 0;

                if (!data.length) {
                    tbody.innerHTML = '<tr><td colspan="6">No data</td></tr>';
                    document.getElementById('shift-total-orders').textContent = '0';
                    return;
                }

                data.forEach(d => {
                    totalOrders += parseInt(d.order_count);
                    tbody.innerHTML += `<tr>
                        <td>${d.order_date}</td>
                        <td>${d.shift}</td>
                        <td>${d.pc_position}</td>
                        <td>${d.order_count}</td>
                       
                    </tr>`;
                });

                document.getElementById('shift-total-orders').textContent = totalOrders;
            });
    };

    document.querySelectorAll('.shift-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.shift-filter').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadShiftOrders(this.dataset.shift);
        });
    });

    loadShiftOrders(); // initial load

    // -----------------------
    // Modal Function
    // -----------------------
    const showMistakeModal = (data) => {
        const modal = document.getElementById('mistakeModal');
        const content = document.getElementById('mistakeContent');
        content.innerHTML = `
            <p><strong>Date:</strong> ${new Date(data.x).toLocaleDateString()}</p>
            <p><strong>Mistakes:</strong> ${data.mistakes ?? 0}</p>
            <p><strong>Type:</strong> ${data.mistake_types ?? '-'}</p>
            <p><strong>Orders:</strong> ${data.orders ?? 0}</p>
            <p><strong>Approved IRs:</strong> ${data.approved_ir ?? 0}</p>
        `;
        modal.style.display = 'block';
    };

    document.getElementById('closeModal').onclick = () => {
        document.getElementById('mistakeModal').style.display = 'none';
    };

    window.onclick = (event) => {
        if(event.target === document.getElementById('mistakeModal')) {
            document.getElementById('mistakeModal').style.display = 'none';
        }
    };
</script>


<?php $this->load->view('backend/footer'); ?>