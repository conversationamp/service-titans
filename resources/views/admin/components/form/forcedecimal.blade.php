function enforceNumberValidation(ele) {

    var target =ele;
    var decimal =target.getAttribute('data-decimal');
    if (decimal != null) {
        // found valid rule for decimal
        var decimal = parseInt(decimal) || 0;
        var val = target.value;
        var splitVal = val.split('.');
        if (decimal > 0) {
            if (splitVal.length == 2 && splitVal[1].length > decimal) {
                // user entered invalid input
                target.value=splitVal[0] + '.' + splitVal[1].substr(0, decimal);
            }
        } else if (decimal == 0) {
            // do not allow decimal place
            if (splitVal.length > 1) {
                // user entered invalid input
                target.value=splitVal[0]
            }
        }
    }
}
