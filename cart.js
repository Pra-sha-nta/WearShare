document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll('.product_btn');
    const daySelects = document.querySelectorAll('.days_select');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const productId = this.getAttribute('href').split('=')[1];
            addToCart(productId);
        });
    });

    daySelects.forEach(select => {
        select.addEventListener('change', function () {
            const productId = this.dataset.id;
            const days = this.value;
            updateDays(productId, days);
        });
    });

    function addToCart(productId) {
        fetch(`cart.php?action=add&id=${productId}`)

        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Network response was not ok.');
        })
        .then(data => {
            alert('Product added to cart!');
            location.reload(); 
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        })
    }

    function updateDays(productId, days) {
        fetch(`cart.php?action=update_days&id=${productId}&days=${days}`)
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok.');
            })
            .then(data => {
                location.reload(); 
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    }
});
