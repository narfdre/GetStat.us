<?php 
$user = unserialize(h($user));
$urls = unserialize(h($urls)); ?>
<div class="main">
	<div class="container">
	  <div class="row">
	    <div class="span4">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Urls</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($urls as  $url) {?>
						<tr>
							<td><a href="http://getstat.us/g/<?php echo $url['short'] ?>">getstat.us/g/<?php echo $url['short'] ?></a></td>
							<td data-id="<?php echo $url['id'] ?>">Get Stats</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
	    </div>
	    <div class="span8">
	      <div id="line"></div>
	      <div id="donut"></div>
	    </div>
	  </div>
	</div>
</div>
<script type="text/javascript">
	$('.table [data-id]').on('click', function(){
		var id = $(this).attr('data-id');
		loadLineGraph(id);
		loadDonutGraph(id);
		
	});
	function loadLineGraph(id){
		$.get('/admin/line/data/' + id, function(data){
			var line = [];
			for(var i in data){
				var newData = data[i]; 
				line.push({y: newData[0], a: ~~newData[1]});
			}
			Morris.Line({
			  element: 'line',
			  data: line,
			  xkey: 'y',
			  ykeys: ['a'],
			  labels: ['Series A']
			});
		}, 'json');
	}
	function loadDonutGraph(id){
		$.get('/admin/donut/data/' + id, function(data){
			var donut = [];
			for(var i in data){
				var newData = data[i]; 
				donut.push({label: newData[0], value: ~~newData[1]});
			}
			Morris.Donut({
			  element: 'donut',
			  data: donut
			});
		}, 'json');
	}
</script>