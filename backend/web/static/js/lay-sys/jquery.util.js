/**
 * ajax请求。和jquery一样，只不过有默认值，这样就不用老是写了。
 * @param {object} data 和jqueryAjax一样的参数
 */
function jqueryAjax(data) {
    (function () {
        var strData = (data.data || '{}');
        if (typeof (strData) == "string") {
            data.data = strData;
        } else {
            data.data = JSON.stringify(strData);
        }
        $.ajax({
            type: data.type || 'post'
            , url: data.url || ''
            , contentType: data.contentType || 'application/json'
            , data: data.data
            , dataType: data.dataType || 'json'
            , headers: data.headers || {}
            , cache: false
            , success: function (result) {
                if (data.success) {
                    data.success(result) || '';
                }
            },
            complete: function (XMLHttpRequest, textStatus) {
                if (data.complete) {
                    data.complete(XMLHttpRequest, textStatus) || '';
                }
            }
            , error: function (ex) {
                if (data.error) {
                    console.error(ex.responseText || '');
                    data.error(ex) || '';
                }
            }
        });
    }(data));
}