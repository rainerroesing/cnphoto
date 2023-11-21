<?php
?>

<hr/>

<div id="cngal_editcommandbar">
	<button type="button" class="button" onclick="cng_main.add_item('image');">Bild hinzufügen</button>
	<button type="button" class="button" onclick="cng_main.add_item('video');">Video hinzufügen</button>
	<button type="button" class="button" onclick="cng_main.add_item('album');">Album hinzufügen</button>
	<span style="float:right; margin-right:0;" id="loading_indicator"><img src="images/wpspin_light.gif" style="vertical-align: middle"/> Bitte warten...</span>
	<!--<button type="button" class="button button-primary button-large" id="btn_save" style="float:right; margin-right:0;">Speichern</button>-->
</div>

<div id="cngal_mainedit">
	<ul id="cngal_sortable">

	</ul>
</div>

<div id="addVideo-form" title="Video hinzufügen" style="display: none;">
	<div class="acf-label">
		<label for="cng_fld_videotitle">Titel:</label>
	</div>
	<div class="acf-input">
		<input type="text" id="cng_fld_videotitle" class="" name="cng_fld_videotitle" value="" style="width: 100%;"/>
	</div>
	<div class="acf-label">
		<label for="cng_fld_videourl">Vimeo ID:</label>
	</div>
	<div class="acf-input">
		<input type="url" id="cng_fld_videourl" class="" name="cng_fld_videourl" value="" placeholder="" style="width: 100%;"/>
	</div>
	<hr/>
	<div class="acf-label">
		<label for="cng_fld_videoprevimg">Vorschaubild:</label>
	</div>
	<div class="acf-input">
		<input type="hidden" name="cng_fld_videoprevimgid" id="cng_fld_videoprevimgid" value=""/>
		<img src="" id="cng_fld_videoprevimg" width="150" height="150" style="border:1px solid #9d9d9d;">
		<button type="button" class="button" onclick="cng_main.select_video_previewimg()">Wählen...</button>
	</div>
	<hr/>
	<div class="acf-label">
		<label for="cng_fld_videoterms">Kategorien:</label>
	</div>
	<div class="acf-input">
		<?php
		$terms = get_terms('media_category');
		foreach($terms as $term) {
			echo sprintf('<input type="checkbox" name="cng_fld_videoterms" value="%s" /> %s ',$term->term_id, $term->name);
		}
		?>
	</div>
</div>

<div id="addAlbum-form" title="Album hinzufügen" style="display: none;">
	<div class="acf-label">
		<label for="cng_fld_album">Album:</label>
	</div>
	<div class="acf-input">
		<select id="cng_fld_album" style="width: 100%"></select>
	</div>
</div>

<style>


</style>

<script type="text/javascript">

	var mediaUploader;
	var lastSelectionId;
	var cng_main = {};
	var loadingCount = 0;


	cng_main.current_list = [];

	cng_main.redraw_editarea = function () {
		jQuery('#cngal_sortable').empty();
		jQuery(this.current_list).each(function (index) {
			if(this.preview_img === null || this.preview_img === false) {
				this.preview_img = '<?php echo get_template_directory_uri() .'/cngalerie/notfound.png'; ?>';
			}
			if(this.mediatype == 'image') {
				jQuery('#cngal_sortable').append('<li class="cngal_editbox ui-state-default" id="box_' + index + '" data-mediatype="' + this.mediatype + '" data-type="' + this.itemtype + '" data-id="' + this.post_ID + '"><img src="' + this.preview_img + '"><i class="thumbicon videoicon fa fa-video-camera" style="visibility: hidden;"></i><i class="thumbicon itemeditbutton fa fa-pencil"></i><i class="thumbicon itemdeletebutton fa fa-remove"></i></li>');
			}
			if(this.mediatype == 'video') {
				jQuery('#cngal_sortable').append('<li class="cngal_editbox ui-state-default" id="box_' + index + '" data-mediatype="' + this.mediatype + '" data-type="' + this.itemtype + '" data-id="' + this.post_ID + '"><img src="' + this.preview_img + '"><i class="thumbicon videoicon fa fa-video-camera"></i><i class="thumbicon itemeditbutton fa fa-pencil"></i><i class="thumbicon itemdeletebutton fa fa-remove"></i></li>');
			}
			if(this.mediatype == 'album') {
				jQuery('#cngal_sortable').append('<li class="cngal_editbox ui-state-default" id="box_' + index + '" data-mediatype="' + this.mediatype + '" data-type="' + this.itemtype + '" data-id="' + this.post_ID + '" data-album-postid="' + this.album_post_id + '"><img src="' + this.preview_img + '"><i class="thumbicon albumicon fa fa-th-large"></i><i class="thumbicon itemeditbutton fa fa-pencil"></i></a><i class="thumbicon itemdeletebutton fa fa-remove"></i></li>');
			}
		});

		jQuery('.itemeditbutton').click(function (event) {
			var liElement = jQuery(event.srcElement).closest('li')[0];
			cng_main.do_item_action(liElement, 'edit');

		});
		jQuery('.itemdeletebutton').click(function (event) {
			var liElement = jQuery(event.srcElement).closest('li')[0];
			cng_main.do_item_action(liElement, 'delete');
		});
	}

	cng_main.do_item_action = function (element, action) {
		var postid = jQuery(element).data('id');
		var mediatype = jQuery(element).data('mediatype');
		switch (action) {
			case 'edit':
				if(mediatype == 'image') {
					cng_main.loading.add();
					jQuery.ajax({
						url: ajaxurl,
						method: 'POST',
						data: {'action': 'cng_getimgattachmentid', 'item_id': postid},
						dataType: 'json',
						success: function (response) {
							var url = 'post.php?post=' + response.attachment_id + '&action=edit';
							window.open(url, '_blank');
							cng_main.loading.rem();
						}
					});
				}
				if(mediatype == 'video') {

					cng_main.loading.add();
					jQuery.ajax({
						url:ajaxurl,
						method: 'POST',
						data: {
							'action': 'cng_getvideoinfo',
							'item_id': postid
						},
						dataType: 'json',
						success: function(response) {
							jQuery('#cng_fld_videourl').val(response.videourl);
							jQuery('#cng_fld_videoprevimgid').val(response.previmg_id);
							jQuery('#cng_fld_videoprevimg').attr('src', response.previmg_url);
							jQuery('#cng_fld_videotitle').val(response.videotitle);
							response.termids.map(function(id) {
								jQuery('[name="cng_fld_videoterms"][value="'+ id +'"]').prop('checked', true);
							});

							dialog = jQuery("#addVideo-form").dialog({
								title: 'Video bearbeiten',
								autoOpen: false,
								height: 500,
								width: 550,
								modal: true,
								buttons: {
									"Speichern": function () {
										videourl = jQuery('#cng_fld_videourl').val();
										previmgid = jQuery('#cng_fld_videoprevimgid').val();
										videotitle = jQuery('#cng_fld_videotitle').val();
										videotermids = [];
										jQuery('[name="cng_fld_videoterms"]:checked').map(function() { videotermids.push(this.value); });
										if (videourl.length >= 1 && previmgid >= 1) {
											cng_main.loading.add();
											jQuery.ajax({
												method: 'POST',
												url: ajaxurl,
												data: {'action': 'cng_updateitem', 'mediatype': 'video', 'previmg_id': previmgid, 'videourl': videourl, 'item_id': postid, 'termids': videotermids, 'videotitle': videotitle},
												dataType: 'json',
												success: function (response) {
													cng_main.refresh_items(true);
													cng_main.loading.rem();
													dialog.dialog("close");
												}
											});
										} else {
											alert('Bitte alle Felder ausfüllen.');
										}
									},
									"Abbrechen": function () {
										dialog.dialog("close");
									}
								},
								close: function () {
									jQuery('#cng_fld_videourl').val('');
									jQuery('#cng_fld_videoprevimgid').val('');
									jQuery('#cng_fld_videoprevimg').attr('src', '');
									jQuery('#cng_fld_videotitle').val('');
									jQuery('[name="cng_fld_videoterms"]').map(function() { jQuery(this).prop('checked',false); });
								}
							});
							dialog.dialog("open");
						}
					});
					cng_main.loading.rem();
				}

				if(mediatype == 'album') {
					album_postid = jQuery(element).data('album-postid');
					window.open('admin.php?page=cngal-album-edit&albumid=' + album_postid, '_blank');
				}
				break;
			case 'delete':
				var delete_confirm = confirm('Möchten Sie das Element wirklich aus der Galerie entfernen?');
				if (delete_confirm) {
					cng_main.loading.add();
					jQuery.ajax({
						method: 'POST',
						url: ajaxurl,
						data: {'action': 'cng_deleteitem', 'item_id': postid},
						dataType: 'json',
						success: function (response) {
							if (response.success != true) {
								console.log(response);
							}
							cng_main.loading.rem();
							cng_main.refresh_items();
						}
					});

				}
				break;
		}
	}


	cng_main.add_item = function (mediatype) {

		if (mediatype === 'image') {

			mediaUploader = null;
			if (mediaUploader) {
				mediaUploader.open();
				return;
			}

			mediaUploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: {
					text: 'Choose Image'
				}, multiple: true
			});

			mediaUploader.on('select', function () {
				var selection = mediaUploader.state().get('selection');
				selection.map(function (file) {
					cng_main.loading.add();
					jQuery.ajax({
						method: 'POST',
						url: ajaxurl,
						data: {'action': 'cng_additem', 'mediatype': 'image', 'image_id': file.id},
						dataType: 'json',
						success: function (response) {
							cng_main.refresh_items(true);
							cng_main.loading.rem();
						}
					});

				})

			});

			mediaUploader.open();
		}

		if (mediatype === 'video') {
			dialog = jQuery("#addVideo-form").dialog({
				title: 'Video hinzufügen',
				autoOpen: false,
				height: 500,
				width: 550,
				modal: true,
				buttons: {
					"Hinzufügen": function () {
						videourl = jQuery('#cng_fld_videourl').val();
						previmgid = jQuery('#cng_fld_videoprevimgid').val();
						videotitle = jQuery('#cng_fld_videotitle').val();
						videotermids = [];
						jQuery('[name="cng_fld_videoterms"]:checked').map(function() { videotermids.push(this.value); });
						if (videourl.length >= 1 && previmgid >= 1) {
							cng_main.loading.add();
							jQuery.ajax({
								method: 'POST',
								url: ajaxurl,
								data: {'action': 'cng_additem', 'mediatype': 'video', 'previmg_id': previmgid, 'videourl': videourl, 'termids': videotermids, 'videotitle': videotitle},
								dataType: 'json',
								success: function (response) {
									cng_main.refresh_items(true);
									cng_main.loading.rem();
									dialog.dialog("close");
								}
							});
						} else {
							alert('Bitte alle Felder ausfüllen.');
						}
					},
					"Abbrechen": function () {
						dialog.dialog("close");
					}
				},
				close: function () {
					jQuery('#cng_fld_videourl').val('');
					jQuery('#cng_fld_videoprevimgid').val('');
					jQuery('#cng_fld_videoprevimg').attr('src', '');
					jQuery('#cng_fld_videotitle').val('');
					jQuery('[name="cng_fld_videoterms"]').map(function() { jQuery(this).prop('checked',false); });
				}
			});

			dialog.dialog("open");
		}

		if(mediatype === 'album') {

			jQuery.ajax({
				method: 'POST',
				url: ajaxurl,
				data: { 'action': 'cng_albums_get' },
				dataType: 'json',
				success: function(response) {
					jQuery('#cng_fld_album').empty();
					jQuery(response).each(function(index) {
						jQuery('#cng_fld_album').append(jQuery('<option></option>').attr('value', response[index].id).text(response[index].title));
					});

					dialog = jQuery("#addAlbum-form").dialog({
						autoOpen: false,
						height: 300,
						width: 350,
						modal: true,
						buttons: {
							"Hinzufügen": function () {
								if(jQuery('#cng_fld_album').val().length > 0) {
									cng_main.loading.add();
									jQuery.ajax({
										method: 'POST',
										url: ajaxurl,
										data: {'action': 'cng_additem', 'mediatype': 'album', 'album_id': jQuery('#cng_fld_album').val()},
										dataType: 'json',
										success: function (response) {
											cng_main.refresh_items(true);
											cng_main.loading.rem();
											dialog.dialog("close");
										}
									});
								} else {
									alert('Bitte wählen Sie ein Album aus.');
								}
							},
							"Abbrechen": function () {
								dialog.dialog("close");
							}
						},
						close: function () {
						}
					});
					dialog.dialog("open");
				}
			});


		}
	}

	cng_main.select_video_previewimg = function () {
		mediaUploader = null;
		if (mediaUploader) {
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Vorschaubild wählen',
			button: {
				text: 'Vorschaubild wählen'
			}, multiple: true
		});

		mediaUploader.on('select', function () {
			var selection = mediaUploader.state().get('selection');
			selection.map(function (file) {
				jQuery('#cng_fld_videoprevimgid').val(file.id);
				jQuery('#cng_fld_videoprevimg').attr('src', file.toJSON().sizes.thumbnail.url);
			})

		});

		mediaUploader.open();
	}

	cng_main.update_ui = function () {
		if (loadingCount > 0) {
			jQuery('#loading_indicator').show();
		} else {
			jQuery('#loading_indicator').hide();
		}
	}

	cng_main.loading = {};
	cng_main.loading.add = function () {
		loadingCount++;
		cng_main.update_ui();
	}
	cng_main.loading.rem = function () {
		if (loadingCount > 0) {
			loadingCount--;
		}
		cng_main.update_ui();
	}

	cng_main.refresh_items = function (doSaveOrder) {
		var data = {
			'action': 'cng_getitems',
		};
		cng_main.loading.add();
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: data,
			dataType: 'json',
			success: function (response) {
				cng_main.current_list = [];
				jQuery(response).each(function (index) {
					cng_main.current_list.push(response[index])
				});
				cng_main.redraw_editarea();
				if (doSaveOrder) {
					cng_main.save_itemorder();
				}
				cng_main.loading.rem();
			}
		});
	}

	cng_main.save_itemorder = function () {
		var orderarr = [];
		jQuery('#cngal_sortable').children().each(function (index) {
			orderarr.push({'item_id': jQuery(this).data('id'), 'index': index});
		});
		cng_main.loading.add();
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {'action': 'cng_reorderitems', 'orderarray': orderarr},
			dataType: 'json',
			success: function (response) {
				if (response.success != true) {
					console.log(response);
				}
				cng_main.loading.rem();
			}
		});
	}

	jQuery(document).ready(function ($) {


		jQuery("#cngal_sortable").sortable({
			cursor: 'move',
			stop: function () {
				cng_main.save_itemorder();
			}
		});

		cng_main.refresh_items();
	});
</script>