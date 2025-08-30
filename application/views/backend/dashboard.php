<?php $this->load->view('backend/header'); ?>

<?php $this->load->view('backend/sidebar'); ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
    <i class="fa fa-tachometer-alt" style="color:#1976d2"></i>&nbsp; Dashboard
</h3>

        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <!-- New Modern Dashboard Cards -->
        <div class="grid-container" style="margin-top: 20px;">

            <!-- TOTAL EMPLOYEES -->
            <div class="card" style="--grad: #FFC107, #FF9800;">
                <div class="title">Total Employees</div>
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="content">
                    <h2>
                        <?php
                        $this->db->where('status', 'ACTIVE');
                        $this->db->from("employee");
                        echo $this->db->count_all_results();
                        ?>
                    </h2>
                    <p>Currently Active Employees</p>
                    <!-- <select class="form-select form-select-sm mt-2" style="width: 120px;">
                        <option selected>All</option>
                        <option value="country1">Malaysia</option>
                        <option value="Country2">Sri Lanka</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Combodia">Cambodia</option>
                    </select> -->
                </div>
            </div>

            <!-- ORDERS -->
            <div class="card" style="--grad: #2196F3, #03A9F4;">
                <div class="title">Orders</div>
                <div class="icon"><a href="<?php echo base_url('Order_report'); ?>"><i class="fa fa-list-alt"></i></a>
                </div>
                <div class="content">
                    <h2 id="order-count">
                        <?php
                        $this->db->select_sum('order_count');
                        $query = $this->db->get('daily_order');
                        $result = $query->row();
                        echo $result->order_count ?? 0;
                        ?>
                    </h2>
                    <p>Total Approved Orders</p>
                    <select class="form-select custom-select-sm mt-2 custom-dropdown" style="width: 150px;"
                        id="time-range-dropdown">
                        <option value="all" selected>All</option>
                        <option value="today">Today</option>
                        <option value="week">Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>

                    <select class="form-select custom-select-sm mt-2 custom-dropdown" style="width: 150px;"
                        id="project-dropdown">
                        <option value="all" selected>All Projects</option>
                        <?php
                        $projects = $this->db->get('project')->result();
                        foreach ($projects as $project) {
                            echo '<option value="' . $project->id . '">' . $project->pro_name . '</option>';
                        }
                        ?>
                    </select>

                </div>
            </div>



            <!-- MISTAKES -->
            <div class="card" style="--grad: #F44336, #E91E63;">
                <div class="title">Mistakes</div>
                <div class="icon"><a href="<?php echo base_url('Daily_Mistake/daily_mistake'); ?>"><i
                            class="fa fa-exclamation-triangle"></i></a></div>
                <div class="content">
                    <h2 id="mistakesCount">0</h2>
                    <p>Total Granted Mistakes</p>

                    <!-- Time Range Filter -->
                    <select id="mistakeTimeFilter" class="form-select custom-select-sm mt-2 custom-dropdown"
                        style="width: 120px;">
                        <option value="all" selected>All</option>
                        <option value="today">Today</option>
                        <option value="week">Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>

                    <select id="mistakeProjectFilter" class="form-select custom-select-sm mt-2 custom-dropdown"
                        style="width: 150px;">
                        <option value="all" selected>All Projects</option>
                        <?php
                        $projects = $this->db->get('project')->result();
                        foreach ($projects as $project) {
                            echo '<option value="' . $project->id . '">' . $project->pro_name . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>







            <!-- End Modern Cards -->

            <style>
                .grid-container {
                    width: min(90%, 1200px);
                    margin-inline: auto;
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap: 2rem;
                    margin-top: 2rem;
                }

                @keyframes shake {
                    0% {
                        transform: translate(0px, 0px);
                    }

                    20% {
                        transform: translate(-2px, 0px);
                    }

                    40% {
                        transform: translate(2px, 0px);
                    }

                    60% {
                        transform: translate(-2px, 0px);
                    }

                    80% {
                        transform: translate(2px, 0px);
                    }

                    100% {
                        transform: translate(0px, 0px);
                    }
                }

                /* .card:hover {
                    animation: shake 0.5s ease-in-out;
                } */

                .card {
                    --grad: red, blue;
                    padding: 2rem;
                    background-image: linear-gradient(to bottom left, #e0e4e5, #f2f6f9);
                    border-radius: 1.5rem;
                    display: grid;
                    grid-template-areas:
                        "title icon"
                        "content content"
                        "bar bar";
                    grid-template-columns: 1fr auto;
                    gap: 1rem;
                    color: #444;
                    box-shadow: inset -2px 2px hsl(0 0 100% / 1), -20px 20px 40px hsl(0 0 0 / .25);
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
        </div>

        <div class="container-fluid">
            <?php
            $notice = $this->notice_model->GetNoticelimit();
            $running = $this->dashboard_model->GetRunningProject();
            $userid = $this->session->userdata('user_login_id');
            $todolist = $this->dashboard_model->GettodoInfo($userid);
            $leaveinfo = $this->dashboard_model->GetLeaveInfo();
            ?>


            <!-- Pie Chart With Body -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">All Project order Count</h4>
                            <select id="time-filter" class="form-select custom-select-sm mt-2 custom-dropdown"
                                style="width: 150px;">
                                <option value="all">All</option>
                                <option value="morning">Morning</option>
                                <option value="noon">Noon</option>
                                <option value="night">Night</option>
                            </select>
                            <div class="table-responsive" style="height:400px; overflow-y:auto; overflow-x:auto;">
                                <div id="orderChart" style="height: 370px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Top 10 Employees by Orders</h4>

                            <?php if (!empty($top_employees)): ?>
                                <ul>
                                    <?php foreach ($top_employees as $emp): ?>
                                        <li>
                                            <?= $emp->first_name . ' ' . $emp->last_name ?>
                                            (<?= $emp->total_orders ?> orders)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <h4>No employee orders found.</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>




            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Notice Board</h4>

                            <div class="card-body">
                                <div class="table-responsive slimScrollDiv" style="height:400px;overflow-y:scroll">
                                    <table class="table table-hover table-bordered earning-box">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>File</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($notice as $value): ?>
                                                <tr class="scrollbar" style="vertical-align:top">
                                                    <td><?php echo $value->title ?></td>
                                                    <td><mark><a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url ?>"
                                                                target="_blank"><?php echo $value->file_url ?></a></mark>
                                                    </td>
                                                    <td style="width:100px"><?php echo $value->date ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Leave List</h4>

                            <div class="card-body">
                                <div class="table-responsive" style="height:400px;overflow-y:scroll">
                                    <table class="table table-hover table-bordered earning-box">
                                        <thead>
                                            <tr>
                                                <th>Leave Type</th>
                                                <th>Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($leaveinfo as $value): ?>
                                                <tr style="background-color:#e3f0f7">
                                                    <td><?php echo $value->leave_type ?></td>
                                                    <td><?php echo $value->leave_duration; ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- To-do List -->
            <script>
                $(document).ready(function () {
                    $(".to-do").on("click", function () {
                        $.ajax({
                            url: "Update_Todo",
                            type: "POST",
                            data: {
                                'toid': $(this).attr('data-id'),
                                'tovalue': $(this).attr('data-value'),
                            },
                            success: function (response) {
                                location.reload();
                            },
                            error: function (response) {
                                console.error();
                            }
                        });
                    });
                });
            </script>

            <!-- mistake_count -->

            <script>
                $(document).ready(function () {
                    function loadMistakeCount(timeRange = 'all', projectId = 'all') {
                        $.ajax({
                            url: "<?= base_url('Dashboard/mistake_count') ?>",
                            type: "POST",
                            data: { timeRange: timeRange, projectId: projectId },
                            dataType: "json",
                            success: function (data) {
                                $('#mistakesCount').text(data.count ?? 0);
                            },
                            error: function (xhr) {
                                console.error("Error fetching mistakes count:", xhr.responseText);
                            }
                        });
                    }

                    $('#mistakeTimeFilter, #mistakeProjectFilter').on('change', function () {
                        const timeRange = $('#mistakeTimeFilter').val();
                        const projectId = $('#mistakeProjectFilter').val();
                        loadMistakeCount(timeRange, projectId);
                    });

                    loadMistakeCount();
                });
            </script>

            <script>
                $(document).ready(function () {
                    let chart;

                    function loadChartData(filter = 'all') {
                        $.ajax({
                            url: `<?= base_url('Dashboard/get_order_comparison_chart') ?>/${filter}`,
                            method: "GET",
                            success: function (res) {
                                let rawData;
                                try {
                                    rawData = typeof res === 'string' ? JSON.parse(res) : res;
                                } catch (e) {
                                    console.error("Invalid JSON:", e);
                                    return;
                                }

                                const categories = [...new Set(rawData.map(row => row.order_date))];
                                const projects = [...new Set(rawData.map(row => row.pro_name))];

                                const series = projects.map(project => ({
                                    name: project,
                                    data: categories.map(date => {
                                        const row = rawData.find(r => r.order_date === date && r.pro_name === project);
                                        return row ? parseInt(row.total_orders) : 0;
                                    })
                                }));

                                const colors = generateColors(projects.length);

                                const options = {
                                    chart: { type: 'line', height: 370 },
                                    series: series,
                                    colors: colors,
                                    xaxis: { categories: categories, title: { text: 'Date' } },
                                    yaxis: { title: { text: 'Order Count' } },
                                    stroke: { curve: 'smooth' },
                                    legend: {
                                        position: 'top',
                                        onItemClick: { toggleDataSeries: true },
                                        onItemHover: { highlightDataSeries: true }
                                    },
                                    tooltip: {
                                        shared: true,
                                        intersect: false,
                                        custom: function ({ series, dataPointIndex, w }) {
                                            if (dataPointIndex === undefined || !w.globals.categoryLabels[dataPointIndex]) {
                                                return "";
                                            }

                                            const date = w.globals.categoryLabels[dataPointIndex];
                                            const collapsed = w.globals.collapsedSeries || [];

                                            let visibleProjects = w.config.series
                                                .map((s, i) => {
                                                    if (collapsed.includes(i)) return null;
                                                    const value = (series[i] && series[i][dataPointIndex] != null) ? series[i][dataPointIndex] : null;
                                                    if (value === null) return null;

                                                    return `
                                        <div style="display:flex;align-items:center;
                                            justify-content:space-between;
                                            padding:6px 10px;margin:3px 0;
                                            background:#f9fafb;border-radius:6px;
                                            font-size:12px;">
                                            <div style="display:flex;align-items:center;gap:8px;">
                                                <span style="width:12px;height:12px;border-radius:50%;
                                                    background:${w.config.colors[i]};"></span>
                                                <span>${s.name}</span>
                                            </div>
                                            <strong>${value}</strong>
                                        </div>
                                    `;
                                                })
                                                .filter(Boolean);

                                            if (visibleProjects.length === 0) return "";

                                            return `
                                <div style="background:#fff;border-radius:10px;
                                    box-shadow:0 4px 12px rgba(0,0,0,0.15);
                                    padding:12px 14px;min-width:200px;">
                                    <div style="font-weight:600;font-size:14px;color:#1976d2;
                                        border-bottom:1px solid #eee;padding-bottom:6px;margin-bottom:8px;  overflow-y:auto; overflow-x:auto;">
                                        📅 ${date}
                                    </div>
                                    ${visibleProjects.join("")}
                                </div>
                            `;
                                        }
                                    }
                                };

                                if (chart) {
                                    chart.updateOptions(options, true, true);
                                } else {
                                    chart = new ApexCharts(document.querySelector("#orderChart"), options);
                                    chart.render();
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Failed to fetch chart data:", error);
                                alert("Error loading order chart.");
                            }
                        });
                    }

                    function generateColors(count) {
                        let colors = [];
                        for (let i = 0; i < count; i++) {
                            const hue = (i * 360 / count) % 360;
                            colors.push(`hsl(${hue}, 70%, 50%)`);
                        }
                        return colors;
                    }

                    loadChartData();

                    $('#time-filter').on('change', function () {
                        loadChartData(this.value);
                    });
                });
            </script>




            <script>
                document.getElementById('time-range-dropdown').addEventListener('change', applyFilters);
                document.getElementById('project-dropdown').addEventListener('change', applyFilters);

                function applyFilters() {
                    const timeRange = document.getElementById('time-range-dropdown').value;
                    const projectId = document.getElementById('project-dropdown').value;
                    fetchOrderCount(timeRange, projectId);
                }

                function fetchOrderCount(timeRange, projectId) {
                    fetch(`<?= base_url('Dashboard/get_total_order_count/') ?>${timeRange}/${projectId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('order-count').innerHTML = data.orderCount;
                            } else {
                                document.getElementById('order-count').innerHTML = 'Error fetching data.';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching order count:', error);
                            document.getElementById('order-count').innerHTML = 'Error fetching data.';
                        });
                }
            </script>

            <?php $this->load->view('backend/footer'); ?>