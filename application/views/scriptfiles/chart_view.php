<?php
defined("BASEPATH") OR exit("No direct script access allowed!");
?>

<script>
    //daily-income-report
    <?php
    $l = isset($cireport_l['a']) ? $cireport_l['a'] :array();
    $c = isset($cireport_c['a']) ? $cireport_c['a'] :array();
    ?>
    var citrace1 = {
      x: [<?php foreach($l as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
      y: [<?php foreach($l as $k=>$v){echo ucfirst($v).",";} ?>],
      type: 'bar',
      name: 'Lead',
      marker:{
        color: "dodgerblue"
      },
    };
    
    var citrace2 = {
      x: [<?php foreach($c as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
      y: [<?php foreach($c as $k=>$v){echo ucfirst($v).",";} ?>],
      type: 'bar',
      name: 'Client',
      marker:{
        color: "skyblue"
      },
    };
    if($("#daily-income-report").length){var cidata=[citrace1,citrace2],cilayout={barmode:"stack"};Plotly.newPlot("daily-income-report",cidata,cilayout)}
    //income source
    <?php 
    $is = isset($isource['s']) ? $isource['s'] : array();
    $iv = isset($isource['v']) ? $isource['v'] : array();
    ?>
    var idata = [{
      type: "pie",
      values: [<?php foreach($iv as $v){echo ($v).",";} ?>],
      labels: [<?php foreach($is as $s){echo "'".ucfirst($s)."',";} ?>],
      textinfo: "label+percent",
      textposition: "inside",
      automargin: false
    }]
    var ilayout={height:300,width:300,margin:{t:15,b:15,l:15,r:15},showlegend:!1};$("#income-source").length&&Plotly.newPlot("income-source",idata,ilayout);
</script>
<script>
<?php
$m = isset($revenue['m'])?$revenue['m']:array();
$a = isset($revenue['a'])?$revenue['a']:array();
?>

//revenue source
var rtrace = {
  x: [<?php foreach($m as $um){echo "'".ucfirst($um)."',";} ?>],
  y: [<?php foreach($a as $ua){echo ($ua).",";} ?>],
  mode: 'lines+markers',
  connectgaps: true
};

var rdata = [rtrace];

var rlayout = {
  title: 'Income Graph - <?=date("Y")?>',
  showlegend: false,
  fill: true
};
if($("#incomeGraph").length){
    Plotly.newPlot('incomeGraph', rdata, rlayout);
}
//irchart
<?php
$a = isset($ireport['a'])?$ireport['a']:array();
?>

var irtrace = {
  x: [<?php foreach($a as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($a as $k=>$v){echo ucfirst($v).",";} ?>],
  type: 'bar',
  name: 'Income Report',
  marker: {
    color: 'rgb(49,130,189)',
    opacity: 1,
  }
};

var irdata = [irtrace];

var irlayout = {
  title: '<?php echo isset($ireport['from']) ? $ireport['from']." - ".$ireport['to'] : date('Y')?> Income Report',
  xaxis: {
    tickangle: -45
  },
  barmode: 'group'
};
if($("#irchart").length){
    Plotly.newPlot('irchart', irdata, irlayout);
}

//client report
<?php
$ca = isset($creport['a'])?$creport['a']:array();
$cro = isset($cro)?$cro:array();
?>
var crtrace1 = {
  x: [<?php foreach($ca as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($ca as $k=>$v){echo ucfirst($v).",";} ?>],
  type: 'bar',
  name: 'No. of Clients',
  marker: {
    color: 'rgb(49,130,189)',
    opacity: 1,
  }
};

var crtrace2 = {
  x: [<?php foreach($ca as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($ca as $k=>$v){echo ucfirst($cro[$k]).",";} ?>],
  type: 'bar',
  name: 'Order Place',
  marker: {
    color: 'rgb(204,204,204)',
    opacity: 1
  }
};

var crdata = [crtrace1, crtrace2];

var crlayout = {
  title: '<?php echo isset($creport['from']) ? $creport['from']." - ".$creport['to'] : date('Y')?> Client Report',
  xaxis: {
    tickangle: -45
  },
  barmode: 'group'
};
if($("#crdiv").length){
    Plotly.newPlot('crdiv', crdata, crlayout);
}

//employee report chart
<?php
$d = isset($ereport['d']) ? $ereport['d']: array();
$w = isset($ereport['w']) ? $ereport['w']: array();
$m = isset($ereport['m']) ? $ereport['m']: array();
$y = isset($ereport['y']) ? $ereport['y']: array();

?>
var ertrace1 = {
  x: [<?php foreach($d as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($d as $k=>$v){echo ucfirst($v).",";} ?>],
  type: 'bar',
  name: 'Daily',
  marker: {
    color: 'rgb(49,130,189)',
    opacity: 1,
  }
};

var ertrace2 = {
  x: [<?php foreach($w as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($w as $k=>$v){echo ucfirst($v).",";} ?>],
  type: 'bar',
  name: 'Weekly',
  marker: {
    color: 'rgb(18, 179, 207)',
    opacity: 1
  }
};

var ertrace3 = {
  x: [<?php foreach($m as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($m as $k=>$v){echo ucfirst($v).",";} ?>],
  type: 'bar',
  name: 'Monthly',
  marker: {
    color: 'rgb(18, 207, 38)',
    opacity: 1
  }
};

var ertrace4 = {
  x: [<?php foreach($y as $k=>$v){echo "'".ucfirst($k)."',";} ?>],
  y: [<?php foreach($y as $k=>$v){echo ucfirst($v).",";} ?>],
  type: 'bar',
  name: 'Yearly',
  marker: {
    color: 'rgb(108, 107, 38)',
    opacity: 1
  }
};
var erdata=[ertrace1,ertrace2,ertrace3,ertrace4],erlayout={title:"Employee Report",xaxis:{tickangle:-50},barmode:"group"};$("#erchart").length&&Plotly.newPlot("erchart",erdata,erlayout);

//custom resource crsrcchart
<?php $resource = get_module_values('lead_source'); $traces = array();?>
<?php 
$m = array();
$m_2 = array();
if(isset($cresource) && !empty($cresource)){
    foreach($cresource as $kr=>$vr){
        array_push($m, $kr);
        array_push($m_2, '"'.$kr.'"');
    }
}
?>

<?php 
if(isset($resource) && !empty($resource)){
    $ii = 1;
    foreach($resource as $r){
        if(isset($_GET['resource']) && $_GET['resource']==base64_encode($r->lead_source_id)){
        $income = array();
        foreach($m as $_m){
            array_push($income, $cresource[$_m]['i'][$r->lead_source_name]);
        }
?>
    var crsrctrace<?=$ii?> = {
      x: [<?=implode(",",$m_2)?>],
      y: [<?=implode(",",$income)?>],
      type: 'bar',
      name: '<?=$r->lead_source_name?>',
      marker: {
        color: 'rgb(<?=implode(",",getColor($ii))?>)',
        opacity: 1,
      }
    };
<?php
    }else if(isset($_GET['resource']) && $_GET['resource']=='' || !isset($_GET['resource'])){
        $income = array();
        foreach($m as $_m){
            array_push($income, $cresource[$_m]['i'][$r->lead_source_name]);
        }
        ?>
    var crsrctrace<?=$ii?> = {
        x: [<?=implode(",",$m_2)?>],
        y: [<?=implode(",",$income)?>],
        type: 'bar',
        name: '<?=$r->lead_source_name?>',
        marker: {
        color: 'rgb(<?=implode(",",getColor($ii))?>)',
        opacity: 1,
        }
    };
        <?php
    }
$ii++;
    }
}
?>
var crsrcdata = [<?php $k=1; foreach($resource as $r){ 
    if(isset($_GET['resource']) && $_GET['resource']==base64_encode($r->lead_source_id)){
        echo 'crsrctrace'.$k.",";
    }else if(isset($_GET['resource']) && $_GET['resource']=='' || !isset($_GET['resource'])){
        echo 'crsrctrace'.$k.",";
    }
    $k++;
}?>];

var crsrclayout={title:"Client Resource Report",xaxis:{tickangle:-45},barmode:"group"};$("#crsrcchart").length&&Plotly.newPlot("crsrcchart",crsrcdata,crsrclayout);
</script>