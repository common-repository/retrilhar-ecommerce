jQuery(document).ready(function($) {
	jQuery(".retrilhar_vitrine_filtro").change(function () {
		retrilharVitrine('retrilhar_vitrine_eventos', jQuery("#retrilhar_div_vitrine_eventos"))
		retrilharVitrine('retrilhar_vitrine_eventos_posts', jQuery("#retrilhar_div_vitrine_eventos_posts"))
		retrilharVitrine('retrilhar_vitrine_produtos', jQuery("#retrilhar_div_vitrine_produtos"))
	}).change();

	function retrilharVitrine(action, div) {
		if (!div.length) {
			return
		}

		var data = {
			'action': action,
			'atividade': $("#retrilhar_id_tipo_atividade").val(),
			'dtInicio': $("#retrilhar_dt_inicio").val(),
			'dtFim': $("#retrilhar_dt_fim").val()
		};
		
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		$.post(Retrilhar.ajaxUrl, data,
				function(response) {
					if (!response.success) {
						return
					}
					div.html(response.data.html)
					jQuery(".retrilhar-hidden").hide()
					jQuery("a#aMaisEventos").click(function (e) {
						jQuery("#aMaisEventos").hide()
						jQuery(".retrilhar-hidden").show()
						e.preventDefault()
					})
				})
	}
})
