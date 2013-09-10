<h1>Saved Tweets Watcher</h1>
<div class="hr"></div>
<!-- Navigation buttons-->
<div class="span12" style="margin-bottom:35px">
	<a href="<?php echo base_url(); ?>" style="margin-right:170px"><button class="btn btn-large" type="button">Load Tweets</button></a>
	<a href="<?php echo base_url(); ?>main/saver" style="margin-left:150px"><button class="btn btn-large btn-primary" type="button">Saved Tweets</button><span class="btn btn-large btn-primary"><?php echo $count_rows; ?></span></a>
</div>
<!-- Painted arrows-->
<div class="img_arrow_right"></div>
<!-- Main data-->
<div class="row">
	<div class="span12 well">
		<table class="table table-bordered table-striped table-hover">
				<?php foreach($tweets as $item):?>
					<tr>
						<td>
							<div class="span2">
								<a href="https://twitter.com/<?php echo $item['name'];?>"><img class='img-rounded' src="<?php echo $item['img'];?>"</img></a>
							</div>
							<blockquote style="width:700px;">
								<strong><a href="https://twitter.com/<?php echo $item['name'];?>"><?php echo $item['name'];?></a></strong>
								    <span style="font-size:80%; padding-left:30px"> ID# <?php echo $item['twitter_id'];?></span>
								<p><?php echo $item['text']."\n";?></p>
							<small><?php echo date('D F d H:i:s Y',  strtotime($item['date']));?></small>
							
						</td>
					<tr>
				<?php endforeach; ?> 
			</table>
		</div>
</div>
