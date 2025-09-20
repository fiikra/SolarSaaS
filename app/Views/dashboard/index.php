<h1 class="text-3xl text-black pb-6"><?php echo trans('dashboard'); ?></h1>

<div class="flex flex-wrap">
    <!-- Active Projects -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-blue-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-blue-500"><i class="fas fa-tasks fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('active_projects'); ?></h5>
                    <h3 class="font-bold text-3xl"><?php echo $data['activeProjects']; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Invoices -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-yellow-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-yellow-500"><i class="fas fa-file-invoice-dollar fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('pending_invoices'); ?></h5>
                    <h3 class="font-bold text-3xl"><?php echo $data['pendingInvoices']; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- New Clients -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-green-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-green-500"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('new_clients_this_month'); ?></h5>
                    <h3 class="font-bold text-3xl"><?php echo $data['newClients']; ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Revenue -->
    <div class="w-full md:w-1/2 xl:w-1/3 p-3">
        <div class="bg-white border-b-4 border-red-500 rounded-lg shadow-lg p-5">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded-full p-5 bg-red-500"><i class="fas fa-hand-holding-usd fa-2x fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600"><?php echo trans('total_revenue'); ?></h5>
                    <h3 class="font-bold text-3xl">$<?php echo number_format($data['totalRevenue'], 2); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-row flex-wrap flex-grow mt-2">

    <div class="w-full md:w-1/2 xl:w-1/2 p-3">
        <!--Graph Card-->
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-200 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600"><?php echo trans('monthly_revenue'); ?></h5>
            </div>
            <div class="p-5">
                <canvas id="chartjs-revenue" class="chartjs" width="undefined" height="undefined"></canvas>
                <script>
                    new Chart(document.getElementById("chartjs-revenue"), {
                        "type": "bar",
                        "data": {
                            "labels": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            "datasets": [{
                                "label": "<?php echo trans('revenue'); ?>",
                                "data": [100, 200, 350, 400, 250, 500, 600, 700, 550, 800, 900, 1000],
                                "fill": false,
                                "backgroundColor": "rgba(54, 162, 235, 0.2)",
                                "borderColor": "rgb(54, 162, 235)",
                                "borderWidth": 1
                            }]
                        },
                        "options": {
                            "scales": {
                                "yAxes": [{
                                    "ticks": {
                                        "beginAtZero": true
                                    }
                                }]
                            }
                        }
                    });
                </script>
            </div>
        </div>
        <!--/Graph Card-->
    </div>

    <div class="w-full md:w-1/2 xl:w-1/2 p-3">
        <!--Graph Card-->
        <div class="bg-white border-transparent rounded-lg shadow-lg">
            <div class="bg-gray-200 uppercase text-gray-800 border-b-2 border-gray-300 rounded-tl-lg rounded-tr-lg p-2">
                <h5 class="font-bold uppercase text-gray-600"><?php echo trans('projects_status'); ?></h5>
            </div>
            <div class="p-5">
                <canvas id="chartjs-projects" class="chartjs" width="undefined" height="undefined"></canvas>
                <script>
                    new Chart(document.getElementById("chartjs-projects"), {
                        "type": "doughnut",
                        "data": {
                            "labels": ["<?php echo trans('completed'); ?>", "<?php echo trans('in_progress'); ?>", "<?php echo trans('pending'); ?>"],
                            "datasets": [{
                                "label": "<?php echo trans('projects'); ?>",
                                "data": [30, 50, 20],
                                "backgroundColor": [
                                    "rgb(75, 192, 192)",
                                    "rgb(54, 162, 235)",
                                    "rgb(255, 205, 86)"
                                ]
                            }]
                        }
                    });
                </script>
            </div>
        </div>
        <!--/Graph Card-->
    </div>
</div>

