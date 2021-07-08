<?php

$request_options = array(
  'http' => array(
  'method' => 'GET',
  'header'=> "Authorization: Bearer ff7c37dfca55a9604e18b90841172a07e8af363463132a67d7e232e1193e30d7 \r\n"
  )
);

$context = stream_context_create($request_options);
$url = 'https://api.shop-pro.jp/v1/categories.json'; 
$response_body = file_get_contents($url, false, $context);
$response_body = json_decode($response_body, true);
$count = count($response_body["categories"]);
$selected = $_GET['big_categories'];
$selected  = json_decode($selected, true);
var_dump($selected);
$s_selected = $_GET['small_categories'];
$s_selected  = json_decode($s_selected, true);
echo $selected["big_id"] ;
echo '<br>'.$s_selected["s_id"] ;

if(is_null($selected["big_id"])){
echo '<form>大カテゴリ：<select name="big_categories" onchange="this.form.submit()"><option value="" selected>------選択してください------</option>';
}else{
echo '<form>大カテゴリ：<select name="big_categories" onchange="this.form.submit()"><option value="">------選択してください------</option>';
}


for($i=0;$i<$count;$i++){
	if($i == $selected["ids"]&&$selected["big_id"] > 1){
echo '<option value={"ids":'.$i.',"big_id":'.$response_body["categories"][$i]["id_big"].'} selected >'.$response_body["categories"][$i]["name"].'</option>';
countinue;
}else{
echo '<option value={"ids":'.$i.',"big_id":'.$response_body["categories"][$i]["id_big"].'} >'.$response_body["categories"][$i]["name"].'</option>';
}
}
echo '</select>';

echo '<span id="selected_cate"></span>';
echo '<br>ああああ';


if(isset($response_body["categories"][$selected["ids"]]["children"][0])){
$counts = count($response_body["categories"][$selected["ids"]]["children"]);
echo '<br>'.$counts;
echo '小カテゴリ：<select id="small_categories" name="small_categories" onchange="this.form.submit()"><option value="">------選択してください------</option>';

for($i2=0;$i2<$counts;$i2++){
$s_id = $response_body["categories"][$selected["ids"]]["children"][$i2]["id_small"];
	if($i2 == $s_selected["s_ids"]){
echo '<option value={"s_ids":'.$i2.',"s_id":'.$s_id.'}  selected >'.$response_body["categories"][$selected["ids"]]["children"][$i2]["name"].'</option>';
}else{
echo '<option value={"s_ids":'.$i2.',"s_id":'.$s_id.'} >'.$response_body["categories"][$selected["ids"]]["children"][$i2]["name"].'</option>';
}
}
echo '</select></form>';
}
else{
echo $selected["ids"];
echo $s_id;
var_dump(isset($response_body["categories"][$selected]["children"][0]));
}


$context = stream_context_create($request_options);
$url = 'https://api.shop-pro.jp/v1/products.json?limit=50'.'&category_id_big='.$selected["big_id"].'&category_id_small='.$s_selected["s_id"]; 
$response_body = file_get_contents($url, false, $context);
$response_body = json_decode($response_body, true);
$count = $response_body["meta"]["total"];

// var_dump($response_body);

echo '<table width=1000 border=1px>';


for($i=0;$i<$count;$i++){
$ii = $i+1;

	if($i%4==0){
echo '<tr><td>'.'商品ナンバー'.$ii.'<br>';
echo '商品：'.$response_body["products"][$i]["name"].'<br>';
echo '価格：'.$response_body["products"][$i]["sales_price_including_tax"].'円（税込み）<br>';
echo '商品説明'.$response_body["products"][$i]["expl"].'<br><br></td>';

}elseif($ii%4==0){
echo '<td>'.'商品ナンバー'.$ii.'<br>';
echo '商品：'.$response_body["products"][$i]["name"].'<br>';
echo '価格：'.$response_body["products"][$i]["sales_price_including_tax"].'円（税込み）<br>';
echo '商品説明'.$response_body["products"][$i]["expl"].'<br><br></td></tr>';

}else{
echo '<td>'.'商品ナンバー'.$ii.'<br>';
echo '商品：'.$response_body["products"][$i]["name"].'<br>';
echo '価格：'.$response_body["products"][$i]["sales_price_including_tax"].'円（税込み）<br>';
echo '商品説明'.$response_body["products"][$i]["expl"].'<br><br></td>';
}
}
echo '</table><br>"小カテゴリを選択した際に小カテゴリのIDを取得する方法をスマートに考える"';