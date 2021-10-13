<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
$(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $(".elementor-sticky--effects").addClass("active");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
           $(".elementor-sticky--effects").removeClass("active");
        }
    });
});

 

</script>
<!-- end Simple Custom CSS and JS -->
