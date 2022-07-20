<script>

	whiteMarkers = [];

	// $('#filter2-excel').click(function(event) {
	// 	let info = {_token: '{{csrf_token()}}',perito2: $('#perito2').val(),daassegnare:'si',datepicker:$('#datepicker').val(),excel: 'true',data_type:[1]};

	// 	$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {
	// 		$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
	// 	});
	// });
	$('#loadBlanco').click(function(event) {

		console.log('loadBlanco');

		_infoWindows = [];
		_infoWindows2 = [];

		if (whiteMarkers.length > 0) {
			$.each(whiteMarkers, function(index, val) {
				val.setMap(null);
			});
			whiteMarkers = [];
			return 0;
		}


		let hoy = moment();

		let info = {_token: '{{csrf_token()}}',perito2: $('#perito2').val(),data_type:[1]};

		$.post('{{url('getMapInformation3')}}',info, function(data, textStatus, xhr) {

			console.log(data);

			$.each(data, function(index, v) {

				var sinisters;

				if (!v.diferents) {
					sinisters = [v];
				}else{
					sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
					sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");
				}

				var val = sinisters[0] || [];
				val.diferents = sinisters;

				var color = "gris",
				icon = "";

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

	            let continuar = true;

	            if (continuar && (val.lat && val.lng)) {

					let l = {lat: val.lat,lng: val.lng};

					var contentString = "";


					for (var i = 0; i < val.diferents.length; i++) {

						let _val = val.diferents[i];

						contentString += '<div id="content content-alt">'+
						"<h5 onclick='loadModal("+_val.id+")' style='margin-bottom: 0' id='firstHeading' class='firstHeading'>"+_val.N_P
						+(_val.DATA_SOPRALLUOGO ? ' - <span style="display: inline-block;font-weight: 700">'+moment(_val.DATA_SOPRALLUOGO).format('HH:mm')+'</span>' : '')+'</h5>\
						</div>';

					}
					  var infowindow = new google.maps.InfoWindow({
					    content: contentString,
					    borderColor: "#2c2c2c"
					  });

					  let _color = "";

					var marker = new google.maps.Marker({
				      position: {lat: parseFloat(l.lat), lng: parseFloat(l.lng)},
				      map: map,
				      icon: {url: '{{url('markers')}}/'+color+'-'+icon+'.png', scaledSize: new google.maps.Size(80, 80)},
				      label: {text: /*val.*/sinisters.length.toString(),color: _color,fontSize: '12px',fontWeight: 'bolder'}
				    });

				    whiteMarkers.push(marker);

				    _infoWindows2.push({marker:marker,infowindow:infowindow});

				    marker.addListener('click', function() {
					  infowindow.open(map, marker);
					});
	            }

			});

		}).fail((e)=>{
			console.log(e);
		});

	});
</script>