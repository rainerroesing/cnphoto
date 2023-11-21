<?php
$albumid = 0;
if ( intval( $_GET['albumid'] ) > 0 ) {
	$albumid = intval( $_GET['albumid'] );
}
?>
<script type="text/javascript">
	var currentAlbumId = <?php echo $albumid; ?>;
</script>
<div id="titlediv">
	<div id="titlewrap">
		<label class="screen-reader-text" id="title-prompt-text" for="title">Titel hier eingeben</label>
		<input type="text" name="post_title" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Titel hier eingeben"/>
	</div>
</div>
<hr />
<h3>Vorschaubild</h3>
<img src="" id="album_previmg" style="width:150px; height: 150px;" /><br/><button type="button" class="button" onclick="cng_albedit.select_album_previewimg()">Vorschaubild wählen...</button>

<hr />
<h3>Inhalte</h3>
<div id="cngal_editcommandbar">
	<button type="button" class="button" onclick="cng_albedit.add_item('image');">Bild hinzufügen</button>
	<button type="button" class="button" onclick="cng_albedit.add_item('video');">Video hinzufügen</button>
	<span style="float:right; margin-right:0;" id="loading_indicator"><img src="images/wpspin_light.gif" style="vertical-align: middle"/> Bitte warten...</span>
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
		<button type="button" class="button" onclick="cng_albedit.select_video_previewimg()">Wählen...</button>
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

<script type="text/javascript">

	var cng_albedit = {};
	var loadingCount = 0;
	var mediaUploader;


	cng_albedit.item_list = [];
	cng_albedit.previmg_id = 0;

	cng_albedit.load_album = function () {
		cng_albedit.item_list = [];
		cng_albedit.loading.add();
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {
				'action': 'cng_album_getdetails',
				'album_id': currentAlbumId,
			},
			dataType: 'json',
			success: function (response) {

				cng_albedit.item_list = [];
				jQuery(response.items).each(function (index) {
					cng_albedit.item_list.push(response.items[index]);
				});
				jQuery('#title').val(response.album_title);
				cng_albedit.previmg_id = response.previmg_id;
				jQuery('#album_previmg').attr('src', response.previmg_url);
				cng_albedit.redraw_editarea();
				cng_albedit.loading.rem();
			}
		});
	};

	cng_albedit.redraw_editarea = function () {
		jQuery('#cngal_sortable').empty();
		jQuery(cng_albedit.item_list).each(function (index) {
			if (this.mediatype == 'image') {
				jQuery('#cngal_sortable').append('<li class="cngal_editbox ui-state-default" id="box_' + index + '" data-mediatype="' + this.mediatype + '" data-type="' + this.itemtype + '" data-id="' + this.item_id + '"><img src="' + this.previmg_url + '"><i class="thumbicon videoicon fa fa-video-camera" style="visibility: hidden;"></i><i class="thumbicon itemeditbutton fa fa-pencil"></i><i class="thumbicon itemdeletebutton fa fa-remove"></i></li>');
			}
			if (this.mediatype == 'video') {
				jQuery('#cngal_sortable').append('<li class="cngal_editbox ui-state-default" id="box_' + index + '" data-mediatype="' + this.mediatype + '" data-type="' + this.itemtype + '" data-id="' + this.item_id + '"><img src="' + this.previmg_url + '"><i class="thumbicon videoicon fa fa-video-camera"></i><i class="thumbicon itemeditbutton fa fa-pencil"></i><i class="thumbicon itemdeletebutton fa fa-remove"></i></li>');
			}
		});

		jQuery('.itemeditbutton').click(function (event) {
			var liElement = jQuery(event.srcElement).closest('li')[0];
			cng_albedit.do_item_action(liElement, 'edit');

		});
		jQuery('.itemdeletebutton').click(function (event) {
			var liElement = jQuery(event.srcElement).closest('li')[0];
			cng_albedit.do_item_action(liElement, 'delete');
		});
	};

	cng_albedit.update_ui = function () {
		if (loadingCount > 0) {
			jQuery('#loading_indicator').show();
		} else {
			jQuery('#loading_indicator').hide();
		}
	}

	cng_albedit.loading = {};
	cng_albedit.loading.add = function () {
		loadingCount++;
		cng_albedit.update_ui();
	}

	cng_albedit.loading.rem = function () {
		if (loadingCount > 0) {
			loadingCount--;
		}
		cng_albedit.update_ui();
	}

	cng_albedit.do_item_action = function (element, action) {
		var postid = jQuery(element).data('id');
		var mediatype = jQuery(element).data('mediatype');
		switch (action) {
			case 'edit':
				if(mediatype == 'image') {
					cng_albedit.loading.add();
					jQuery.ajax({
						url: ajaxurl,
						method: 'POST',
						data: {'action': 'cng_getimgattachmentid', 'item_id': postid},
						dataType: 'json',
						success: function (response) {
							var url = 'post.php?post=' + response.attachment_id + '&action=edit';
							window.open(url, '_blank');
							cng_albedit.loading.rem();
						}
					});
				}
				if(mediatype == 'video') {

					cng_albedit.loading.add();
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
								height: 400,
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
											cng_albedit.loading.add();
											jQuery.ajax({
												method: 'POST',
												url: ajaxurl,
												data: {'action': 'cng_updateitem', 'mediatype': 'video', 'previmg_id': previmgid, 'videourl': videourl, 'item_id': postid,  'termids': videotermids, 'videotitle': videotitle},
												dataType: 'json',
												success: function (response) {
													cng_albedit.refresh_items(true);
													cng_albedit.loading.rem();
													console.log('close here');
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
							cng_albedit.loading.rem();
							dialog.dialog("open");
						}
					});


					cng_albedit.loading.rem();
				}
				break;
			case 'delete':
				var delete_confirm = confirm('Möchten Sie das Element wirklich aus der Galerie entfernen?');
				if (delete_confirm) {
					cng_albedit.loading.add();
					jQuery.ajax({
						method: 'POST',
						url: ajaxurl,
						data: {'action': 'cng_deleteitem', 'item_id': postid},
						dataType: 'json',
						success: function (response) {
							if (response.success != true) {
								console.log(response);
							}
							cng_albedit.loading.rem();
							cng_albedit.refresh_items();
						}
					});

				}
				break;
		}
	}

	cng_albedit.save_itemorder = function () {
		var orderarr = [];
		jQuery('#cngal_sortable').children().each(function (index) {
			orderarr.push({'item_id': jQuery(this).data('id'), 'index': index});
		});
		cng_albedit.loading.add();
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: {'action': 'cng_reorderitems', 'orderarray': orderarr},
			dataType: 'json',
			success: function (response) {
				if (response.success != true) {
					console.log(response);
				}
				cng_albedit.loading.rem();
			}
		});
	}

	cng_albedit.add_item = function (mediatype) {

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
					cng_albedit.loading.add();
					jQuery.ajax({
						method: 'POST',
						url: ajaxurl,
						data: {'action': 'cng_additem', 'mediatype': 'image', 'image_id': file.id, 'album_id': currentAlbumId},
						dataType: 'json',
						success: function (response) {
							cng_albedit.refresh_items(true);
							cng_albedit.loading.rem();
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
				height: 400,
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
							cng_albedit.loading.add();
							jQuery.ajax({
								method: 'POST',
								url: ajaxurl,
								data: {'action': 'cng_additem', 'mediatype': 'video', 'previmg_id': previmgid, 'videourl': videourl,'termids': videotermids, 'videotitle': videotitle, 'album_id': currentAlbumId},
								dataType: 'json',
								success: function (response) {
									cng_albedit.refresh_items(true);
									cng_albedit.loading.rem();
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
	}

	cng_albedit.refresh_items = function (doSaveOrder) {
		cng_albedit.load_album();
		if(doSaveOrder) {
			cng_albedit.save_itemorder();
		}
	}

	cng_albedit.select_video_previewimg = function () {
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

	cng_albedit.select_album_previewimg = function() {
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
				cng_albedit.previmg_id = file.id;
				jQuery('#album_previmg').attr('src', file.toJSON().sizes.thumbnail.url);
				cng_albedit.update_album_details();
			})
		});

		mediaUploader.open();
	}

	cng_albedit.update_album_details = function() {
		cng_albedit.loading.add();
		jQuery.ajax({
			method: 'POST',
			url: ajaxurl,
			data: { 'action': 'cng_album_updatedetails', 'album_id': currentAlbumId, 'album_title': jQuery('#title').val(), 'album_previmg_id': cng_albedit.previmg_id },
			dataType: 'json',
			success: function(response) {
				cng_albedit.loading.rem();
			}
		});
	};

	jQuery(document).ready(function ($) {

		jQuery("#cngal_sortable").sortable({
			cursor: 'move',
			stop: function () {
				cng_albedit.save_itemorder();
			}
		});

		jQuery('#title').focusout(function() {
			cng_albedit.update_album_details();
		});


		if (currentAlbumId != 0) {
			cng_albedit.load_album();
		}

		cng_albedit.update_ui();
	});
</script>