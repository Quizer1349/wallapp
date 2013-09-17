<!-- Main data-->
<div class="row">
	<div class="span12 well">
        <ul class="thumbnails">
            <?php foreach($images_data as $image){ ?>
                <li class="span3">
                    <div class="thumbnail">
                        <a href="<?php echo site_url("image/get/" . str_replace('/', '__', $image['src_url']))?>">
                            <img src="<?php echo $image['thumb_url']?>" alt="">
                        </a>
                        <div class="btn-group" style="margin: 5px">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                Image Tags
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php foreach($image['tags'] as $tag_data){
                                    foreach($tag_data as $tag => $data)
                                    echo ' <li class="label">' . $tag . ' : ' . $data . '</li><br>';
                                } ?>
                            </ul>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
	</div>
</div>
