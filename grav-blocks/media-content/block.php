<?php

	$media_type = get_sub_field('media_type');
	if(!$media_type)
	{
		$media_type = 'image';
	}

	$video_url = get_sub_field('video_'.get_sub_field('video_type'));

	$embed = get_sub_field('embed');
	$video_attributes = get_sub_field('video_attributes');

	$placement = ($right = get_sub_field('image_placement')) ? $right : 'left';
	$col_width = get_sub_field('image_size');
	$content = get_sub_field('content');
	$col_array = GRAV_BLOCKS::column_width_options();

	$col_total = ($col_width > 4 )? 12 : 10;
	$col_total = apply_filters('grav_block_mediacontent_columns', $col_total, $col_width, $placement);
	$col_content_width = $col_total-$col_width;
	$col_class = 'col-option-'.$placement.'-'.sanitize_title($col_array[$col_width]);

	$bottom_classes = GRAV_BLOCKS::css()->col(12, $col_content_width)->add($col_class)->get();
	$top_classes = GRAV_BLOCKS::css()->col(12, $col_width)->add($col_class.', block-media-content__col-media')->get();
	if($placement == 'right'){
		$top_classes = GRAV_BLOCKS::css()->col(12, $col_width)->add('medium-order-2, '.$col_class.', block-media-content__col-media')->get();
		$bottom_classes = GRAV_BLOCKS::css()->col(12, $col_content_width)->add('medium-order-1, '.$col_class)->get();
	}

	$image_format = '';
	if ($media_type == 'image' && $col_width >= 6) {
		$image_format = ' ' . get_sub_field('image_format');
	}

?>

<div class="block-inner <?php echo $placement.'-'.sanitize_title($col_array[$col_width]); echo $image_format; ?>">
	<div class="<?php echo GRAV_BLOCKS::css()->row()->add(array('block-media-content__media-type--'.$media_type.'-container',($col_width > 5 && $format != 'fullbleed') ? 'align-center' : 'align-' . $placement))->get(); ?>">
		<div class="<?php echo $top_classes; ?>">
			<?php if($link = GRAV_BLOCKS::get_link_url('link')){ ?>
				<a class="block-link-<?php echo esc_attr(get_sub_field('link_type'));?>" href="<?php echo esc_url($link); ?>">
			<?php } ?>

			<div class="block-media-content__media-type--<?php echo $media_type;?>">
				<?php if($media_type === 'video' && $video_url){ ?>
					<video src="<?php echo $video_url;?>" <?php echo implode(' ', $video_attributes);?>></video>
				<?php } ?>

				<?php if($media_type === 'embed'){ ?>
					<?php echo $embed;?>
				<?php } ?>

				<?php if($media_type === 'image'){ ?>
				<?php echo GRAV_BLOCKS::image(get_sub_field('image'), array(), 'img', 'large');?>
				<?php } ?>
			</div>

			<?php if($link){ ?>
				</a>
			<?php } ?>
		</div>
		<div class="<?php echo $bottom_classes; ?> block-media-content__col-content">
			<?php echo $content; ?>
		</div>
	</div>
</div>
