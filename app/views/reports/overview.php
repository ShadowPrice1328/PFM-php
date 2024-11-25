<?php
    $pageTitle = 'Overview';
    ob_start();
?>

<div class="container" id="container-overview">
    <div class="form-box" id="chart" >
        <h1>Generate pie chart <i class="fa-solid fa-chart-pie" style="margin-left:0.2rem"></i></h1>
        <?php include_once(__DIR__ . '/../../partialViews/reports_partial.php'); ?>
    </div>

    <div>
        <?php if (!empty($categoryCosts)) : ?>
            <div class="chart-title">
                <h2><?= htmlspecialchars($chartTitle) ?></h2>
            </div>
        <?php endif;?>
        <div>
            <?php if (empty($categoryCosts)): ?>
                <p>No transactions available for the selected date range.</p>
            <?php else: ?>
                <canvas id="pieChart"></canvas>
            <?php endif; ?>
        </div>
        <?php if (!empty($categoryCosts)) : ?>
            <div class="chart-sum">
                <h3>Sum: <?= htmlspecialchars(array_sum($categoryCosts)) ?></h3>
            </div>
        <?php endif;?>
    </div>
</div>
<?php
    $content = ob_get_clean();
    include_once(__DIR__ . '/../../views/layouts/layout.php');
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    let categoryCosts = <?= json_encode($categoryCosts) ?>;
    console.log(categoryCosts);

    let labels = Object.keys(categoryCosts);

    let values = Object.values(categoryCosts).map(Number);
    console.log(values);

    let colors = ['#1abc9c', '#2ecc71', '#3498db', '#9b59b6', '#34495e', '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50'];

    let backgroundColors = [];
    let borderColors = [];

    for (let i = 0; i < labels.length; i++) {
        let colorIndex = i % colors.length;
        backgroundColors.push(colors[colorIndex]);
        borderColors.push(colors[colorIndex]);
    }

    let ctx = document.getElementById('pieChart').getContext('2d');
    let myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
