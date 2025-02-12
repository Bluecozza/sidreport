<?php
if (!defined('ABSPATH')) {
    exit;
}

class SIDReport_Frontend {
    public function __construct() {
		add_shortcode('sidreport_form', [$this, 'render_form']);
        add_shortcode('sidreport_search', [$this, 'render_search_form']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
	}

    public function render_form() {
        ob_start();
        include SIDREPORT_PLUGIN_DIR . 'templates/form-report.php';
        return ob_get_clean();
    }
	
    // Menampilkan form pencarian
    public function render_search_form() {
        ob_start();
        ?>
        <div id="sidreport-search-container">
            <input type="text" id="sidreport-search-input" placeholder="Masukkan Account...">
            <button id="sidreport-search-btn">Cari</button>
            <div id="sidreport-search-results"></div>
        </div>
		<div id="sidreport-modal" class="sidreport-modal"></div>

        <?php
        return ob_get_clean();
    }

    // Load JavaScript dan CSS
    public function enqueue_scripts() {
        wp_enqueue_style('sidreport-style', plugins_url('../assets/css/style.css', __FILE__));
        wp_enqueue_script('sidreport-script', plugins_url('../assets/js/script.js', __FILE__), ['jquery'], null, true);
        wp_localize_script('sidreport-script', 'sidreport_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
        wp_enqueue_script('sidreport-frontend', plugins_url('../assets/js/sidreport-frontend.js', __FILE__), ['jquery'], null, true);
        wp_enqueue_style('sidreport-style', plugins_url('../assets/css/sidreport-style.css', __FILE__));

        wp_localize_script('sidreport-frontend', 'sidreport_ajax', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);	
	
	}


	
}

new SIDReport_Frontend();
