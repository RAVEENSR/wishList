/*
* Adds an item to cart
* */
function addToCart(bookId) {
    if (bookId) {
        var siteURL = $('#siteURL')[0].value;
        var quantity;
        if ($('#quantity').length) {
            quantity = parseInt($('#quantity')[0].value);
        } else {
            quantity = 1;
        }

        $.ajax({
            url: siteURL + "/visitor/addToCart",
            type: "POST",
            data: {isbn: bookId, quantity: quantity},
            success: function (data) {
                var flag = data;
                if (flag === '0') {
                    alert('Quantity should be less than the available copies');
                } else if (flag === '1') {
                    alert('Book is already available in the cart');
                } else if (flag === '2') {
                    alert('Book Added to the Cart Successfully');
                } else {
                    alert('Error occurred when adding the book into the cart');
                }
            },
            error: function (XHR, status, response) {
                console.log(XHR.response);
                console.log(status);
                console.log(response);
                alert('Error occurred when adding the book into the cart');
            }
        });
    }
}