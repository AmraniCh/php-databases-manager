/**
 * Responsible for ajax requests
 * Optionel Params [complete, beforeSend, async]
 * Required Params [url, method, data, success]
 */
function ajax (url, method, data, dataType, success, complete = null, beforeSend = null, async = null)
{
    return $.ajax ({
        url: url,
        type: method,
        dataType: dataType,
        data: data,
        async: (async == null) ? true : false,
        beforeSend: beforeSend,
        success: success,
        complete: complete
    });
}

/**
 * Takes a JSON array as a parameter
 * Returns the keys (columns) of the array objects
 */
function columns(array)
{
    var cols = [];

    Object.keys(array[0]).forEach(e => cols.push(e));

    return cols;
}

/**
 * Takes a normal array as a parameter
 * Returns a JSON array especially for DataTable's <column> property
 */
function dataTableColumns(array)
{
    var cols = [];

    array.forEach(e => {
        var c = new Object();
        c['data'] = e;

        cols.push(c);
    });

    return cols;
}
