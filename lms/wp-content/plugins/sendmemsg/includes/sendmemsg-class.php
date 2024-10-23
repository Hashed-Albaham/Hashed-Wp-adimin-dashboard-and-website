<?php

/**
 * Adds Foo_Widget widget.
 */

//   var win = window.open(`https://wa.me/${num}?text=I%27m%20api%20msg%20hello%20${name}%20friend%20${msg}`, '_blank');

class SendMe_Msg_Widget extends WP_Widget
{

	/**
	 * Register widget with WordPress.
	 */
	function __construct()
	{
		parent::__construct(
			'sendmemsg_widget', // Base ID
			esc_html__('SendMeMsg Button', 'sendMeMsg_domain'), // Name
			array('description' => esc_html__('widget to send whatsapp msg', 'sendMeMsg_domain'),) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance)
	{
		echo $args['before_widget']; // whatever i want to display before widget(<div>, etc)

		if (!empty($instance['title'])) {
		}
		// widget Content Output

		echo "<form id='sendMsgOnForm'action='https://wa.me/" . $instance['yNumber'] . "'> 
                          <input id='sendMsgOn' type='submit' name='submit' value='" . $instance['title'] . "'>
                 </form>";
		echo $args['after_widget']; // whatever i want to display after widget(</div>, etc)
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance)
	{
		$title = !empty($instance['title']) ? $instance['title'] : esc_html__('MyButton', 'sendMeMsg_domain');
		$yNumber = !empty($instance['yNumber']) ? $instance['yNumber'] : esc_html__('972502244482', 'yNumber_domain');

?>

		<!-- Title -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Button Title:', 'sendMeMsg_domain'); ?>

			</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('yNumber')); ?>"><?php esc_attr_e('Your Number', 'yNumber_domain'); ?>

			</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('yNumber')); ?>" name="<?php echo esc_attr($this->get_field_name('yNumber')); ?>" type="text" value="<?php echo esc_attr($yNumber); ?>">
		</p>
<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = array();

		$instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
		$instance['yNumber'] = (!empty($new_instance['yNumber'])) ? sanitize_text_field($new_instance['yNumber']) : '';

		return $instance;
	}
} // class Foo_Widget