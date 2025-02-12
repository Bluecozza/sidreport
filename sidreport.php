<?php
/**
 * Plugin Name: SIDReport
 * Plugin URI: https://yourwebsite.com
 * Description: Plugin untuk mengecek dan melaporkan akun yang terindikasi scam atau penipuan.
 * Version: 1.0.0
 * Author: Nama Anda
 * Author URI: https://yourwebsite.com
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit;
}

// Definisikan path plugin
define('SIDREPORT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SIDREPORT_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load file yang diperlukan
require_once SIDREPORT_PLUGIN_DIR . 'includes/class-sidreport-db.php';
require_once SIDREPORT_PLUGIN_DIR . 'includes/class-sidreport-ajax.php';
require_once SIDREPORT_PLUGIN_DIR . 'includes/class-sidreport-admin.php';
require_once SIDREPORT_PLUGIN_DIR . 'includes/class-sidreport-frontend.php';

// Inisialisasi Database saat aktivasi
register_activation_hook(__FILE__, ['SIDReport_DB', 'install']);
