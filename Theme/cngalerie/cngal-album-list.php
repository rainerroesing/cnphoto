<?php
$query_args = array(
	'post_type'      => 'cngalbum',
	'posts_per_page' => - 1,
	'orderby'        => 'title',
	'order'          => 'ASC',
);

$albums = new WP_Query( $query_args );

$currentRow = 0;
?>
<hr/>
<div id="cngal_editcommandbar">
	<a href="#" onclick="cng_album.create_album()" class="button">Neues Album</a>
	<span style="float:right; margin-right:0;" id="loading_indicator"><img src="images/wpspin_light.gif" style="vertical-align: middle"/> Bitte warten...</span>
</div>

<table class="widefat fixed" cellspacing="0">
	<thead>
	<tr>
		<th style="width:120px;" id="col_previmg" class="manage-column column-col_previmg" scope="col">Vorschaubild</th>
		<th id="col_name" class="manage-column column-col_name" scope="col">Name</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ( $albums->posts as $album ): ?>
		<tr class="<?php echo ( $currentRow % 2 != 0 ) ? 'alternate' : ''; ?>" valign="top">
			<td class="column-columnname"><img src="<?php echo wp_get_attachment_image_url( get_post_meta( $album->ID, 'cng_image' )[0], 'thumbnail' ); ?>" style="width:120px; height: 120px;"/></td>
			<td class="column-columnname">
				<?php echo $album->post_title; ?>
				<div class="row-actions">
					<span><a href="admin.php?page=cngal-album-edit&albumid=<?php echo $album->ID; ?>" data-albumid="<?php echo $album->ID; ?>">Bearbeiten</a> |</span>
					<span class="trash"><a class="" href="#" onclick="cng_album.delete_album(<?php echo $album->ID; ?>)" data-albumid="<?php echo $album->ID; ?>"> Löschen</a></span>
				</div>
			</td>
		</tr>
		<?php $currentRow ++; endforeach; ?>
	</tbody>
	<tfoot>
	<tr>
		<th class="manage-column column-col_previmg" scope="col"></th>
		<th class="manage-column column-col_name" scope="col"></th>
	</tr>
	</tfoot>
</table>

<script type="text/javascript">
	var cng_album = {};
	var loadingCount = 0;

	cng_album.update_ui = function () {
		if (loadingCount > 0) {
			jQuery('#loading_indicator').show();
		} else {
			jQuery('#loading_indicator').hide();
		}
	}

	cng_album.loading = {};
	cng_album.loading.add = function () {
		loadingCount++;
		cng_album.update_ui();
	}
	cng_album.loading.rem = function () {
		if (loadingCount > 0) {
			loadingCount--;
		}
		cng_album.update_ui();
	}

	cng_album.delete_album = function (albumid) {

		var confirm_delete = confirm('Möchten Sie das Album wirklich löschen?');
		if (confirm_delete) {
			cng_album.loading.add();
			jQuery.ajax({
				method: 'POST',
				url: ajaxurl,
				data: {'action': 'cng_album_delete', 'album_id': albumid},
				dataType: 'json',
				success: function (response) {
					location.reload();
					cng_album.loading.rem();
				}
			});
		}
	}

	cng_album.create_album = function () {
		cng_album.loading.add();
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: { 'action': 'cng_album_create' },
			dataType: 'json',
			success: function(response) {
				cng_album.loading.rem();
				location.href = 'admin.php?page=cngal-album-edit&albumid=' + response.new_album_id;
			}
		});
	}

	jQuery(document).ready(function ($) {

		cng_album.update_ui();
	});
</script>