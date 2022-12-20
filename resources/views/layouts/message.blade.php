@if (session('success'))
<script>
    toastr.success("{{ session('success') }}", {
        timeOut: 10000
    })

</script>
@endif
@if (session('error'))
<script>
    toastr.danger("{{ session('error') }}")

</script>
@endif