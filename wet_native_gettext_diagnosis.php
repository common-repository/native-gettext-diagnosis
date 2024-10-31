<?php
/*
Plugin Name: Native gettext diagnosis
Plugin URI: http://talkpress.de/artikel/webspace-wordpress-langsam-deutsch
Description: Diagnose a server's capabilities to use the native gettext library for translations.
Author: Robert Wetzlmayr
Version: 1.3
Author URI: http://wetzlmayr.com/
License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
*/


class wet_native_gettext_diagnosis {
	function wet_native_gettext_diagnosis() {
		if (is_admin()) {
			load_plugin_textdomain('wet_native_gettext_diagnosis', false, dirname(plugin_basename(__FILE__)));
			add_action('admin_menu', array($this, 'admin_menu'));
		}
	}

	function admin_menu() {
    	add_submenu_page('tools.php',
    		__('Native gettext diagnosis', __CLASS__),
    		__('Gettext diags', __CLASS__),
		    'update_core', __FILE__, array($this, 'diag_panel'));
	}

	function diag_panel() {
		global $locale;

		$td =  __CLASS__;

		$diags[__('PHP gettext extension', $td)] = extension_loaded('gettext') ? __('Loaded', $td) : __('Not loaded', $td);
		$diags[__('WordPress locale', $td)] = $locale;
		$l = setlocale (LC_ALL, "0");
		$diags[__('Current system locales', $td)] = '<ul><li>'.join('</li><li>', explode(';', $l)).'</li></ul>';
		$diags[__('WordPress may set new system locale', $td)] = (setlocale (LC_ALL, $locale) == $locale) ? __('Yes',  $td) : __('No' , $td);

		if(!empty($l)) setlocale (LC_ALL, $l);

?>
<div class="wrap">
<h2><?php _e('Diagnosis results', __CLASS__); ?></h2>

<table class="widefat wp-list-table">
	<thead>
		<tr>
			<th><?php _e('Test', __CLASS__); ?></th>
			<th class="sortable"><?php _e('Result', __CLASS__); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($diags as $test => $result): ?>
		<tr>
			<td><?php _e($test, 'wet_native_gettext_diagnosis'); ?></td>
			<td><?php _e($result); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
<?php
	} // diag_pane
}
new wet_native_gettext_diagnosis();
