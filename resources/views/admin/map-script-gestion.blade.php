<script>
	$('#filter2-excel').click(function(event) {
		let info = {_token: '{{csrf_token()}}',perito4: $('#perito2').val(),daassegnare:'yes',datepicker:$('#datepicker').val(),excel: 'true'};

		$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {
			$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
		});
	});
	$('#filter2').click(function(event) {

		infoWindows = [];

		$('#filtro-perito').text("");

		$('#marron-div').removeClass('hidden');

		$('#verde').text("0"); $('#verde-media').text((0).toFixed(2));
		$('#amarillo').text("0"); $('#amarillo-media').text((0).toFixed(2));
		$('#rojo').text("0"); $('#rojo-media').text((0).toFixed(2));
		$('#violeta').text("0"); $('#violeta-media').text((0).toFixed(2));
		$('#marron').text("0"); $('#marron-media').text((0).toFixed(2));

		$('#total-1').text((0).toString());
		$('#total-media-1').text(((0).toFixed(2)).toString());

		$('#total-f').text("0"); $('#total-media-f').text("0");
		$('#total-nf').text("0"); $('#total-media-nf').text("0");
		// function initMap() {
			$('[data-target="#filtros2"]').trigger('click');
		  	navigator.geolocation.getCurrentPosition(function(position) {
		        var pos = {
			      lat: position.coords.latitude,
			      lng: position.coords.longitude
			    };

			   //  map = new google.maps.Map(document.getElementById('map-locations'), {
			   //    zoom: 8,
			   //    center: {lat:45.4628328,lng:9.1076928},
			   //    // mapTypeControl: false,
				  // streetViewControl: false,
				  // rotateControl: false,
		    //       mapTypeId: 'roadmap'
			   //  });
			   //  var marker = new google.maps.Marker({
			   //    position: pos,
			   //    map: map
			   //  });

				let address;
				let url;
				let fecha
				let diff
				let color
				let icon

				let verde = {total:0,diff:0};
				let amarillo = {total:0,diff:0};
				let rojo = {total:0,diff:0};
				let violeta = {total:0,diff:0};
				let marron = {total:0,diff:0};

				let fissato = {total:0,diff:0};
				let non_fissato = {total:0,diff:0};

				$('#verde').text("0");
				$('#amarillo').text("0");
				$('#rojo').text("0");
				$('#violeta').text("0");
				$('#marron').text("0");

				$('#total-1').text("0");

				mAll = [];
				mVerde = [];
				mAmarillo = [];
				mRojo = [];
				mVioleta = [];
				mMarron = [];

				let hoy = moment();

				let max = $('#max').val();

				if (!max) {
					max=0;
				}

				let info = {_token: '{{csrf_token()}}',perito4: $('#perito2').val(),daassegnare:'yes',datepicker:$('#datepicker').val()};

				console.log(info);

				$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {

					$('#filtro-perito').text("FILTRO PER "+$('#perito2').val()+" "+$('#datepicker').val());

					$.each(data[1], function(index, v) {

						var sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
						// sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");

						var val = sinisters[0] || [];
						val.diferents = sinisters;

						var fecha = moment(val.DT_Incarico),
						diff = hoy.diff(fecha, 'days'),
						color = "",
						icon = "",
						addn = "";

						if (diff >= max) {

				            if (val.TP == 'AC' || val.TP == 'RG') { icon = 'ac'; }
							else if (val.TP == 'AT') { icon = 'at'; }
							else if (val.TP == 'EA') { icon = 'ea'; }
							else if (val.TP == 'FE') { icon = 'fe'; }
							else if (val.TP == 'EL') { icon = 'el'; }
							else if (val.TP == 'AL' || val.TP == 'VA' || val.TP == 'altre') { icon = 'altre'; }
							else if (val.TP == 'IN') { icon = 'in'; }
							else if (val.TP == 'RE') { icon = 're'; }
							else if (val.TP == 'CR') { icon = 'cr'; }
							else if (val.TP == 'AR') { icon = 'ar'; }
							else if (val.TP == 'FU' || val.TP == 'AM' || val.TP == 'RA') { icon = 'fu'; }
							else if (val.TP == 'RC' || val.TP == 'RU' || val.TP == 'RP') { icon = 'rc'; }
							else if (val.TP == 'NN') { icon = 'nn'; }
							else {icon = "altre";}

				            if (!val.TELEFONO && !val.CELLULARE && !val.EMAIL) {
				            	addn = '-sin';
				            }

				            let continuar = true;

				            if(val.DATA_SOPRALLUOGO && val.DATA_SOPRALLUOGO != ""){

				            	// fissato.total++;
				            	// fissato.diff += diff;

					            if(true /*moment(val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day')*/)
					            {
					            	continuar = true;
					            	addn+='-transparente';
					            }else{
					            	// data[1].splice(index,1);
					            	continuar = false;
					            }
				            }else{
				            	// non_fissato.total++;
				            	// non_fissato.diff += diff;
				            }

				            if (continuar && (val.lat && val.lng)) {

				            	if (val.SOPRALLUOGO == $('#perito2').val()) {
					            	color = "marron";
					            	marron.total+=/*val.sinisters*/sinisters.length;
						            marron.diff+=diff;
					            }else{
					            	if (diff <= 20) {
						                color = "verde";
						                verde.total+=/*val.sinisters*/sinisters.length;
						                verde.diff+=diff;
						            }else if (diff > 20 && diff <= 40) {
						                color = "amarillo";
						                amarillo.total+=/*val.sinisters*/sinisters.length;
						                amarillo.diff+=diff;
						            }else if (diff > 40 && diff <= 60) {
						                color = "rojo";
						                rojo.total+=/*val.sinisters*/sinisters.length;
						                rojo.diff+=diff;
						            }else if (diff > 60) {
						                color = "violeta";
						                violeta.total+=/*val.sinisters*/sinisters.length;
						                violeta.diff+=diff;
						            }
					            }

				            	// console.log('{{url('markers')}}/'+color+'-'+icon+addn+'.png');

					            if (color == 'verde') {mVerde.push(val);}
								if (color == 'amarillo') {mAmarillo.push(val);}
								if (color == 'rojo') {mRojo.push(val);}
								if (color == 'violeta') {mVioleta.push(val);}
								if (color == 'marron') {mMarron.push(val);}

								mAll.push(val);

								let l = {lat: val.lat,lng: val.lng};

								let _tp;

								if (val.TP == 'AC' || val.TP == 'RG') {_tp = "Acqua condotta";}
								if (val.TP == 'AT') {_tp = "Atti Vandalici";}
								if (val.TP == 'EA') {_tp = "Evento Atmosferico";}
								if (val.TP == 'FE') {_tp = "Fenomeno Elettrico";}
								if (val.TP == 'EL') {_tp = "Elettronica";}
								if (val.TP == 'AL' || val.TP == 'VA' || val.TP == 'altre') {_tp = "Pluralità di garanzie";}
								if (val.TP == 'IN') {_tp = "Incendio";}
								if (val.TP == 'RE') {_tp = "RC Auto";}
								if (val.TP == 'CR') {_tp = "Cristalli";}
								if (val.TP == 'AR') {_tp = "Accertamenti";}
								if (val.TP == 'FU' || val.TP == 'AM' || val.TP == 'RA') {_tp = "Furto";}
								if (val.TP == 'RC' || val.TP == 'RU' || val.TP == 'RP') {_tp = "Responsabilità Civile";}
								if (val.TP == 'NN') {_tp = "Non indennizzabile";}

								var contentString = "";

								// for (var i = 0; i < val.diferents.length; i++) {

								// 	let _val = val.diferents[i];


								for (var i = 0; i < val.diferents.length; i++) {

									let _val = val.diferents[i];

									if(moment(_val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day')){
										fissato.total++;
										if (diff) {
				            				fissato.diff += diff;
				            			}
									}else{
										non_fissato.total++;
										if (diff) {
				            				non_fissato.diff += diff;
										}
									}

									// if (color == 'marron') {

									// 	contentString += '<div id="content">'+
									// 	"<h5 onclick='loadModal("+_val.id+")' style='margin-bottom: 0' id='firstHeading' class='firstHeading'>"+_val.N_P
									// 	+(_val.DATA_SOPRALLUOGO ? ' - <span style="display: inline-block;font-weight: 700">'+moment(_val.DATA_SOPRALLUOGO).format('HH:mm')+'</span>' : '')+'</h5>\
									// 	</div>';
										
									// }else{
										
									// 	contentString += '<div id="content">'+
									//       '<div class="siteNotice">'+
									//       '</div>'+
									//       '<h5 style="margin-bottom: 0" id="firstHeading" class="firstHeading">'+_val.N_P+' - '+_val.Assicurato+' '+_val.TP+'-'+_tp+'</h5>'+
									//       '<h5 style="margin-top: 3px; margin-bottom: 0" id="firstHeading"> COMPAGNIA: '+_val.COMPAGNIA+'</h5>'+
									//       '<h6 style="margin-top: 5px" id="firstHeading"> Stato: '+_val.Stato+(_val.DATA_SOPRALLUOGO ? ' <small style="font-size: 12px; display: inline-block; margin-left: 16px;font-weight: 700">Il: '+moment(_val.DATA_SOPRALLUOGO).format('DD-MM-YYYY HH:mm')+'</small>' : '')+'</h6>'+
									//       '<div id="bodyContent">'+
									//       '<p>\
									//       Indirizzo: '+(_val.CAP+' '+_val.INDIRIZZO+', '+_val.COMUNE+', '+_val.PROVINCIA)+'<br>\
									//       Cellulare: '+(_val.CELLULARE == null ? '---' : _val.CELLULARE)+'<br>\
									//       Telefono: '+(_val.TELEFONO == null ? '---' : _val.TELEFONO)+'<br>\
									//       Email: '+(_val.EMAIL == null ? '---' : _val.EMAIL)+'<br>\
									//       Data Incarico: '+(_val.DT_Incarico == null ? '---' : moment(_val.DT_Incarico).format('DD-MM-YYYY HH:mm'))+'<br>\
									//       Accertatore: '+(_val.SOPRALLUOGO == null ? '---' : _val.SOPRALLUOGO)+'<br>\
									//       </p>'+
									//       (_val.total > 1 ? "<button onclick='loadModal("+_val.id+")' class='loadModal btn btn-info btn-block btn-xs'>Vedi tutti i danneggiati ("+_val.total+")</button>" : '')+
									//       '</div>'+
									//       '</div>';

									// }

								}

								  var infowindow = new google.maps.InfoWindow({
								    content: contentString
								  });

								  let _color = "";

								  if (color == 'amarillo') {_color='#333333';}else{_color='#ffffff'}

								// var marker = new google.maps.Marker({
							 //      position: {lat: parseFloat(l.lat), lng: parseFloat(l.lng)},
							 //      map: map,
							 //      icon: {url: '{{url('markers')}}/'+color+'-'+icon+addn+'.png', scaledSize: new google.maps.Size(80, 80)},
							 //      label: {text: /*val.*/sinisters.length.toString(),color: _color,fontSize: '12px',fontWeight: 'bolder'}
							 //    });

							 //    if (color == 'marron') {infoWindows.push({marker:marker,infowindow:infowindow});}

							 //    marker.addListener('click', function() {
								//   infowindow.open(map, marker);
								// });
				            }

						}

					});

					$('#verde').text(verde.total); $('#verde-media').text(((verde.diff/verde.total) || 0).toFixed(2));
					$('#amarillo').text(amarillo.total); $('#amarillo-media').text(((amarillo.diff/amarillo.total) || 0).toFixed(2));
					$('#rojo').text(rojo.total); $('#rojo-media').text(((rojo.diff/rojo.total) || 0).toFixed(2));
					$('#violeta').text(violeta.total); $('#violeta-media').text(((violeta.diff/violeta.total) || 0).toFixed(2));
					$('#marron').text(marron.total); $('#marron-media').text(((marron.diff/marron.total) || 0).toFixed(2));

					$('#total-1').text((verde.total+amarillo.total+rojo.total+violeta.total).toString());
					$('#total-media-1').text((((verde.diff+amarillo.diff+rojo.diff+violeta.diff+marron.diff)/(verde.total+amarillo.total+rojo.total+violeta.total+marron.total)).toFixed(2)).toString());

					$('#total-f').text(fissato.total);
					$('#total-media-f').text((( (fissato.diff/fissato.total) || 0 ).toFixed(2)).toString());

					$('#total-nf').text($('#total-1').text()-fissato.total/*non_fissato.total*/);
					$('#total-media-nf').text((( (non_fissato.diff/non_fissato.total) || 0 ).toFixed(2)).toString());

					// $('.table').dataTable().fnDestroy();

					// $('#results').html(data[0]);

					// $('.table').dataTable()

				}).fail((e)=>{
					console.log(e);
				});
			});
		// }
	});
</script>