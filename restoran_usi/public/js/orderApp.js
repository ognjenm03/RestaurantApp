function orderApp() {
    return {
        categories: window.appData.categories,
        menuItems: window.appData.menuItems,

        selectedCategory: null,
        qty: {},
        order: [],
        paymentMethod: 'cash',

        init() {
            this.menuItems.forEach(item => {
                this.qty[item.item_id] = 1;
            });
        },

        get filteredItems() {
            if (!this.selectedCategory) return this.menuItems;
            return this.menuItems.filter(i => i.category_id === this.selectedCategory);
        },

        selectCategory(id) {
            this.selectedCategory = id;
        },

        increaseQty(id) {
            if (!this.qty[id]) this.qty[id] = 1;
            this.qty[id]++;
        },

        decreaseQty(id) {
            if (!this.qty[id]) this.qty[id] = 1;
            if(this.qty[id] > 1) this.qty[id]--;
        },

        addToOrder(item) {
            const quantity = this.qty[item.item_id] || 1;
            const existing = this.order.find(i => i.item_id === item.item_id);

            if (existing) {
                existing.quantity += quantity;
            } else {
                this.order.push({
                    item_id: item.item_id,
                    name: item.name,
                    price: parseFloat(item.price),
                    quantity: quantity,
                });
            }

            this.qty[item.item_id] = 1; // reset quantity input
        },

        increaseOrderQty(id) {
            const item = this.order.find(i => i.item_id === id);
            if(item) item.quantity++;
        },

        decreaseOrderQty(id) {
            const item = this.order.find(i => i.item_id === id);
            if(item) {
                if(item.quantity > 1) item.quantity--;
                else this.removeFromOrder(id);
            }
        },

        removeFromOrder(id) {
            this.order = this.order.filter(i => i.item_id !== id);
        },

        get totalPrice() {
            return this.order.reduce((sum, i) => sum + i.price * i.quantity, 0);
        },

        createOrder() {
            if(this.order.length === 0) {
                alert('Cart is empty!');
                return;
            }

            alert('Order created with total: $' + this.totalPrice.toFixed(2) + '\nPayment method: ' + this.paymentMethod);

            // TODO: Implement order creation with backend
        }
    }
}
