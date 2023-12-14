$(document).ready(function() {
    $(".custom-btn").click(function(event) {
        event.preventDefault(); 

        var productId = $(this).data("product-id");

        $.ajax({
            url: "funciones/verificar_sesion.php",
            type: "GET",
            success: function(response) {
                if (response.trim() !== "sesion_activa") {
                    window.location.href = "login.php";
                } 
            }
        });
    }); 
});