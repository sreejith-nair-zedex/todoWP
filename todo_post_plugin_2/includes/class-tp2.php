<?php

defined('ABSPATH') || exit();

if (!class_exists('TodoPost2')){
    class TodoPost2{
        protected static $instancee;
        public $tp2TaskPost;
        public $tp2ShortCode;
//        public $tp2MetaBox;

        public function __construct(){
            add_action( 'plugins_loaded', array($this, 'initialize'), 20);
        }

        public static function getInstance(){
            if (self::$instancee === null){
                self::$instancee = new self();
            }
            return self::$instancee;
        }

        public function initialize(){
            $this->includes();
            $this->init();
        }

        public function includes(){
            include_once TODOPOST2_INCLUDES_DIR . 'class-tp2-post.php';
//            include_once TODOPOST2_INCLUDES_DIR . 'class-tp2-metabox.php';
            include_once TODOPOST2_INCLUDES_DIR . 'class-tp2-shortcodes.php';
            include_once TODOPOST2_INCLUDES_DIR . 'class-tp2-handlers.php';
        }

        public function init(){
            $this->tp2TaskPost = Tp2CustomPost::getInstance();
//            $this->tp2MetaBox = Tp2Metabox::getInstance();
            $this->tp2ShortCode = Tp2Shortcodes::getInstance();
        }
    }
}