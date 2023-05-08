<style>
.row{
    margin-top:40px;
    padding: 0 10px;
}
.clickable{
    cursor: pointer;   
}
.panel-heading div {
	margin-top: -18px;
	font-size: 15px;
}
.panel-heading div span{
	margin-left:5px;
}
.panel-body{
	display: none;
}
body {
background: url('http://fc07.deviantart.net/fs70/f/2013/174/3/e/recycled_texture_background_by_sandeep_m-d6aeau9.jpg')no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
z-index:-1;
width:100%;
height:100%;
position:fixed;
}
  
}
</style>
<link rel="stylesheet" href="http://getbootstrap.com/dist/css/bootstrap.min.css">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-primary">
<div class="panel-heading">
	<h3 class="panel-title">IP Logs</h3>
	<div class="pull-right">
		<span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
		<i class="glyphicon glyphicon-filter"></i>
		</span>
	</div>
</div>
<div class="panel-body">
	<input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filter Developers" />
</div>
<table class="table table-hover" id="dev-table">
	<thead>
	<tr>
		<th>#</th>
		<th>IP</th>
		<th>Browser</th>
		<th>Platform</th>
		<th>Time</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$file = file_get_contents("ips.txt");
	$ips = explode("\n", $file);
	$i=1;
	Foreach ($ips as $ipdata) {
	$ipdatanew = explode("---", $ipdata);
		if (isset($ipdatanew[0],$ipdatanew[1],$ipdatanew[2],$ipdatanew[3])) {
			
			echo "
				<tr>
				<td>{$i}</td>
				<td>{$ipdatanew[1]}</td>
				<td>{$ipdatanew[2]}</td>
				<td>{$ipdatanew[3]}</td>
				<td>{$ipdatanew[0]}</td>
			</tr>";
			$i++;
		}
	}
	?>
	</tbody>
</table>
</div>
</div>
</div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
(function(){
    'use strict';
	var $ = jQuery;
	$.fn.extend({
		filterTable: function(){
			return this.each(function(){
				$(this).on('keyup', function(e){
					$('.filterTable_no_results').remove();
					var $this = $(this), search = $this.val().toLowerCase(), target = $this.attr('data-filters'), $target = $(target), $rows = $target.find('tbody tr');
					if(search == '') {
						$rows.show(); 
					} else {
						$rows.each(function(){
							var $this = $(this);
							$this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
						})
						if($target.find('tbody tr:visible').size() === 0) {
							var col_count = $target.find('tr').first().find('td').size();
							var no_results = $('<tr class="filterTable_no_results"><td colspan="'+col_count+'">No results found</td></tr>')
							$target.find('tbody').append(no_results);
						}
					}
				});
			});
		}
	});
	$('[data-action="filter"]').filterTable();
})(jQuery);

$(function(){
    // attach table filter plugin to inputs
	$('[data-action="filter"]').filterTable();
	
	$('.container').on('click', '.panel-heading span.filter', function(e){
		var $this = $(this), 
				$panel = $this.parents('.panel');
		
		$panel.find('.panel-body').slideToggle();
		if($this.css('display') != 'none') {
			$panel.find('.panel-body input').focus();
		}
	});
	$('[data-toggle="tooltip"]').tooltip();
})
</script>