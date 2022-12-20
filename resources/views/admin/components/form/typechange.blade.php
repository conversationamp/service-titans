$('input[name=type]').on('change', function(e) {

    var addnew = $('.btn-add-new');
    oldhref = addnew.attr('old-href');
    if(typeof oldhref=='undefined'){
        oldhref = addnew.attr('href');
        addnew.attr('old-href',addnew.attr('href'));
    }
    addnew.attr('href',oldhref+'/'+$('input[name=type]:checked').val());
    table.draw();
    try{
        tablefolder.draw();
    }catch(err){

    }
});
