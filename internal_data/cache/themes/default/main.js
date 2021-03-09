/** 
 * navigation class
 * 
*/

class p_navigation {

    /** 
     * open side bar navigation drawer
     * 
    */
    
    open_sidenav() {
        
        $(".sidenav-wrapper").css("left", "0px");
        $(".sidenav-overlay").fadeIn(300);
        
    }

    /** 
     * close side bar navigation drawer
     *  
    */

    close_sidenav() {
        
        $(".sidenav-wrapper").css("left", "-250px");
        $(".sidenav-overlay").fadeOut(300);
        
    }
    
}

// create navigation object
let navigation = new p_navigation();

// hide navbar links based on amount of space available
window.onresize = function () {
    
    // define navigation items
    var links = $(".navbar-wrapper .links-wrapper");
    var menu = $(".navbar-wrapper .group .menu");
    var logo = $(".navbar-wrapper .group .logo");

    // define space from edge
    var isOff = $(window).width() - (links.offset().left + links.outerWidth());

    // calculate space
    if (isOff >= 0) {

        links.css("opacity", "100%");
        links.css("pointer-events", "all");
        logo.css("margin-left", "20px");
        menu.css("display", "none");

    } else {

        links.css("opacity", "0%");
        logo.css("margin-left", "10px");
        links.css("pointer-events", "none");
        menu.css("display", "initial");

    }
};


// hide links based on amount of space available
$(document).ready(function () {

    // define navigation items
    var links = $(".navbar-wrapper .links-wrapper");
    var menu = $(".navbar-wrapper .group .menu");
    var logo = $(".navbar-wrapper .group .logo");

    // define space from edge
    var isOff = $(window).width() - (links.offset().left + links.outerWidth());

    // calculate space
    if (isOff >= 0) {

        links.css("opacity", "100%");
        links.css("pointer-events", "all");
        logo.css("margin-left", "20px");
        menu.css("display", "none");

    } else {

        links.css("opacity", "0%");
        logo.css("margin-left", "10px");
        links.css("pointer-events", "none");
        menu.css("display", "initial");

    }

});

// sidebar navigation
$(document).ready(function () {
    
    // close sidenav
    $(".sidenav-wrapper .header-wrapper .button").click(function () {
        
        navigation.close_sidenav();
        
    });

    $(".sidenav-overlay").click(function () {
        
        navigation.close_sidenav();
        
    });

    // open sidenav
    $(".navbar-wrapper .group .menu").click(function () {
        
        navigation.open_sidenav();
        
    });
    
});

class p_snackbar {
    
    close_snackbar() {
        
        var snackbar = $(".snackbar-wrapper");
        var snackbar_height = snackbar[0].offsetHeight;
            
        snackbar.css("bottom", "-" + snackbar_height + "px");
        
    }
    
    open_snackbar(text) {
        
        var snackbar = $(".snackbar-wrapper");
        var snackbar_content = $(".snackbar-wrapper .text");
        
        snackbar_content.html(text);
        snackbar.css("bottom", "10px");
        
        setTimeout(() => {
        
            this.close_snackbar();
    
        }, 5000);
        
    }
    
}

let snackbar = new p_snackbar();

class p_modal {
    
    close_modal() {
        
        var modal = $(".modal-wrapper");
        var modal_overlay = $(".modal-overlay");
        
        modal.fadeOut(300);
        modal.css("top", "70vh");
        modal_overlay.fadeOut(300);

        this.caller.classList.remove('focused');
        
    }
    
    open_modal(url, caller) {

        this.caller = caller;
        
        var modal = $(".modal-wrapper");
        var modal_overlay = $(".modal-overlay");
        var modal_content = $(".modal-wrapper .body-wrapper");
        
        ajaxloader.show_ajaxloader();
        
        $.ajax({
            
            url: url,
            data: "layout=remote",
            method: "POST",
            
            success: function(result) {
               
                modal_content.html(result);

                ajaxloader.hide_ajaxloader();
                
                modal.fadeIn(300);
                modal.css("top", "50vh");
                modal_overlay.fadeIn(300);
                
            },
            
            error: function() {
                
                snackbar.open_snackbar("Error, something went wrong. More info may be available in the console");
                ajaxloader.hide_ajaxloader();
                
            }
            
        });
        
    }
    
}

let modal = new p_modal();

class p_ajaxloader {
    
    show_ajaxloader() {
        
        var ajaxloader = $(".ajaxloader-wrapper .bar");
        
        ajaxloader.addClass("on");
        
    }
    
    hide_ajaxloader() {
        
        var ajaxloader = $(".ajaxloader-wrapper .bar");
        
        ajaxloader.removeClass("on");
        
    }
    
}

let ajaxloader = new p_ajaxloader();

$(document).ready(function() {

    $("button").click(function() {
        
        if (this.dataset.modal == "true") {
            
            modal.open_modal(this.dataset.href, this);
            this.classList.add('focused');

        }

    });

});