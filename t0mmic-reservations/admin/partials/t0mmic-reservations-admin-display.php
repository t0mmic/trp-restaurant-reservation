<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       t0mmic.cz
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/admin/partials
 */

 /**
	* Display a custom menu page
	*/

	function t0mmic_reservations_reservations(){

		$tblsett = get_option('t0mmic_reservation');

	?>
	<div id="screen-meta" class="metabox-prefs">
		<div id="screen-options-wrap" class="hidden" tabindex="-1" style="display: block;">
			<form id="adv-settings" method="post">
					<fieldset class="metabox-prefs">
						<legend><?php echo __("Columns", "t0mmic-reservations"); ?></legend>
						<input name="table_select[rdate]" type="hidden" value="0">
						<input name="table_select[timefrom]" type="hidden" value="0">
						<input name="table_select[timeto]" type="hidden" value="0">
						<input name="table_select[places]" type="hidden" value="0">
						<input name="table_select[firstname]" type="hidden" value="0">
						<input name="table_select[surname]" type="hidden" value="0">
						<input name="table_select[phone]" type="hidden" value="0">
						<input name="table_select[email]" type="hidden" value="0">
						<input name="table_select[status]" type="hidden" value="0">
						<input name="table_select[disapprove]" type="hidden" value="0">
						<input name="table_select[note]" type="hidden" value="0">
						<label><input name="table_select[rdate]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['rdate'], 1 ); ?>><?php echo __("Date:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[timefrom]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['timefrom'], 1 ); ?>><?php echo __("Time from:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[timeto]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['timeto'], 1 ); ?>><?php echo __("Time To:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[places]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['places'], 1 ); ?>><?php echo __("Party:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[firstname]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['firstname'], 1 ); ?>><?php echo __("Firstname:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[surname]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['surname'], 1 ); ?>><?php echo __("Surname:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[phone]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['phone'], 1 ); ?>><?php echo __("Phone:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[email]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['email'], 1 ); ?>><?php echo __("Email:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[status]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['status'], 1 ); ?>><?php echo __("Condition:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[disapprove]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['disapprove'], 1 ); ?>><?php echo __("Disapproved:", "t0mmic-reservations"); ?></label>
						<label><input name="table_select[note]" type="checkbox" value="1" <?php checked( $tblsett['table_select']['note'], 1 ); ?>><?php echo __("Notes:", "t0mmic-reservations"); ?></label>
					</fieldset>
					<fieldset class="screen-options">
						<legend><?php echo __("Pagination", "t0mmic-reservations"); ?></legend>
						<label for="edit_page_per_page"><?php echo __("Number of items per page:", "t0mmic-reservations"); ?></label>
						<input type="number" step="1" min="1" max="999" name="screen_options" id="per_page" maxlength="3" value="<?php if (isset($tblsett['screen_options'])){ echo $tblsett['screen_options'];} ?>">
					</fieldset>
					<fieldset class="hiden-options">
						<legend><?php echo __("Hidden rows", "t0mmic-reservations"); ?></legend>
						<input name="hide_disapproved" type="hidden" value="0">
						<label><input name="hide_disapproved" type="checkbox" value="1" <?php checked( $tblsett['hide_disapproved'], 1 ); ?>><?php echo __("Hide disapproved reservations:", "t0mmic-reservations"); ?></label>
					</fieldset>
					<p class="submit"><input type="submit" name="options-apply" id="options-apply" class="button button-primary" value="<?php echo __("Apply", "t0mmic-reservations"); ?>"></p>
			 </form>
		</div>
</div>
<div id="screen-meta-links">
		<div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
			<button type="button" id="show-settings-link" class="button show-settings" aria-controls="screen-options-wrap" aria-expanded="false">Nastavení zobrazených informací</button>
		</div>
</div>

	<!-- The Modal -->
	<div id="trp-addForm" class="trp-modal">
	  <div class="trp-modal-content">
	    <span class="trp-x">&times;</span>
			<form id="trp-modal-form" action="" method="POST">
		    <input type="text" class="trp-brdr" value="<?php echo __("Date:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="date" name="rdate" required/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Time from:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="time" name="timefrom" required/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Time To:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="time" name="timeto" required/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Party:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="text" name="places" required/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Firstname:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="text" name="firstname"/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Surname:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="text" name="surname" required/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Phone:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="text" name="phone" required/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Email:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="text" name="email"/><br/>
				<input type="text" class="trp-brdr" value="<?php echo __("Notes:", "t0mmic-reservations"); ?>"/><input class="trp-input" type="text" name="note"/><br/>
				<input type="hidden" name="status" value="0"/>
				<input type="text" class="trp-brdr" value="<?php echo __("Condition:", "t0mmic-reservations"); ?>"/><input class="trp-input-checkbox" type="checkbox" name="status" value="1"/><br/>
				<input id="trp_update_reservation" type="submit" class="trp-input-form" value="<?php echo __("Save"); ?>">
			</form>
	  </div>
	</div>

	<div class="wrap">

			<h1 class="wp-heading-inline"><?php echo __("Reservations:", "t0mmic-reservations"); ?></h1>
			<a id="trp-modal" class="page-title-action"><?php echo __("Add new reservation", "t0mmic-reservations"); ?></a>

			<hr class="wp-header-end">

			<p class="search-box">
				<input type="search" id="trp-search" name="s" value="" title="<?php echo __("Not return results from Date, Time, Party size, Condition and Disapproved.", "t0mmic-reservations"); ?>" placeholder="<?php echo __("'Whole' table filter...", "t0mmic-reservations"); ?>">
			</p>

			<div class="tablenav top">
				<div class="alignleft actions bulkactions" style="margin-right:20px">
					<label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __("Select an action for bulk editing"); ?></label>
						<select name="action" id="bulk-action-selector-top">
						  <option value="-1"><?php echo __("Bulk Actions"); ?></option>
							<option value="disapprove"><?php echo __("Disapproved"); ?></option>
							<option value="status"><?php echo __("Approve"); ?></option>
							<option value="delete"><?php echo __("Delete"); ?></option>
						</select>
						<input id="trp_bulk_action" type="submit" class="button action" value="Použít">
				</div>

				<div class="alignleft actions">
					<label for="trp-dateFilter" class="screen-reader-text"><?php echo __("From Date:", "t0mmic-reservations"); ?></label>
					<input type="date" id="trp-dateFilter" value="<?php if (!isset($_GET['val'])){echo date('Y-m-d');} else {echo $_GET['val'];} ?>" title="<?php echo __("View from selected date.", "t0mmic-reservations"); ?>">
					<label for="trp-timeFilter" class="screen-reader-text"><?php echo __("Time occupancy:", "t0mmic-reservations"); ?></label>
					<input type="time" id="trp-timeFilter" value="<?php if (isset($_GET['time'])){echo $_GET['time'];} ?>" title="<?php echo __("Searches booking time just in one selected day.", "t0mmic-reservations"); ?>">
					<label for="trp-refresh" class="screen-reader-text"><?php echo __("Clear filter:", "t0mmic-reservations"); ?></label>
					<input type="submit" id="trp-refresh" class="button action" onClick="window.location.href='admin.php?page=trp-reservations&val=<?php echo date('Y-m-d'); ?>'" value="<?php echo __("Clear filter", "t0mmic-reservations"); ?>">
					<div id="message"></div>
				</div>

			</div>

			<table class="wp-list-table widefat fixed">
				<thead>
					<tr>
						<td class="manage-column column-cb check-column">
							<label class="screen-reader-text" for="cb-select-all-1"><?php echo __("Select all", "t0mmic-reservations"); ?></label>
							<input id="cb-select-all-1" type="checkbox">
						</td>
						<?php	if ($tblsett['table_select']['rdate'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=rdate&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Date", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['timefrom'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=timefrom&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Time from", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['timeto'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=timeto&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Time to", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['places'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Party size", "t0mmic-reservations"); ?></th>
						<?php	}
						if ($tblsett['table_select']['firstname'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=firstname&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Firstname", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['surname'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=surname&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Surname", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['phone'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=phone&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Phone", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['email'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable desc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=email&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Email", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['status'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Condition", "t0mmic-reservations"); ?></th>
						<?php	}
						if ($tblsett['table_select']['disapprove'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Disapproved", "t0mmic-reservations"); ?></th>
						<?php	}
						if ($tblsett['table_select']['note'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Notes", "t0mmic-reservations"); ?></th>
						<?php	}	?>
					</tr>
				</thead>

				<tbody id="dataout">
					<?php
					trp_table ();
					?>
				</tbody>

				<tfoot>
					<tr>
						<td class="manage-column column-cb check-column">
							<label class="screen-reader-text" for="cb-select-all-1"><?php echo __("Select all", "t0mmic-reservations"); ?></label>
							<input id="cb-select-all-2" type="checkbox">
						</td>
						<?php	if ($tblsett['table_select']['rdate'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=rdate&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Date", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['timefrom'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=timefrom&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Time from", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['timeto'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=timeto&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Time to", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['places'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Party size", "t0mmic-reservations"); ?></th>
						<?php	}
						if ($tblsett['table_select']['firstname'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=firstname&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Firstname", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['surname'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=surname&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Surname", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['phone'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=phone&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Phone", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['email'] == 1 ){ ?>
							<th scope="col" class="manage-column sortable asc"><a href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&orderby=email&amp;order=<?php echo isset($_GET['order'])?!$_GET['order']:1; ?>"><span><?php echo __("Email", "t0mmic-reservations"); ?></span><span class="sorting-indicator"></span></a></th>
						<?php	}
						if ($tblsett['table_select']['status'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Condition", "t0mmic-reservations"); ?></th>
						<?php	}
						if ($tblsett['table_select']['disapprove'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Disapproved", "t0mmic-reservations"); ?></th>
						<?php	}
						if ($tblsett['table_select']['note'] == 1 ){ ?>
							<th scope="col" class="manage-column"><?php echo __("Notes", "t0mmic-reservations"); ?></th>
						<?php	}	?>
					</tr>
				</tfoot>

			</table>

		</div>
 <?php

 }

 function t0mmic_settings(){
   $data = get_option('t0mmic_settings');
?>
  <div class="wrap">

    <h1><?php echo __("Restaurant reservations - settings", "t0mmic-reservations"); ?></h1>
		<hr class="wp-header-end">
		<br/>
    <form id="trp-form-sett" action="admin.php?page=trp-settings" method="POST">
			<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <input type="hidden" name="lastID" id="lastID" value="<?php if (isset($data['lastID'])){ echo $data['lastID'];} else { echo '0'; } ?>"/>

				<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
			    <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><?php echo __("general", "t0mmic-reservations"); ?></a></a></li>
			    <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><?php echo __("weeks", "t0mmic-reservations"); ?></a></li>
			    <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"><?php echo __("datepicker", "t0mmic-reservations"); ?></a></li>
					<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false"><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"><?php echo __("texts", "t0mmic-reservations"); ?></a></li>
				</ul>
				<div id="tabs-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: block;">
					<label for="headingRes" class="trp-control-label"><?php echo __("Page heading", "t0mmic-reservations"); ?></label>
					<input type="text" name="headingRes" value="<?php if (isset($data['headingRes'])){ echo $data['headingRes'];} ?>" class="trp-form-control"/>
					<br/>
					<label for="timepickerTheme" class="trp-control-label"><?php echo __("Theme for datepicker", "t0mmic-reservations"); ?></label>
			        <select name="timepickerTheme" id="timepickerTheme" title="<?php echo __("Theme for datepicker", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['timepickerTheme']=='base') echo "selected";?> value="base">Base</option>
			        	<option <?php if ($data['timepickerTheme']=='ui-lightness') echo "selected";?> value="ui-lightness">UI lightness</option>
			        	<option <?php if ($data['timepickerTheme']=='ui-darkness') echo "selected";?> value="ui-darkness">UI darkness</option>
			        	<option <?php if ($data['timepickerTheme']=='smoothness') echo "selected";?> value="smoothness">Smoothness</option>
			        	<option <?php if ($data['timepickerTheme']=='start') echo "selected";?> value="start">Start</option>
			        	<option <?php if ($data['timepickerTheme']=='redmond') echo "selected";?> value="redmond">Redmond</option>
			        	<option <?php if ($data['timepickerTheme']=='sunny') echo "selected";?> value="sunny">Sunny</option>
			        	<option <?php if ($data['timepickerTheme']=='overcast') echo "selected";?> value="overcast">Overcast</option>
			        	<option <?php if ($data['timepickerTheme']=='le-frog') echo "selected";?> value="le-frog">Le Frog</option>
			        	<option <?php if ($data['timepickerTheme']=='flick') echo "selected";?> value="flick">Flick</option>
			        	<option <?php if ($data['timepickerTheme']=='pepper-grinder') echo "selected";?> value="pepper-grinder">Pepper Grinder</option>
			        	<option <?php if ($data['timepickerTheme']=='eggplant') echo "selected";?> value="eggplant">Eggplant</option>
			        	<option <?php if ($data['timepickerTheme']=='dark-hive') echo "selected";?> value="dark-hive">Dark Hive</option>
			        	<option <?php if ($data['timepickerTheme']=='cupertino') echo "selected";?> value="cupertino">Cupertino</option>
			        	<option <?php if ($data['timepickerTheme']=='south-street') echo "selected";?> value="south-street">South Street</option>
			        	<option <?php if ($data['timepickerTheme']=='blitzer') echo "selected";?> value="blitzer">Blitzer</option>
			        	<option <?php if ($data['timepickerTheme']=='humanity') echo "selected";?> value="humanity">Humanity</option>
			        	<option <?php if ($data['timepickerTheme']=='hot-sneaks') echo "selected";?> value="hot-sneaks">Hot Sneaks</option>
			        	<option <?php if ($data['timepickerTheme']=='excite-bike') echo "selected";?> value="excite-bike">Excite Bike</option>
			        	<option <?php if ($data['timepickerTheme']=='vader') echo "selected";?> value="vader">Vader</option>
			        	<option <?php if ($data['timepickerTheme']=='dot-luv') echo "selected";?> value="dot-luv">Dot Luv</option>
			        	<option <?php if ($data['timepickerTheme']=='mint-choc') echo "selected";?> value="mint-choc">Mint Choc</option>
			        	<option <?php if ($data['timepickerTheme']=='black-tie') echo "selected";?> value="black-tie">Black Tie</option>
			        	<option <?php if ($data['timepickerTheme']=='trontastic') echo "selected";?> value="trontastic">Trontastic</option>
			        	<option <?php if ($data['timepickerTheme']=='swanky-purse') echo "selected";?> value="swanky-purse">Swanky Purse</option>
				      </select>
							<br/>
							<label for="cssRes" class="trp-control-label"><?php echo __("Front end form color", "t0mmic-reservations"); ?></label>
							<select name="cssRes" id="cssRes" title="<?php echo __("Front end color of the plugin.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
								<option <?php if ($data['cssRes']=='black')    echo "selected";?> value="black"><?php echo __("black", "t0mmic-reservations"); ?></option>
								<option <?php if ($data['cssRes']=='white')    echo "selected";?> value="white"><?php echo __("white", "t0mmic-reservations"); ?></option>
							</select>
							<br/>
							<label for="toEmail" class="trp-control-label"><?php echo __("Email for sending the reservation form", "t0mmic-reservations"); ?></label>
							<input type="text" name="toEmail" value="<?php if (isset($data['toEmail'])){ echo $data['toEmail'];} ?>" title="<?php echo __("Reservation form will be sent to this email.", "t0mmic-reservations"); ?>"class="trp-form-control" required/>
							<br/>
							<label for="dateFormatRes" class="trp-control-label"><?php echo __("Date format", "t0mmic-reservations"); ?></label>
			        <select name="dateFormatRes" id="dateFormatRes" title="<?php echo __("Select the date format", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['dateFormatRes']=='yy-mm-dd') echo "selected";?> value="yy-mm-dd">yy-mm-dd</option>
			        	<option <?php if ($data['dateFormatRes']=='dd-mm-yy') echo "selected";?> value="dd-mm-yy">dd-mm-yy</option>
			        	<option <?php if ($data['dateFormatRes']=='mm-dd-yy') echo "selected";?> value="mm-dd-yy">mm-dd-yy</option>
				      </select>
							<br/>
							<label for="timeFormatRes" class="trp-control-label"><?php echo __("Time format", "t0mmic-reservations"); ?></label>
			        <select name="timeFormatRes" id="timeFormatRes" title="<?php echo __("Select the time format", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['timeFormatRes']=='24h') echo "selected";?> value="24h">24h</option>
			        	<option <?php if ($data['timeFormatRes']=='12h') echo "selected";?> value="12h">12h</option>
				      </select>
							<br/>
							<label for="firstDayRes" class="trp-control-label"><?php echo __("First day of the week", "t0mmic-reservations"); ?></label>
							<select name="firstDayRes" id="firstDayRes" title="<?php echo __("First day of the week.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
								<option <?php if ($data['firstDayRes']==0)    echo "selected";?> value="0"><?php echo __("Sunday", "t0mmic-reservations"); ?></option>
								<option <?php if ($data['firstDayRes']==1)    echo "selected";?> value="1"><?php echo __("Monday", "t0mmic-reservations"); ?></option>
							</select>
							<br/>
							<label for="timeOffset" class="trp-control-label"><?php echo __("How soon can be make reservation", "t0mmic-reservations"); ?></label>
			        <select name="timeOffset" id="timeOffset" title="<?php echo __("Distance from the current time, when it´s possible to make a reservation first.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['timeOffset']==0)    echo "selected";?> value="0"><?php echo __("the next day", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==5)    echo "selected";?> value="5"><?php echo __("5 minutes in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==10)   echo "selected";?> value="10"><?php echo __("10 minutes in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==20)   echo "selected";?> value="20"><?php echo __("20 minutes in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==30)   echo "selected";?> value="30"><?php echo __("30 minutes in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==45)   echo "selected";?> value="45"><?php echo __("45 minutes in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==60)   echo "selected";?> value="60"><?php echo __("1 hour in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==120)  echo "selected";?> value="120"><?php echo __("2 hours in advance", "t0mmic-reservations"); ?></option>
			          <option <?php if ($data['timeOffset']==240)  echo "selected";?> value="240"><?php echo __("4 hours in advance", "t0mmic-reservations"); ?></option>
				      </select>
							<br/>
							<label for="statusRes" class="trp-control-label"><?php echo __("Set default 'Condition', (yes=approved, no=pending)", "t0mmic-reservations"); ?></label>
							<select name="statusRes" id="statusRes" title="<?php echo __("If email is required, it should be set 'no'.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
								<option <?php if ($data['statusRes']==0)   echo "selected";?> value="0"><?php echo __("no", "t0mmic-reservations"); ?></option>
								<option <?php if ($data['statusRes']==1)   echo "selected";?> value="1"><?php echo __("yes", "t0mmic-reservations"); ?></option>
							</select>
							<br/>
							<label for="emailRes" class="trp-control-label"><?php echo __("Email is required? Do you want to confirm reservation by email?", "t0mmic-reservations"); ?></label>
							<select name="emailRes" id="emailRes" title="<?php echo __("They will must to fill an email to the form.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
								<option <?php if ($data['emailRes']==1)   echo "selected";?> value="1"><?php echo __("yes", "t0mmic-reservations"); ?></option>
								<option <?php if ($data['emailRes']==0)   echo "selected";?> value="0"><?php echo __("no", "t0mmic-reservations"); ?></option>
							</select>
							<br/>
							<label style="margin-top:-100px" for="arrayDateClosed" class="trp-control-label"><?php echo __("List of comma separated closed date (e.g. the New Year).", "t0mmic-reservations"); ?></label>
							<textarea rows="5" name="arrayDateClosed" title="<?php echo __("Enter dates separated by ',' in the format 'yyyy-mm-dd' e.g. '2017-12-25, 2017-12-26'", "t0mmic-reservations"); ?>" placeholder="2017-12-25, 2017-12-26" class="trp-form-control-txt"><?php if (isset($data['arrayDateClosed'])){ echo $data['arrayDateClosed'];} ?></textarea>
							<br/>
							<label style="margin-top:-100px" for="arrayBlockEmail" class="trp-control-label"><?php echo __("List of comma separated blocked email, or phone", "t0mmic-reservations"); ?></label>
							<textarea rows="5" name="arrayBlockEmail" title="<?php echo __("Enter emails addresses or phones separated by ','. Reservation is after this entered in the table with a note that it needs to be verified.", "t0mmic-reservations"); ?>" placeholder="email@example.com, +1-202-555-0124, secondemail@example.com" class="trp-form-control-txt"><?php if (isset($data['arrayBlockEmail'])){ echo $data['arrayBlockEmail'];} ?></textarea>
							<br/>
							<label for="blockEmail" class="trp-control-label"><?php echo __("Enable blocking", "t0mmic-reservations"); ?></label>
							<input type="hidden" name="blockEmail" value="0"/>
							<input type="checkbox" class="trp-checkbox" name="blockEmail" value="1" <?php checked( $data['blockEmail'], 1 ); ?> title="<?php echo __("If checked, set reservation for blocked emails and phones only by phone.", "t0mmic-reservations"); ?>"/>
							<br/>
					</div>
					<div id="tabs-2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: none;">
							<label for="WeedDaySet" class="trp-control-label"><?php echo __("Times and days when it is possible to make a reservation", "t0mmic-reservations"); ?></label>
			        <div id="WeedDaySet">
			          <?php
			          $lastID = $data['lastID'];
			          if ($lastID == ""){$lastID = 0;}
			          for ($i = 0; $i <= $lastID; $i++){ ?>
			          <div class="row WeedDaySet<?php echo $i ?> trp-row">
			    					<label for="" class="trp-control-label"><?php echo __("Week days", "t0mmic-reservations"); ?></label>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][0]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][0]" value="1" <?php checked( $data['weekDaysRes'][$i][0], 1 ); ?> /> <?php echo __("sunday", "t0mmic-reservations"); ?>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][1]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][1]" value="1" <?php checked( $data['weekDaysRes'][$i][1], 1 ); ?> /> <?php echo __("monday", "t0mmic-reservations"); ?>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][2]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][2]" value="1" <?php checked( $data['weekDaysRes'][$i][2], 1 ); ?> /> <?php echo __("tuesday", "t0mmic-reservations"); ?>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][3]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][3]" value="1" <?php checked( $data['weekDaysRes'][$i][3], 1 ); ?> /> <?php echo __("wednesday", "t0mmic-reservations"); ?>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][4]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][4]" value="1" <?php checked( $data['weekDaysRes'][$i][4], 1 ); ?> /> <?php echo __("thursday", "t0mmic-reservations"); ?>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][5]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][5]" value="1" <?php checked( $data['weekDaysRes'][$i][5], 1 ); ?> /> <?php echo __("friday", "t0mmic-reservations"); ?>
			              <input type="hidden" name="weekDaysRes[<?php echo $i ?>][6]" value="0"/>
			              <input type="checkbox" class="trp-checkbox hidden<?php echo $i ?>" name="weekDaysRes[<?php echo $i ?>][6]" value="1" <?php checked( $data['weekDaysRes'][$i][6], 1 ); ?> /> <?php echo __("saturday", "t0mmic-reservations"); ?>
										<br/>
			              <label for="" class="trp-control-label"><?php echo __("From", "t0mmic-reservations"); ?></label>
			    					<input type="time" name="timeFromRes[<?php echo $i ?>]" value="<?php if (isset($data['timeFromRes'][$i])){ echo $data['timeFromRes'][$i];} ?>" class="trp-form-control" required/>
										<br/>
			              <label for="" class="trp-control-label"><?php echo __("To", "t0mmic-reservations"); ?></label>
			    					<input type="time" name="timeToRes[<?php echo $i ?>]" value="<?php if (isset($data['timeToRes'][$i])){ echo $data['timeToRes'][$i];} ?>" class="trp-form-control" required/>
										<button id="add-day-settings<?php echo $i ?>" class="buttonAdd btn <?php if ($i<$lastID){echo 'button-hide';} ?>" title="<?php echo __("Add new week", "t0mmic-reservations") ?>"><span class="dashicons dashicons-plus-alt"></span></button>
										<br/>
										<label for="" class="trp-control-label"><?php echo __("Day with extra open hours", "t0mmic-reservations"); ?></label>
			              <input id="dateDiffRes<?php echo $i ?>" class="trp-form-control dateDiffRes" type="date" name="dateDiffRes[<?php echo $i ?>]" value="<?php if (isset($data["dateDiffRes"][$i])){ echo $data["dateDiffRes"][$i];} ?>" title="<?php echo __("Fill, if the opening hours are changed on given day. Days of the week, do not fill.", "t0mmic-reservations") ?>"/>
										<button id="remove_day_settings<?php echo $i ?>" class="buttonRem btn day-settings" title="<?php echo __("Remove week", "t0mmic-reservations") ?>"><span class="dashicons dashicons-dismiss"></span></button>
								 </div>
			        <?php } ?>
							</div>
					</div>
					<div id="tabs-3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: none;">
							<label for="maxAllRes" class="trp-control-label"><?php echo __("All reservations capacity", "t0mmic-reservations"); ?></label>
			        <select name="maxAllRes" id="maxAllRes" title="<?php echo __("Reservation capacity at the same time", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <?php
			          for ($i=1;$i<101;$i++){
			            if ($data['maxAllRes']==$i){
			              $selected='selected';
			            } else {
			              $selected='';
			            }
			            print_r ("<option ".$selected." value='".$i."'>".$i."</option>");
			          }
			          ?>
				      </select>
							<br/>
							<label for="maxOneRes" class="trp-control-label"><?php echo __("Max. party size", "t0mmic-reservations"); ?></label>
			        <select name="maxOneRes" id="maxOneRes" title="<?php echo __("Max. party size", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <?php
			          for ($i=1;$i<101;$i++){
			            if ($data['maxOneRes']==$i){
			              $selected='selected';
			            } else {
			              $selected='';
			            }
			            print_r ("<option ".$selected." value='".$i."'>".$i."</option>");
			          }
			          ?>
				      </select>
							<br/>
			        <label for="dayRes" class="trp-control-label"><?php echo __("Reservation in advance", "t0mmic-reservations"); ?></label>
			        <select name="dayRes" id="dayRes" title="<?php echo __("How many days in advance can be make a reservation", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <?php
			          for ($i=1;$i<366;$i++){
			            if ($data['dayRes']==$i){
			              $selected='selected';
			            } else {
			              $selected='';
			            }
			            print_r ("<option ".$selected." value='".$i."'>".$i."</option>");
			          }
			          ?>
			        </select>
							<br/>
							<label for="minTimePeriodRes" class="trp-control-label"><?php echo __("Minimal time for one reservation", "t0mmic-reservations"); ?></label>
			        <select name="minTimePeriodRes" id="minTimePeriodRes" title="<?php echo __("Maximal time for one reservation.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['minTimePeriodRes']==30)   echo "selected";?> value="30">30 <?php echo __("min.", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['minTimePeriodRes']==45)   echo "selected";?> value="45">45 <?php echo __("min.", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['minTimePeriodRes']==60)   echo "selected";?> value="60">1 <?php echo __("hour", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['minTimePeriodRes']==90)   echo "selected";?> value="90">1 <?php echo __("hour", "t0mmic-reservations") ?> 30 <?php echo __("min.") ?></option>
			          <option <?php if ($data['minTimePeriodRes']==120)  echo "selected";?> value="120">2 <?php echo __("hours", "t0mmic-reservations") ?></option>
				      </select>
							<br/>
							<label for="maxTimePeriodRes" class="trp-control-label"><?php echo __("Maximal time for one reservation", "t0mmic-reservations"); ?></label>
			        <select name="maxTimePeriodRes" id="maxTimePeriodRes" title="<?php echo __("Maximal time for one reservation", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['maxTimePeriodRes']==60)    echo "selected";?> value="60">1 <?php echo __("hour", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==90)    echo "selected";?> value="90">1 <?php echo __("hour", "t0mmic-reservations") ?> 30 <?php echo __("min.") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==120)   echo "selected";?> value="120">2 <?php echo __("hours", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==150)   echo "selected";?> value="150">2 <?php echo __("hours", "t0mmic-reservations") ?> 30 <?php echo __("min.") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==180)   echo "selected";?> value="180">3 <?php echo __("hours", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==210)   echo "selected";?> value="210">3 <?php echo __("hours", "t0mmic-reservations") ?> 30 <?php echo __("min.") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==240)   echo "selected";?> value="240">4 <?php echo __("hours", "t0mmic-reservations") ?></option>
			          <option <?php if ($data['maxTimePeriodRes']==300)   echo "selected";?> value="300">5 <?php echo __("hours", "t0mmic-reservations") ?></option>
				      </select>
							<br/>
			        <label for="minRes" class="trp-control-label"><?php echo __("Clock interval for reservation", "t0mmic-reservations"); ?></label>
			        <select name="minRes" id="minRes" title="<?php echo __("Choosing the interval between the times available for reservation.", "t0mmic-reservations"); ?>" size="1" class="trp-select">
			          <option <?php if ($data['minRes']==5)    echo "selected";?> value="5">5</option>
			          <option <?php if ($data['minRes']==10)   echo "selected";?> value="10">10</option>
			          <option <?php if ($data['minRes']==15)   echo "selected";?> value="15">15</option>
			          <option <?php if ($data['minRes']==20)   echo "selected";?> value="20">20</option>
			          <option <?php if ($data['minRes']==30)   echo "selected";?> value="30">30</option>
			          <option <?php if ($data['minRes']==60)   echo "selected";?> value="60">60</option>
			        </select>
							<br/>
						</div>
						<div id="tabs-4" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: none;">
							<div class="trp-div">
								<label class="trp-control-label-1"><?php echo __("Use these variables in the body of the email as a replacements for words that are loaded automatically from form or table.", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$date</div><label class="trp-control-label"><?php echo __("Reserved date", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$timeFrom</div><label class="trp-control-label"><?php echo __("Reserved from time", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$timeTo</div><label class="trp-control-label"><?php echo __("Reserved to time", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$party</div><label class="trp-control-label"><?php echo __("Reserved party size", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$note</div><label class="trp-control-label"><?php echo __("Note", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$ip</div><label class="trp-control-label"><?php echo __("IP from which the request came (the reservation form)", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$firstname</div><label class="trp-control-label"><?php echo __("First name of the user who made the reservation", "t0mmic-reservations"); ?></label>
								<br/>
								<div class="trp-var">$surname</div><label class="trp-control-label"><?php echo __("Surname of the user who made the reservation", "t0mmic-reservations"); ?></label>
							</div>
							<br/><br/><br/>
							<div class="trp-div">
								<label class="trp-control-label-1"><?php echo __("Email text, whitch is sent from reservation front end form.", "t0mmic-reservations"); ?></label>
								<br/>
								<label class="trp-control-label"><?php echo __("Email subject", "t0mmic-reservations"); ?></label>
								<input type="text" name="mail_subject_first" value="<?php if (isset($data['mail_subject_first'])){ echo $data['mail_subject_first'];} ?>" class="trp-form-control-long">
								<br/>
								<label class="trp-control-label"><?php echo __("Result text, if default 'Condition' is set to 'yes' and result is OK.", "t0mmic-reservations"); ?></label>
								<input type="text" name="mail_confirm_text" value="<?php if (isset($data['mail_confirm_text'])){ echo $data['mail_confirm_text'];} ?>" class="trp-form-control-long">
								<br/>
								<label class="trp-control-label"><?php echo __("Result text, if default 'Condition' is set to 'no' and result is OK.", "t0mmic-reservations"); ?></label>
								<input type="text" name="mail_saved_text" value="<?php if (isset($data['mail_saved_text'])){ echo $data['mail_saved_text'];} ?>" class="trp-form-control-long">
								<?php
								$replace = array('\"', "\'");
								$reimbursement = array('"', "'");
								if (isset($data['editor_first'])){$editor_first = str_replace($replace,$reimbursement,base64_decode($data['editor_first']));} else { $editor_first = '';}
								$content1 = $editor_first;
								$editor_id1 = 'editor1';
								$settings1 = array('tinymce'       => array(
														       'toolbar1'      => 'bold,italic,underline,forecolor,backcolor,separator,alignleft,aligncenter,alignright,alignjustify,separator,link,unlink,undo,redo',
														       'toolbar2'      => 'fontselect,fontsizeselect,styleselect,hr,cut,copy,paste,pastetext,removeformat,fullscreen,wp_help'
																  ),
																	 'media_buttons' => false,
																	 'textarea_name' => 'editor_first',
																	 'editor_height' => 300
								);
								wp_editor( $content1, $editor_id1, $settings1 );
								?>
							</div>
							<br/><br/><br/>
							<div class="trp-div">
								<label class="trp-control-label-1"><?php echo __("Text of the approval email that is sent from the reservations overview.", "t0mmic-reservations"); ?></label>
								<br/>
								<label class="trp-control-label"><?php echo __("Email subject", "t0mmic-reservations"); ?></label>
								<input type="text" name="mail_subject_second" value="<?php if (isset($data['mail_subject_second'])){ echo $data['mail_subject_second'];} ?>" class="trp-form-control">
								<br/>
								<label class="trp-control-label"><?php echo __("Sender name of confirmation email", "t0mmic-reservations"); ?></label>
								<input type="text" name="mail_sender_name" value="<?php if (isset($data['mail_sender_name'])){ echo $data['mail_sender_name'];} ?>" class="trp-form-control">
								<?php
								if (isset($data['editor_second'])){$editor_second = str_replace($replace,$reimbursement,base64_decode($data['editor_second']));} else { $editor_second = '';}
								$content2 = $editor_second;
								$editor_id2 = 'editor2';
								$settings2 = array('tinymce'       => array(
														       'toolbar1'      => 'bold,italic,underline,forecolor,backcolor,separator,alignleft,aligncenter,alignright,alignjustify,separator,link,unlink,undo,redo',
														       'toolbar2'      => 'fontselect,fontsizeselect,styleselect,hr,cut,copy,paste,pastetext,removeformat,fullscreen,wp_help'
																  ),
																	 'media_buttons' => false,
																	 'textarea_name' => 'editor_second',
																	 'editor_height' => 300
								);
								wp_editor( $content2, $editor_id2, $settings2 );
								?>
							</div>
						</div>
					</div>
					<button type="submit" name="submit" class="btn button-primary trp-btn"><?php echo __("Submit", "t0mmic-reservations"); ?></button>
  		</form>
  	</div>
<?php
 }

 function t0mmic_reservations_info(){
?>
  <h1><?php echo __("TRP Reservations description:", "t0mmic-reservations"); ?></h1>
  <p style="font-size:15px;font-weight:bold"><?php echo __("Allows online restaurant reservation, send e-mails or search free seats and automatically booked.", "t0mmic-reservations"); ?></p>
  <ul>
  <li><?php echo __("When fully occupied, it offers alternative reservation options.", "t0mmic-reservations"); ?></li>
  <li><?php echo __("Searches based on custom specified days and times, restrict booking times.", "t0mmic-reservations"); ?></li>
  <li><?php echo __("Opening hours for holidays and other days. Closed days. All block or modify automatically.", "t0mmic-reservations"); ?></li>
  <li><?php echo __("Allows edit bookings from the admin panel.", "t0mmic-reservations"); ?></li>
  <li><?php echo __("Allows block users based on email or phone.", "t0mmic-reservations"); ?></li>
  <li><?php echo __("Send email to customers about their booking.", "t0mmic-reservations"); ?></li>
  <li><?php echo __("Also can be used as a widget.", "t0mmic-reservations"); ?></li>
  </ul>
  <p style="font-size:18px;font-weight:bold"><?php echo __("If you like my work, you can support me on", "t0mmic-reservations"); ?> <a href='https://paypal.me/t0mmic'>PayPal</a></p>

  <h2><?php echo __("Instruction:"); ?></h2>
  <h3><?php echo __("Reservation table:"); ?></h3>

  <p style="font-size:15px"><?php echo __("Reservations table can edit if you click in the table cell and edit the text. The change is saved immediately. Only some cells can be updated.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("After the status update to approved, you can send confirmation email, when the user has filled in.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("'Whole' table filter find data by firstname, surname, phone, email and note.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("If date is selected, data will loaded from selected day.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("If you insert time to input, all selected data contains the selected day and the selected time is between 'time from' and 'time to'", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("In the drop-down bar, you can set visible table columns, the number of rows, and you can also hide disapproved reservations.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("For bulk actions, use the box at the beginning of the reservation table. You can delete rows from the database, approve or disapprove reservations.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("With button 'Add new reservation', you can add new reservation from admin interface.", "t0mmic-reservations") ?></p>

  <h3 class="trp-h3"><?php echo __("Settings:"); ?></h3>

  <p style="font-size:15px"><?php echo __("On the general and datepicker bookmark you can set all the necessary parameters to search for free seats to book.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("There you will find the option to set the closed days, or block some emails or phone.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("Bookmark weeks serves to set the opening hours on different days of the week, or to set a special opening time on a selected day.", "t0mmic-reservations") ?></p>
  <p style="font-size:15px"><?php echo __("Bookmark texts serves to create texts for send emails. Beware, first try to send email yourself, not all html characters are supported.", "t0mmic-reservations") ?></p>
<?php
 }
?>
