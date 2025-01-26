<div class="container">
    <div class="form-box" id="delivery-form">
        <h1>Delivery information</h1>
        <p>Please fill this form in a decent manner</p>

        <form method="post" id="deliveryForm">
            <div class="form-group">
                <label for="name">
                    Your name:
                    <input type="text" name="name" id="name" class="form-control" required>
                </label>
            </div>
            <div class="form-group">
                <label for="address">Address of delivery:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="delivery-method">Delivery method:</label>
                <select id="delivery-method" name="delivery-method" class="form-control" required>
                    <option value="standard">Standard delivery</option>
                    <option value="express">Express delivery</option>
                    <option value="pickup">Pickup</option>
                </select>
            </div>
            <div class="form-group">
                <label>Additional options:</label>
                <div>
                    <input type="checkbox" id="gift-wrap" name="options[]" value="gift-wrap">
                    <label for="gift-wrap">Wrap as a gift</label>
                </div>
                <div>
                    <input type="checkbox" id="insurance" name="options[]" value="insurance">
                    <label for="insurance">Add insurance</label>
                </div>
            </div>
            <div class="form-group">
                <label for="upload-file">Discount card:</label>
                <input type="file" id="upload-file" name="upload-file" accept=".jpg,.png,.pdf">
            </div>
            <div class="form-group">
                <label for="delivery-date">Select delivery date:</label>
                <input type="date" id="delivery-date" name="delivery-date" required>
            </div>
        </form>
    </div>
</div>

<script src="js/minDate.js"></script>