<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FlowOrder */

$this->title = 'Create Flow Order';
$this->params['breadcrumbs'][] = ['label' => 'Flow Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-order-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="ui grid">
      <form class="ui form">
        <div class="inline fields">
            <div class="four wide column">订单号：</div>
            <div class="twelve wide column">
                <input name="first-name" placeholder="First Name" type="text" value="<?=$data['orderNumber']?>">
            </div>
        </div>
        <div class="inline fields">
            <div class="four wide column">供应商：</div>
            <div class="twelve wide column">
                <div class="field">
                    <select class="ui fluid dropdown">
                        <?php foreach ($data['supplierList'] as $supplier) { ?>
                            <option value=""><?=$supplier?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="inline fields ">

<table class="ui celled table">
  <thead>
    <tr>
      <th>单据序号</th>
      <th>产品型号</th>
      <th>数量(正整数)</th>
      <th>折扣(75代表75%)</th>
      <th>产品名称</th>
      <th>标准单价</th>
      <th>折扣单价</th>
      <th>订货金额</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <td><input type="text" id="bill_number_1" class="bill_number" value="1" placeholder=""></td>
        <td><input type="text" id="model_1" onblur="setModel(this,1)" placeholder=""></td>
        <td><input type="text" id="quantity_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="discount_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="product_name_1" placeholder=""></td>
        <td><input type="text" id="product_price_1" placeholder=""></td>
        <td><input type="text" id="discount_price_1" placeholder=""></td>
        <td><input type="text" id="order_price_1" placeholder=""></td>
    </tr>
    <tr id="default-bill"></tr>
  </tbody>
  <tfoot class="full-width">
    <tr>
      <th colspan="8">
        <div class="ui right floated small primary button"><i class="send outline icon"></i>预览</div>
        <div class="ui right floated small orange button"><i class="checkmark icon"></i>保存</div>
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
    var html = '<tr><td><input type="text" id="bill_number_'+id+'" class="bill_number" value="'+id+'" placeholder=""></td><td><input type="text" id="model_'+id+'" onblur="setModel(this,'+id+')" placeholder=""></td><td><input type="text" id="quantity_'+id+'" placeholder=""></td><td><input type="text" id="discount_'+id+'" placeholder=""></td><td><input type="text" id="product_name_'+id+'" placeholder=""></td><td><input type="text" id="product_price_'+id+'" placeholder=""></td><td><input type="text" id="discount_price_'+id+'" placeholder=""></td><td><input type="text" id="order_price_'+id+'" placeholder=""></td></tr>';
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
function setModel(data,id){
    var model = $(data).val();
    var dict = {'model':model};
    $.post(
        '/product/get-product-info',
        dict,
        function(data){
            $("#product_name_"+id).val(data['name']);
            $("#product_price_"+id).val(data['price']);
        }
    );
}
function setPrivce(id){
    var quantity = $("#quantity_"+id).val();
    var discount = $("#discount_"+id).val();
    var product_price = $("#product_price_"+id).val();
    if (quantity && discount && product_price) {
        discount_price = product_price * (discount/100);
        order_price = discount_price * quantity;        
        $("#discount_price_"+id).val(discount_price);
        $("#order_price_"+id).val(order_price);
    }
}
</script>
