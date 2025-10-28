


    $("#addMoreButton").click(function () {
        var row = $(".product-box").html();
        $(".product-box-extra").append(row);
        $(".product-box-extra .remove-row").last().removeClass('hideit');
        $(".product-box-extra .product-price").last().text('0.0');
        $(".product-box-extra .product-qty").last().val('1');
        $(".product-box-extra .product-total").last().text('0.0');
    });

    $(document).on("click", ".remove-row", function (){
        $(this).closest('.row').remove();
        calculateGrandTotal();
    });




    function updateRowTotal(row) {
        var price = parseFloat(row.find('.product-price').val()) || 0;
        var qty = parseInt(row.find('.product-qty').val()) || 1;
        var total = price * qty;
        row.find('.product-total').val(total.toFixed(2));
    }

    function calculateGrandTotal() {
        var grandTotal = 0;
        $(".product-total").each(function() {
            grandTotal += parseFloat($(this).val()) || 0;
        });
        $("#product_grand_total").val(grandTotal.toFixed(2));
    }


    $(document).on("change", ".cart-product, .product-qty, .product-price", function() {
        var row = $(this).closest('.row');
        updateRowTotal(row);
        calculateGrandTotal();
    });


