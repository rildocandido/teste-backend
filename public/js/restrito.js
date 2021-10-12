// Exibe modal
$(function () {
	
	$("#btn_add_clientes").click(function () {
		clearErrors();
		$("#form_clientes")[0].reset();
 		$("#modal_clientes").modal();
	})

	$("#form_clientes").submit(function (){
		$.ajax({
			type: "POST",
			url: BASE_URL + "restrito/ajax_save_cliente",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				clearErrors();
				$("#btn_save_cliente").parent().siblings(".help-block").html(loadingImg("Verificando..."));
			},
			success: function(response) {
				clearErrors();
				if (response["status"]) {
					$("#modal_clientes").modal("hide");
					swal("Sucesso!","Cliente salvo com sucesso!","success");
					dt_cliente.ajax.reload();
				} else {
					showErrorsModal(response["error_list"])
				}
			}
		})

		return false;
	});

	function active_btn_cliente() {
		$(".btn-edit-cliente").click(function(){
			$.ajax({
				type: "POST",
				url: BASE_URL + "restrito/ajax_get_cliente_data",
				dataType: "json",
				data: {"clientes_id": $(this).attr("clientes_id")},
				success: function(response) { 
					clearErrors();
					$("#form_clientes")[0].reset(); 
					$.each(response["input"], function(id, value) {
						$("#"+id).val(value);
					});
					$("#modal_clientes").modal();
				}
			})
		})
		$(".btn-del-cliente").click(function(){
			
			clientes_id = $(this);
			swal({
				title: "Atenção!",
				text: "Deseja deletar esse Cliente?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#d9534f",
				confirmButtonText: "Sim",
				cancelButtontext: "Não",
				closeOnConfirm: true,
				closeOnCancel: true,
			}).then((result) => {
				if (result.value) {
					$.ajax({
						type: "POST",
						url: BASE_URL + "restrito/ajax_delete_cliente_data",
						dataType: "json",
						data: {"clientes_id": clientes_id.attr("clientes_id")},
						success: function(response) {
							swal("Sucesso!", "Ação executada com sucesso", "success");
							dt_cliente.ajax.reload();
						}
					})
				}
			})

		});
	}
 	  
	var dt_cliente = $("#dt_clientes").DataTable({
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": BASE_URL + "restrito/ajax_list_cliente",
			"type": "POST",
		},
		"language": {
            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        },
		"columnDefs": [
			{ targets: "no-sort", orderable: false },
			{ targets: "dt-center", className: "dt-center" },
		],
		"drawCallback": function(){
			active_btn_cliente();
		} 

	});


});

