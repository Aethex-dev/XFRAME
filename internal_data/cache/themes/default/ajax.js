class ajax {



}

$(document).on('submit', "form", function(event) {

    if(this.dataset.ajax == "true") {

        ajaxloader.show_ajaxloader();

        var action = $(this).attr("action");
    
        event.preventDefault();

        if (typeof action != 'undefined') {
        
            action = $(this).prop("action");

        } else {
        
            snackbar.open_snackbar("ERROR: Something went wrong, More information may be available in the console.");
            console.error("The action parameter hasn't been defined yet.");
            ajaxloader.hide_ajaxloader();
            modal.close_modal();
            return false;
        
        }

        var data = $(this).serialize();

        $.ajax({
        
            url: action,
            method: "POST",
            data: data + "&layout=remote",

            success: function (result) {
            
                $("body").append(result);
                ajaxloader.hide_ajaxloader();
            
            },

            error: function() {
            
                snackbar.open_snackbar("ERROR: Something went wrong, More information may be available in the console.");
                ajaxloader.hide_ajaxloader();
            
            }
        
        });
    
    }

});