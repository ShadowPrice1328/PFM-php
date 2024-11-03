<?php
    $pageTitle = "Daily Report";
    $authenticated = false;

    ob_start();
    ?>

<div class="container">
    <div class="form-box" id="chart">
        <h1>Generate line chart <i class="fa-solid fa-chart-line"></i></h1>

        <form autocomplete="off" method="post">
            <?php if (!empty($errors['summary'])): ?>
                <div class="text-bad"><?= htmlspecialchars($errors['summary']) ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="firstDate" class="control-label">From
                    <input name="firstDate" type="date" max="<?= htmlspecialchars(date('Y-m-d')) ?>"
                           value="<?= isset($model) ? htmlspecialchars($model->firstDate->format('Y-m-d')) : '' ?>" class="form-control" required />
                </label>
                <?php if (!empty($errors['firstDate'])): ?>
                    <div class="text-bad"><?= htmlspecialchars($errors['firstDate']) ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="lastDate" class="control-label">To
                    <input name="lastDate" type="date" max="<?= htmlspecialchars(date('Y-m-d')) ?>"
                           value="<?= isset($model) ? htmlspecialchars($model->lastDate->format('Y-m-d')) : '' ?>" class="form-control" required />
                </label>
                <?php if (!empty($errors['lastDate'])): ?>
                    <div class="text-bad"><?= htmlspecialchars($errors['lastDate']) ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="type" class="control-label">Type</label>
                <div class="select-wrapper">
                    <label>
                        <select name="type" class="form-control">
                            <option value="Expense" <?= (!isset($model->type) || $model->type === "Expense") ? 'selected' : ''?>>Expense</option>
                            <option value="Revenue" <?= (isset($model->type) && $model->type === "Revenue") ? 'selected' : ''?>>Revenue</option>
                        </select>
                    </label>
                    <?php if (!empty($errors['type'])): ?>
                        <div class="text-bad"><?= htmlspecialchars($errors['type']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label for="category" class="control-label text-muted">Category (optional)</label>
                <div class="select-wrapper">
                    <?php if (!empty($category_names)): ?>
                        <label>
                            <select class="form-control" name="category">
                                <option value="" <?= (!isset($model->category)) ? 'selected' : '' ?>>Select Category</option>
                                <?php foreach ($category_names as $category_name): ?>
                                    <option value="<?= htmlspecialchars($category_name) ?>" <?= (isset($model->category) && $model->category === $category_name) ? 'selected' : ''?>>
                                        <?= htmlspecialchars($category_name) ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </label>
                    <?php else:?>
                        <label>
                            <select class="form-control" disabled>
                                <option value="">No categories available</option>
                            </select>
                        </label>
                    <?php endif;?>
                    <?php if (!empty($errors['category'])): ?>
                        <div class="text-bad"><?= htmlspecialchars($errors['category']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group mt-3">
                <input type="submit" value="Generate" class="btn btn-primary" />
            </div>
        </form>
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



