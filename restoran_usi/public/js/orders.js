document.addEventListener('DOMContentLoaded', () => {
    const orderItems = [];
    const activeOrderId = window.appData.activeOrderId;

    if (!activeOrderId) {
        // Učitaj order iz localStorage ako postoji
        const savedOrder = localStorage.getItem('orderItems');
        if (savedOrder) {
            try {
                const parsed = JSON.parse(savedOrder);
                if (Array.isArray(parsed)) {
                    orderItems.push(...parsed);
                }
            } catch(e) {
                console.error('Error parsing saved orderItems', e);
            }
        }
    }

    function renderOrderList() {
        const orderList = document.getElementById('orderItems');
        orderList.innerHTML = '';
        let totalPrice = 0;

        if(orderItems.length === 0) {
            orderList.innerHTML = '<li class="text-gray-400 italic">No items yet</li>';
        } else {
            orderItems.forEach(item => {
                totalPrice += item.price * item.quantity;
                const li = document.createElement('li');
                li.textContent = `${item.quantity}x ${item.name} - $${(item.price * item.quantity).toFixed(2)}`;
                li.className = 'mb-2 font-semibold text-base';
                orderList.appendChild(li);
            });
        }
        document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
    }

    if (!activeOrderId) {
        // Dodaj event listener-e za dugmad ADD samo ako nema aktivne narudžbine
        const buttons = document.querySelectorAll('.add-to-order');
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const productCard = button.closest('.product-card');
                const quantityInput = productCard.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value);

                if(quantity < 1 || isNaN(quantity)) {
                    alert('Please enter a valid quantity (1 or more).');
                    return;
                }

                const itemId = button.dataset.id;
                const itemName = button.dataset.name;
                const itemPrice = parseFloat(button.dataset.price);

                let existing = orderItems.find(item => item.item_id === itemId);
                if(existing) {
                    existing.quantity += quantity;
                } else {
                    orderItems.push({ item_id: itemId, name: itemName, price: itemPrice, quantity });
                }

                localStorage.setItem('orderItems', JSON.stringify(orderItems));
                renderOrderList();
            });
        });

        renderOrderList();
    }

    // Event listener za dugme Create/Pay
    document.getElementById('createOrderBtn').addEventListener('click', () => {
        const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethodInput) {
            alert('Please select a payment method');
            return;
        }
        const paymentMethod = paymentMethodInput.value;

        if (activeOrderId) {
            // Plaćanje postojeće narudžbine
            fetch(`/orders/${activeOrderId}/pay`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.appData.csrfToken,
                },
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                alert(data.message || 'Order paid successfully!');
                localStorage.removeItem('orderItems');
                window.location.href = window.appData.tablesIndexUrl;
            })
            .catch(async err => {
                console.error('Error paying order:', err);
                let msg = 'Unknown error';
                if (err instanceof Response) {
                    const json = await err.json().catch(() => null);
                    if (json && json.message) msg = json.message;
                } else if (err.message) {
                    msg = err.message;
                }
                alert('Failed to pay order: ' + msg);
            });
        } else {
            // Kreiranje nove narudžbine
            if (orderItems.length === 0) {
                alert('Order is empty!');
                return;
            }

            const payload = {
                table_id: window.appData.tableId,
                payment_method: paymentMethod,
                items: orderItems
            };

            fetch(window.appData.ordersStoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.appData.csrfToken
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                alert(data.message || 'Order created successfully!');
                localStorage.removeItem('orderItems');
                window.location.href = window.appData.tablesIndexUrl;
            })
            .catch(async err => {
                console.error('Error creating order:', err);
                let msg = 'Unknown error';
                if (err instanceof Response) {
                    const json = await err.json().catch(() => null);
                    if (json && json.message) msg = json.message;
                } else if (err.message) {
                    msg = err.message;
                }
                alert('Failed to create order: ' + msg);
            });
        }
    });
});
