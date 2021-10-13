<?php

/**
 * This class is loaded on the back-end since its main job is 
 * to display the Admin to box.
 */

class GMWPLW_Admin {
	
	protected static $instance = NULL;


	public function __construct () {

		add_action('admin_enqueue_scripts', array($this, 'GMWPLW_scripts'));
		add_action( 'wp_ajax_gmwqp_change_cat', array( $this, 'gmwqp_change_cat' ));
		add_action( 'wp_ajax_nopriv_gmwqp_change_cat', array( $this, 'gmwqp_change_cat' ));
		add_action( 'wp_ajax_gmwqp_change_val', array( $this, 'gmwqp_change_val' ));
		add_action( 'wp_ajax_nopriv_gmwqp_change_val', array( $this, 'gmwqp_change_val' ));
	}

	public static function get_instance()
    {
        if ( NULL === self::$instance )
            self::$instance = new self;

        return self::$instance;
    }
	
	public function gmwqp_change_val() {
		$formid = $_REQUEST['formid'];
		$htmlfinal = '';
		$terms = get_terms( $_REQUEST['option'], array(
						    'hide_empty' => false,
						) );
		foreach ($terms as $key => $value) {
			$htmlfinal .= '<option value="'.$value->term_id.'" >'.$value->name.'</option>';
		}
		echo $htmlfinal ;
		
		exit;
	}


	public function gmwqp_change_cat() {

		echo $this->gmwqp_retun($_REQUEST['option'],$_REQUEST['formid']);
		exit;
	}
	public function GMWPLW_scripts(){
		wp_enqueue_script('gmwplw-script', GMWPLW_PLUGIN_URL . '/js/script.js', array(), '1.0.0', true );
		wp_localize_script( 'gmwplw-script', 'gmwplw_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	public function gmwqp_retun($type,$formid,$passdata=array(),$isedit=false){
		$htmlfinal ='';

		if($type=='taxonomy'){

			$taxonomies=get_object_taxonomies( 'product', 'objects' ); 
			//print_r($taxonomies);
			$taxc = array();
			foreach ($taxonomies as $key => $value) {
				if($value->show_ui){
					$taxc[$key] = $value->label;
				}
			}
			$htmlfinal = '<select class="gmwqp_leftoption" formid="'.$formid.'" type="'.$type.'" name="widget-gmwplw_products_list_widget_filter['.$formid.'][gmwplw_tax]">';
			$x = 1;
			foreach ($taxc as $key => $value) {
				if($x == 1 && $isedit==false){
					$terms = get_terms( $key, array(
							    'hide_empty' => false,
							) );
				}
				if($isedit==true){
					$terms = get_terms( $passdata['gmwplw_tax'], array(
							    'hide_empty' => false,
							) );
				}
				$x=2;
				$htmlfinal .= '<option value="'.$key.'" '.(($isedit==true && $key==$passdata['gmwplw_tax'])?'selected':'').'>'.$value.'</option>';
			}
			$htmlfinal .= '</select>';

			$htmlfinal .= '<select class="gmwqp_middeloption" name="widget-gmwplw_products_list_widget_filter['.$formid.'][gmwplw_type]">';
			$htmlfinal .= '<option value="equal" '.(($isedit==true && 'equal'==$passdata['gmwplw_type'])?'selected':'').'>=</option>';
			$htmlfinal .= '<option value="notequal" '.(($isedit==true && 'notequal'==$passdata['gmwplw_type'])?'selected':'').'>!=</option>';
			$htmlfinal .= '</select>';

			
			$htmlfinal .= '<select class="gmwqp_rightoption" name="widget-gmwplw_products_list_widget_filter['.$formid.'][gmwplw_val]">';
			foreach ($terms as $key => $value) {
				$htmlfinal .= '<option value="'.$value->term_id.'" '.(($isedit==true && $value->term_id==$passdata['gmwplw_val'])?'selected':'').'>'.$value->name.'</option>';
			}
			$htmlfinal .= '</select>';

		}
		return $htmlfinal;
	}

}

?>