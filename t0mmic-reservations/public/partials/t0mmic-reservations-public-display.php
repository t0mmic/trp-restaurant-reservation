<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       t0mmic.cz
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/public/partials
 */

 /**
	* Display a public plugin page
	*/

function t0mmic_reservation_public_page() {

  $data = get_option('t0mmic_settings');

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
    <div class="trp-reservation">
<?php if ($data['headingRes']!="") { ?>
        <div class="trp-row">
          <div class="trp-col-sm-2"></div>
          <div class="trp-col-sm-8"><h1 class="trp-h1"><?php echo $data['headingRes']; ?></h1></div>
          <div class="trp-col-sm-2"></div>
        </div>
<?php } ?>
      <br/>
      <div id="trp-timeGraph" class="trp-graph-hide">
      	<div class="trp-left">
      		<div id="trp-graph">
      			<div class="trp-scale" style="top:100%"><div></div></div>
      		</div>
      	</div>
      	<div id="trp-labels"><div style="width:5px;height:5px;background:#b7b303;float:left;margin:5px 10px 10px 40%"></div><div style="float:left;font-size:10px;margin:5px 10px 10px 0"><?php echo __("free space", "t0mmic-reservations"); ?></div><div style="width:5px;height:5px;background:#b70307;float:left;margin:5px 10px 10px 0"></div><div style="float:left;font-size:10px;margin:5px 10px 10px 0"><?php echo __("full", "t0mmic-reservations"); ?></div></div>
      </div>
      <div class="trp-error"></div>
      <div class="trp-row">
        <div class="trp-col-sm-2"></div>
        <div class="trp-col-sm-8">
          <form id="resForm" action="" method="post">
            <input type="hidden" id="date" value="">
            <div class="form-group">
              <div class="trp-row">
                <div class="trp-col-sm-6">
                  <label for="trp-datepicker" class="trp-control-label"><?php echo __("Date", "t0mmic-reservations"); ?></label>
                </div>
                <div class="trp-col-sm-6 select">
                  <input type="hidden" id="trp-date" name="trp-date">
                  <input type="text" id="trp-datepicker" name="trp-datepicker" class="trp-form-control" required/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="trp-row">
                <div class="trp-col-sm-6">
                  <label for="timepickerFrom" class="trp-control-label"><?php echo __("From time", "t0mmic-reservations"); ?></label>
                </div>
                <div class="trp-col-sm-6 colors-custom">
                  <select id="timepickerFrom" name="timepickerFrom" title="<?php echo __("From time", "t0mmic-reservations"); ?>" size="1" class="trp-select">
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="trp-row">
                <div class="trp-col-sm-6">
                  <label for="resTimeRes" class="trp-control-label"><?php echo __("Reserved time", "t0mmic-reservations"); ?></label>
                </div>
                <div class="trp-col-sm-6">
                  <select id="resTimeRes" name="resTimeRes" title="<?php echo __("Reserved time", "t0mmic-reservations"); ?>" size="1" class="trp-select">
                    <?php
                    for ($i=$data['minTimePeriodRes'];$i<$data['maxTimePeriodRes']+1;$i+=30){
                      print_r ("<option value='".$i."'>".$i." min.</option>");
                    }
                    ?>
      			      </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="trp-row">
                <div class="trp-col-sm-6">
                  <label for="placesRes" class="trp-control-label"><?php echo __("Party Size", "t0mmic-reservations"); ?></label>
                </div>
                <div class="trp-col-sm-6">
                  <select name="placesRes" id="placesRes" title="<?php echo __("Party size", "t0mmic-reservations"); ?>" size="1" class="trp-select">
                    <?php
                    for ($i=1;$i<$data['maxOneRes']+1;$i++){
                      print_r ("<option value='".$i."'>".$i."</option>");
                    }
                    ?>
      			      </select>
                </div>
              </div>
            </div>
            <div id="trp-hide">
              <div class="form-group">
                <div class="trp-row">
                  <div class="trp-col-sm-6">
                    <label for="firstnameRes" class="trp-control-label"><?php echo __("Firstname", "t0mmic-reservations"); ?></label>
                  </div>
                  <div class="trp-col-sm-6">
                    <input type="text" id="firstnameRes" name="firstnameRes" class="trp-form-control disabled" required/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="trp-row">
                  <div class="trp-col-sm-6">
                    <label for="fader" class="trp-control-label"><?php echo __("Surname", "t0mmic-reservations"); ?></label>
                  </div>
                  <div class="trp-col-sm-6">
                    <input type="text" id="surnameRes" name="surnameRes" class="trp-form-control disabled" required/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="trp-row">
                  <div class="trp-col-sm-6">
                    <label for="fader" class="trp-control-label"><?php echo __("Phone", "t0mmic-reservations"); ?></label>
                  </div>
                  <div class="trp-col-sm-6">
                    <input type="tel" id="phoneRes" name="phoneRes" class="trp-form-control disabled" required/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="trp-row">
                  <div class="trp-col-sm-6">
                    <label for="fader" class="trp-control-label"><?php echo __("Email", "t0mmic-reservations"); ?></label>
                  </div>
                  <div class="trp-col-sm-6">
                    <input type="email" id="emailRes" name="emailRes" placeholder="<?php if($data['emailRes'] == 0) { echo __("if you want confirmation by email", "t0mmic-reservations"); } ?>" class="trp-form-control disabled"/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="trp-row">
                  <div class="trp-col-sm-6">
                    <label for="textRes" class="trp-control-label notes"><?php echo __("Notes", "t0mmic-reservations"); ?></label>
                  </div>
                  <div class="trp-col-sm-6">
                    <textarea id="textRes" name="textRes" trp-rows="3" class="trp-form-control disabled"></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group buttons">
                <div class="trp-row">
                  <button type="submit" class="btn btn-secondary formRes"><?php echo __("Submit", "t0mmic-reservations"); ?></button>&nbsp;
                  <button type="reset" id="reset" class="btn btn-secondary"><?php echo __("Reset", "t0mmic-reservations"); ?></button>
                </div>
              </div>
            </form>
          </div> <!-- end hide -->
        </div>
        <div class="trp-col-sm-2"></div>
      </div>
<?php
}
?>
