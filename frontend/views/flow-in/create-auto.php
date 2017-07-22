<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOrder */

$this->title = 'Create In Order';
$this->params['breadcrumbs'][] = ['label' => 'Flow Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-order-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="ui grid">
      <form class="ui form">
        <div class="inline fields">
            <div class="four wide column">入库单号：</div>
            <div class="twelve wide column">
                <input name="first-name" placeholder="" type="text" value="<?=$data['orderNumber']?>">
            </div>
        </div>
        <div class="inline fields">
            <div class="four wide column">订单/出库单号：</div>
            <div class="twelve wide column">
                <input type="text" value="" id="order_number" onblur="getOrderInfo(this)">
            </div>
        </div>
        <div class="inline fields">
            <div class="twelve wide column">
                <div class="inline fields">
                    <div class="field">供应商：</div>
                    <div class="field">
                        <input id="supplier" size="40" placeholder="" type="text" value="">
                    </div>
                    <div class="field">
                        <div class="ui dropdown" id="supplier-down">
                          <i class="filter icon"></i>
                          <span class="text" id="supplier-value">筛选供应商</span>
                          <i class="dropdown icon"></i>
                          <div class="menu" id=''>
                            <div class="ui icon search input">
                              <i class="search icon"></i>
                              <input type="text" placeholder="输入关键字搜索">
                            </div>
                            <?php foreach ($data['supplierList'] as $supplier) { ?>
                                <div class="item" data-value="<?=$supplier?>" data-pattern="like"><?=$supplier?></div>
                            <?php } ?>
                          </div>
                        </div>
                    </div>
                    <div class="field">
                        <select class="ui fluid dropdown" id="inStore">
                            <option value="">入库库房</option>
                            <?php foreach ($data['storeList'] as $store) { ?>
                            <option value="<?=$store?>"><?=$store?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="inline fields ">

<table class="ui celled table">
  <thead>
    <tr>
      <th>单据序号</th>
      <th>条形码1</th>
      <th>条形码2</th>
      <th>产品型号</th>
      <th>产品名称</th>
      <th>数量</th>
      <th>进货单价</th>
      <th>进货金额</th>
      <th>批号</th>
      <th>有效期</th>
      <th>备注</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bill">
        <td><input type="text" id="bill_number_1" class="bill_number" value="1" placeholder=""></td>
        <td><input type="text" id="code_one_1" onblur="setCodeOne(this,1)" placeholder=""></td>
        <td><input type="text" id="code_two_1" placeholder=""></td>
        <td><input type="text" id="model_1" onchange="setModel(this,1)" placeholder=""></td>
        <td><input type="text" id="product_name_1" placeholder=""><input type="hidden" id="type_1" placeholder=""></td>
        <td><input type="text" id="quantity_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="in_one_price_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="in_price_1" placeholder=""></td>
        <td><input type="text" id="lot_number_1" placeholder=""></td>
        <td><input type="text" id="expiration_date_one_1" placeholder=""></td>
        <td><input type="text" id="comment_1" placeholder=""></td>
    </tr>
    <tr id="default-bill"></tr>
  </tbody>
  <tfoot class="full-width">
    <tr>
      <th colspan="11">
        <div class="ui right floated small primary button" onclick="preview()"><i class="send outline icon"></i>预览</div>
        <div class="ui right floated small orange button" onclick="save()"><i class="checkmark icon"></i>保存</div>
        <div class="ui left floated small button" onclick="addRow()"><i class="plus icon"></i>增加</div>
        <div class="ui left floated small button" onclick="removeRow()"><i class="minus icon"></i>减少</div>
      </th>
    </tr>
  </tfoot>
</table>
        </div>
      </form>
    </div>

</div>

<script>
function addRow(){
    id = getLatestId() + 1;
    var html = '<tr class="bill"><td><input type="text" id="bill_number_'+id+'" class="bill_number" value="'+id+'" placeholder=""></td><td><input type="text" id="code_one_'+id+'" onblur="setCodeOne(this,'+id+')" placeholder=""></td><td><input type="text" id="code_two_'+id+'" placeholder=""></td><td><input type="text" id="model_'+id+'" onchange="setModel(this,'+id+')" placeholder=""></td><td><input type="text" id="product_name_'+id+'" placeholder=""><input type="hidden" id="type_'+id+'" placeholder=""></td><td><input type="text" id="quantity_'+id+'" onblur="setPrivce('+id+')" placeholder=""></td><td><input type="text" id="in_one_price_'+id+'" onblur="setPrivce('+id+')" placeholder=""></td><td><input type="text" id="in_price_'+id+'" placeholder=""></td><td><input type="text" id="lot_number_'+id+'" placeholder=""></td><td><input type="text" id="expiration_date_one_'+id+'" placeholder=""></td><td><input type="text" id="comment_'+id+'" placeholder=""></td></tr>';
    $("#default-bill").before(html);
}

function removeRow(){
    id = getLatestId();
    if (id > 1) {
        $("#default-bill").prev().remove();
    } else {
        alertS('错误', '请至少保留一条记录')
    }
}
function getLatestId(){
    var ids = $(".bill_number");
    var id = $(ids[(ids.length-1)]).attr('id');
    id = parseInt(id.replace('bill_number_',''));
    return id;
}
function setCodeOne(data,id){
    var code = $(data).val();
    var productNumber = code.substr(0,16);
    var dict = {'productNumber':productNumber};
    $.post(
        '/product/get-product-info-by-number',
        dict,
        function(data){
            var model = data['model']
            $("#model_"+id).val(model);
            $("#product_name_"+id).val(data['name']);
            $("#type_"+id).val(data['type']);
            setModel('',id,model)
        }
    );
    console.log(productNumber)
}
function setModel(data,id,model){
    if (!model){
        var model = $(data).val();
    }
    var order_number = $("#order_number").val();
    var dict = {'order_number':order_number,'model':model};
    $.post(
        '/flow-order/get-order-info',
        dict,
        function(data){
            $("#in_one_price_"+id).val(data['data']['discount_price']);
            $("#product_name_"+id).val(data['data']['product_name']);
            setPrivce(id);
        }
    );
}
function getOrderInfo(data){
    var order_number = $(data).val();
    var dict = {'order_number':order_number};
    $.post(
        '/flow-order/get-order-info',
        dict,
        function(data){
            $("#supplier").val(data['data']['product_suppliers']);
        }
    );
}
function setPrivce(id){
    var in_one_price = $("#in_one_price_"+id).val();
    var quantity = $("#quantity_"+id).val();
    var in_price = in_one_price * quantity;
    $("#in_price_"+id).val(in_price);
}
$("#supplier-down").on('click',function(){
    $("#supplier").val(document.getElementById('supplier-value').innerHTML);
});
function save(){
    var dict = getPostData();
    $.post(
        '/flow-in/save-bill',
        dict,
        function(data){
            if (data['success']) {
                window.location.href = data['redirect'];
            }
        }
    );
}
function preview(){
    var dict = getPostData();
    $.post(
        '/flow-in/preview-bill',
        dict,
        function(data){
            if (data['success']) {
                window.location.href = data['redirect'];
            }
        }
    );
}
function getPostData(){
    var inputs = $(".bill input");
    var dict = {};
    dict['inNumber'] = '<?=$data['orderNumber']?>';
    dict['supplier'] = $("#supplier").val();
    dict['orderNumber'] = $("#order_number").val();
    dict['inStore'] = $("#inStore").val();
    for (var i=0;i<inputs.length;i++){
        var bill_item = inputs[i];
        var bill_key = $(bill_item).attr('id');
        var bill_value = $(bill_item).val();
        dict[bill_key] = bill_value;
    }
    return dict;
}
</script>
