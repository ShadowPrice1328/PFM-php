<?php
    $pageTitle = "Daily Report";
    ob_start();
    ?>

<div class="container">
    <div class="form-box" id="chart">
        <h1>Generate line chart <i class="fa-solid fa-chart-line" style="margin-left:0.2rem"></i></h1>
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
                <canvas id="lineChart"></canvas>
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
    let categoryCostsByDate = <?= json_encode($categoryCostsByDate ?? []) ?>;

    // Extract dates and total costs
    let dates = Object.keys(costsByDate);

    let costs = Object.values(costsByDate).map(Number); // Make sure these are numbers

    let type = <?= json_encode($model->type) ?>;

    // Initialize the line chart
    let ctx = document.getElementById('lineChart').getContext('2d');
    let chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: `Daily ${type}s`,
                data: costs,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: `Day-by-Day ${type}s`
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Costs'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(tooltipItems) {
                            // Get the date from the tooltip item
                            let date = tooltipItems[0].label;
                            return date;
                        },
                        label: function(tooltipItem) {
                            let date = tooltipItem.label;
                            let totalCost = costsByDate[date]; // Total cost for the date
                            let categories = categoryCostsByDate[date];

                            // Create the tooltip label
                            let labels = [];
                            for (const [category, cost] of Object.entries(categories)) {
                                labels.push(`${category}: ${cost}`);
                            }

                            // Add the total cost summary at the end
                            return [...labels, `Sum: ${totalCost}`];
                        }
                    }
                }
            }
        }
    });
</script>



