/**
 * View logic for Mascotas
 */

/**
 * application logic specific to the Mascota listing page
 */
var page = {

	mascotas: new model.MascotaCollection(),
	collectionView: null,
	mascota: null,
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
		$("#newMascotaButton").click(function(e) {
			e.preventDefault();
			page.showDetailDialog();
		});

		// let the page know when the dialog is open
		$('#mascotaDetailDialog').on('show',function() {
			page.dialogIsOpen = true;
		});

		// when the model dialog is closed, let page know and reset the model view
		$('#mascotaDetailDialog').on('hidden',function() {
			$('#modelAlert').html('');
			page.dialogIsOpen = false;
		});

		// save the model when the save button is clicked
		$("#saveMascotaButton").click(function(e) {
			e.preventDefault();
			page.updateModel();
		});

		// initialize the collection view
		this.collectionView = new view.CollectionView({
			el: $("#mascotaCollectionContainer"),
			templateEl: $("#mascotaCollectionTemplate"),
			collection: page.mascotas
		});

		// initialize the search filter
		$('#filter').change(function(obj) {
			page.fetchParams.filter = $('#filter').val();
			page.fetchParams.page = 1;
			page.fetchMascotas(page.fetchParams);
		});
		
		// make the rows clickable ('rendered' is a custom event, not a standard backbone event)
		this.collectionView.on('rendered',function(){

			// attach click handler to the table rows for editing
			$('table.collection tbody tr').click(function(e) {
				e.preventDefault();
				var m = page.mascotas.get(this.id);
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
 				page.fetchMascotas(page.fetchParams);
 			});

			// attach click handlers to the pagination controls
			$('.pageButton').click(function(e) {
				e.preventDefault();
				page.fetchParams.page = this.id.substr(5);
				page.fetchMascotas(page.fetchParams);
			});
			
			page.isInitialized = true;
			page.isInitializing = false;
		});

		// backbone docs recommend bootstrapping data on initial page load, but we live by our own rules!
		this.fetchMascotas({ page: 1 });

		// initialize the model view
		this.modelView = new view.ModelView({
			el: $("#mascotaModelContainer")
		});

		// tell the model view where it's template is located
		this.modelView.templateEl = $("#mascotaModelTemplate");

		if (model.longPollDuration > 0)	{
			setInterval(function () {

				if (!page.dialogIsOpen)	{
					page.fetchMascotas(page.fetchParams,true);
				}

			}, model.longPollDuration);
		}
	},

	/**
	 * Fetch the collection data from the server
	 * @param object params passed through to collection.fetch
	 * @param bool true to hide the loading animation
	 */
	fetchMascotas: function(params, hideLoader) {
		// persist the params so that paging/sorting/filtering will play together nicely
		page.fetchParams = params;

		if (page.fetchInProgress) {
			if (console) console.log('supressing fetch because it is already in progress');
		}

		page.fetchInProgress = true;

		if (!hideLoader) app.showProgress('loader');

		page.mascotas.fetch({

			data: params,

			success: function() {

				if (page.mascotas.collectionHasChanged) {
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
		$('#mascotaDetailDialog').modal({ show: true });

		// if a model was specified then that means a user is editing an existing record
		// if not, then the user is creating a new record
		page.mascota = m ? m : new model.MascotaModel();

		page.modelView.model = page.mascota;

		if (page.mascota.id == null || page.mascota.id == '') {
			// this is a new record, there is no need to contact the server
			page.renderModelView(false);
		} else {
			app.showProgress('modelLoader');

			// fetch the model from the server so we are not updating stale data
			page.mascota.fetch({

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


        // poblar el combobox con los tipos de mascotas
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var tipo_mascotaValues = new model.TipoMascotaCollection();
        tipo_mascotaValues.fetch({
            success: function(c){
                var dd = $('#fktipoMascota');
                c.forEach(function(item,index)
                {
                    dd.append(app.getOptionHtml(
                        item.get('pktipoMascota'),
                        item.get('nombre'),
                        page.mascota.get('fktipoMascota') == item.get('pktipoMascota')
                    ));
                });
            },
            error: function(collection,response,scope){
                app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
            }
        });

        // poblar el combobox con las razas
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var razaValues = new model.RazaCollection();
        razaValues.fetch({
            success: function(c){
                var dd = $('#fkraza');
                c.forEach(function(item,index)
                {
                    dd.append(app.getOptionHtml(
                        item.get('pkraza'),
                        item.get('nombre'),
                        page.mascota.get('fkraza') == item.get('pkraza')
                    ));
                });
            },
            error: function(collection,response,scope){
                app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
            }
        });

        // poblar el combobox con las tamanos
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var dd = $('#tamano');
        dd.append(app.getOptionHtml(
            'pequeño',
            'pequeño',
            page.mascota.get('tamano') == 'pequeño'
        ));
        dd.append(app.getOptionHtml(
            'mediano',
            'mediano',
            page.mascota.get('tamano') == 'mediano'
        ));
        dd.append(app.getOptionHtml(
            'grande',
            'grande',
            page.mascota.get('tamano') == 'grande'
        ));

        // poblar el combobox con los generos
        // TODO: load only the selected value, then fetch all options when the drop-down is clicked
        var dd = $('#genero');
        dd.append(app.getOptionHtml(
            'macho',
            'macho',
            page.mascota.get('genero') == 'macho'
        ));
        dd.append(app.getOptionHtml(
            'hembra',
            'hembra',
            page.mascota.get('genero') == 'hembra'
        ));
        dd.append(app.getOptionHtml(
            'indeterminado',
            'indeterminado',
            page.mascota.get('genero') == 'indeterminado'
        ));



		if (showDeleteButton) {
			// attach click handlers to the delete buttons

			$('#deleteMascotaButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteMascotaContainer').show('fast');
			});

			$('#cancelDeleteMascotaButton').click(function(e) {
				e.preventDefault();
				$('#confirmDeleteMascotaContainer').hide('fast');
			});

			$('#confirmDeleteMascotaButton').click(function(e) {
				e.preventDefault();
				page.deleteModel();
			});

		} else {
			// no point in initializing the click handlers if we don't show the button
			$('#deleteMascotaButtonContainer').hide();
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
		var isNew = page.mascota.isNew();

		app.showProgress('modelLoader');

		page.mascota.save({

			'nombre': $('input#nombre').val(),
			'tamano': $('select#tamano').val(),
			'genero': $('select#genero').val(),
			'color': $('input#color').val(),
			'fktipoMascota': $('select#fktipoMascota').val(),
			'fkraza': $('select#fkraza').val(),
		}, {
			wait: true,
			success: function(){
				$('#mascotaDetailDialog').modal('hide');
				setTimeout("app.appendAlert('Mascota was sucessfully " + (isNew ? "inserted" : "updated") + "','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				// if the collection was initally new then we need to add it to the collection now
				if (isNew) { page.mascotas.add(page.mascota) }

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchMascotas(page.fetchParams,true);
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

		page.mascota.destroy({
			wait: true,
			success: function(){
				$('#mascotaDetailDialog').modal('hide');
				setTimeout("app.appendAlert('The Mascota record was deleted','alert-success',3000,'collectionAlert')",500);
				app.hideProgress('modelLoader');

				if (model.reloadCollectionOnModelUpdate) {
					// re-fetch and render the collection after the model has been updated
					page.fetchMascotas(page.fetchParams,true);
				}
			},
			error: function(model,response,scope) {
				app.appendAlert(app.getErrorMessage(response), 'alert-error',0,'modelAlert');
				app.hideProgress('modelLoader');
			}
		});
	}
};

