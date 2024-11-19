function calculateTotal(inputId, price, displayId) {
    const input = document.getElementById(inputId);
    let value = parseInt(input.value, 10) || 0;

    if (value < 0) value = 0;
    if (value > 10) value = 10;

    input.value = value; 
    const total = value * price;

    const display = document.getElementById(displayId);

    if (value > 0) {
        const total = value * price;
        display.textContent = `${total}€`;
    } else {
        display.textContent = "";
    }
}

function calculateGrandTotal() {
    const adultTotal = parseInt(document.getElementById('adultTotal').textContent) || 0;
    const kidTotal = parseInt(document.getElementById('kidTotal').textContent) || 0;

    const grandTotal = adultTotal + kidTotal;

    const totalDisplay = document.getElementById('total');
    totalDisplay.textContent = grandTotal > 0 ? `${grandTotal}€` : "0€";
}

document.getElementById('tadult').addEventListener('input', function() {
    calculateTotal('tadult', 20, 'adultTotal');
    calculateGrandTotal();
});

document.getElementById('tkid').addEventListener('input', function() {
    calculateTotal('tkid', 12, 'kidTotal');
    calculateGrandTotal();
});

