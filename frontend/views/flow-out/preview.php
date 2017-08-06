<table border="1" cellspacing=0 style="width: 100%;border: 1px solid #eee;line-height: 24px;">
    <tr>
        <td colspan=9 align="center">亨通瑞鑫（北京）科技有限公司</td>
    </tr>
    <tr>
        <td colspan=9 align="center">出库单</td>
    </tr>
    <tr>
        <td colspan=4>收货方：<?=$datas['supplier']?></td>
        <td colspan=5>单据编号：<?=$datas['outNumber']?></td>
    </tr>
    <tr style="background-color:#efefef;">
        <td style="font-weight:bold;">序号</td>
        <td style="font-weight:bold;">产品名称</td>
        <td style="font-weight:bold;">规格型号</td>
        <td style="font-weight:bold;">数量</td>
        <td style="font-weight:bold;">单位</td>
        <td style="font-weight:bold;">单价</td>
        <td style="font-weight:bold;">金额</td>
        <td style="font-weight:bold;">批号</td>
        <td style="font-weight:bold;">有效期</td>
    </tr>
    <?php
        $total = 0;
        $totalPrice = 0;
    ?>
    <?php foreach ($list as $item) { 
        $total += $item['quantity'];
        $totalPrice += $item['in_price'];
    ?>
        <tr style="background-color:#efefef;">
            <td><?=$item['bill_number']?></td>
            <td><?=$item['product_name']?></td>
            <td><?=$item['model']?></td>
            <td><?=$item['quantity']?></td>
            <td>EA</td>
            <td>¥<?=$item['in_one_price']?></td>
            <td>¥<?=$item['in_price']?></td>
            <td><?=$item['lot_number']?></td>
            <td><?=$item['expiration_date_one']?></td>
        </tr>
    <?php } ?>
    <tr style="background-color:#efefef;">
        <td>入库库房</td>
        <td><?=$datas['outStore']?></td>
        <td>总计</td>
        <td colspan=2><?=$total?></td>
        <td colspan=2>¥<?=$totalPrice?></td>
        <td>付款日期</td>
        <td><?=date("Y-m-d", time())?></td>
    </tr>
    <tr style="background-color:#efefef;">
        <td>备注</td>
        <td colspan=8>
            <?php foreach ($list as $item) { ?> 
                <?=$item['comment'].'<br />'?>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td colspan=2>经手人：</td>
        <td colspan=3>签收人：</td>
        <td colspan=4>审批人：</td>
    </tr>
</table>
