/**
 * View logic for Notificaciones
 */

/**
 * application logic specific to the Notificacion listing page
 */
var page = {

	notificaciones: new model.NotificacionCollection(),
	collectionView: null,
	notificacion: null,
	modelView: null,
	isInitialized: false,
	isInitializing: false,

	fetchParams: { filter: '', orderBy: '', orderDesc: '', page: 1 },
	fetchInProgress: false,
	dialogIsOpen: false,

	/**
	 *
	 */
	init: function() {
		// ensure initialization only occurs once
		if (page.isInitialized || page.isInitializing) return;
		page.isInitializing = true;

		if (!$.isReady && console) console.warn('page was initialized before dom is ready.  views may not render properly.');

		// make the new button clickable
		$("#newNotificacionButton").click(function(e) {
			e.preventDefault();
			page.showDetailDialog();
		});

		// let the page know when the dialog is open
		$('#notificacionDetailDialog').on('show',function() {
			page.dialogIsOpen = true;
		});

		// when the model dialog is closed, let page know and reset the model view
		$('#notificacionDetailDialog').on('hidden',function() {
			$('#modelAlert').html('');
			page.dialogIsOpen = false;
		});

		// save the model when the save button is clicked
		$("#saveNotificacionButton").click(function(e) {
			e.preventDefault();
			page.updateModel();
		});

		// initialize the collection view
		this.collectionView = new view.CollectionView({
			el: $("#notificacionCollectionContainer"),
			templateEl: $("#notificacionCollectionTemplate"),
			collection: page.notificaciones
		});

		// initialize the search filter
		$('#filter').change(function(obj) {
			page.fetchParams.filter = $('#filter').val();
			page.fetchParams.page = 1;
			page.fetchNotificaciones(page.fetchParams);
		});
		
		// make the rows clickable ('rendered' is a custom event, not a standard backbone event)
		this.collectionView.on('rendered',function(){

			// attach click handler to the table rows for editing
			$('table.collection tbody tr').click(function(e) {
				e.preventDefault();
				var m = page.notificaciones.get(this.id);
				page.showDetailDialog(m);
			});

			// make the headers clickable for sorting
 			$('table.collection thead tr th').click(function(e) {
 				e.preventDefault();
				var prop = this.id.replace('header_','');

				// toggle the ascending/descending before we change the sort prop
				page.fetchParams.orderDesc = (prop == page.fetchParams.orderBy && !page.fetchParams.orderDesc) ? '1' : '';
				page.fetchParams.orderBy = prop;
				page.fetchParams.page = 1;
 				page.fetchNotificaciones(page.fetchParams);
 			});

			// attach click handlers to the pagination controls
			$('.pageButton').click(function(e) {
				e.preventDefault();
				page.fetchParams.page = this.id.substr(5);
				page.fetchNotificaciones(page.fetchParams);
			});
			
			page.isInitialized = true;
			page.isInitializing = false;
		});

		// backbone docs recommend bootstrapping data on initial page load, but we live by our own rules!
		this.fetchNotificaciones({ page: 1 });

		// initialize the model view
		this.modelView = new view.ModelView({
			el: $("#notificacionModelContainer")
		});

		// tell the model view where it's template is located
		this.modelView.templateEl = $("#notificacionModelTemplate");

		if (model.longPollDuration > 0)	{
			setInterval(function () {

				if (!page.dialogIsOpen)	{
					page.fetchNotificaciones(page.fetchParams,true);
				}

			}, model.longPollDuration);
		}
	},

	/**
	 * Fetch the collection data from the server
	 * @param object params passed through to collection.fetch
	 * @param bool true to hide the loading animation
	 */
	fetchNotificaciones: function(params, hideLoader) {
		// persist the params so that paging/sorting/filtering will play together nicely
		page.fetchParams = params;

		if (page.fetchInProgress) {
			if (console) console.log('supressing fetch because it is already in progress');
		}

		page.fetchInProgress = true;

		if (!hideLoader) app.showProgress('loader');

		page.notificaciones.fetch({

			data: params,

			success: function() {

				if (page.notificaciones.collectionHasChanged) {
					// TODO: add any logic necessary if the collection has changed
					// the sync event will trigger the view to re-render
				}

				app.hideProgress('loader');
				page.fetchInProgress = false;
			},

			error: function(m, r) {
				app.appendAlert(app.getErrorMessage(r), 'alert-error',0,'collectionAlert');
				app.hideProgress('loader');
				page.fetchInProgress = false;
			}

		});
	},

	/**
	 * show the dialog for editing a model
	 * @param model
	 */
	showDetailDialog: function(m) {

		// show the modal dialog
		$('#notificacionDetailDialog').modal({ show: true });

		// if a model was specified then that means a user is editing an existing record
		// if not, then the user is creating a new record
		page.notificacion = m ? m : new model.NotificacionModel();

		page.modelView.model = page.notificacion;

		if (page.notificacion.id == null || page.notificacion.id == '') {
			// this is a new record, there is no need to contact the server
			page.renderModelView(false);
		} else {
			app.showProgress('modelLoader');

			// fetch the model from the server so we are not updating stale data
			page.notificacion.fetch({

				success: function() {
					// data returned from the server.  render the model view
					page.renderModelView(true);
				},

				error: function(m, r) {
					app.appendAlert(app.getErrorMessage(r), 'alert-error',0,'modelAlert');
					app.hideProgress('modelLoader');
				}

			});
		}

	},

	/**
	 * Render the model template in the popup
	 * @param bool show the delete button
	 */
	renderModelView: function(showDeleteButton)	{
		page.modelView.render();

		app.hideProgress('modelLoader');

		// initialize any special controls
		try {
			$('.date-picker')
				.datepicker()
				.on('changeDate', function(ev){
					$('.date-picker').datepicker('hide');
				});
		} catch (error) {
			// this happens if the datepicker input.value isn't a valid date
			if (console) console.log('datepicker error: '+error.message);
		}
		
		$('.timepicker-default').timepicker({ defaultTime: 'value' });


        // poblar el combobox con los posters
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var posterValues = new model.PosterCollection();
        posterValues.fetch({
            success: function(c){
                var dd = $('#fkposter');
                c.forEach(function(item,index)
                {
                    dd.append(app.getOptionHtml(
                        item.get('pkposter'),
                        item.get('pkposter'),
                        page.notificacion.get('fkposter') == item.get('pkposter')
                    ));
                });
            },
            error: function(collection,response,scope){
                app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
            }
        });

        // poblar el combobox con los usuarios destinos
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var destinoValues = new model.UsuarioCollection();
        destinoValues.fetch({
            success: function(c){
                var dd = $('#fkusuarioDestino');
                c.forEach(function(item,index)
                {
                    dd.append(app.getOptionHtml(
                        item.get('pkusuario'),
                        item.get('nombre'),
                        page.notificacion.get('fkusuario') == item.get('pkusuario')
                    ));
                });
            },
            error: function(collection,response,scope){
                app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
            }
        });

		if (showDeleteButton) {
			// attach click handlers to the delete buttons

			$('#deleteNotificacionButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteNotificacionContainer').show('fast');
			});

			$('#cancelDeleteNotificacionButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteNotificacionContainer').hide('fast');
			});

			$('#confirmDeleteNotificacionButton').click(function(e) {
				e.preventDefault();
				page.deleteModel();
			});

		} else {
			// no point in initializing the click handlers if we don't show the button
			$('#deleteNotificacionButtonContainer').hide();
		}
	},

	/**
	 * update the model that is currently displayed in the dialog
	 */
	updateModel: function() {
		// reset any previous errors
		$('#modelAlert').html('');
		$('.control-group').removeClass('error');
		$('.help-inline').html('');

		// if this is new then on success we need to add it to the collection
		var isNew = page.notificacion.isNew();

		app.showProgress('modelLoader');

		page.notificacion.save({

			'fecha': $('input#fecha').val(),
			'hora': $('input#hora').val(),
			'fkusuarioDestino': $('select#fkusuarioDestino').val(),
			'fkposter': $('select#fkposter').val(),
			'visto': +$('input#visto').is(":checked"),
		}, {
			wait: true,
			success: function(){
				$('#notificacionDetailDialog').modal('hide');
				setTimeout("app.appendAlert('Notificacion was sucessfully " + (isNew ? "inserted" : "updated") + "','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				// if the collection was initally new then we need to add it to the collection now
				if (isNew) { page.notificaciones.add(page.notificacion) }

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchNotificaciones(page.fetchParams,true);
				}
		},
			error: function(model,response,scope){

				app.hideProgress('modelLoader');

				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');

				try {
					var json = $.parseJSON(response.responseText);

					if (json.errors) {
						$.each(json.errors, function(key, value) {
                            $('#'+key).parent().addClass('has-error has-feedback');
                            $('#'+key).next().html('<i class="fa fa-times"></i> '+value).addClass('text-danger').show();
						});
					}
				} catch (e2) {
					if (console) console.log('error parsing server response: '+e2.message);
				}
			}
		});
	},

	/**
	 * delete the model that is currently displayed in the dialog
	 */
	deleteModel: function()	{
		// reset any previous errors
		$('#modelAlert').html('');

		app.showProgress('modelLoader');

		page.notificacion.destroy({
			wait: true,
			success: function(){
				$('#notificacionDetailDialog').modal('hide');
				setTimeout("app.appendAlert('The Notificacion record was deleted','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchNotificaciones(page.fetchParams,true);
				}
			},
			error: function(model,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
				app.hideProgress('modelLoader');
			}
		});
	}
};

