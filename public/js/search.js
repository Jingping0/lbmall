
$(document).ready(function () {

    load_data();
    $('#search').keyup(function () {

        var search = $(this).val();

        if (search != '')
        {
            product_list(search);
        } else
        {
            product_list();
        }
    });

    $("#search").keyup(function () {

        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val();
        // get the list to be searched
        var items = $(".search-menu button");

        // Loop through the comment list
        $(".search-menu button").each(function () {

            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).hide();

                // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
            }
        });
    });

    $("#search").focus(function () {
        $("#search-menu").show();
    });

    function product_list(query) {

        $.ajax({
            type: 'GET',
            url: 'SearchProductResult',
            data: {query: query},
            success: function (data)
            {
                $('#search-menu').html(data);
            }
        })
    }

});
