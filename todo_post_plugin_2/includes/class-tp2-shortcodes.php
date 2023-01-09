<?php
defined('ABSPATH') || exit();

if (!class_exists('Tp2Shortcodes')){
    class Tp2Shortcodes{
        protected static $instance;
        protected $shortcodes = array();

        public function __construct(){
            add_action('wp_enqueue_scripts',[$this,'enqueueScripts']);
            $this->registerShortCode();
        }

        public static function getInstance(){
            if (self::$instance === null){
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function enqueueScripts(){
//            if (is_archive()){
                wp_enqueue_style('BootstrapCSS','https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css');
                wp_enqueue_style('Font Awesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
//                wp_enqueue_style('DataTableCSS','//cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css');
//                wp_enqueue_script('DataTableJs','//cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.js',array('jQuery'));
                wp_enqueue_script('BootstrapJS','https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js');
//                wp_enqueue_script('jQuery','//code.jquery.com/jquery-3.6.3.min.js');
//            }
        }

        public function registerShortCode() {
            $this->shortcodes = [
                'task' => [ $this, 'loadTemplate' ]
            ];
            foreach ( $this->shortcodes as $key => $value ) {
                add_shortcode( $key, $value );
            }
        }

        public function loadTemplate(){
            load_template(TODOPOST2_TEMPLATES_DIR . 'template-view-task.php',true);
        }
    }
}