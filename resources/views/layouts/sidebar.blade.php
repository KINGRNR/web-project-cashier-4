<!--end::Aside Toggle-->
<div class="hover-scroll-overlay-y my-2 my-lg-5 pe-lg-n1" id="kt_aside_menu_wrapper" data-kt-scroll="true"
    data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
    data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="5px">
    <!--begin::Menu-->
    <div class="sidebar-append menu menu-column menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold"
        id="#kt_aside_menu" data-kt-menu="true">
        {{-- <div class="menu-item py-2">
            <a class="menu-link menu-center" href="javascript:;" data-con="ozqopvu1arkmk3gv"
            data-code="dashboard" data-type="main" onclick="loadPage(this)"
            title="" data-judul="dashboard" data-bs-toggle="tooltip"
            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right"
            data-bs-original-title="dashboard">
                <span class="menu-icon me-0">
                    <i class="bi bi-house fs-2"></i>
                </span>
                <span class="menu-title">Home</span>
            </a>
        </div> --}}
        {{-- <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item py-2">
            <span class="menu-link menu-center" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                <span class="menu-icon me-0">
                    <i class="bi bi-gear fs-2"></i>
                </span>
                <span class="menu-title">More</span>
            </span>
            <div class="menu-sub menu-sub-dropdown w-225px px-1 py-4">
                <div class="menu-item">
                    <div class="menu-content">
                        <span class="menu-section fs-5 fw-bolder ps-1 py-1">Pre-Modul</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link"href="javascript:;" data-con="cfweqelm72wwtxbg" data-code="example" data-type="sub"
                    onclick="loadPage(this)">
                        <span class="menu-icon">
                            <i class="bi bi-grid fs-3"></i>
                        </span>
                        <span class="menu-title">CRUD Example</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="javascript:;" data-con="sqtlpuyaaivgnaSS" data-code="leafletcontoh" data-type="sub"
                    onclick="loadPage(this)">
                    <span class="menu-icon">
                            <i class="bi bi-box fs-3"></i>
                        </span>Leaflet Example</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="https://preview.keenthemes.com/metronic8/demo6/layout-builder.html" title="Build your layout, preview and export HTML for server side integration" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                        <span class="menu-icon">
                            <i class="bi bi-layers fs-3"></i>
                        </span>
                        <span class="menu-title">Layout Builder</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="../../demo6/dist/documentation/getting-started/changelog.html">
                        <span class="menu-icon">
                            <i class="bi bi-card-text fs-3"></i>
                        </span>
                        <span class="menu-title">Changelog v8.0.25</span>
                    </a>
                </div>
            </div>
        </div> --}}
        {{-- <div class="menu-item-append">

        </div> --}}
    </div>
    <!--end::Menu-->
</div>
<script>
    function loadSidebar() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: APP_URL + "getSidebar",
            type: "get",
            success: function (res) {
                $.each(res.data.nonparent, function (index, value) {
                    var sidebarnonparent = `<div class="menu-item py-2">
                        <a class="menu-link menu-center" href="javascript:;" data-con="${value.menu_id}" data-code="${value.menu_code}"
                            data-type="main" onclick="loadPage(this)" title="" data-judul="${value.menu_title}" data-bs-toggle="tooltip"
                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right"
                            data-bs-original-title="Dashboard">
                            <span class="menu-icon">
                                <i class="${value.menu_logo}"></i>
                        </span>           

                            <span class="menu-title">${value.menu_title}</span>
                        </a>
                    </div>`;
                    $('.sidebar-append').append(sidebarnonparent);
                    console.log(sidebarnonparent);
                });
             
                            resolve(); // Resolve the promise when the AJAX request is successful
            },
            error: function (xhr, status, error) {
                reject(error); // Reject the promise if there is an error
            },
        });
    });
}

</script>
