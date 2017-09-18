<table id="ta" border="1" cellspacing=0 style="width: 100%;border: 1px solid #eee;line-height: 24px;">
    <tr>
        <td colspan=7 align="center">亨通瑞鑫（北京）科技有限公司</td>
    </tr>
    <tr>
        <td colspan=7 align="center">销售单</td>
    </tr>
    <tr>
        <td colspan=3>收货方：<?=$datas['custom']?></td>
        <td colspan=4>销售单号：<?=$datas['saleNumber']?></td>
    </tr>
    <tr style="background-color:#efefef;">
        <td style="font-weight:bold;">序号</td>
        <td style="font-weight:bold;">产品名称</td>
        <td style="font-weight:bold;">规格型号</td>
        <td style="font-weight:bold;">数量</td>
        <td style="font-weight:bold;">单位</td>
        <td style="font-weight:bold;">单价</td>
        <td style="font-weight:bold;">金额</td>
    </tr>
    <?php
        $total = 0;
        $totalPrice = 0;
    ?>
    <?php foreach ($list as $item) { 
        $total += $item['quantity'];
        $totalPrice += $item['sale_price'];
    ?>
        <tr style="background-color:#efefef;">
            <td><?=$item['bill_number']?></td>
            <td><?=$item['product_name']?></td>
            <td><?=$item['model']?></td>
            <td><?=$item['quantity']?></td>
            <td>EA</td>
            <td>¥<?=$item['sale_one_price']?></td>
            <td>¥<?=$item['sale_price']?></td>
        </tr>
    <?php } ?>
    <tr style="background-color:#efefef;">
        <td>付款日期</td>
        <td><?=date("Y-m-d", time())?></td>
        <td colspan=1>总计</td>
        <td colspan=2><?=$total?></td>
        <td colspan=2>¥<?=$totalPrice?></td>
    </tr>
    <tr>

    </tr>
    <tr style="background-color:#efefef;">
        <td>备注</td>
        <td colspan=6>
            <?php foreach ($list as $item) { ?> 
                <?=$item['comment'].'<br />'?>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan=4>经手人：</td>
        <td colspan=3>审批人：</td>
    </tr>
</table>
<button onclick="javascript:method1('ta')">导出EXCEL</button>
<script>
var idTmr;
function  getExplorer() {
    var explorer = window.navigator.userAgent ;
    //ie 
    if (explorer.indexOf("MSIE") >= 0) {
        return 'ie';
    }
    //firefox 
    else if (explorer.indexOf("Firefox") >= 0) {
        return 'Firefox';
    }
    //Chrome
    else if(explorer.indexOf("Chrome") >= 0){
        return 'Chrome';
    }
    //Opera
    else if(explorer.indexOf("Opera") >= 0){
        return 'Opera';
    }
    //Safari
    else if(explorer.indexOf("Safari") >= 0){
        return 'Safari';
    }
}
function method1(tableid) {//整个表格拷贝到EXCEL中
    if(getExplorer()=='ie')
    {
        var curTbl = document.getElementById(tableid);
        var oXL = new ActiveXObject("Excel.Application");

        //创建AX对象excel 
        var oWB = oXL.Workbooks.Add();
        //获取workbook对象 
        var xlsheet = oWB.Worksheets(1);
        //激活当前sheet 
        var sel = document.body.createTextRange();
        sel.moveToElementText(curTbl);
        //把表格中的内容移到TextRange中 
        sel.select();
        //全选TextRange中内容 
        sel.execCommand("Copy");
        //复制TextRange中内容  
        xlsheet.Paste();
        //粘贴到活动的EXCEL中       
        oXL.Visible = true;
        //设置excel可见属性

        try {
            var fname = oXL.Application.GetSaveAsFilename("Excel.xls", "Excel Spreadsheets (*.xls), *.xls");
        } catch (e) {
            print("Nested catch caught " + e);
        } finally {
            oWB.SaveAs(fname);

            oWB.Close(savechanges = false);
            //xls.visible = false;
            oXL.Quit();
            oXL = null;
            //结束excel进程，退出完成
            //window.setInterval("Cleanup();",1);
            idTmr = window.setInterval("Cleanup();", 1);

        }

    }
    else
    {
        tableToExcel('ta');
    }
}
function Cleanup() {
    window.clearInterval(idTmr);
    CollectGarbage();
}
var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
    base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },
    format = function(s, c) {
        return s.replace(/{(\w+)}/g,
        function(m, p) { return c[p]; }) }
            return function(table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = {worksheet: name || '<?=$datas['saleNumber']?>', table: table.innerHTML}
                window.location.href = uri + base64(format(template, ctx))
              }
})();
</script>
