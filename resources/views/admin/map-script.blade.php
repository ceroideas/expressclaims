<script>
	$('#filter2-excel').click(function(event) {
		let info = {_token: '{{csrf_token()}}',perito2: $('#perito2').val(),daassegnare:'si',datepicker:$('#datepicker').val(),excel: 'true',data_type:[1]};

		$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {
			$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
		});
	});
	$('#filter2').click(function(event) {

		infoWindows = [];
		infoWindows2 = [];

		$('#filtro-perito').text("");

		$('.marron-div').removeClass('hidden');

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

			    map = new google.maps.Map(document.getElementById('map-locations'), {
			      zoom: 8,
			      center: {lat:45.4628328,lng:9.1076928},
			      // mapTypeControl: false,
				  streetViewControl: false,
				  rotateControl: false,
		          mapTypeId: 'roadmap'
			    });
			    var marker = new google.maps.Marker({
			      position: pos,
			      map: map
			    });

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

				// let max = $('#max').val();

				// if (!max) {
				// 	max=0;
				// }

				let info = {_token: '{{csrf_token()}}',perito2: $('#perito2').val(),daassegnare:'si',datepicker:$('#datepicker').val(),data_type:[1]};

				$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {

					$('#filtro-perito').text("FILTRO PER "+$('#perito2').val()+" "+$('#datepicker').val());

					console.log(data[1]);

					$.each(data[1], function(index, v) {

						var sinisters = [];
							
						if (!v.diferents) {
							sinisters = [v];
						}else{
							sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
							sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");
						}

						var val = sinisters[0] || [];
						val.diferents = sinisters;

						var fecha = moment(val.DT_Incarico),
						diff = hoy.diff(fecha, 'days'),
						color = "",
						icon = "",
						addn = "";

						// if (diff >= max) {
						// }

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

					            if(moment(val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day'))
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

				            if (continuar && (val.lat && val.lng) && val.Stato != '030FATTO') {

				            	if (val.SOPRALLUOGO == $('#perito2').val()) {
					            	color = "marron";
					            	// marron.total+=sinisters.length;
						            // marron.diff+=diff;
					            }else{
					            	if (diff <= 20) {
						                color = "verde";
						                // verde.total+=sinisters.length;
						                // verde.diff+=diff;
						            }else if (diff > 20 && diff <= 40) {
						                color = "amarillo";
						                // amarillo.total+=sinisters.length;
						                // amarillo.diff+=diff;
						            }else if (diff > 40 && diff <= 60) {
						                color = "rojo";
						                // rojo.total+=sinisters.length;
						                // rojo.diff+=diff;
						            }else if (diff > 60) {
						                color = "violeta";
						                // violeta.total+=sinisters.length;
						                // violeta.diff+=diff;
						            }
					            }

				            	// console.log('{{url('markers')}}/'+color+'-'+icon+addn+'.png');

								let l = {lat: val.lat,lng: val.lng};

								var contentString = "";

								// for (var i = 0; i < val.diferents.length; i++) {

								// 	let _val = val.diferents[i];

								var added = null;

								for (var i = 0; i < val.diferents.length; i++) {

									let _val = val.diferents[i];

									let _tp;

									if (_val.TP == 'AC' || _val.TP == 'RG') {_tp = "Acqua condotta";}
									if (_val.TP == 'AT') {_tp = "Atti Vandalici";}
									if (_val.TP == 'EA') {_tp = "Evento Atmosferico";}
									if (_val.TP == 'FE') {_tp = "Fenomeno Elettrico";}
									if (_val.TP == 'EL') {_tp = "Elettronica";}
									if (_val.TP == 'AL' || _val.TP == 'VA' || _val.TP == 'altre') {_tp = "Pluralità di garanzie";}
									if (_val.TP == 'IN') {_tp = "Incendio";}
									if (_val.TP == 'RE') {_tp = "RC Auto";}
									if (_val.TP == 'CR') {_tp = "Cristalli";}
									if (_val.TP == 'AR') {_tp = "Accertamenti";}
									if (_val.TP == 'FU' || _val.TP == 'AM' || _val.TP == 'RA') {_tp = "Furto";}
									if (_val.TP == 'RC' || _val.TP == 'RU' || _val.TP == 'RP') {_tp = "Responsabilità Civile";}
									if (_val.TP == 'NN') {_tp = "Non indennizzabile";}

									let _fecha = moment(_val.DT_Incarico),
									_diff = hoy.diff(_fecha, 'days'),
									_color = "";

									if (_val.SOPRALLUOGO == $('#perito2').val()) {
						            	_color = "marron";
						            	marron.total+=1;
							            marron.diff+=_diff ? _diff : 0;
						            }else{
						            	if (diff <= 20) {
							                _color = "verde";
							                verde.total+=1;
							                verde.diff+=_diff ? _diff : 0;
							            }else if (_diff > 20 && _diff <= 40) {
							                _color = "amarillo";
							                amarillo.total+=1;
							                amarillo.diff+=_diff ? _diff : 0;
							                console.log('_val',_val)

							            }else if (_diff > 40 && _diff <= 60) {
							                _color = "rojo";
							                rojo.total+=1;
							                rojo.diff+=_diff ? _diff : 0;
							            }else if (_diff > 60) {
							                _color = "violeta";
							                violeta.total+=1;
							                violeta.diff+=_diff ? _diff : 0;
							            }
						            }

						            console.log(color)

									if (_color == 'verde') {mVerde.push(_val);}
									if (_color == 'amarillo') {mAmarillo.push(_val);}
									if (_color == 'rojo') {mRojo.push(_val);}
									if (_color == 'violeta') {mVioleta.push(_val);}
									if (_color == 'marron') {mMarron.push(_val);}

									mAll.push(_val);

									if(moment(_val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day')){
										fissato.total++;
										if (_diff) {
				            				fissato.diff += _diff;
				            			}
									}else{
										non_fissato.total++;
										if (_diff) {
				            				non_fissato.diff += _diff;
										}
									}

										contentString += '<div id="content content-alt">'+
										"<h5 onclick='loadModal("+_val.id+")' style='margin-bottom: 0' id='firstHeading' class='firstHeading'>"+_val.N_P
										+(_val.DATA_SOPRALLUOGO ? ' - <span style="display: inline-block;font-weight: 700">'+moment(_val.DATA_SOPRALLUOGO).format('HH:mm')+'</span>' : '')+'</h5>\
										</div>';

								}
								if (color == 'marron') {
								  var infowindow = new google.maps.InfoWindow({
								    content: contentString,
								    borderColor: "#2c2c2c"
								  });
								}else{
								  var infowindow = new google.maps.InfoWindow({
								    content: contentString,
								  });
								}


								  let _color = "";

								  if (color == 'amarillo') {_color='#333333';}else{_color='#ffffff'}

								var marker = new google.maps.Marker({
							      position: {lat: parseFloat(l.lat), lng: parseFloat(l.lng)},
							      map: map,
							      icon: {url: '{{url('markers')}}/'+color+'-'+icon+addn+'.png', scaledSize: new google.maps.Size(80, 80)},
							      label: {text: /*val.*/val.diferents.length.toString(),color: _color,fontSize: '12px',fontWeight: 'bolder'}
							    });

							    if (color == 'marron') {infoWindows.push({marker:marker,infowindow:infowindow});}
							    else {infoWindows2.push({marker:marker,infowindow:infowindow});}

							    marker.addListener('click', function() {
								  infowindow.open(map, marker);
								});
				            }

					});

					console.log(violeta,rojo,amarillo,verde,marron);
					console.log(non_fissato,fissato);

					$('#verde').text(verde.total); $('#verde-media').text(((verde.diff/verde.total) || 0).toFixed(2));
					$('#amarillo').text(amarillo.total); $('#amarillo-media').text(((amarillo.diff/amarillo.total) || 0).toFixed(2));
					
					$('#rojo').text(rojo.total); $('#rojo-media').text(((rojo.diff/rojo.total) || 0).toFixed(2));

					$('#violeta').text(violeta.total); $('#violeta-media').text(((violeta.diff/violeta.total) || 0).toFixed(2));

					$('#marron').text(marron.total); $('#marron-media').text(((marron.diff/marron.total) || 0).toFixed(2));

					$('#total-1').text((verde.total+amarillo.total+rojo.total+violeta.total+marron.total).toString());

					$('#total-media-1').text((( ((verde.diff+amarillo.diff+rojo.diff+violeta.diff+marron.diff)/(verde.total+amarillo.total+rojo.total+violeta.total+marron.total)) || '0' ).toFixed(2)).toString());

					$('#total-f').text(fissato.total);
					$('#total-media-f').text((( (fissato.diff/fissato.total) || 0 ).toFixed(2)).toString());

					$('#total-nf').text($('#total-1').text()-fissato.total/*non_fissato.total*/);

					$('#total-media-nf').text((( (non_fissato.diff/non_fissato.total) || 0 ).toFixed(2)).toString());


				}).fail((e)=>{
					console.log(e);
				});
			});
		// }
	});
</script>