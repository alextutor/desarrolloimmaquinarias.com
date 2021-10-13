<?php
/**
* Class Sale Notification
*/
class Woolentor_Sale_Notification{

    private static $_instance = null;
    public static function instance(){
        if( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    function __construct(){
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'woolentor_inline_styles' ] );
        add_action( 'wp_footer', [ $this, 'woolentor_ajax_request' ] );
    }

    public function enqueue_scripts(){
        wp_enqueue_style( 'woolentor-animate' );
        wp_enqueue_script( 'woolentor-widgets-scripts' );
        wp_localize_script( 'woolentor-widgets-scripts', 'porduct_fake_data', $this->woolentor_fakes_notification_data() );
    }

    public function woolentor_fakes_notification_data(){
        $notification = array();
        foreach( woolentor_get_option( 'noification_fake_data','woolentor_sales_notification_tabs', '' ) as $key => $fakedata ) {
            $nc = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $fakedata );
            array_push( $notification, $nc );
        }
        return $notification;
    }

    // Inline CSS
    function woolentor_inline_styles() {
        $crosscolor = woolentor_get_option( 'cross_color','woolentor_sales_notification_tabs', '#000000' );
        $custom_css = "
            .wlcross{
                color: {$crosscolor} !important;
            }";
        wp_add_inline_style( 'woolentor-widgets', $custom_css );
    }

    // Ajax request
    function woolentor_ajax_request() {

        $intervaltime  = (int)woolentor_get_option( 'notification_time_int','woolentor_sales_notification_tabs', '4' )*1000;
        $duration      = (int)woolentor_get_option( 'notification_loadduration','woolentor_sales_notification_tabs', '3' )*1000;
        $showing       = (int)woolentor_get_option( 'notification_time_showing','woolentor_sales_notification_tabs', '5' )*1000;
        $inanimation   = woolentor_get_option( 'notification_inanimation','woolentor_sales_notification_tabs', 'fadeInLeft' );
        $outanimation  = woolentor_get_option( 'notification_outanimation','woolentor_sales_notification_tabs', 'fadeOutRight' );
        $notposition  = woolentor_get_option( 'notification_pos','woolentor_sales_notification_tabs', 'bottomleft' );

        ?>
            <script>
                ;jQuery( document ).ready( function( $ ) {

                    var notposition = '<?php echo $notposition; ?>';

                    $('body').append('<div class="woolentor-sale-notification"><div class="notifake woolentor-notification-content '+notposition+'"></div></div>');

                    var duration = <?php echo $duration; ?>,
                        intervaltime = <?php echo $intervaltime; ?>,
                        showing_time = <?php echo $showing; ?>,
                        inanimation = '<?php echo $inanimation; ?>',
                        outanimation = '<?php echo $outanimation; ?>',
                        i = 0;

                    window.setTimeout( function(){
                        setTimeout( function () { 
                            $('.woolentor-notification-content').removeClass(inanimation).addClass(outanimation);
                            i++;
                        }, showing_time );
                        if( porduct_fake_data.length > 0 ){
                            woolentor_notification_loop_start( porduct_fake_data );
                        }
                    }, duration );


                    function woolentor_notification_loop_start( porduct_fake_data ){

                        var interval = parseInt( intervaltime ) + parseInt( showing_time );

                        setInterval( function ( porduct_fake_data ) {
                            if( i == porduct_fake_data.length ){ i = 0; }

                            $('.woolentor-notification-content').html('');
                            var ordercontent = `${ porduct_fake_data[i] }<span class="wlcross">&times;</span>`;
                            $('.woolentor-notification-content').append( ordercontent ).addClass('animated '+inanimation).removeClass(outanimation);

                            var notification = porduct_fake_data;
                            if ( notification != undefined ) {
                                setTimeout( function () { 
                                    $('.woolentor-notification-content').removeClass(inanimation).addClass(outanimation);
                                    i++;
                                }, showing_time );
                            }
                            
                        }, interval, porduct_fake_data );

                    }

                    // Close Button
                    $('.woolentor-notification-content').on('click', '.wlcross', function(e){
                        e.preventDefault()
                        $(this).closest('.woolentor-notification-content').removeClass(inanimation).addClass(outanimation);
                    });

                });
            </script>
        <?php 
    }

}

Woolentor_Sale_Notification::instance();