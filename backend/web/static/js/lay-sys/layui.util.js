/**
 * 渲染layui表格
 * @param {object} table layui的table对象
 * @param {object} data 渲染layui表格的参数(和layui一致)
 */
function layuiTable(table, data) {
    table.render({
        elem: data.elem
        , method: data.method || "post"
        , where: data.where || {}
        , height: data.height
        , limit: data.limit || 10
        , limits: data.limits || [10, 50, 200, 500]
        , url: data.url
        , toolbar: data.toolbar
        , defaultToolbar: data.defaultToolbar || ['filter', 'print']
        , title: data.title
        , page: data.page || { theme: '#1E9FFF' }
        , response: data.response || { statusCode: 200 /*规定成功的状态码，默认：0*/ }
        , cols: data.cols || [[{ type: 'checkbox', fixed: 'left' }, { type: 'numbers', title: '#', fixed: 'left' }]]
        , done: data.done || function (res, curr, count) { }
    });
}


/**
 * 重载layui表格(一般查询的时候使用)
 * @param {object} table 表格的id
 * @param {string} id 表格的id
 * @param {object} data 重载layui表格的参数(和layui一致)
 */
function tableReload(table, id, data) {
    table.reload(id, {
        url: data.url
        , method: data.method || "post"
        , where: data.where
        , height: data.height
        , done: data.done || function (res, curr, count) { }
    });
}

/**
 * 弹出一个最高警告框
 * @param {string} infoText 警告框内容
 * @param {string} title 警告框标题
 * @param {function} done 回调函数
 */
function openTopWarn(infoText, title, done) {
    var data = { btn: ['确定'], title: title, icon: 0, shade: 0.9, anim: 6, closeBtn: 0, isOutAnim: false, scrollbar: false, id: "openTopWarn" };
    top.layui.layer.confirm(infoText, data, done);
}