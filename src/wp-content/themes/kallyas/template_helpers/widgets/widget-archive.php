<?php if(! defined('ABSPATH')){ return; }

/**
 * Archives widget class
 *
 * @since 2.8.0
 */
class ZN_Widget_Archives extends WP_Widget
{

	function __construct()
	{
		$widget_ops = array ( 'classname'   => 'widget_archive',
							  'description' => __( 'A monthly archive of your site&#8217;s posts', 'zn_framework' )
		);
		parent::__construct( 'archives', __( 'Archives', 'zn_framework' ), $widget_ops );
	}

	function widget( $args, $instance )
	{
		$before_widget = $before_title = $after_title =  $after_widget = '';

		extract( $args );
		$c     = ! empty( $instance['count'] ) ? '1' : '0';
		$d     = ! empty( $instance['dropdown'] ) ? '1' : '0';
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Archives', 'zn_framework' ) : $instance['title'], $instance, $this->id_base );

		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $d ) {
			?>
			<select name="archive-dropdown"
					onchange='document.location.href=this.options[this.selectedIndex].value;'>
				<option value=""><?php echo esc_attr( __( 'Select Month', 'zn_framework' ) ); ?></option>
				<?php wp_get_archives( apply_filters( 'widget_archives_dropdown_args', array (
					'type'            => 'monthly',
					'format'          => 'option',
					'show_post_count' => $c
				) ) ); ?> </select>
		<?php
		}
		else {
			?>
			<ul class="menu">
				<?php wp_get_archives( apply_filters( 'widget_archives_args', array (
					'type'            => 'monthly',
					'show_post_count' => $c
				) ) ); ?>
			</ul>
		<?php
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance )
	{
		$instance             = $old_instance;
		$new_instance         = wp_parse_args( (array) $new_instance, array (
			'title'    => '',
			'count'    => 0,
			'dropdown' => ''
		) );
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['count']    = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

		return $instance;
	}

	function form( $instance )
	{
		$instance = wp_parse_args( (array) $instance, array ( 'title' => '', 'count' => 0, 'dropdown' => '' ) );
		$title    = strip_tags( $instance['title'] );
		$count    = $instance['count'] ? 'checked="checked"' : '';
		$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'zn_framework' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>"/></p>
		<p>
			<input class="checkbox" type="checkbox" <?php echo $dropdown; ?>
				   id="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'dropdown' ) ); ?>"/> <label
				for="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"><?php _e( 'Display as dropdown', 'zn_framework' ); ?></label>
			<br/>
<?php /*
		<input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" /> <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Show post counts', 'zn_framework' ); ?></label>
*/ ?>
			<input class="hidden" type="checkbox" value='0' id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"/>
		</p>
	<?php
	}
}
function register_widget_ZN_Widget_Archives(){
	register_widget( "ZN_Widget_Archives" );
}
add_action( 'widgets_init', 'register_widget_ZN_Widget_Archives' );
