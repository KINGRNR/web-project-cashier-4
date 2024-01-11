<div class="modal-dialog modal-dialog-centered mw-650px" id="modal_form">
    <div class="modal-content">

        <form action="javascript:save()" method="post" id="formModule" name="formModule" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="card card-bordered">
                <div class="card-body">
                    <input type="hidden" name="menu_id" id="menu_id">
                    <div class="fv-row mb-5">
                        <label for="" class="required form-label">Nama Folder</label>
                        <input type="text" name="menu_code" id="menu_code"
                            class="form-control form-control-sm form-control-solid input-required" required />
                    </div>

                    <div class="fv-row mb-5">
                        <label for="" class="required form-label">Nama Menu</label>
                        <input type="text" name="menu_title" id="menu_title"
                            class="form-control form-control-sm form-control-solid input-required" required />
                    </div>
                    <div class="fv-row mb-5">
                        <label for="" class="required form-label">Path Folder</label>
                        <input type="text" name="menu_folder_path" id="menu_folder_path"
                            class="form-control form-control-sm form-control-solid input-required"
                            placeholder="foldername.modulename" required />
                    </div>
                    <div class="fv-row mb-5">
                        <label for="" class="required form-label">Ikon Menu</label><i class="ms-2">Contoh penggunaan Icon dibawah ini</i>
                        <input type="text" name="menu_logo" id="menu_logo" 
                            class="form-control form-control-sm form-control-solid input-required"
                            placeholder="bi bi-layers fs-3" required />
                    </div>
                    <div class="fv-row mb-5">
                        <label for="" class="required form-label">Akses</label>
                        <select name="menu_role" id="menu_role" class="form-control form-control-sm form-control-solid" required>
                            <option value="FOV4Qtgi5lcQ9kCY">
                                Superadmin
                            </option>
                            <option value="FOV4Qtgi5lcQ9kCY">
                                Superadmin
                            </option>
                            <option value="BfiwyVUDrXOpmStr">
                                Admin/Toko
                            </option>
                            <option value="FOV4Qtgi5ASHn9kZ">
                                Petugas
                            </option>
                            <option value="">
                                All Role
                            </option>
                        </select>
                    </div>
                    {{-- <div class="fv-row mb-5">
                        <label for="" class="required form-label">Akses</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Pilih Akses</option>
                            <option value="1">Superadmin</option>
                            <option value="2">Admin/Pemilik Toko</option>
                            <option value="3">Petugas</option>
                          </select>
                    </div> --}}
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" onclick="onReset(this)"
                        class="btn btn-sm btn-light btn-active-light-primary me-2 actCreate">
                        <i class="las la-redo-alt fs-1"></i> Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm me-2 actCreate">
                        <i class="las la-save fs-1"></i> Save Changes
                    </button>
                    <button type="button" onclick="onDisplayEdit(this)"
                        class="btn btn-warning btn-sm me-2 d-none actEdit">
                        <i class="las la-edit fs-1"></i>Click to Edit
                    </button>
                    <button type="button" onclick="onDelete(this)" class="btn btn-danger btn-sm me-2 d-none actEdit">
                        <i class="las la-trash fs-1"></i> Delete Data
                    </button>
                    <button type="button" class="btn btn-light close-modal" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </form>
    </div>
</div>
