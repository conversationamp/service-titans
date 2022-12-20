let table{{ $position }} = $('#datatable{{ $position }}').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        "url": "{{ route($route . '.get-default',$position) }}",
    },

columns: [
    {
        data: 'titan_location_name',
        name: 'titan_location_name'
    },
    {
        data: 'business_unit_name',
        name: 'business_unit_name'
    },
    {
        data: 'campaign_name',
        name: 'campaign_name'
    },
    {
        data: 'priority',
        name: 'priority'
    },
    {
        data: 'job_type_name',
        name: 'job_type_name'
    },
    {
        data: 'slot',
        name: 'slot'
    },
    {
        data: 'position',
        name: 'position'
    },
    {
        data: 'default',
        name: 'default'
    },
],


order: [
    [5, 'asc']
],
rowGroup: {
    startRender: function ( rows, group ) {
     return group +' Please select default from below rows';
 },
    dataSrc: ['position']
},
});