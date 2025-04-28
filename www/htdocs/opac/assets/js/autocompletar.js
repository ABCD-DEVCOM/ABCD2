$(function () {
    function configurarAutocomplete() {
        var base = $("#base").val(); // It can be empty

        $("#termo-busca").autocomplete({
            source: function (request, response) {
                $("#spinner").show(); // Show the spinner

                var baseUrl = window.location.pathname.split('/opac')[0] + '/opac';

                $.ajax({
                    url: baseUrl + "/json.php",
                    dataType: "json",
                    data: {
                        base: base, // If it's empty, the backend understands!
                        letra: request.term
                    },
                    success: function (data) {
                        $("#spinner").hide();
                        response(data.slice(0, 20)); // Limit 20 suggestions
                    },
                    error: function (xhr, status, error) {
                        $("#spinner").hide();
                        console.error("Query error:", error);
                        response([]);
                    }
                });
            },
            minLength: 2,
        });
    }

    configurarAutocomplete(); // First call

    $("#base").on("change", function () {
        $("#termo-busca").val("");
        if ($("#termo-busca").data('ui-autocomplete')) {
            $("#termo-busca").autocomplete("destroy");
        }
        configurarAutocomplete();
    });
});
