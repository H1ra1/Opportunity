<?php if(! defined('ABSPATH')){ return; }

/**
 * Categories widget class
 *
 * @since 2.8.0
 */
class ZN_Widget_Categories extends WP_Widget
{

	function __construct()
	{
		$widget_ops = array ( 'classname'   => 'widget_categories',
							  'description' => __( "A list or dropdown of categories", 'zn_framework' )
		);
		parent::__construct( 'categories', __( 'Categories', 'zn_framework' ), $widget_ops );
	}

	function widget( $args, $instance )
	{
		$before_widget = $before_title = $after_title =  $after_widget = '';

		extract( $args );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories', 'zn_framework' ) : $instance['title'], $instance, $this->id_base );
		$c     = ! empty( $instance['count'] ) ? '1' : '0';
		$h     = ! empty( $instance['hierarchical'] ) ? '1' : '0';
		$d     = ! empty( $instance['dropdown'] ) ? '1' : '0';

		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		$cat_args = array ( 'orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h );

		if ( $d ) {
			$cat_args['show_option_none'] = __( 'Select Category', 'zn_framework' );
			wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
			?>
			<script type='text/javascript'>
				var dropdown = document.getElementById("cat");
				function onCatChange(){
					if (dropdown.options[dropdown.selectedIndex].value > 0) {
						location.href = "<?php echo home_url(); ?>/?cat=" + dropdown.options[dropdown.selectedIndex].value;
					}
				}
				dropdown.onchange = onCatChange;
			</script>
		<?php
		}
		else {
			?>
			<ul class="menu">
				<?php
					$cat_args['title_li'] = '';
					wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
				?>
			</ul>
		<?php
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance )
	{
		$instance                 = $old_instance;
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;
		$instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? 1 : 0;
		$instance['dropdown']     = ! empty( $new_instance['dropdown'] ) ? 1 : 0;

		return $instance;
	}

	function form( $instance )
	{
		//Defaults
		$instance     = wp_parse_args( (array) $instance, array ( 'title' => '' ) );
		$title        = esc_attr( $instance['title'] );
		$count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown     = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'zn_framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"
				  name="<?php echo esc_attr( $this->get_field_name( 'dropdown' ) ); ?>"<?php checked( $dropdown ); ?> />
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"><?php _e( 'Display as dropdown', 'zn_framework' ); ?></label><br/>

<?php /*
	<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"<?php checked( $count ); ?> />
	<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Show post counts', 'zn_framework' ); ?></label><br />
*/ ?>
			<input type="hidden" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" value="0"/>

			<input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hierarchical' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'hierarchical' ) ); ?>"<?php checked( $hierarchical ); ?> />
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'hierarchical' ) ); ?>"><?php _e( 'Show hierarchy', 'zn_framework' ); ?></label>
		</p>
	<?php
	}
}
function register_widget_ZN_Widget_Categories(){
	register_widget( "ZN_Widget_Categories" );
}

add_action( 'widgets_init', 'register_widget_ZN_Widget_Categories' );
