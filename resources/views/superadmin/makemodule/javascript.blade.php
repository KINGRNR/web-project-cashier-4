<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="assets/js/quickact.js"></script>
<script type="text/javascript">
    var form = 'formExample';
    $(() => {
        init()
        console.log("halo")
    })
    init = async () => {
        await initializeDataTables();
        quick.unblockPage()
    }
    $('#modal_form').on('hidden.bs.modal', function() {
        $(`input, select`).removeAttr('disabled');
    });
    //filter
    var filterDatatable = [];
    var menutable = null;

    function initializeDataTables(filterDatatable) {
        menutable = $('#table-menu').DataTable({
            processing: true,
            serverSide: true,
            clickable: true,
            searchAble: true,
            searching: true,
            destroyAble: true,
            ajax: {
                url: APP_URL + 'menu/table',
                type: "POST",
                dataType: "json",
            },
            columns: [{
                    "targets": 0,
                    render: function(data, type, row, meta) {
                        return '<span class="ps-3">' + (meta.row + meta.settings._iDisplayStart + 1) +
                            '</span>';
                    }
                },
                {
                    data: 'menu_id',
                    name: 'menu_id'
                },
                {
                    data: 'menu_code',
                    name: 'menu_code'
                },
                {
                    data: 'menu_title',
                    name: 'menu_title'
                },
                {
                    data: 'menu_role',
                    name: 'menu_role',
                    render: function(data, type, row, meta) {
                        switch (data) {
                            case 'FOV4Qtgi5lcQ9kCY':
                                return '<span class="badge badge-primary">Superadmin</span>';
                            case 'BfiwyVUDrXOpmStr':
                                return '<span class="badge badge-warning">Admin/Toko</span>';
                            case 'FOV4Qtgi5lcQ9kZ':
                                return '<span class="badge badge-success">Petugas</span>';
                            default:
                                return '<span class="badge badge-secondary">Unknown Role</span>';
                        }
                    }
                }, {
                    data: 'menu_order',
                    name: 'menu_order'
                },
                {
                    data: 'menu_folder_path',
                    name: 'menu_folder_path'
                },
                {
                    data: 'menu_parent',
                    name: 'menu_parent'
                }
            ]

        });

        // $('#search_company').on('input', function() {
        //     var searchValue = $(this).val();
        //     userTable.search(searchValue).draw();
        // });

        // $('#table-user tbody').on('click', 'tr', function() {
        //     let rowData = userTable.row(this).data();
        //     if (rowData) {
        //         let id = rowData.id;
        //         onDetail(id);
        //     } else {
        //         onReset();
        //         $('#formExample').find('input, select').removeAttr('disabled');
        //         $('.actCreate').removeClass('d-none');
        //         $('.actEdit').addClass('d-none');
        //     }
        // }).css('cursor', 'pointer');
    }

    // toggleDetailUser = () => {
    //     $(`[data-group="detail"]`).addClass('active');
    //     $(`[data-group="job"]`).removeClass('active');
    //     $('#job_history').fadeOut();
    //     $('#kt_profile_details_view').fadeIn();
    // }
    // toggleJob = () => {
    //     $(`[data-group="detail"]`).removeClass('active');
    //     $(`[data-group="job"]`).addClass('active');
    //     $('#kt_profile_details_view').fadeOut();
    //     $('#job_history').fadeIn();
    // }
    toogleTable = () => {
        $('.table-company-ini').fadeIn();
        $('.detail').fadeOut();
    }
    toggleMenu = (id) => {
        Swal.fire({
            title: 'Action',
            showCancelButton: true,
            showDenyButton: false,
            confirmButtonText: 'Details',
            customClass: {
                popup: 'custom-swal-popup',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                onDetail(id).then(() => {
                    initializeDataTablesJob(id);
                });
            }
        })
    }
    save = () => {
        // $('#submit-btn').attr('disabled');
        var form = "formModule";
        var data = new FormData($('[name="' + form + '"]')[0]);
        // $('#submit-btn').prop('disabled', true);

        Swal.fire({
            title: 'Apakah data yang anda input sudah benar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post("/menu/createmenu", data, {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'multipart/form-data',
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            $('#formModule').trigger('reset');
                            $(".close-modal").trigger('click');
                            quick.toastNotif({
                                title: 'success',
                                icon: 'success',
                                timer: 500,
                                callback: function() {
                                    quick.reload('makemodule')
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('There has been a problem with your Axios operation:', error);
                    });
            }
        });
    };
</script>
