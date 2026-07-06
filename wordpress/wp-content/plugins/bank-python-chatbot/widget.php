<?php
/**
 * Widget Class
 */
class Bank_Python_Chatbot_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'bank_python_chatbot_widget',
            __('Bank Python Chatbot', 'bank-python-chatbot'),
            ['description' => __('Hiển thị chatbot AI trong sidebar/footer', 'bank-python-chatbot')]
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $height = !empty($instance['height']) ? $instance['height'] : '450px';
        
        echo do_shortcode('[bank_chatbot height="' . esc_attr($height) . '" title="' . esc_attr($instance['chat_title'] ?? 'BankBot') . '"]');
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Chatbot', 'bank-python-chatbot');
        $chat_title = !empty($instance['chat_title']) ? $instance['chat_title'] : __('Ngân Hàng BankBot', 'bank-python-chatbot');
        $height = !empty($instance['height']) ? $instance['height'] : '450px';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('Widget Title:', 'bank-python-chatbot'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('chat_title')); ?>">
                <?php _e('Chat Header Title:', 'bank-python-chatbot'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('chat_title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('chat_title')); ?>" 
                   type="text" value="<?php echo esc_attr($chat_title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('height')); ?>">
                <?php _e('Chat Height:', 'bank-python-chatbot'); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('height')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('height')); ?>" 
                   type="text" value="<?php echo esc_attr($height); ?>" placeholder="500px">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['chat_title'] = (!empty($new_instance['chat_title'])) ? strip_tags($new_instance['chat_title']) : '';
        $instance['height'] = (!empty($new_instance['height'])) ? strip_tags($new_instance['height']) : '450px';
        return $instance;
    }
}