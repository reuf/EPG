(function($){

var table = {
	"add": function ( rows ) {
		for ( var i=0 ; i<rows ; i++ ) {
			table._addRow();
		}
		$('.timepicker').timepicker();
		jQuery(function($){
			    $.timepicker.regional['hr'] = {
			                hourText: 'Sat',
			                minuteText: 'Minuta',
			                amPmText: ['', ''],
			                closeButtonText: 'Zatvoriti',
			                nowButtonText: 'Sada',
			                deselectButtonText: 'PoniÅ¡tite'}

			    $.timepicker.setDefaults($.timepicker.regional['hr']);
			});
		$('#column_count').val( $('#epg tbody tr').length );
	},

	"_addRow": function () {
		var tbody = $('#epg tbody')[0];
		var order = $('#epg tbody tr').length;
		var tr = $(
			'<tr class="epg_row">'+
				'<td class="order">'+(order+1)+'</td>'+
				'<td><input type="text" name="vrijeme_'+(order+1)+'" class="epg_vrijeme timepicker"></td>'+
				'<td><input type="text" name="naslov_'+(order+1)+'" class="epg_naslov"></td>'+
				'<td>'+
					'<select size="1" name="tip_'+(order+1)+'" class="epg_tip">'+
						'<option value="Dnevnik">Dnevnik</option>'+
						'<option value="Vijesti">Vijesti</option>'+
						'<option value="Serija">Serija</option>'+
						'<option value="Film">Film</option>'+
						'<option value="Muzicki Program">Muzicki Program</option>'+
						'<option value="Dokumentarni Program">Dokumentarni Program</option>'+
						'<option value="Drugo" selected="true">Drugo</option>'+
					'</select>'+
				'</td>'+
				'<td><input type="text" name="kratki_opis_'+(order+1)+'" class="epg_kratki_opis"></td>'+
				'<td><input type="text" name="dugi_opis_'+(order+1)+'" class="epg_dugi_opis"></td>'+
				'<td><input type="text" name="ostalo_'+(order+1)+'" class="epg_ostalo"></td>'+
								'<td>'+
					'<select size="1" name="rejting_'+(order+1)+'" class="epg_rejting">'+
						'<option value="Svi" selected="true">Svi</option>'+
						'<option value="12+" selected="false">12+</option>'+
						'<option value="16+" selected="false">16+</option>'+
					'</select>'+
				'</td>'+
				'<td><img class="epg_delete" src="img/delete.png"></td>'+
			'</tr>')[0];

		tbody.appendChild( tr );
		$('select.epg_type', tr).change();
	},

	"addRowsWithData": function(data){
		//First remove previos columns:
		var tbody = $('#epg tbody')[0];
		var order = $('#epg tbody tr').length;
		$('#epg tbody').find("tr").remove();
		if(data['error']==='false'){
			//Generate new columns with data:
			for ( var i=0 ; i<data.columns ; i++ ) {
				var tr_data_tip = data['tip_'+(i+1)];
				var tr_data_rejting = data['rejting_'+(i+1)];
				console.log(tr_data_tip);
				console.log(tr_data_rejting);
				var tbody = $('#epg tbody')[0];
				var tr = $(
					'<tr class="epg_row">'+
						'<td class="order">'+(i+1)+'</td>'+
						'<td><input type="text" name="vrijeme_'+(i+1)+'" class="epg_vrijeme timepicker" value='+data['vrijeme_'+(i+1)]+'></td>'+
						'<td><input type="text" name="naslov_'+(i+1)+'" class="epg_naslov" value='+data['naslov_'+(i+1)]+'></td>'+
						'<td>'+
							'<select size="1" name="tip_'+(i+1)+'" class="epg_tip">'+
								'<option value="Dnevnik"'+( (tr_data_tip === 'Dnevnik') ? " selected=\"true\"" : "" )+'>Dnevnik</option>'+
								'<option value="Vijesti"'+( (tr_data_tip === 'Vijesti') ? " selected=\"true\"" : "" )+'>Vijesti</option>'+
								'<option value="Serija"'+( (tr_data_tip === 'Serija') ? " selected=\"true\"" : "" )+'>Serija</option>'+
								'<option value="Film"'+( (tr_data_tip === 'Film') ? " selected=\"true\"" : "" )+'>Film</option>'+
								'<option value="Muzicki Program"'+( (tr_data_tip === 'Muzicki Program') ? " selected=\"true\"" : "" )+'>Muzicki Program</option>'+
								'<option value="Dokumentarni Program"'+( (tr_data_tip === 'Dokumentarni Program') ? " selected=\"true\"" : "" )+'>Dokumentarni Program</option>'+
								'<option value="Drugo"'+( (tr_data_tip === 'Drugo') ? " selected=\"true\"" : "" )+'>Drugo</option>'+
							'</select>'+
						'</td>'+
						'<td><input type="text" name="kratki_opis_'+(i+1)+'" class="epg_kratki_opis" value='+data['kratki_opis_'+(i+1)]+'></td>'+
						'<td><input type="text" name="dugi_opis_'+(i+1)+'" class="epg_dugi_opis" value='+data['dugi_opis_'+(i+1)]+'></td>'+
						'<td><input type="text" name="ostalo_'+(i+1)+'" class="epg_ostalo" value='+data['ostalo_'+(i+1)]+'></td>'+
						'<td>'+
							'<select size="1" name="rejting_'+(i+1)+'" class="epg_rejting">'+
								'<option value="Svi"'+( (tr_data_rejting === 'Svi') ? " selected=\"true\"" : "" )+'>Svi</option>'+
								'<option value="12+"'+( (tr_data_rejting === '12+') ? " selected=\"true\"" : "" )+'>12+</option>'+
								'<option value="16+"'+( (tr_data_rejting === '16+') ? " selected=\"true\"" : "" )+'>16+</option>'+
							'</select>'+
						'</td>'+
						'<td><img class="epg_delete" src="img/delete.png"></td>'+
					'</tr>')[0];

					tbody.appendChild( tr );
					$('select.epg_type', tr).change();
			}
		} else if (data['error']==='true'){
			// var tbody = $('#epg tbody')[0];
			// var tr = $('<tr class="epg_row"><td colspan="9">'+data['message']+'</td></tr>')[0];
			// tbody.appendChild( tr );
			alert(data['message']); return;
		} else {
			// var tbody = $('#epg tbody')[0];
			// var tr = $('<tr class="epg_row">DoŠlo je do greske. Kontaktirajte administratora.</tr>')[0];
			// tbody.appendChild( tr );
			// $('select.epg_type', tr).change();
			alert("DoŠlo je do greske. Kontaktirajte administratora."); return;
		}

		$('.timepicker').timepicker();
		jQuery(function($){
			$.timepicker.regional['hr'] = {
			    hourText: 'Sat',
			    minuteText: 'Minuta',
			    amPmText: ['', ''],
			    closeButtonText: 'Zatvoriti',
			    nowButtonText: 'Sada',
			    deselectButtonText: 'PoniÅ¡tite'}
			$.timepicker.setDefaults($.timepicker.regional['hr']);
		});
		$('#column_count').val( $('#epg tbody tr').length );
	},

	"reorder": function () {
	$('#epg tbody tr').each( function (i) {
				$('td:eq(0)', this).html( i+1 );
				$('.epg_vrijeme', this).attr('name', 'vrijeme_'+ (i + 1) );
				$('.epg_naslov', this).attr('name', 'naslov_'+ (i + 1) );
				$('.epg_tip', this).attr('name', 'tip_'+ (i + 1) );
				$('.epg_kratki_opis', this).attr('name', 'kratki_opis_'+ (i + 1) );
				$('.epg_dugi_opis', this).attr('name', 'dugi_opis_'+ (i + 1) );
				$('.epg_ostalo', this).attr('name', 'ostalo_'+ (i + 1) );
				$('.epg_rejting', this).attr('name', 'rejting_'+ (i + 1) );
				$('.epg_delete', this).attr('name', 'delete');
			} );
		},

	"remove": function ( tr ) {
		$(tr).remove();
		table.reorder();
		$('#column_count').val( $('#epg tbody tr').length );
	},
};

$(document).ready( function () {
	//Dugme dodaj novi red
	$('#add_button').click( function () {
		table.add( $('#add_input').val() );
		$('#add_input').val(1);
		table.reorder();
	} );
	//Dugme prikazi listing za dan
	$('#btnprikazi').click(function() {
		$.ajax({
	    type: 'GET',
	    url: '/index.php?id=5226',
	    data: "kanal=" + $('#kanal').val() + "&datum=" + $('#datum').val(),
	    success: function(data) {
	    	$('.btnspasi').show();
	    	$('.add_input').show();
	    	$('.epgdan').html($('#datum').val());
			$('.epgkanal').html(capitaliseFirstLetter($('#kanal').val()));
	    	var rezultat = JSON.parse(data);
	    	table.addRowsWithData(rezultat);
		  }
		});
	});
	//Dugme posalji u bazu da se spasi.
	$("#epg_form").on("submit", function(event) {
		event.preventDefault();
		console.log($(this).serialize());
	});

	$('.btnspasi').click(function() {
		var arraydata = $('#epg_form').serialize();
		$.ajax({
	    type: 'POST',
	    url: '/index.php?id=5224',
	    data: arraydata,
	    success: function(data) {
	    	var rezultat = JSON.parse(data);
	    	//alert(rezultat.message);
	        // $('#debug').html(data);
		},
		complete: function(){
			$( "#dialog-message" ).dialog({
		      modal: true,
		      buttons: {
		        Ok: function() {
		          $( this ).dialog( "close" );
		        }
		      }
		    });
		}
		});
	});

	$('#epg tbody').on('click', 'img.epg_delete', function () {
		// alert($(this).parents('tr')[0].rowIndex)
		table.remove( $(this).parents('tr')[0] );
		$(this).parents('tr')[0].after()
	} );

	$( "#epg tbody" ).sortable( {
		"helper": function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		},
		"handle": "td:eq(0)",
		"stop": function ( e, ui ) {
			table.reorder();
		}
	} );

	$('#epg_form').submit( function (e) {
		var error = null;

		$('input.epg_vrijeme').each( function () {
			if ( this.value === "" ) {
				error = "All fields must have a DB name. This is used to generate the DB table and populate the DataTables and Editor fields.";
				//this.focus();
				return false;
			}
			else if ( this.value.match(/[^a-zA-Z0-9_\-]/) ) {
				error = "Database column names must only contain letters, numbers, underscores or dashes.";
				//this.focus();
				return false;
			}
		} );
		if ( error ) {
			e.preventDefault();
			//alert( error );
			return;
		}

		$('select.text_options').each( function () {
			var tr = $(this).parents('tr')[0];
			var val = $(this).val();
			var options_val = $('span.text_options input').val();

			if ( val === "minLen" || val === "maxLen" ) {
				if ( ! $.isNumeric(options_val) ) {
					error = "Length must be a numeric value";
					$('span.text_options input').focus();
					return false;
				}
			}
			else if ( val === "minMaxLen" ) {
				var a = options_val.split('|');
				if ( a.length !== 2 || !$.isNumeric(a[0]) || !$.isNumeric(a[1]) ) {
					error = "Min / max length must be given as two numbers, separated by a pipe (|). Currently: '"+options_val+"' - Len: "+a.length;
					$('span.text_options input').focus();
					return false;
				}
			}
		} );
		if ( error ) {
			e.preventDefault();
			//alert( error );
			return;
		}
	} );


} );

}(jQuery));

jQuery(function($) {
	$.datepicker.regional['bs'] = {
		closeText: 'Zatvori',
		prevText: '&#x3c;',
		nextText: '&#x3e;',
		currentText: 'Danas',
		monthNames: ['Januar', 'Februar', 'Mart', 'April', 'Maj', 'Juni',
				'Juli', 'August', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'
		],
		monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun',
				'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'
		],
		dayNames: ['Nedelja', 'Ponedeljak', 'Utorak', 'Srijeda', 'Četvrtak', 'Petak', 'Subota'],
		dayNamesShort: ['Ned', 'Pon', 'Uto', 'Sri', 'Čet', 'Pet', 'Sub'],
		dayNamesMin: ['Ne', 'Po', 'Ut', 'Sr', 'Če', 'Pe', 'Su'],
		weekHeader: 'Wk',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['bs']);

	//Selektuj defaultni datum
	var myDate = new Date();
	var prettyDate = myDate.getDate() + '.' + (myDate.getMonth()+1) + '.' + myDate.getFullYear();
	$("#datum").val(prettyDate);

	$.timepicker.regional['hr'] = {
		hourText: 'Sat',
		minuteText: 'Minuta',
		amPmText: ['', ''],
		closeButtonText: 'Zatvoriti',
		nowButtonText: 'Sada',
		deselectButtonText: 'PoniÅ¡tite'
	}
	$.timepicker.setDefaults($.timepicker.regional['hr']);

});

$('#test').timepicker();
/* Add event listeners to the two range filtering inputs */
$("#datum").datepicker( $.datepicker.regional[ "bs" ] );

// $('#yes').click(function() {
// 	// update the block message
// 	$.blockUI({
// 		message: "<h1>Remote call in progress...</h1>"
// 	});

// 	$.ajax({
// 		url: '/',
// 		cache: false,
// 		complete: function() {
// 			// unblock when remote call returns
// 			$.unblockUI();
// 		}
// 	});
// });

// $('#no').click(function() {
// 	$.unblockUI();
// 	return false;
// });



// Funckije za CRUD/REST operacije prema PHP - Pocetak
function serializeDeep(form) {
	var rv, obj, elements, element, index, names, nameIndex, value;

	rv = {};
	elements = form.elements;
	for (index = 0; index < elements.length; ++index) {
		element = elements[index];
		name = element.name;
		if (name) {
			value = $(element).val();
			names = name.split(".");
			obj = rv;
			for (nameIndex = 0; nameIndex < names.length; ++nameIndex) {
				name = names[nameIndex];
				if (nameIndex == names.length - 1) {
					obj[name] = value;
				} else {
					obj = obj[name] = obj[name] || {};
				}
			}
		}
	}
	return rv;
}

function processGetAllData() {
	$.ajax({
		url: "/contests/categories/get",
		type: "GET",
		data: "",
		success: function(data, textStatus, jqXHR) {
			console.log("post response:");
			console.dir(data);
			console.log(textStatus);
			console.dir(jqXHR);
			$('.select-all-result').html(JSON.stringify(data));
		}
	});
}

function processInsertData(form_elems) {

	var resources = serializeDeep(form_elems);
	//alert(resources);
	return;

	$.ajax({
		url: "/contests/categories/create",
		type: "POST",
		data: serializeDeep(form_elems),
		success: function(data, textStatus, jqXHR) {
			console.log("post response:");
			console.dir(data);
			console.log(textStatus);
			console.dir(jqXHR);
			$('.insert-result').html(JSON.stringify(data));
		}
	});
}

function processUpdateData(form_elems) {
	$.ajax({
		url: "/contests/categories/update",
		type: "PUT",
		data: serializeDeep(form_elems),
		success: function(data, textStatus, jqXHR) {
			console.log("post response:");
			console.dir(data);
			console.log(textStatus);
			console.dir(jqXHR);
			('.update-by-id-result').html(JSON.stringify(data));
		}
	});
}

function processDelData(form_elems) {
	var serializedData = serializeDeep(form_elems);
	$.ajax({
		url: "/contests/categories/delete/" + serializedData.id,
		type: "DELETE",
		data: "",
		success: function(data, textStatus, jqXHR) {
			console.log("post response:");
			console.dir(data);
			console.log(textStatus);
			console.dir(jqXHR);
			$('.delete-by-id-result').html(JSON.stringify(data));
		}
	});
}
// Funckije za CRUD/REST operacije prema PHP - Kraj

function capitaliseFirstLetter(string)
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

//Modal - start
$("#fw_body").on({
    // When ajaxStart is fired, add 'loading' to body class
    ajaxStart: function() {
        $(this).addClass("loading");
    },
    // When ajaxStop is fired, rmeove 'loading' from body class
    ajaxStop: function() {
        $(this).removeClass("loading");
    }
});
$("body").on({
    // When ajaxStart is fired, add 'loading' to body class
    ajaxStart: function() {
        $(this).addClass("loading");
    },
    // When ajaxStop is fired, rmeove 'loading' from body class
    ajaxStop: function() {
        $(this).removeClass("loading");
    }
});
//MOdal - end