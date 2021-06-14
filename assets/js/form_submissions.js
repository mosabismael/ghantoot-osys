
/* -- AJAX FUNCTIONS -- */
var submission_res = '';
var form_processed = '';
var form_processed_callback = '';
var modal_processed = '';
var details_processed = '';
var modal_processed_alerter = '';
var alerts_C = 12;

function mk_alert( alertTxt, alertType, alertDistenation ){
	alerts_C++;
	if( alertDistenation != '' ){
		var txtFA = '';
		var txtClass = '';
		if( alertType == 'suc' ){
			txtFA = '<i class="far fa-check-circle"></i>';
			txtClass = 'btn-success';
			} else if( alertType == 'err' ){
			txtFA = '<i class="far fa-times-circle"></i>';
			txtClass = 'btn-danger';
			} else if( alertType == 'warn' ){
			txtFA = '<i class="fas fa-exclamation-circle"></i>';
			txtClass = 'btn-warning';
		}
		var alertData = '<p id="alerter-' + alerts_C + '" onclick="rem_alert(' + alerts_C + ');" class="' + txtClass + '">' + txtFA + ' ' + alertTxt + '</p>';
		$(alertDistenation).append(alertData);
	}
	
}

function rem_alert( alertID ){
	$('#alerter-' + alertID).remove();
}

function submit_form(frm_id, res){
	var wrongsCount = 0;
	submission_res = res;
	var formdata = new FormData();
	form_processed = '#' + frm_id;
	var URLer = $(form_processed).attr('api');
	form_processed_callback = $(form_processed).attr( 'id-callback' );
	modal_processed = $(form_processed).attr('id-modal');
	details_processed = $(form_processed).attr('id-details');
	modal_processed_alerter = form_processed + ' .form-alerts';
	console.log(modal_processed_alerter);
	$(modal_processed_alerter).html('');
	//tinyMCE.triggerSave();
	console.log('submission started == ' + frm_id);
	var gate = true;
	$(form_processed + ' .frmData').each(function(){
		//collect entry data
		var ths_id = $(this).attr('id');
		var ths_name = $(this).attr('name');
		var ths_den = $(this).attr('den');
		var ths_alert = $(this).attr('alerter');
		var ths_namer = capitalizer(ths_name.replace('_', ' '));
		if( ths_alert == '' || ths_alert == null || ths_alert == 'undefined' ){
			ths_alert = "Please_Check_Inputs" + '( '+ ths_namer +' )';
		}
		
		var ths_default = $(this).attr('defaulter');
		var ths_req = parseInt($(this).attr('req'));
		var ths_val = $(this).val();
		var ths_tag = $(this).prop("tagName").toLowerCase();
		var ths_type = '';
		// alert(ths_tag);
		//define element type
		if(ths_tag == 'input'){
			ths_type = $(this).attr('type');
			} else {
			ths_type = ths_tag;
		}
		
		if(ths_type == 'file'){
			//its file
			if (($("#" + ths_id))[0].files.length> 0) {
				var filer = ($("#" + ths_id))[0].files[0];
				formdata.append(ths_id, filer);
				} else {
				if(ths_req == 1){
					gate = false;
					mk_alert(ths_alert, 'err', modal_processed_alerter);
					return false;
				}
			}
			} else {
			//its input, select, textarea
			if(ths_val != ths_den){
				formdata.append(ths_name, ths_val);
				} else {
				if(ths_req == 1){
					mk_alert(ths_alert, 'err', modal_processed_alerter);
					wrongsCount++;
					} else {
					formdata.append(ths_name, ths_default);
				}
			}
		}
		
	});
	
	// gate = false;
	if( wrongsCount == 0 ){
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress", progressHandlerA, false);
		ajax.addEventListener("load", completeHandlerA, false);
		ajax.addEventListener("error", errorHandlerA, false);
		ajax.addEventListener("abort", abortHandlerA, false);
		ajax.open("POST", URLer);
		if(gate == true){
			//send data to ajax
			//hide_modal();
			start_loader();
			ajax.send(formdata);
		}
	}
}



function capitalizer(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function clear_form(frm){
	
	$(frm + ' .frmData').each(function(){
		
		//collect entry data
		var ths_id = $(this).attr('id');
		var ths_name = $(this).attr('name');
		var ths_den = $(this).attr('denier');
		var ths_alert = $(this).attr('alerter');
		var ths_default = $(this).attr('defaulter');
		var ths_req = parseInt($(this).attr('req'));
		var ths_val = $(this).val();
		var ths_tag = $(this).prop("tagName").toLowerCase();
		var ths_type = '';
		
		//clear element type based on type
		if(ths_tag == 'input' || ths_tag == 'textarea'){
			$(this).val('');
			} else if(ths_tag == 'select'){
			$(this).val(0);
			} else {
			$(this).val('');
		}
		
	});
	
}





function progressHandlerA(event){
	var percent = (event.loaded / event.total) * 100;
	set_loader(percent);
}
function completeHandlerA(event){
	var responser = event.target.responseText;
	console.log(responser);
	var aa = responser.split('|');
	if(aa[0] == 1){
		
		if(submission_res == 'reload_page'){
			mk_alert(aa[1], 'suc', modal_processed_alerter);
			hide_modal();
			$("#article").load(window.location.href + " #article");
			if (typeof sthsSearchCond === 'undefined') {
				sthsSearchCond = "";
			}
			
			
			if (typeof thsPage !== 'undefined') {
				loadTableData( 1, 20, thsPage );
			}
			//$("#article").load(window.location.href + " #article");
			//$("#article").load(location.href + " #article>*", "");
			//setTimeout(function(){$("#article").load(window.location.href + " #article");}, 1000);
			//setTimeout(function(){window.location.reload();}, 1000);
			} else if(submission_res == 'nothing'){
			mk_alert(aa[1], 'suc', modal_processed_alerter);
			} else if(submission_res == 'forward_page'){
			var nwLink = aa[1];
			window.location.replace(nwLink);
			// repeat_call();
			}   else if(submission_res == 'close_modal'){
			mk_alert(aa[1], 'suc', modal_processed_alerter);
			hide_modal();
			// clear_form(form_processed);
			// repeat_call();
			}   else if(submission_res == 'call_back'){
			mk_alert(aa[1], 'suc', modal_processed_alerter);
			hide_modal();
			clear_form(form_processed);
			window[form_processed_callback]();
			// repeat_call();
			}  else if(submission_res == 'execute_action'){
			$('#explorer').append(aa[1]);
			}  else if(submission_res == 'next_step'){
			var ths_step = parseInt($('#' + form_processed).attr('stepper'));
			var nxt_step = ths_step + 1;
			console.log(form_processed + '==========' + nxt_step);
			form_processed = form_processed.substring(0, form_processed.length - 2);
			show_modal(form_processed + '-modal-' + nxt_step);
			$('#' + form_processed + '-' + nxt_step).html(aa[1]);
			} else if(submission_res == 'refresh') {
			//  $("#article").load(location.href + " #article");
			setTimeout(function(){window.location.reload();}, 1000);
			} else if(submission_res == 'append_data') {
			$('#added_items').append(aa[1]);
			hide_modal();
			} else if(submission_res == 'clear_form') {
			mk_alert(aa[1], 'suc', modal_processed_alerter);
			clear_form(form_processed);
			} else if(submission_res == 'close_details') {
			mk_alert(aa[1], 'suc', modal_processed_alerter);
			hide_details(details_processed);
		}
		
		} else {
		mk_alert(aa[1], 'err', modal_processed_alerter);
	}
end_loader();

}
function errorHandlerA(event){
var responser = event.target.responseText;
mk_alert("Upload Failed, please check your inputs 4656545687", "err", modal_processed_alerter);
alert(responser);
}
function abortHandlerA(event){
var responser = event.target.responseText;
mk_alert("Upload Aborted by user", "err", modal_processed_alerter);
alert(responser);
}

