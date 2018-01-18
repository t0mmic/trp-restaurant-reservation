(function($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

		$(window).load(function(){

			var message = $("#message");

			// the question of whether to send email
			function sendEmail() {
					if (confirm(phpSettings.sendEmail)) return true;
					return false;
			}

			// cell update function for reservation table
			$("[name=status],[name=disapprove],[name=vdata]").blur(function(){
				var jsonData = {"action":"trp_update_table"},
						field_id = $(this).attr("id"),
						field_class = $(this).attr("class"),
						value = $(this).text();
				if ((field_id == "status-" + field_class) || (field_id == "disapprove-" + field_class)){
					if (this.checked) {value = '1';} else {
						value = '0';
					}
					var email = $("#trp-email-"+ + field_class).text();
					if ((field_id == "status-" + field_class) && (value == 1) && (email != "")){
						if (sendEmail()){
							jsonData.send_email = 1
						}
					}
				}
				jsonData.field_id = field_id;
				jsonData.value = value;
				$.ajax({
					type: 'POST',
					url: phpSettings.url,
					dataType: 'json',
					data: jsonData,
					success: function(data, textStatus, XMLHttpRequest){
						message.show().text(data);
						setTimeout(function(){message.hide()},800);
						location.replace(location.href+'&reload');
					},
					error: function(MLHttpRequest, textStatus){
						message.show().text(MLHttpRequest.responseText);
						setTimeout(function(){message.hide()},800);
					}
				});
			});

			// bulk actions for reservation page
			$("#trp_bulk_action").on('click', function(){
				var val = $("#bulk-action-selector-top").val();
				var post = [];
				$(".trp-post").each(function(){
					if (this.checked){
						post.push($(this).val());
					}
				});
				if(val != '-1'){
					$.ajax({
						type: 'POST',
						url: phpSettings.url,
						dataType: 'json',
						data: {action:"trp_bulk_action",value:val,post:post},
						success: function(data, textStatus, XMLHttpRequest){
							message.show().text(textStatus);
							setTimeout(function(){message.hide()},800);
							location.replace(location.href+'&reload');
						},
						error: function(MLHttpRequest, textStatus){
							message.show().text(textStatus);
							setTimeout(function(){message.hide()},800);
						}
					});
				}
			});

			// add new reservation to table
			$("#trp-modal-form").on('submit', function(){
				var data = $(this).serialize();
				$.ajax({
					type: "POST",
					url: phpSettings.url,
					data: 'action=trp_update_reservation&' + data,
					success: function(data, textStatus, XMLHttpRequest){
						message.show().text(textStatus);
						setTimeout(function(){message.hide()},800);
						location.replace(location.href+'&reload');
					},
					error: function(data, MLHttpRequest, textStatus){
						message.show().text(textStatus);
						setTimeout(function(){message.hide()},800);
					}
				});
			});

			//update settings options from settings and reservation page
			$("#adv-settings, #trp-form-sett").on('submit', function(e){
				e.preventDefault();
				var data = $(this).serialize();
				var val = 'settings';
				if (e.target.id == 'adv-settings'){val = 'table'}
				$.ajax({
					type: "POST",
					url: phpSettings.url,
					data: 'action=trp_option&switch='+val+'&' + data,
					success: function(data, textStatus, XMLHttpRequest){
						message.show().text(textStatus);
						setTimeout(function(){message.hide()},800);
						location.replace(location.href+'&reload');
					},
					error: function(data, MLHttpRequest, textStatus){
						message.show().text(textStatus);
						setTimeout(function(){message.hide()},800);
					}
				});
			});

			 // in settings page, hide week day checkboxes, if date is set and page is loaded
			 $(function(){
				 var thisId = $(".dateDiffRes").each(function() {
					 var checkDate = $(this).val();
					 if (checkDate != "") {
						 var id = $(this).attr("id").slice(-1);
						 $(".hidden"+id).attr("disabled", true);
					 }
				 });
			 });

		});

		$(document).ready(function(){

			// open the modal window form
			$("#trp-modal").on('click', function(){
			 	$("#trp-addForm").css("display", "block");
			});

			// close the modal window
			$(".trp-x").on('click', function(){
				$("#trp-addForm").css("display", "none");
			});

			// button add, new week day settings to admin settings page
			$(".buttonAdd").on('click', function(e){
				e.preventDefault();
				var i = $("#lastID").val();
				i = ++i;
				var addDiv  = '<div class="row WeedDaySet'+i+' trp-row">'+
													'<label class="trp-control-label">'+
													phpSettings.weekDaysRes+
													'</label>'+
													'<input type="hidden" name="weekDaysRes['+i+'][0]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][0]" value="1" <?php checked($data["weekDaysRes"]['+i+'][0],1)?&gt; />'+
													phpSettings.sunday+
													'<input type="hidden" name="weekDaysRes['+i+'][1]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][1]" value="1" <?php checked($data["weekDaysRes"]['+i+'][1],1);?&gt; />'+
													phpSettings.monday+
													'<input type="hidden" name="weekDaysRes['+i+'][2]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][2]" value="1" <?php checked($data["weekDaysRes"]['+i+'][2],1);?&gt; />'+
													phpSettings.tuesday+
													'<input type="hidden" name="weekDaysRes['+i+'][3]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][3]" value="1" <?php checked($data["weekDaysRes"]['+i+'][3],1);?&gt; />'+
													phpSettings.wednesday+
													'<input type="hidden" name="weekDaysRes['+i+'][4]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][4]" value="1" <?php checked($data["weekDaysRes"]['+i+'][4],1);?&gt; />'+
													phpSettings.thursday+
													'<input type="hidden" name="weekDaysRes['+i+'][5]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][5]" value="1" <?php checked($data["weekDaysRes"]['+i+'][5],1);?&gt; />'+
													phpSettings.friday+
													'<input type="hidden" name="weekDaysRes['+i+'][6]" value="0"/>'+
													'<input type="checkbox" class="trp-checkbox hidden'+i+'" name="weekDaysRes['+i+'][6]" value="1" <?php checked($data["weekDaysRes"]['+i+'][6],1);?&gt; />'+
													phpSettings.saturday+
													'<br/>'+
													'<label for="" class="trp-control-label">'+
													phpSettings.from+
													'</label>'+
													'<input type="time" name="timeFromRes['+i+']" value="<?php if(isset($data["timeFromRes"]['+i+'])){echo $data["timeFromRes"]['+i+'];?&gt; class="trp-form-control" required/>'+
													'<br/>'+
													'<label for="" class="trp-control-label">'+
													phpSettings.to+
													'</label>'+
													'<input type="time" name="timeToRes['+i+']" value="<?php if(isset($data["timeToRes"]['+i+'])){echo $data["timeToRes"]['+i+'];?&gt;" class="trp-form-control" required/>'+
													'<br/>'+
													'<label for="" class="trp-control-label">'+
													phpSettings.daysett+
													'</label>'+
													'<input id="dateDiffRes'+i+'" class="trp-form-control dateDiffRes" type="date" name="dateDiffRes['+i+']" value="<?php if(isset($data["dateDiffRes"]['+i+'])){echo $data["dateDiffRes"]['+i+'];}?&gt;" title="'+ phpSettings.title +'"/>'+
													'<button id="remove_day_settings'+i+'" class="buttonRem btn day-settings" title="'+ phpSettings.removeThis +'"><span class="dashicons dashicons-dismiss"></span></button>'+
												'</div>'+
											'</div>';
				$("#WeedDaySet").append(addDiv);
				$("#lastID").val(i);
			});

			// remove button, delete week day settings from admin settings page
			$(".day-settings").on('click', function(e){
				e.preventDefault();
				var id = e.delegateTarget.id.slice(-1);
				$(".WeedDaySet"+id).remove();
				var i = $("#lastID").val();
				$("#lastID").val(i-1);
			});

			// reservation page, whole table search
			$("#trp-search").keyup(function(){
				var value = this.value.toLowerCase().trim();
				var url = window.location.href;
				var last = url.split('/');
				var lastpart = last[last.length-1];
				setTimeout(function(){
				 	window.location.href=lastpart + '&filter=' + value + '&cpage=1';
				}, 1000);
			});

			// date and time filters for reservation table
			$("#trp-dateFilter").change(function(e){
				e.preventDefault();
				var dateFilter = $("#trp-dateFilter").val();
				var timeFilter = $("#trp-timeFilter").val();
				if (timeFilter != ""){
					window.location.href='admin.php?page=trp-reservations&val=' +dateFilter + '&time=' + timeFilter;
				} else {
					window.location.href='admin.php?page=trp-reservations&val=' +dateFilter;
				}
			});
			$("#trp-timeFilter").change(function(e){
				e.preventDefault();
				var dateFilter = $("#trp-dateFilter").val();
				var timeFilter = $("#trp-timeFilter").val();
				setTimeout(function(){
				window.location.href='admin.php?page=trp-reservations&val=' +dateFilter + '&time=' + timeFilter;
				}, 1000);
			});

		  // hide week day settings checkboxes if date is set and value changed
			$(".dateDiffRes").change(function(e){
				e.preventDefault();
				var id = e.delegateTarget.id.slice(-1);
				if (e.delegateTarget.value != ""){
					$(".hidden"+id).attr("disabled", true);
				} else {
					$(".hidden"+id).attr("disabled", false);
				}
			});

			// checked (unchecked) all checkbox ids in reservation table, when first or last is checked (unchecked)
			$('#cb-select-all-1, #cb-select-all-2').change(function(){
				if (this.checked){
					$(".trp-post").each(function(){
						$(this).prop('checked', true);
					});
				} else {
					$(".trp-post").each(function(){
						$(this).prop('checked', false);
					});
				}
			});

			// setings form pagination
			$( function() {
				$("#tabs").tabs();
			});

		});

})(jQuery);
