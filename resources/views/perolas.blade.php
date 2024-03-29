<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gerenciamento de Pérolas</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h1>Gerenciamento de Pérolas</h1>
    <div>
    @for ($index = 2; $index <= 9; $index++)
        <div>
            <span>Pérola {{ $index }}:</span>
            <button class="decrement" data-perola-id="perola{{ $index }}">-</button>
            <span id="perola{{ $index }}">0</span>
            <button class="increment" data-perola-id="perola{{ $index }}">+</button>
            <div id="guiaForja{{ $index }}"></div>
        </div>
    @endfor
    </div>

    <script>
    $(document).ready(function() {
        $('.increment, .decrement').click(function() {
            var perolaId = $(this).data('perola-id');
            var action = $(this).hasClass('increment') ? 'incrementar' : 'decrementar';
            var quantidadeAtual = parseInt($('#' + perolaId).text()) || 0;
            var novaQuantidade = action === 'incrementar' ? quantidadeAtual + 1 : Math.max(0, quantidadeAtual - 1);

            atualizarPerola(perolaId, novaQuantidade);
        });

        function atualizarPerola(perolaId, quantidade) {
            $.ajax({
                url: '/atualizar-perola',
                type: 'POST',
                data: {
                    perola_id: perolaId,
                    quantidade: quantidade,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#' + perolaId).text(data.quantidade);
                    var guiaId = 'guiaForja' + perolaId.substring(6);
                    $('#' + guiaId).empty();
                    var conteudoGuia = '<strong>Guia de Forja:</strong><ul>';
                    $.each(data.guia_forja, function(perolaDependente, quantidade) {
                        conteudoGuia += '<li>' + quantidade + 'x ' + perolaDependente.replace('perola', 'Pérola ') + '</li>';
                    });
                    conteudoGuia += '</ul>';
                    $('#' + guiaId).html(conteudoGuia);
                }
            });
        }
    });
    </script>
</body>
</html>
