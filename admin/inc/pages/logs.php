<?php
// unplanned execution path
defined( 'IN_WAZIHUB') or die( 'e902!');

$conf	= callAPI( 'system/conf');


$status = CallHost( 'docker/status');

//printr( $status);

/*------------*/

$tabs = array(
			array(
				'title'		=>	'LoRa',
				'active'	=>	true,
				'notes'		=>	$lang['Notes_Test_Logs'],
				'content'	=>	array(
					array( logsForm( 'lora')),
				),
			)
	);

foreach( $status as $k => $container)
{
	$cName = ltrim( $container['Names'][0], '/');
	$tabs[] = array(
			'title'		=>	$cName,
			'active'	=>	false, // Active only the first tab
			'notes'		=>	'',
			'content'	=>	array(
				array( $lang['State']  .': '. $container['State']),
				array( $lang['Status'] .': '.  $container['Status'] ),
				array( logsForm( $cName, $container['Id'])),
			)
		);
	
}

/*------------*/

/*------------*/

$templateData = array(

	'icon'	=>	$pageIcon,
	'title'	=>	$lang['Logs'],
	'msgDiv'=>	'msg',
	'tabs'	=>	$tabs
);

/*------------*/

require( './inc/template_admin.php');

/*------------*/

function downlinkReqForm()
{
	global $lang, $maxAddr;

	return '<form id="downlink_form" role="form">
				<fieldset>
					<div class="form-group">
						<label>'. $lang['Destination'] .'</label>
						<input class="form-control" placeholder="Between 2 and '. $maxAddr .'" name="destination" type="number" value="" min="2" max="'. $maxAddr .'" autofocus />
					</div>
					<div class="form-group">
						<label>'. $lang['Message'] .'</label>
						<input class="form-control" placeholder="'. $lang['Message'] .'" name="message" type="text" value="" autofocus />
					</div>
					
					<center>
						<button  type="submit" class="btn btn-primary">'. $lang['Submit'] .'</button>
						<button  id="btn_downlink_form_reset" type="reset" class="btn btn-primary">'. $lang['Clear'] .'</button>
					</center> 
				</fieldset>
			</form>';

}

/*------------*/

function logsForm( $type = '', $cId = '0')
{
	global $lang;
	
	$typeJsClear = str_replace( '-', '', $type);
	
	return '<table class="table table-striped table-bordered table-hover">
		  <thead></thead>
		<tbody>
		   <tr>
		    <td><a href="?get=logs&type='. $type .'">'. $lang['LogsDownload_All'] .'</a></td>
		   </tr>
		   <tr>
		    <td><a href="javascript:loadLogs_'. $typeJsClear .'(500);">'.  $lang['LogsDownload_500L'] .'</a></td>
		   </tr>
		</tbody>
	  </table>
	  <div class="logs">
	  	<pre id="logsAjx_'. $typeJsClear .'">NA</pre>
	  </div>
		<table class="table table-striped table-bordered table-hover">
		  <thead></thead>
		<tbody>
		   <tr><td>Logs for <b>'.  $type .'</b></td></tr>
		   <tr>
		    <td><a href="?get=logs&type='. $type .'&cId='. $cId .'">'. $lang['LogsDownload_All'] .'</a></td>
		   </tr>
		   <tr>
		    <td><a href="javascript:loadLogs_'. $typeJsClear .'(500);">'.  $lang['LogsDownload_500L'] .'</a></td>
		   </tr>
		</tbody>
	  </table>	  
	  <div id="logsDown'. $typeJsClear .'"></div>
	  <script>
		var autoR_'. $typeJsClear .' = 0;
		function loadLogs_'. $typeJsClear .'( n){
			if( ! $("#logsAjx_'. $typeJsClear .'").is(":visible"))
			{ 
				autoR_'. $typeJsClear .' = setTimeout( function(){loadLogs_'. $typeJsClear .'(50)}, 1000);
				return false;
			}
			clearTimeout( autoR_'. $typeJsClear .');
			
			$("#logsAjx_'. $typeJsClear .'").html( "<p align=\"center\"><img src=\"./style/img/loading_b.gif\" /></p>").fadeIn();
			$.get( "?get=logs&type='. $type .'&cId='. $cId .'&n="+ n, function( data){
				$("#logsAjx_'. $typeJsClear .'").html( data).fadeIn();
				
				if( n == 50){ autoR_'. $typeJsClear .' = setTimeout( function(){loadLogs_'. $typeJsClear .'(50)}, 5000);}
				$("html, body").animate({
					  scrollTop: $("#logsDown'. $typeJsClear .'").offset().top - 100
				}, 1000);
			});
		}
		$(function(){ loadLogs_'. $typeJsClear .'(50);});
	 </script>';
}

/*------------*/

?>
