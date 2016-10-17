/**
 * View logic for Afiliados
 */

/**
 * application logic specific to the Afiliado listing page
 */
var page = {

	afiliados: new model.AfiliadoCollection(),
	collectionView: null,
	afiliado: null,
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
		$("#newAfiliadoButton").click(function(e) {
			e.preventDefault();
			page.showDetailDialog();
		});

		// let the page know when the dialog is open
		$('#afiliadoDetailDialog').on('show',function() {
			page.dialogIsOpen = true;
		});

		// when the model dialog is closed, let page know and reset the model view
		$('#afiliadoDetailDialog').on('hidden',function() {
			$('#modelAlert').html('');
			page.dialogIsOpen = false;
		});

		// save the model when the save button is clicked
		$("#saveAfiliadoButton").click(function(e) {
			e.preventDefault();
			page.updateModel();
		});

		// initialize the collection view
		this.collectionView = new view.CollectionView({
			el: $("#afiliadoCollectionContainer"),
			templateEl: $("#afiliadoCollectionTemplate"),
			collection: page.afiliados
		});

		// initialize the search filter
		$('#filter').change(function(obj) {
			page.fetchParams.filter = $('#filter').val();
			page.fetchParams.page = 1;
			page.fetchAfiliados(page.fetchParams);
		});
		
		// make the rows clickable ('rendered' is a custom event, not a standard backbone event)
		this.collectionView.on('rendered',function(){

			// attach click handler to the table rows for editing
			$('table.collection tbody tr').click(function(e) {
				e.preventDefault();
				var m = page.afiliados.get(this.id);
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
 				page.fetchAfiliados(page.fetchParams);
 			});

			// attach click handlers to the pagination controls
			$('.pageButton').click(function(e) {
				e.preventDefault();
				page.fetchParams.page = this.id.substr(5);
				page.fetchAfiliados(page.fetchParams);
			});
			
			page.isInitialized = true;
			page.isInitializing = false;
		});

		// backbone docs recommend bootstrapping data on initial page load, but we live by our own rules!
		this.fetchAfiliados({ page: 1 });

		// initialize the model view
		this.modelView = new view.ModelView({
			el: $("#afiliadoModelContainer")
		});

		// tell the model view where it's template is located
		this.modelView.templateEl = $("#afiliadoModelTemplate");

		if (model.longPollDuration > 0)	{
			setInterval(function () {

				if (!page.dialogIsOpen)	{
					page.fetchAfiliados(page.fetchParams,true);
				}

			}, model.longPollDuration);
		}
	},

	/**
	 * Fetch the collection data from the server
	 * @param object params passed through to collection.fetch
	 * @param bool true to hide the loading animation
	 */
	fetchAfiliados: function(params, hideLoader) {
		// persist the params so that paging/sorting/filtering will play together nicely
		page.fetchParams = params;

		if (page.fetchInProgress) {
			if (console) console.log('supressing fetch because it is already in progress');
		}

		page.fetchInProgress = true;

		if (!hideLoader) app.showProgress('loader');

		page.afiliados.fetch({

			data: params,

			success: function() {

				if (page.afiliados.collectionHasChanged) {
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
		$('#afiliadoDetailDialog').modal({ show: true });

		// if a model was specified then that means a user is editing an existing record
		// if not, then the user is creating a new record
		page.afiliado = m ? m : new model.AfiliadoModel();

		page.modelView.model = page.afiliado;

		if (page.afiliado.id == null || page.afiliado.id == '') {
			// this is a new record, there is no need to contact the server
			page.renderModelView(false);
		} else {
			app.showProgress('modelLoader');

			// fetch the model from the server so we are not updating stale data
			page.afiliado.fetch({

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

        // poblar el combobox con los posters
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var usuarioValues = new model.UsuarioCollection();
        usuarioValues.fetch({
            success: function(c){
                var dd = $('#fkusuario');
                c.forEach(function(item,index)
                {
                    dd.append(app.getOptionHtml(
                        item.get('pkusuario'),
                        item.get('nombre'),
                        page.afiliado.get('fkusuario') == item.get('pkusuario')
                    ));
                });
            },
            error: function(collection,response,scope){
                app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
            }
        });

		if (showDeleteButton) {
            //Es Editar
            InicializarMapa(parseFloat($("#latitud").val()),parseFloat($("#longitud").val()));//Inicializar mapa con la ciudad de Santa Cruz por defecto
			// attach click handlers to the delete buttons

			$('#deleteAfiliadoButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteAfiliadoContainer').show('fast');
			});

			$('#cancelDeleteAfiliadoButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteAfiliadoContainer').hide('fast');
			});

			$('#confirmDeleteAfiliadoButton').click(function(e) {
				e.preventDefault();
				page.deleteModel();
			});

		} else {
            //Es nuevo Inicializar mapa con la ciudad de Santa Cruz por defecto
            InicializarMapa(-17.783302473602816,-63.18211555480957);
			// no point in initializing the click handlers if we don't show the button
			$('#deleteAfiliadoButtonContainer').hide();
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
		var isNew = page.afiliado.isNew();

		app.showProgress('modelLoader');

		page.afiliado.save({

			'nombre': $('input#nombre').val(),
			'direccion': $('input#direccion').val(),
			'latitud': $('input#latitud').val(),
			'longitud': $('input#longitud').val(),
			'telefono': $('input#telefono').val(),
			'descripcion': $('textarea#descripcion').val(),
			'fkusuario': $('select#fkusuario').val(),
			'plan': $('input#plan').val()
		}, {
			wait: true,
			success: function(){
				$('#afiliadoDetailDialog').modal('hide');
				setTimeout("app.appendAlert('Afiliado was sucessfully " + (isNew ? "inserted" : "updated") + "','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				// if the collection was initally new then we need to add it to the collection now
				if (isNew) { page.afiliados.add(page.afiliado) }

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchAfiliados(page.fetchParams,true);
				}
		},
			error: function(model,response,scope){

				app.hideProgress('modelLoader');

				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');

				try {
					var json = $.parseJSON(response.responseText);

					if (json.errors) {
						$.each(json.errors, function(key, value) {
							$('#'+key+'InputContainer').addClass('error');
							$('#'+key+'InputContainer span.help-inline').html(value);
							$('#'+key+'InputContainer span.help-inline').show();
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

		page.afiliado.destroy({
			wait: true,
			success: function(){
				$('#afiliadoDetailDialog').modal('hide');
				setTimeout("app.appendAlert('The Afiliado record was deleted','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchAfiliados(page.fetchParams,true);
				}
			},
			error: function(model,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
				app.hideProgress('modelLoader');
			}
		});
	}
};

