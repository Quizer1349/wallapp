<!-- Main data-->
<div class="row">
    <div class="span12 well">
        <div>
        <?php foreach($tags as $tag){
                echo ' <a href="' . base_url() . 'tag/' . $tag['tag'] . '">   ';
                echo ' <span class="label">' . $tag['tag'] . '</span>   ';
                echo ' </a>';
              } ?>
        </div>
    </div>
</div>
