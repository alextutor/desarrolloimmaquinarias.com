<?php
/*
*
* Products By Category Widget
*
*/

if (!defined('ABSPATH')) {
	exit;
}

class GMWPLW_Product_List_Filter_Widget extends WP_Widget {
	function __construct() {

		parent::__construct(
			'gmwplw_products_list_widget_filter',
			__('GM Woo Product list Widget', 'gmwplw') ,
			array(
				'description' => __('Woocommerce Product list Widget with filter.', 'gmwplw')
				));
		
	}

	function form($instance) {
		$cat = $instance['cat'];
		$gmwplw_tax = $instance['gmwplw_tax'];
		$gmwplw_type = $instance['gmwplw_type'];
		$gmwplw_val = $instance['gmwplw_val'];
		$posts = $instance['posts'];
		$orderby = $instance['orderby'];
		$order = $instance['order'];
		$thumbs = $instance['thumbs'];

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Products By Category', 'gmwplw' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>">Type</label>
			<select class='widefat changecat' formid="<?php echo $this->number;?>" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>">
				<option value="all"  <?php echo ($cat == 'all') ? 'selected' : ''; ?>>All</option>
				<option value="taxonomy"  <?php echo ($cat == 'taxonomy') ? 'selected' : ''; ?>>Taxonomy</option>
				<option value="featured"  <?php echo ($cat == 'featured') ? 'selected' : ''; ?>>Featured</option>
				<option value="sale"  <?php echo ($cat == 'sale') ? 'selected' : ''; ?>>On-sale</option>
				<option value="bestsellers"  <?php echo ($cat == 'bestsellers') ? 'selected' : ''; ?>>Best sellers</option>
				
			</select>
		</p>
		<div class="showonchangec">
			<?php
			$passdata = array(
				"gmwplw_tax" =>$gmwplw_tax,
				"gmwplw_type" =>$gmwplw_type,
				"gmwplw_val" =>$gmwplw_val,
			);
			
			 echo GMWPLW_Admin::get_instance()->gmwqp_retun($cat,$this->number,$passdata,true);
			?>
		</div>
		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>">Products Shown</label>
			<br/><small>Leave blank to show all products.</small>
			<input class="widefat" type="number" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo esc_attr($posts); ?>">
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'thumbs' ); ?>" name="<?php echo $this->get_field_name( 'thumbs' ); ?>" type="checkbox" value="1" <?php checked( $thumbs, 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'thumbs' ); ?>">Show product thumbnails?</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">Order By</label>
			<select class='widefat' id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
				<option value='post_title' <?php echo ($orderby == 'post_title') ? 'selected' : ''; ?>>Product Name</option>
				<option value='id' <?php echo ($orderby == 'id') ? 'selected' : ''; ?>>Product ID</option>
				<option value='date' <?php echo ($orderby == 'date') ? 'selected' : ''; ?>>Date Published</option>
				<option value='modified' <?php echo ($orderby == 'modified') ? 'selected' : ''; ?>>Last Modified</option>
				<option value='rand' <?php echo ($orderby == 'rand') ? 'selected' : ''; ?>>Random</option>
				<option value='none' <?php echo ($orderby == 'none') ? 'selected' : ''; ?>>None</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>">Order</label>
			<select class='widefat' id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value='ASC' <?php echo ($order == 'ASC') ? 'selected' : ''; ?>>Ascending (A to Z)</option>
				<option value='DESC' <?php echo ($order == 'DESC') ? 'selected' : ''; ?>>Descending (Z to A)</option>
			</select>
		</p>
		
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['gmwplw_tax'] = strip_tags($new_instance['gmwplw_tax']);
		$instance['gmwplw_type'] = strip_tags($new_instance['gmwplw_type']);
		$instance['gmwplw_val'] = strip_tags($new_instance['gmwplw_val']);
		$instance['posts'] = strip_tags($new_instance['posts']);
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['thumbs'] = isset( $new_instance['thumbs'] ) ? 1 : false;

		return $instance;
	}

	function widget($args, $instance) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( !empty( $title )) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		$defaults = array(
			'cat' => 'all',
			'posts' => '-1',
			'orderby' => 'name',
			'order' => 'ASC',
			'thumbs' => ''
			);
		if (empty($instance['posts'])) {
			$instance['posts'] = $defaults['posts'];
		}

		if (empty($instance['orderby'])) {
			$instance['orderby'] = $defaults['orderby'];
		}

		if (empty($instance['order'])) {
			$instance['order'] = $defaults['order'];
		}

		?>
		<ul class="productsbycat_list woocommerce  productsbycat_<?php echo $instance['cat']; ?>">
			<?php
			$arggs = array(
				'post_type' => 'product',
				'posts_per_page' => $instance['posts'],
				'orderby' => $instance['orderby'],
				'order' => $instance['order'],
				'thumbs' => $instance['thumbs']
				);
			if($instance['cat']=='taxonomy'){
				$tacar = array(
										        'taxonomy'      => $instance['gmwplw_tax'],
										        'field'         => 'term_id', 
										        'terms'         => array($instance['gmwplw_val']),
									   		 );
				if($instance['gmwplw_type']=='notequal'){
					$tacar['operator'] = 'NOT IN';
				}
				
				$arggs['tax_query'] = array(
						                $tacar
						            );
			}
			if($instance['cat']=='featured'){
				$arggs['tax_query'] = array(
						                array(
						                    'taxonomy' => 'product_visibility',
						                    'field'    => 'name',
						                    'terms'    => 'featured',
						                ),
						            );
			}
			if($instance['cat']=='bestsellers'){
				$arggs['meta_query'] = array(
						                array(
						                    'taxonomy' => 'product_visibility',
						                    'field'    => 'name',
						                    'terms'    => 'featured',
						                ),
						            );
			}
			
			if($instance['cat']=='sale'){
				$arggs['meta_query']     = array(
										            array( 
										                'key'           => 'total_sales',
										                'value'         => 0,
										                'compare'       => '>',
										                'type'          => 'numeric'
										                )
										            );
			}
			$loop = new WP_Query($arggs);
			while ($loop->have_posts()):
				$loop->the_post();
			global $product; 
			$producta = wc_get_product( $loop->post->ID );

			?>
			<li class="gmwplw-product">
				<a href="<?php	echo get_permalink($loop->post->ID) ?>" title="<?php	echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID) ?>">
					<?php

					if ($instance['thumbs'] == '1') {
						$isthem = get_the_post_thumbnail_url($loop->post->ID, 'thumbnail');
						if ($isthem!='') {
						
						?>
						<div class="lefmss"><img src="<?php echo $isthem; ?>" alt="Placeholder" width="40" height="40" /></div>
						<?php
						} else { ?>
							<div class="lefmss"><img src="<?php echo woocommerce_placeholder_img_src('thumbnail') ?>" alt="Placeholder" width="40" height="40" /></div>
						<?php }
						}
						$averagea = $producta->get_average_rating();
			?>
			<div class="rightss">
			<div class="gmwproduct-title"><?php echo $loop->post->post_title;	?></div>
			<?php
			if($averagea!=0){
			?>
			<div class="gmproduct-rating"><?php echo '<div class="star-rating"><span style="width:'.( ( $averagea / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$averagea.'</strong> '.__( 'out of 5', 'woocommerce' ).'</span></div>';	?></div>
			<?php
			}
			?>
			<div class="gmproduct-price"><?php echo $producta->get_price_html();	?></div>

			</div>

			</a>
		</li>
		<?php
		endwhile;
		wp_reset_query();
		?>
	</ul>
	<?php
	echo $args['after_widget'];
}
}

add_action( 'widgets_init', 'GMWPLW_product_by_filter_widget' );
function GMWPLW_product_by_filter_widget () {

		register_widget('GMWPLW_Product_List_Filter_Widget');
}