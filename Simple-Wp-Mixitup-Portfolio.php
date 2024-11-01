<?php 
/*
plugin name: Simple Wp Mixitup Portfolio
Author: nayon46
Author uri: http://www.nayonbd.com
description:Simple Mixitup Portfolio allows you to create a very modern and outstanding portfolio which filters instantly using jQuery animations
version:1.0
*/
class Swmp_main_class{

	public function __construct(){

		add_action('wp_enqueue_scripts',array($this,'Swmp_script_portfolio_area'));
	    add_action('init',array($this,'Swmp_custom_area_portfolio_site'));
	    add_shortcode('simple-portfolio',array($this,'Swmp_advanced_portfolio_section'));

	}
	public function Swmp_script_portfolio_area(){

		wp_enqueue_style('portfolio',PLUGINS_URL('css/portfolio.css',__FILE__));
		wp_enqueue_script('portfolio-js',PLUGINS_URL('js/jquery.mixitup.min.js',__FILE__),array('jquery'));
		wp_enqueue_script('portfolio',PLUGINS_URL('js/portfolio.js',__FILE__),array('jquery','portfolio-js'));

	}

	public function Swmp_custom_area_portfolio_site(){

		load_plugin_textdomain('Swmp_custom_textdomain', false, dirname( __FILE__).'/lang');
		register_post_type('simple-portfolio',array(
			'labels'=>array(
				'name'=>'Portfolio',
				'add_new_item'=>'add new protfolio',
				'add_new'=>'add protfolio'
			),
			'public'=>true,
			'supports'=>array('title','editor','thumbnail'),
			'menu_icon'=>'dashicons-format-gallery'
		));

	register_taxonomy('advanced_taxonomoy','simple-portfolio',array(
			'labels'=>array(
				'name'=>'category'
			),
			'public'=>true,
			'hierarchical'=>true
		));
	}

	public function Swmp_advanced_portfolio_section(){
		ob_start();
		?>
		
	<!-- Portfolio Section Start  -->
	<section class="portfolio padding-top">
		<div class="mixiarea">
			<div class="mixifilter">
					<div class="controls">
					    <button class="filter " data-filter="all">Show all</button>
							<?php $portfolio_types= get_terms('advanced_taxonomoy'); 
								foreach($portfolio_types as $portfolio) :
							?>
					    			<button class="filter" data-filter=".<?php echo  $portfolio->slug;  ?>"><?php echo  $portfolio->name;  ?></button>
							<?php endforeach; ?>			
					</div>
			</div>
		<!-- WORK ITEM -->
		<div id="Containerrr" class="containerr">
			<?php $advanced= new wp_Query(array(
				'post_type'=>'advanced-portfolio',
				'posts_per_page'=>-1
			));
			while( $advanced->have_posts() ) : $advanced->the_post();
			$terms_area = get_the_terms(get_the_id(),'advanced_taxonomoy');
			$terms   = array();
			foreach($terms_area as $term) :
			$terms[] = $term->slug;
			 ?>
			<?php endforeach; ?>
			<div class="max-total-area">
				<!-- WORK ITEM -->
				<div class="mix <?php echo implode(' ',$terms); ?>">
					<div class="grid gird-area new-gird">
						<a href="#"><figure class="effect-apollo">
							<?php the_post_thumbnail(); ?>
							<figcaption>
								<p><span><?php echo $term->name; ?></span></p>
							</figcaption>

						</figure></a>
					</div>
					<div class="max-content-area"> 
					<div class="content-area"> 
						<h1><?php the_title(); ?></h1>
						<p><?php the_content(); ?></p>
					</div>
					</div>
				</div>
				<!-- END / WORK ITEM -->
           </div>
		<?php  endwhile;  ?>
			</div>
		</div>
	</section> <!-- /portfolio -->
	<!-- Portfolio Section End  -->
		<?php return ob_get_clean();
	}
}
new Swmp_main_class();

















