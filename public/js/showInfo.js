function showInfo(name, description, price, quantity) {
    // Populate modal with product details
    document.getElementById("modalTitle").textContent = name;
    document.getElementById("modalDescription").textContent = description;
    document.getElementById("modalPrice").textContent = `Price: ${price} zł`;
    document.getElementById("modalQuantity").textContent = `Available: ${quantity}`;

    // Show modal
    document.getElementById("imageModal").style.display = "block";
}