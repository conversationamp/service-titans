d._token = $('meta[name="csrf-token"]').attr('content');
var it=$('input[name=type]:checked').val();
if ( it!= '') {
    d.item_type =it;
}
