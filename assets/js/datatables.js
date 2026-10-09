$(document).ready(function() {
    
    var csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="csrf_token"]').val();

    $('.dynamic-datatable').each(function() {
        var $table =$(this);
        var pageTarget = $table.data('page');
        if (!pageTarget) return;

        var typeTarget = $table.data('type');
        if (!typeTarget) return;

        var dynamicColumns = [];
        
        $table.find('thead th').each(function() {
            var $th =$(this);
            var colName = $th.data('name');
            var colType = $th.data('type');
            // Hangi butonların basılacağını alıyoruz (Varsayılan: hepsi)
            var buttonKeys = $th.data('buttons') ?$th.data('buttons').split(',') : ['duzenle', 'durum', 'sil'];
            
            var colDef = { data: colName };

            if (colType === 'badge') {
                colDef.render = function(data) {
                    return data == 1 
                        ? '<span class="badge bg-success">Aktif</span>' 
                        : '<span class="badge bg-danger">Pasif</span>';
                };
            } 
            else if (colType === 'islem') {
                colDef.orderable = false;
                colDef.searchable = false;
                colDef.render = function(data, type, row) {
                    var buttonsHtml = '<div class="btn-group btn-group-sm" role="group">';

                    if (buttonKeys.includes('duzenle')) {
                        buttonsHtml += `
                            <a href="${typeTarget}-duzenle/${data}" class="btn btn-primary btn-edit me-2" title="Düzenle">
                                Düzenle
                            </a>
                        `;
                    }

                    if (buttonKeys.includes('durum')) {
                        buttonsHtml += `
                            <button type="button" class="btn btn-warning me-2 durum-degistir" data-id="${data}" data-durum="${row.durum}" title="Durum Değiştir">
                                Durum
                            </button>
                        `;
                    }

                    if (buttonKeys.includes('sil')) {
                        buttonsHtml += `
                            <button type="button" class="btn btn-danger kayit-sil" data-id="${data}" title="Sil">
                                Sil
                            </button>
                        `;
                    }

                    buttonsHtml += '</div>';
                    return buttonsHtml;
                };
            }

            dynamicColumns.push(colDef);
        });

        var dataTableInstance = $table.DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "request/" + pageTarget,
                type: "POST",
                data: function(d) {
                    d.postType = "List"; 
                    d.csrf_token = csrfToken;
                }
            },
            columns: dynamicColumns,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
            },
            createdRow: function (row, data, dataIndex) {
                $(row).attr('data-id', data.id);$(row).css('cursor', 'grab');
            },
            drawCallback: function(settings) {
                if ($.fn.sortable) {
                    $table.find('tbody').sortable({
                        update: function(event, ui) {
                            var siralama = [];
                            
                            $(this).children('tr').each(function() {
                                var rowId = $(this).data('id');
                                if (rowId) siralama.push(rowId);
                            });

                            $.ajax({
                                url: 'request/' + pageTarget,
                                type: 'POST',
                                dataType: 'json',
                                data: { 
                                    postType: 'Siralama', 
                                    siralama: siralama, 
                                    csrf_token: csrfToken 
                                },
                                success: function(response) {
                                    if(response.type !== 'success') {
                                        alert(response.message || "Sıralama güncellenirken hata oluştu.");
                                        dataTableInstance.ajax.reload(null, false);
                                    }
                                }
                            });
                        }
                    });
                }
            }
        });

        // Silme olayı
        $table.on('click', '.kayit-sil', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            
            if(confirm('Bu kaydı silmek istediğinize emin misiniz?')) {
                $.ajax({
                    url: 'request/' + pageTarget,
                    type: 'POST',
                    dataType: 'json',
                    data: { 
                        postType: 'Sil', 
                        id: id, 
                        csrf_token: csrfToken
                    },
                    success: function(response) {
                        if(response.type === 'success') {
                            dataTableInstance.ajax.reload(null, false); 
                        } else {
                            alert(response.message || "Bir hata oluştu");
                        }
                    }
                });
            }
        });

        // Durum değiştirme olayı
        $table.on('click', '.durum-degistir', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var mevcut_durum = $(this).data('durum');
            var yeni_durum = mevcut_durum == 1 ? 0 : 1;

            $.ajax({
                url: 'request/' + pageTarget,
                type: 'POST',
                dataType: 'json',
                data: { 
                    postType: 'Durum', 
                    id: id, 
                    durum: yeni_durum, 
                    csrf_token: csrfToken
                },
                success: function(response) {
                    if(response.type === 'success') {
                        dataTableInstance.ajax.reload(null, false);
                    } else {
                        alert(response.message || "Bir hata oluştu");
                    }
                }
            });
        });
    });
});