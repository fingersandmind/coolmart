<script src="{{ asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(function(e) {
        $('#datatable').DataTable();
    } );
</script>
<script>
    $(function(e) {
        $('#datatable-lists').DataTable();
    } );
</script>
<script>
    $(function(e) {
        $('#datatable-po').DataTable({
            "order" : [[0, 'desc']]
        });
    } );
</script>

{{-- "order": [[ 6, "desc" ]] --}}