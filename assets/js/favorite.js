jQuery(document).on("click", ".add-product-to-favourite", function (e) {

    var $this = jQuery(this);

    // Do NOTHING for guests
    if ($this.hasClass("guest")) {
        return;
    }

    var product_id = $this.data("product_id");

    var action = $this.hasClass("added") ? "remove_product" : "add_product";

    jQuery.ajax({
        url: mee_object.ajax_url,
        type: "POST",
        dataType: "json",
        data: {
            action: "add_product_to_favourite",
            product_id: product_id,
            fav_action: action
        },

        success: function () {

            if (action === "add_product") {

                jQuery('.add-product-to-favourite[data-product_id="' + product_id + '"]').addClass("added");

            } else {

                jQuery('.add-product-to-favourite[data-product_id="' + product_id + '"]').removeClass("added");

                var productRow =
                    ".myaccount-user_favourites li.post-" + product_id +
                    ", .favoritter__slwrp li.post-" + product_id;

                jQuery(productRow).fadeOut(300, function () {
                    jQuery(this).remove();
                });
            }
        }
    });
});
