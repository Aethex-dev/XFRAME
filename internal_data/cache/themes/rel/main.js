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

$(".snackbar-wrapper .button").click(function() {
    
    snackbar.close_snackbar();
    
});