try {
    $(document).ready(function () { $("#datatable").DataTable(), $("#datatable-buttons").DataTable({ lengthChange: !1, buttons: ["copy", "excel", "pdf", "colvis"] }), $(".dataTables_length select").addClass("form-select form-select-sm") });
} catch { }