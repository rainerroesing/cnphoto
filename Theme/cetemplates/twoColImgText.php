<div class="row">

    <div class="col-xs-12 col-sm-5 col-md-offset-1 wow fadeIn" data-wow-delay="0.2s">
        <?php
        $imgobj = get_sub_field('image');
        ?>
        <img class="img-responsive" data-thumbimg="<?php echo wp_get_attachment_image_url( $imgobj['ID'], 'thumbnail' ); ?>" src="<?php echo $imgobj['url']; ?>"
             srcset="<?php echo wp_get_attachment_image_srcset($imgobj['ID']); ?>"
             alt="<?php echo $imgobj['alt'];?>">
    </div>

    <div class="topspace col-xs-12 col-sm-7 col-md-6 col-sm-pull-1 wow fadeIn" data-wow-delay="0.4s">


        <div class="copy">

            <?php echo get_sub_field('content'); ?>

            <div class="tl"></div>
            <div class="tr"></div>
            <div class="bl"></div>
            <div class="br"></div>

        </div>

    </div>
</div>