<?php
    $pageTitle = "Daily Report";
    ob_start();


    ?>

<div class="container" id="container-daily">
    <div class="form-box" id="chart">
        <h1>Generate bar chart <i class="fa-solid fa-chart-simple" style="margin-left:0.2rem"></i></h1>
        <?php include_once(__DIR__ . '/../../partialViews/reports_partial.php'); ?>
    </div>

    <div>
        <?php if (!empty($costsByDate)) : ?>
            <div class="chart-title">
                <h2><?= htmlspecialchars($chartTitle) ?></h2>
            </div>
        <?php endif;?>
        <div>
            <?php if (empty($costsByDate)): ?>
                <p>No transactions available for the selected date range.</p>
            <?php else: ?>
                <canvas id="barChart"></canvas>
            <?php endif; ?>
        </div>
        <?php if (!empty($costsByDate)) : ?>
            <div class="chart-sum">
                <h3>Sum: <?= htmlspecialchars(array_sum($costsByDate)) ?></h3>
            </div>
        <?php endif;?>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include_once __DIR__ . '/../layouts/layout.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

<script>
    let costsByDate = <?= json_encode($costsByDate ?? []) ?>;

    // Extract dates and total costs
    let dates = Object.keys(costsByDate);

    let costs = Object.values(costsByDate).map(Number); // Make sure these are numbers

    let type = <?= json_encode($model->type) ?>;

    // Initialize the line chart
    let ctx = document.getElementById('barChart').getContext('2d');
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dates,
            datasets: [{
                label: `Daily ${type}s`,
                data: costs,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        displayFormats: {
                            day: 'yyyy-MM-dd'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Costs'
                    }
                }
            }
        }
    });

</script>



