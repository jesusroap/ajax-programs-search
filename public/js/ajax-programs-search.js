(function ( $ ) {

	$('#search-programs').keyup(function(){
		var query = $(this).val();

		if (query.length > 2) {
			$.ajax({
				method: 'post',
				url: programs.adminAjax,
				data: {
					action: 'findProgram',
					query: query,
				},
				beforeSend: function() {
					if ( $('.search-results').length ) {
						$('.search-results').html('<div class="program-wrapper"><div class="content"><p>Buscando programas...</p></div></div>');
					} else {
						$('#form-search-programs').append('<div class="search-results"><div class="program-wrapper"><div class="content"><p>Buscando programas...</p></div></div></div>');
					}
				},
				success: function(programs) {
					var $wrapper = $('.search-results');

					if (programs.length) {
						var programsMarkup = searchResultsMarkup(programs);

						$wrapper.html(programsMarkup);
					} else {
						$wrapper.html('<div class="program-wrapper"><div class="content"><p>No se encontraron programas</p></div></div>')
					}
					
				}
			})
		} else if(query.length < 3) {
			$('.search-results').html('<div class="program-wrapper"><div class="content"><p>Buscando programas...</p></div></div>');
		}

	});

	function searchResultsMarkup(programs) {
		var markup = '';

		programs.forEach(function(program) {
			markup += '<div class="program-wrapper">';
			markup += '<div class="content">';
			markup += '		<h4><a href="' + program.link + '">' + program.title + '</a></h4>'
			markup += '</div>';
			markup += '</div>'
		});

		return markup;
	}

}) (jQuery);