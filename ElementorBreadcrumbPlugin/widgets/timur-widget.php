<?php
class Timur_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'TimurName';
	}

	public function get_title() {
		return __( 'breadcrumbs');
	}

	public function get_icon() {
		return 'fas fa-ankh';
	}

	public function get_categories() {
		return [ 'general' ];
	}
	
	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content'),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'var1',
			[
				'label' => __( 'Separator'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'default: »'),
			]
		);
		
		$this->add_control(
			'var2',
			[
				'label' => __( 'Home Page title'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'default: Home'),
			]
		);

		$this->end_controls_section();
	}

    public function breadcrumbs($separator = ' » ', $home = 'Главная') {

        $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        $base_url = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
        $breadcrumbs = array("<a href=\"$base_url\">$home</a>");

        $last = end( array_keys($path) );

        foreach( $path as $x => $crumb ){
            $title = ucwords(str_replace(array('.php', '_'), Array('', ' '), $crumb));
            if( $x != $last ){
                $breadcrumbs[] = '<a href="'.$base_url.$crumb.'">'.$title.'</a>';
            }
            else {
                $breadcrumbs[] = $title;
            }
        }

        return implode( $separator, $breadcrumbs );
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ($settings['var1']=="" ) $settings['var1']=' » ';
        if ($settings['var2']=="" ) $settings['var2']=' Home ';
        echo $this->breadcrumbs($settings['var1'], $settings['var2']);
	}

	protected function _content_template() {}

}
