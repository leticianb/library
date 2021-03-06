$(document).ready(function() {

    $('.btn-save').click(function(e) {
        e.preventDefault()

        let dados = $('#formeixo').serialize()

        dados += `&operacao=${$('.btn-save').attr('data-operation')}`

        $.ajax({
            type: 'POST',
            dataType: 'json',
            assync: true,
            data: dados,
            url: 'src/eixo/model/saveeixo.php',
            success: function(dados) {
                Swal.fire({
                    title: 'library',
                    text: dados.mensagem,
                    icon: dados.tipo,
                    confirmButtonText: 'OK'
                })

                $('#modaleixo').modal('hide')
                $('#table-eixo').DataTable().ajax.reload()
            }
        })
    })

})