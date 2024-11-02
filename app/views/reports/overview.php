<?php
    $pageTitle = 'Overview';
    $authenticated = false;
    ob_start();

    if (isset($model))
    {
        $categoryCosts = [];
        foreach ($model->categoryCosts as $category => $decimalObj) {
            $categoryCosts[$category] = $decimalObj->getValue();  // Access the private value through the getter
        }
    }
?>

<div class="container">
    <div class="form-box" id="chart" >
        <h1>Generate pie-chart <i class="fa-solid fa-chart-pie"></i></h1>

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

    if (categoryCosts.length === 0){

    }

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