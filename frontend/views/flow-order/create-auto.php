<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOrder */

$this->title = '订单录入';
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
                <input name="first-name" placeholder="" type="text" value="<?=$data['orderNumber']?>">
            </div>
        </div>
        <div class="inline fields">
            <div class="four wide column">供应商：</div>
            <div class="twelve wide column">
                <div class="inline fields">
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
                </div>
            </div>
        </div>
        <div class="inline fields ">

<table class="ui celled table">
  <thead>
    <tr>
      <th>单据序号</th>
      <th>产品型号</th>
      <th>数量</th>
      <th>折扣(75代表75%)</th>
      <th>产品名称</th>
      <th>标准单价</th>
      <th>折扣单价</th>
      <th>订货金额</th>
      <th>备注</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bill">
        <td><input type="text" id="bill_number_1" class="bill_number" value="1" placeholder=""></td>
        <td><input type="text" id="model_1" onblur="setModel(this,1)" placeholder=""></td>
        <td><input type="text" id="quantity_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="discount_1" onblur="setPrivce(1)" placeholder="" value="100"></td>
        <td><input type="text" id="product_name_1" placeholder=""></td>
        <td><input type="text" id="product_price_1" placeholder=""></td>
        <td><input type="text" id="discount_price_1" placeholder=""></td>
        <td><input type="text" id="order_price_1" placeholder=""></td>
        <td><input type="text" id="comment_1" placeholder=""></td>
    </tr>
    <tr id="default-bill"></tr>
  </tbody>
  <tfoot class="full-width">
    <tr>
      <th colspan="9">
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
    var html = '<tr class="bill"><td><input type="text" id="bill_number_'+id+'" class="bill_number" value="'+id+'" placeholder=""></td><td><input type="text" id="model_'+id+'" onblur="setModel(this,'+id+')" placeholder=""></td><td><input type="text" id="quantity_'+id+'" onblur="setPrivce('+id+')" placeholder=""></td><td><input type="text" id="discount_'+id+'" onblur="setPrivce('+id+')" placeholder="" value="100"></td><td><input type="text" id="product_name_'+id+'" placeholder=""></td><td><input type="text" id="product_price_'+id+'" placeholder=""></td><td><input type="text" id="discount_price_'+id+'" placeholder=""></td><td><input type="text" id="order_price_'+id+'" placeholder=""></td><td><input type="text" id="comment_'+id+'" placeholder=""></td></tr>';
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
            if (!$("#supplier").val()) {
                $("#supplier").val(data['suppliers']);
            }
        }
    );
}
function setPrivce(id){
    var quantity = $("#quantity_"+id).val();
    var discount = $("#discount_"+id).val();
    var product_price = $("#product_price_"+id).val();
    if (quantity && discount && product_price) {
        discount_price = product_price * (discount/100);
        discount_price = Math.round(discount_price*100)/100;
        order_price = discount_price * quantity;        
        $("#discount_price_"+id).val(discount_price);
        $("#order_price_"+id).val(order_price);
    }
}
$("#supplier-down").on('click',function(){
    $("#supplier").val(document.getElementById('supplier-value').innerHTML);
});
function save(){
    var dict = getPostData();
    $.post(
        '/flow-order/save-bill',
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
        '/flow-order/preview-bill',
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
    dict['orderNumber'] = '<?=$data['orderNumber']?>';
    dict['supplier'] = $("#supplier").val();
    for (var i=0;i<inputs.length;i++){
        var bill_item = inputs[i];
        var bill_key = $(bill_item).attr('id');
        var bill_value = $(bill_item).val();
        dict[bill_key] = bill_value;
    }
    return dict;
}
</script>
