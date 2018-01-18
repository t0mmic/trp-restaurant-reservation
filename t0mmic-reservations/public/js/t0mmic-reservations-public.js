(function($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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

		 var mindate = 0;   // ok
		 var maxdate = new Date();   // ok
		 maxdate.setDate(maxdate.getDate() + parseInt(phpSettings.dayRes));   // ok

		 var now = new Date();
		 //var dateNow = now.getDate() + "." + (now.getMonth()+1) + "." + now.getFullYear();

		 // set reservation offset time from now
		 var dayNow     = now.getDay();
		 var offsetMin 	= parseInt(phpSettings.timeOffset);
		 var offsetHour = 0;
		 if (offsetMin >= 60){
			 offsetHour = offsetMin / 60;
			 offsetMin = 0;
		 }
		 var hoursNow   = now.getHours()+offsetHour;
		 var minutesNow = now.getMinutes()+offsetMin;
		 if (minutesNow > 59){
			 minutesNow = minutesNow % 60;
			 hoursNow = hoursNow+Math.floor(minutesNow/60);
		 }
		 if ((hoursNow > 23) || (offsetMin == 0)){   // ok
			 mindate = 1;
			 hoursNow = hoursNow - 24;
		 }
		 var setHour = hoursNow + ":" + minutesNow;


     // set closed days on the calendar
		 var data = phpSettings.weekDaysRes;
		 var arrayDisabledWeekDay = [];
		 for ( var i = 0; i < data.length; i++ ){
			 for (var j = 0; j <= 6; j++ ){
				 if (phpSettings.dateDiffRes[i] == ""){
				 		if (data[i][j] == 1){
					  	arrayDisabledWeekDay.push(j);
						}
				 }
			 }
		 }

		 $("#trp-datepicker").datepicker({
			 altField: '#trp-date',
			 minDate:mindate,
			 maxDate:maxdate,
			 firstDay:phpSettings.firstDayRes,
			 dateFormat:phpSettings.dateFormatRes,
			 onSelect: function(datetimeText){
				 // string to date format
				 function toDate(dateStr){
    	 			var parts = dateStr.split("-");
						if (phpSettings.dateFormatRes == 'yy-mm-dd'){
    					return new Date(parts[0], parts[1] - 1, parts[2]);
						} else if (phpSettings.dateFormatRes == 'dd-mm-yy'){
							return new Date(parts[2], parts[1] - 1, parts[0]);
						} else if (phpSettings.dateFormatRes == 'mm-dd-yy'){
							return new Date(parts[2], parts[0] - 1, parts[1]);
						}
				 }
				 var newDate = toDate(datetimeText);
				 var dayNow  = newDate.getDay();

				 // set time option
				 function toD(dateStr){
    	 			var parts = dateStr.split("-");
						if (phpSettings.dateFormatRes == 'yy-mm-dd'){
    					return parts[0] +'-'+ parts[1] +'-'+ parts[2];
						} else if (phpSettings.dateFormatRes == 'dd-mm-yy'){
							return parts[2] +'-'+ parts[1] +'-'+ parts[0];
						} else {
							return parts[2] +'-'+ parts[0] +'-'+ parts[1];
						}
				 }
				 var key = phpSettings.dateDiffRes.indexOf(toD(datetimeText));
				 switch (key){
					 case -1: // if date is not set in week settings line
							 for ( var i = 0; i < data.length; i++ ){
								 if (data[i][dayNow] == 1){ // set option values for selected day of week only
									 set_option();
								 }
							 }
							 break;
					 default:
							 var i = key;
							 set_option();
							 break;
			 	 }

				 function set_option(){
					 $("#timepickerFrom option").remove(); // so that the option is not added multiple times
					 var optionHourF = parseInt(phpSettings.timeFromRes[i].slice(0,2))*60,
							 optionHourT = parseInt(phpSettings.timeToRes[i].slice(0,2))*60,
							 optionMinutesF = parseInt(phpSettings.timeFromRes[i].slice(3,5)),
							 optionMinutesT = parseInt(phpSettings.timeToRes[i].slice(3,5)),
							 minRes = parseInt(phpSettings.minRes),
							 from = optionHourF+optionMinutesF,
							 to = optionHourT+optionMinutesT;

					 // option value time offset from now, if date is today
					 if (newDate.toString().slice(0,15) == new Date().toString().slice(0,15)){
						 if ((optionHourF/60) <= hoursNow){
							 from = ((hoursNow*60)+(optionMinutesF+(Math.round(minutesNow/minRes)*minRes)));
							 if (from >= to) {from = to;}
						 }
					 }

					 for (var j = from; j <= to; j += minRes) {
						 var h = Math.floor(j/60);
						 if (h < 10){h = '0' + h}
						 var m = j%60;
						 if (m < 10){m = '0' + m}
						 if (phpSettings.timeFormatRes == '12h') {
							 var hr = Math.floor(j/60);
							 if (hr < 12){
								 var time = hr + ':' + m + ' AM';
							 } else {
								 var time = ((hr + 11) % 12 + 1) + ':' + m + ' PM';
							 }
							 var opt = '<option value="' + time + '" >' + time + '</option>';
						 } else {
							 var opt = '<option value="' + h + ':' + m + '" >' + h + ':' + m + '</option>';
						 }
						 $("#timepickerFrom").append(opt);
					 }
			   } // end function set_option

				 var arrayDate = phpSettings.arrayDateClosed.split(",");
				 var arrayDateClosed = [];
				 arrayDateClosed = arrayDateClosed.concat(arrayDate);
				 newDate = new Date(Date.parse(newDate)).toString().slice(0,15);
				 for (var i = 0; i < arrayDateClosed.length; i++) {
					 var parseDate = new Date(Date.parse(arrayDateClosed[i])).toString().slice(0,15);
					 if (parseDate == newDate){
						  $("#timepickerFrom option").remove();
						  var opt = '<option value="" >' + phpSettings.closed + '</option>';
						  $("#timepickerFrom").append(opt);
		 			 }
				 } // end make options
			 },
			 beforeShowDay: function(date){
				 return [date.getDay() == arrayDisabledWeekDay[0] || date.getDay() == arrayDisabledWeekDay[1] || date.getDay() == arrayDisabledWeekDay[2] || date.getDay() == arrayDisabledWeekDay[3] || date.getDay() == arrayDisabledWeekDay[4] || date.getDay() == arrayDisabledWeekDay[5] || date.getDay() == arrayDisabledWeekDay[6],"" ];
       }
		 });

		 if (phpSettings.emailRes == 1) {
			 $("#emailRes").prop("required", true);
		 } else {
			 $("#emailRes").prop("required", false);
		 }


	 });

	 $(document).ready(function(){

		// searches that capacity is available, and then allow to fill other fields.
		var jsonData = {action:"t0mmic_reservation_ajax"};
		$("#trp-datepicker").on('focusout', function(e){
			e.preventDefault();
			setTimeout(function(){
				 jsonData.datepicker = e.currentTarget.value;
				 if ($("#timepickerFrom").val()==""){
					 jsonData.timepicker = "";
					 jsonData.minutes = ""
				 }
		 	}, 200);
		});
		$("#placesRes,#timepickerFrom,#resTimeRes").on('change', function(){
			var placesRes = $("#placesRes").val();
			var timepickerFrom = $("#timepickerFrom").val();
			var resTimeRes = $("#resTimeRes").val();
			jsonData.places = placesRes;
			jsonData.timepicker = timepickerFrom;
			jsonData.minutes = resTimeRes;
		});
	 	$("#placesRes,#trp-datepicker,#timepickerFrom,#resTimeRes").on('focusout change', function(){
			setTimeout(function(){
				if ((jsonData['datepicker']!=undefined) && (jsonData['timepicker']!=undefined) && (jsonData['minutes']!=undefined) && (jsonData['places']!=undefined)){
					var timeval = [];
					$('#timepickerFrom option').map(function() {
						timeval.push($(this).val());
					});
					jsonData.timeval = timeval;

					$.ajax({
		 				type: 'POST',
		 				url: phpSettings.url,
						dataType: 'json',
		 				data: jsonData,
		 				success: function(data, textStatus, XMLHttpRequest){
		 					var placesSelected = phpSettings.maxAllRes-data["places"]-jsonData['places'];
							if (placesSelected>=0){
								$("#trp-hide").css("display","block");
								$(".trp-graph-hide").css("display","none");
								$(".trp-error").text("");
							} else {
								$("#trp-hide").css("display","none");
								$(".trp-graph-hide").css("display","block");
								$(".trp-error").text(phpSettings.occupied);

								// draws a graph
								$('.trp-column').remove();
								var column = (98/timeval.length).toFixed(6);
								var width = (column*0.7).toFixed(6)+'%';
								$('.trp-column').css('height','0');
								$.each(timeval,function(index, value) {
									var proc = (phpSettings.maxAllRes)-data[index]-jsonData['places'];
									var color = '#b7b303';
									if (proc<0) {color = '#b70307'}
									$('#trp-graph').append('<div id="col' + index + '" style="left:'+(index*column)+'%; background-color:'+color+'; width:'+width+'" class="trp-column"></div>');
									var height = "40%";

									if (phpSettings.timeFormatRes == '12h'){
										var min = value.split(" ");
										var min = min[0].split(":");
										var min = min[1];
										if ($('#trp-timeGraph').width() < 550){
											if (min != '00'){value = ''; height = '30%'}
										} else {
											if ((min != '00') && (min != '30')){value = ''; height = '30%'}
										}
									} else {
										var min = value.slice(3,5);
										if ($('#trp-timeGraph').width() < 550){
											if (min != '00'){value = ''; height = '30%'}
										} else {
											if ((min != '00') && (min != '30')){value = ''; height = '30%'}
										}
									}
									$('#col'+index).animate({height: height}, 700).html("<div><span class='trp-time'>"+value+"</span></div>");
								});
							}
		 				},
						error: function(MLHttpRequest, textStatus){
		 					alert(phpSettings.fail);
		 				}
					});
				}
			}, 300);

	 	}); // end searches that capacity is available

		// if a new reservation is set, calls the function t0mmic_reservation_table
		$(".formRes").on('click', function(){
			var sdata = $('#resForm').serializeArray();
			var data = {};
			data.action = 't0mmic_reservation_table';
			$.each(sdata, function(i, v){
	        data[v.name] = v.value;
	    });
			$.ajax({
				type: 'POST',
				url: phpSettings.url,
				data: data,
				success: function(data, textStatus, XMLHttpRequest){
					alert(data);
				},
				error: function(MLHttpRequest, textStatus){
					if (MLHttpRequest.status===0){
						alert('OK');
					} else {
						alert(textStatus);
					}
				}
			});
	 	});


	}); // end document ready

})(jQuery);
