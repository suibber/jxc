<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOrder */

$this->title = '销售录入';
$this->params['breadcrumbs'][] = ['label' => 'Flow Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-order-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="ui grid">
      <form class="ui form">
        <div class="inline fields">
            <div class="four wide column">销售单号：</div>
            <div class="twelve wide column">
                <input name="first-name" placeholder="" type="text" value="<?=$data['orderNumber']?>">
            </div>
        </div>
        <div class="inline fields">
            <div class="twelve wide column">
                <div class="inline fields">
                    <div class="field">客户：</div>
                    <div class="field">
                        <input id="supplier" onchange="setCustom(this)" size="40" placeholder="" type="text" value="">
                    </div>
                    <div class="field">
                        <div class="ui dropdown" id="supplier-down">
                          <i class="filter icon"></i>
                          <span class="text" id="supplier-value">筛选客户</span>
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
                        销售：<input id="customer" size="40" placeholder="" type="text" value="">
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
      <th>产品名称</th>
      <th>数量</th>
      <th>进货单价</th>
      <th>进货金额</th>
      <th>销售单价</th>
      <th>销售金额</th>
      <th>备注</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bill">
        <td><input type="text" id="bill_number_1" class="bill_number" value="1" placeholder=""></td>
        <td><input type="text" id="model_1" onchange="setModel(this,1)" placeholder=""></td>
        <td><input type="text" id="product_name_1" placeholder=""></td>
        <td><input type="text" id="quantity_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="in_one_price_1" onblur="setPrivce(1)" placeholder=""></td>
        <td><input type="text" id="in_price_1" placeholder=""></td>
        <td><input type="text" id="sale_one_price_1" onchange="setModel(this,1)" placeholder=""></td>
        <td><input type="text" id="sale_price_1" placeholder=""></td>
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
    var html = '<tr class="bill"><td><input type="text" id="bill_number_'+id+'" class="bill_number" value="'+id+'" placeholder=""></td><td><input type="text" id="model_'+id+'" onchange="setModel(this,'+id+')" placeholder=""></td><td><input type="text" id="product_name_'+id+'" placeholder=""></td><td><input type="text" id="quantity_'+id+'" onblur="setPrivce('+id+')" placeholder=""></td><td><input type="text" id="in_one_price_'+id+'" onblur="setPrivce('+id+')" placeholder=""></td><td><input type="text" id="in_price_'+id+'" placeholder=""></td><td><input type="text" id="sale_one_price_'+id+'" onchange="setModel(this,'+id+')" placeholder=""></td><td><input type="text" id="sale_price_'+id+'" placeholder=""></td><td><input type="text" id="comment_'+id+'" placeholder=""></td></tr>';
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
        var model = $("#model_"+id).val();
    }
    var lot_number = $("#lot_number_"+id).val();
    var dict = {'lot_number':lot_number,'model':model};
    $.post(
        '/product/get-product-info',
        dict,
        function(data){
            $("#product_name_"+id).val(data['name']);
            $("#in_one_price_"+id).val(data['price']);
            setPrivce(id);
        }
    );
    setSale(id);
}
function setSale(id){
    var model = $("#model_"+id).val();
    var receiver = $("#supplier").val();
    var dict = {'model':model,'receiver':receiver}
    $.post(
        '/sale-price/get-sale-info-by-model-receiver',
        dict,
        function(data){
            $("#sale_one_price_"+id).val(data['data']['price']);
            setSalePrivce(id);
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
    setSalePrivce(id)
}
function setSalePrivce(id){
    var sale_one_price = $("#sale_one_price_"+id).val();
    var quantity = $("#quantity_"+id).val();
    var sale_price = sale_one_price * quantity;
    $("#sale_price_"+id).val(sale_price);
}
$("#supplier-down").on('click',function(){
    var company = document.getElementById('supplier-value').innerHTML;
    $("#supplier").val(company);
    setCustom('',company);
});
function save(){
    var dict = getPostData();
    $.post(
        '/flow-sale/save-bill',
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
        '/flow-sale/preview-bill',
        dict,
        function(data){
            if (data['success']) {
                window.open(data['redirect']);
            }
        }
    );
}
function getPostData(){
    var inputs = $(".bill input");
    var dict = {};
    dict['saleNumber'] = '<?=$data['orderNumber']?>';
    dict['custom'] = $("#supplier").val();
    dict['salesman'] = $("#customer").val();
    for (var i=0;i<inputs.length;i++){
        var bill_item = inputs[i];
        var bill_key = $(bill_item).attr('id');
        var bill_value = $(bill_item).val();
        dict[bill_key] = bill_value;
    }
    return dict;
}
function setCustom(data,company){
    if (!company) { 
        var company = $(data).val();
    }
    var dict = {'company':company};
    $.post(
        '/customer/get-customer-info-by-company',
        dict,
        function(data){
            $("#customer").val(data['data']['man']);
        }
    );
}
</script>
