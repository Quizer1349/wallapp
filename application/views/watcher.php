<!-- Main data-->
<div class="row">
	<div class="span12 well">
        <ul class="thumbnails">
            <?php
            if($images_data !== null){
                foreach($images_data as $image){ ?>
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
                                        echo ' <a href="' . base_url() . 'tag/' . $tag_data['tag'] . '">   ';
                                        echo ' <li class="label">' . $tag_data['tag'] . ' : ' . $tag_data['value'] . '</li><br>';
                                        echo '</a>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php }
            }else{
                echo "<div style='text-align: center' class='span12'>Images not found!</div>";
            }
            ?>
        </ul>
	</div>
</div>
