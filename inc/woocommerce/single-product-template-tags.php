<?php
/**
 * Template functions and filters used in Single Product
 *
 * @package electro
 */

if ( ! function_exists( 'electro_toggle_shop_sidebar' ) ) {
	/**
	 * [electro_toggle_shop_sidebar description]
	 * 
	 * @param  [type] $has_sidebar [description]
	 * @return [type]              [description]
	 */
	function electro_toggle_shop_sidebar( $has_sidebar ) {

		$layout = electro_get_shop_layout();

		if ( 'full-width' === $layout ) {
			
			$has_sidebar = false;
		
		} elseif ( 'right-sidebar' === $layout || 'left-sidebar' === $layout ) {

			$has_sidebar = true;
		
		}

		return $has_sidebar;
	}
}

if ( ! function_exists( 'electro_toggle_single_product_hooks' ) ) {
	function electro_toggle_single_product_hooks() {

		$style 	= electro_get_single_product_style();

		if ( 'extended' === $style ) {
			remove_action( 'woocommerce_single_product_summary', 		'electro_template_loop_availability',		10 );
			remove_action( 'woocommerce_single_product_summary', 		'electro_loop_action_buttons', 				15 );
			remove_action( 'woocommerce_single_product_summary', 		'woocommerce_template_single_price', 		25 );
			remove_action( 'woocommerce_single_product_summary', 		'electro_template_single_add_to_cart', 		30 );
			remove_action( 'woocommerce_single_product_summary', 		'electro_template_single_divider',			11 );
			remove_action( 'woocommerce_after_single_product_summary',	'woocommerce_output_product_data_tabs', 	10 );
			add_action( 'woocommerce_after_single_product_summary',		'electro_single_product_action', 			0  );
			add_action( 'woocommerce_after_single_product_summary',		'electro_output_product_data_tabs',			10 );
		}
	}
}

if ( ! function_exists( 'electro_product_description_tab' ) ) {
	function electro_product_description_tab() {
		echo '<div class="electro-description">';
		wc_get_template( 'single-product/tabs/description.php' );
		echo '</div>';
		woocommerce_template_single_meta();
	}
}

if ( ! function_exists( 'electro_get_single_product_style' ) ) {
	function electro_get_single_product_style() {
		
		$layout = electro_get_single_product_layout();
		$style 	= 'normal';

		if ( 'full-width' === $layout ) {
			$product_style = get_post_meta( get_the_ID(), '_product_style', true );
			$style = ! empty( $product_style ) ? $product_style : apply_filters( 'electro_single_product_layout_style', 'extended' );
		}

		return $style;
	}
}

if ( ! function_exists( 'electro_get_single_product_layout' ) ) {
	function electro_get_single_product_layout() {
		$layout = apply_filters( 'electro_single_product_layout', 'full-width' );

		$product_layout = get_post_meta( get_the_ID(), '_product_layout', true );
		if( ! empty( $product_layout ) ) {
			$layout = $product_layout;
		}

		return $layout;
	}
}

if ( ! function_exists( 'electro_product_accessories_tab' ) ) {
	function electro_product_accessories_tab() {
		electro_get_template( 'shop/single-product/tabs/accessories.php' );
	}
}

if ( ! function_exists( 'electro_product_specification_tab' ) ) {
	function electro_product_specification_tab() {
		electro_get_template( 'shop/single-product/tabs/specifications.php' );
	}
}

if ( ! function_exists( 'electro_output_product_data_tabs' ) ) {
	function electro_output_product_data_tabs() {
		electro_get_template( 'shop/single-product/tabs/electro-tabs.php' );
	}
}

if ( ! function_exists( 'electro_single_product_action' ) ) {
	function electro_single_product_action() {

		add_action( 'electro_single_product_action', 'electro_template_loop_availability',		10 );
		add_action( 'electro_single_product_action', 'woocommerce_template_single_price',		20 );
		add_action( 'electro_single_product_action', 'electro_template_single_add_to_cart', 	30 );
		add_action( 'electro_single_product_action', 'electro_loop_action_buttons',				40 );

		?>
		<div class="product-actions-wrapper">
			<div class="product-actions"><?php
		do_action( 'electro_single_product_action' );
		?></div>
		</div><?php
	}
}

if( ! function_exists( 'electro_template_single_add_to_cart' ) ) {
	function electro_template_single_add_to_cart() {
		global $product;
		
		if( electro_get_shop_catalog_mode() == false ) {
			do_action( 'woocommerce_' . $product->product_type . '_add_to_cart'  );
		} elseif( electro_get_shop_catalog_mode() == true && $product->is_type( 'external' ) ) {
			do_action( 'woocommerce_' . $product->product_type . '_add_to_cart'  );
		}
	}
}

if ( ! function_exists( 'electro_product_thumbnails_columns' ) ) {
	/**
	 * Sets Colums + Class for single product thumbnails
	 * 
	 * @param  int $columns
	 * @return string
	 */
	function electro_product_thumbnails_columns( $columns ) {
		if( is_product() ) {
			return '5';
		}

		return $columns;
	}
}

if ( ! function_exists ( 'electro_wrap_single_product' ) ) {
	/**
	 * 
	 */
	function electro_wrap_single_product() {
		?>
		<div class="single-product-wrapper">
		<?php
	}
}

if ( ! function_exists( 'electro_wrap_single_product_close' ) ) {
	/**
	 * 
	 */
	function electro_wrap_single_product_close() {
		?>
		</div><!-- /.single-product-wrapper -->
		<?php
	}
}

/*rawash*/
 
/* if ( ! function_exists( 'installment_add' ) ) {
	
	function installment_add() {
		?>
	<button 
		type="button" 
		name="add-to-cart" 
		value="<?php echo esc_attr( $product->id ); ?>"
		id="instalment" 
		class="single_add_to_cart_button button alt instalment"
		onclick="document.getElementById('installment_table').style.visibility='visible'" >
		<?php echo esc_html__( installment , electro); ?>
	</button>
		<div>
			<div id="installment_table" class="alert alert-success" style="visibility: hidden;" >
			<br>  
				<strong>Success!</strong> Indicates a successful or positive action.
							<?php  
							global $product;
							?>
							<p class="price"><?php echo $product->get_price_html(); ?></p>
							<?php

					 echo $product->price ;
					 
				
					 
							?>
							<body ng-app="installment">							
							<div ng-controller="ctrl">

							<div class="input-group input-group-lg">
								<!--<span class="input-group-addon" id="sizing-addon1">@</span>-->
								<p>Input something in the input box:</p>
								<input type="text" ng-model="inAdvance" class="form-control" placeholder="المقدم" aria-describedby="sizing-addon1">
							</div>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="true">
							اختار مدة القسط
							<span class="caret"></span>
							</button>
								<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li ng-repeat="dur in durs"><a ng-click="getper($index)" href="#">{{dur.monthes}} monthes</a></li>
									<!--<li role="separator" class="divider"></li>-->
									<!--<li><a href="#">Separated link</a></li>-->
								</ul>
							</div>

							<!--<p>Name: <input type="text"></p>-->
							<p>the rest amount : {{restAmount}}</p>
							<p>interest :  {{interest}}</p>
							<p>each month : {{eachMonth}}</p>


							<div class="alert alert-warning" ng-show="showAlert">
								<strong>تحزير!</strong> برجاء ادخال مبلغ اكبر من او يساوى 20% من المبلغ الاصلى.
							</div>

							</div>
							<script>
							angular.module('installment', [])
								.controller('ctrl', function ($scope) {
									$scope.per = 0;
									$scope.eachMonth = 0
									$scope.interest = 0
									$scope.restAmount = 0
									$scope.showAlert = false;
							///////////////////////////////////////////////////////////////
									$scope.durs = [{
										monthes: 6,
									}, {
										monthes: 12,
									}]

									$scope.categ = [{
										type: "air caonditaner",
										installmentDuration: [0.25, 0.35]
									}]
							//////////////////////////////////////////////////////
									$scope.getper = (idx) => {
										$scope.per = $scope.categ[0].installmentDuration[idx]
										$scope.monthes = $scope.durs[idx].monthes
										let amount = 5000;
										if ($scope.inAdvance > 0.2 * amount && $scope.inAdvance <  amount  ) {
											$scope.showAlert = false;

											$scope.restAmount = amount - $scope.inAdvance
											$scope.interest = $scope.restAmount * $scope.per
											$scope.eachMonth = ($scope.restAmount + $scope.interest) / $scope.monthes
										} else {
											$scope.showAlert = true;
										}
									}

								});
							</script>
							</body>						
  			</div>
		</div><!-- /.single-product-installment-wrapper -->
		<script>
		document.getElementById('installment_table').style.visibility='hiddin'
		</script>
		<?php
	}
}
  */

if ( ! function_exists ( 'electro_wrap_product_images' ) ) {
	/**
	 * 
	 */
	function electro_wrap_product_images() {
		?>
		<div class="product-images-wrapper">
		<?php
	}
}

if ( ! function_exists( 'electro_wrap_product_images_close' ) ) {
	/**
	 * 
	 */
	function electro_wrap_product_images_close() {
		?>
		</div><!-- /.product-images-wrapper -->
		<?php
	}
}

if ( ! function_exists( 'electro_template_single_brand' ) ) {
	/**
	 * 
	 */
	function electro_template_single_brand() {

		global $product;
	
		$product_id = isset($product_id) ? $product_id : $product->id;
		$brands_tax = electro_get_brands_taxonomy();
		$terms 		= get_the_terms( $product_id, $brands_tax );
		$brand_img 	= '';

		if ( $terms && ! is_wp_error( $terms ) ) {
			
			foreach ( $terms as $term ) {
				$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );

				if ( $thumbnail_id ) {
					$image_attributes = wp_get_attachment_image_src( $thumbnail_id, 'full' );
					
					if( $image_attributes ) {
						$image_src = $image_attributes[0];
					}
				} else {
					$image_src = wc_placeholder_img_src();
				}

				$image_src 	= str_replace( ' ', '%20', $image_src );
				$brand_img 	.= '<a href="' . esc_url( get_term_link( $term ) ). '"><img src="' . esc_url( $image_src ) . '" alt="' . esc_attr( $term->name ) . '" /></a>';
			}
		}

		if ( ! empty( $brand_img ) ) : ?>
		<div class="brand">
			<?php echo wp_kses_post( $brand_img ); ?>
		</div>
		<?php endif;
	}
}

if ( ! function_exists( 'electro_template_single_divider' ) ) {
	/**
	 * 
	 */
	function electro_template_single_divider() {
		?>
		<hr class="single-product-title-divider" />
		<?php
	}
}

if ( ! function_exists( 'electro_output_related_products' ) ) {
	function electro_output_related_products() {
		if ( apply_filters( 'electro_enable_related_products', true ) ) {
			woocommerce_output_related_products();
		}
	}
}