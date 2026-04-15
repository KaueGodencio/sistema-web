$(document).ready(function() {
    // 0. Inicialização do DataTables
    $('.datatable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/pt-BR.json"
        }
    });

    // 1. Controle da Sidebar
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
    });

    // 2. Lógica de Pedidos (Cadastro Dinâmico)
    let itemIndex = 0;

    function calculateTotals() {
        let grandTotal = 0;
        $('.item-row').each(function() {
            const qty = parseFloat($(this).find('.qty').val()) || 0;
            const unitPrice = parseFloat($(this).find('.unit-price').val()) || 0;
            const total = qty * unitPrice;
            $(this).find('.item-total').text('R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
            grandTotal += total;
        });
        $('#grandTotal').text('R$ ' + grandTotal.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
    }

    function addItem() {
        const templateNode = document.getElementById('itemTemplate');
        if (!templateNode) return;

        let template = templateNode.innerHTML;
        template = template.replace(/{index}/g, itemIndex);
        $('#itemsBody').append(template);
        itemIndex++;
        calculateTotals();
    }

    // Eventos de Itens
    $('#addItem').on('click', function() {
        addItem();
    });

    $(document).on('click', '.removeItem', function() {
        $(this).closest('tr').remove();
        calculateTotals();
    });

    $(document).on('input', '.qty, .unit-price', function() {
        calculateTotals();
    });

    // Inicialização do primeiro item se o modal for aberto
    $('#modalNovoPedido').on('shown.bs.modal', function () {
        if ($('#itemsBody').children().length === 0) {
            addItem();
        }
    });
});
