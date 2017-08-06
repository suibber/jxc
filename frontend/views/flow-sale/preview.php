<table border="1" cellspacing=0 style="width: 100%;border: 1px solid #eee;line-height: 24px;">
    <tr>
        <td colspan=7 align="center">亨通瑞鑫（北京）科技有限公司</td>
    </tr>
    <tr>
        <td colspan=7 align="center">销售单</td>
    </tr>
    <tr>
        <td colspan=3>收货方：<?=$datas['custom']?></td>
        <td colspan=4>单据编号：<?=$datas['saleNumber']?></td>
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
        <td colspan=2>总计</td>
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
