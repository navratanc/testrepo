<?
/*
•Opera (Browser::BROWSER_OPERA)
 •WebTV (Browser::BROWSER_WEBTV)
 •NetPositive (Browser::BROWSER_NETPOSITIVE)
 •Internet Explorer (Browser::BROWSER_IE)
 •Pocket Internet Explorer (Browser::BROWSER_POCKET_IE)
 •Galeon (Browser::BROWSER_GALEON)
 •Konqueror (Browser::BROWSER_KONQUEROR)
 •iCab (Browser::BROWSER_ICAB)
 •OmniWeb (Browser::BROWSER_OMNIWEB)
 •Phoenix (Browser::BROWSER_PHOENIX)
 •Firebird (Browser::BROWSER_FIREBIRD)
 •Firefox (Browser::BROWSER_FIREFOX)
 •Mozilla (Browser::BROWSER_MOZILLA)
 •Amaya (Browser::BROWSER_AMAYA)
 •Lynx (Browser::BROWSER_LYNX)
 •Safari (Browser::BROWSER_SAFARI)
 •iPhone (Browser::BROWSER_IPHONE)
 •iPod (Browser::BROWSER_IPOD)
 •Google’s Android(Browser::BROWSER_ANDROID)
 •Google’s Chrome(Browser::BROWSER_CHROME)
 •GoogleBot(Browser::BROWSER_GOOGLEBOT)
 •Yahoo!’s Slurp(Browser::BROWSER_SLURP)
 •W3C’s Validator(Browser::BROWSER_W3CVALIDATOR)
 •BlackBerry(Browser::BROWSER_BLACKBERRY)

*/


header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter("must-revalidate");

require_once('tool_setup.php');

$browser = $_SERVER['HTTP_USER_AGENT'];

$query="select * from m0000errormessage where lang_code='$defaultlang'";
$result = mysql_query($query);
$i = 0;
while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
    $errMessage[$row['id']] = $row['description'];
}

$divtags = "<tr><td>";
$query = "select * from m0008toolconfig A,m0008toolsetup B where A.field_id=B.field_id and A.step_id=B.step_id and lang_code='$defaultlang' order by A.field_id ";
$result = mysql_query($query);
$num=mysql_numrows($result);
$i=0;
while ($i < $num)
{
  $field_id = mysql_result($result,$i,"field_id");
  $is_tooltip = mysql_result($result,$i,"is_tooltip");
  $field_caption[$field_id] = mysql_result($result,$i,"field_caption");
  $field_errmsg[$field_id] = mysql_result($result,$i,"field_errmsg");
  $field_tt_heading[$field_id] = mysql_result($result,$i,"field_tt_heading");
  $field_tt_desc[$field_id] = mysql_result($result,$i,"field_tt_desc");
  $field_tt_image[$field_id] = mysql_result($result,$i,"field_tt_image");
  if($is_tooltip == 1)
  {
    $divtags .= "
    <div id='tt_".$field_id."' class=tip>
         <div style='padding: 15px; width: 310px; text-align:left;'> ";
         if(isset($field_tt_image[$field_id]) && $field_tt_image[$field_id] !== "") {
            $divtags .= "<img src=\"../fabmin//cmsimages/tooltips/".$field_tt_image[$field_id]."\" alt=\"Tool Tip\" />
            <br><br>";
         }
         $divtags .= "<div style='margin-bottom: 10px; font-weight:bold; font-size:15px; color: #333333;'>".$field_tt_heading[$field_id]."</div>
            ".$field_tt_desc[$field_id]."
         </div>
    </div>";
  }

  $i++;
}
$divtags .= "</td></tr>";

$pagetitle = $field_caption[307];
$meta_keywords = $field_caption[308];
$meta_description = $field_caption[309];
$strToolStepId = 3;
include("toolheader.php");

echo $divtags;

$query = "select * from m0012websitecommontext where lang_code='$defaultlang'";
$result = mysql_query($query);
$num=mysql_numrows($result);
$i=0;
while ($i < $num)
{
  $gotoconfigurationtext = mysql_result($result,$i,"gotoconfigurationtext");
  $nextbuttontext = mysql_result($result,$i,"nextbuttontext");
  $backbuttontext = mysql_result($result,$i,"backbuttontext");
  $checkouttext = mysql_result($result,$i,"checkouttext");
  $saveconfigurationtext = mysql_result($result,$i,"saveconfigurationtext");
  $logontext = mysql_result($result,$i,"logontext");
  $registertext = mysql_result($result,$i,"registertext");
  $withoutregistertext = mysql_result($result,$i,"withoutregistertext");
  $ordertext = mysql_result($result,$i,"ordertext");
  $i++;
}

// Default Data
$currencycode = "EUR";
$exchangerate = 1;
$currencysymbol = "€";
$query = "select * from m0001lang A,m0000currencyexchange B,m0000currency C
       where A.currency_code = B.currency_code
         and A.currency_code = C.currency_code
         and A.lang_code='$defaultlang'";
$result = mysql_query($query);
$num=mysql_numrows($result);
$i=0;
while ($i < $num)
{
  $currencycode = mysql_result($result,$i,"currency_code");
  $exchangerate = mysql_result($result,$i,"exchange_rate");
  $currencysymbol = mysql_result($result,$i,"currency_symbol");

  $i++;
}

$step1_heading = $field_caption[1];
$step2_heading = $field_caption[6];


$query = "select * from m0060toolpagesconfiguration where lang_code='$defaultlang' and page_type_id = 4 ";
$result = mysql_query($query);
$num=mysql_numrows($result);
$i=0;
while ($i < $num)
{
    $toolnextpageurl = mysql_result($result,$i,"page_url");
	$i++;
}

$query = "select * from m0060toolpagesconfiguration where lang_code='$defaultlang' and page_type_id = 2 ";
$result = mysql_query($query);
$num=mysql_numrows($result);
$i=0;
while ($i < $num)
{
    $toolprevpageurl = mysql_result($result,$i,"page_url");
	$i++;
}

$query = "select * from m0060toolpagesconfiguration where lang_code='$defaultlang' and page_type_id = 1 ";
$result = mysql_query($query);
$num=mysql_numrows($result);
$i=0;
while ($i < $num)
{
    $toolstep1pageurl = mysql_result($result,$i,"page_url");
	$i++;
}


?>

<script type="text/JavaScript">
var designwidth = <?=$width?>;
var actualdesignwidth = <?=$actualwidth?>;
var totalcol= <?=$noofcolumn?>;
var maxcols = <?=$maxcolumns?>;
var mincols = <?=$mincolumns?>;
var eachtdwidth = <?=$tdwidth?>;
var eachtdheight = <?=$tdheight?>;
var designheight = <?=$height?>;
var actualdesignheight = <?=$actualheight?>;
var woodprice = <?=$price?>;
var mincol_dist = <?=$min_wall_distance?>;
var maxcol_dist = <?=$max_wall_distance?>;
var minrow_dist = <?=$min_board_distance?>;
var maxrow_dist = <?=$max_board_distance?>;
</script>
<?include("tooltips.php");?>

<form action="step4_1.php" method="post" name="theForm">
<input type=hidden name=hdnheight id=hdnheight value="<?=$actualheight?>">
<input type=hidden name=hdnwidth id=hdnwidth value="<?=$actualwidth?>">

<input type=hidden name=mainheight value="<?=$actualheight?>">
<input type=hidden name=mainwidth value="<?=$actualwidth?>">
<input type=hidden name=txtwoodcolorandtype value="<?=$woodcolorandtype?>">
<input type=hidden name=regemailadd>
<input type=hidden name=txtwoodtypeindex id=txtwoodtypeindex>
<input type=hidden name=txtthicknessindex id=txtthicknessindex>
<input type=hidden name=txtcurrencycode id=txtcurrencycode value="<?=$currencycode?>">
<input type=hidden name=txtexchangerate id=txtexchangerate value="<?=$exchangerate?>">
<input type=hidden name=txtcurrencysymbol id=txtcurrencysymbol value="<?=$currencysymbol?>">
<input type=hidden name=txtcurrencysymbolpositionind id=txtcurrencysymbolpositionind value="<?=$currency_symbol_position_ind?>">

<input type=hidden name=editURL value="step3_modify.php">
    <tr height="2">
         <td >
                 <div id="boxes">
                         <div id="dialog3" class="window" style="width:600px;height:250px;">
                              <a class="close" id=popup_close></a>
							  <div style="float:left; margin: 0px 0 0px 0;">
								  <table width="590" border="0" cellspacing="0" cellpadding="0">
									 <tr height="80px" valign="top">
									   <td colspan=2 class="pop_header"><?=$field_caption[167]?></td>
									 </tr>
									 <tr>
									   <td colspan="2" class="pop_content"><?=$field_caption[65]?></td>
									 </tr>
									 <tr><td colspan="2"><br /></td></tr>
									 <tr>
									   <td class="pop_form">
									   <input onfocus="fn_select();" onblur="fn_blur();" id="txtsaveemailadd" name="txtsaveemailadd" value="<?=$field_caption[66]?>" class="pop_email" type="text" />
									 </td>
									 <td class="pop_next">
										 <div style='float:left;width:30px;'><img src="../fabimages/buttons/weiter_button_30x30.png" border=0></div>
										 <div id="sectionlink" style='float:right;width:120px;text-align:left;padding-top:4px;'><a href="javascript:fn_savedesign()"><?=$field_caption[168]?></a></div>
									 </td>
									 </tr>
									 <tr><td colspan="2"><br /></td></tr>
								   </table>
							   </div>

                         </div>
						 <div id="dialog4" class="window" style="padding-left:0px;height:460px;width:320px;padding-right:10px;">
							  <a class="close" id=popup_close></a>
							  <div style="float:left; margin: 0px 0 0px 0;padding-left:10px;width:300px;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2">
										<div id='divspecialrequestinfo'><?=$specialrequest_step3?></div>
									</td>
								</tr>
								</table>
							  </div>
						</div>
                        <div id="mask"></div>
                    </div>

         </td>
    </tr>
	<tr><td>
	 <div class='shelf_tool_top_navigation' style='background-color:#FFFFFF;height:40px;border: 1px solid #D4D4D4;'>
		<div class='shelf_tool_top_navigation_text' style='float:left;padding-left:10px;'><a href="javascript:fn_prevStep1()"><?=$field_caption[1]?></a></div>
		<div class='shelf_tool_top_navigation_text' style='float:left;padding-top:12px;padding-left:15px;padding-right:15px;'><img src='../fabimages/right_arrow.png' border=0></div>
	    <div class='shelf_tool_top_navigation_text' style='float:left;'><a href="javascript:fn_prevStep2()"><?=$field_caption[6]?></a></div>
		<div class='shelf_tool_top_navigation_text' style='float:left;padding-top:12px;padding-left:15px;padding-right:15px;'><img src='../fabimages/right_arrow.png' border=0></div>
	    <div class='shelf_tool_top_navigation_text_active' style='float:left;'><?=$field_caption[10]?></div>
		<div class='shelf_tool_top_navigation_text' style='float:left;padding-top:12px;padding-left:15px;padding-right:15px;'><img src='../fabimages/right_arrow.png' border=0></div>
	    <div class='shelf_tool_top_navigation_text' style='float:left;'><?=$field_caption[31]?></div>
	 </div>
	</td></tr>
    <tr><td><div id=diverrmessage class="message" style="display:none;"></div></td></tr>
    <tr><td>
        <div class="coulmn_container">
		<div class="shelf_tool_section" style='border: 1px solid #D4D4D4;'>
		<div style='width:960px;margin-top:10px;margin-left:10px;margin-right:20px;margin-bottom:10px;float:left;'>
			<!--
			<div style='float:left;width:50px;'>
			   <a class='ui-corner-all' href='javascript:fn_openVideo()'><img src='../fabimages/video_icon.png' border=0 ></a> &nbsp;
            </div>
				<div style='float:left;width:350px;padding-top:7px;'>
			   <span class='shelf_tool_video_text'><?=$field_caption[288]?></span>
            </div>
			-->
			<div style='float:right;margin-top:5px;margin-right:20px;'>
				  <span class='ui-style-video-button-disable'><a class='ui-corner-all' href="#dialog4" name="modal2"><?=$field_caption[289]?></a></span> &nbsp;&nbsp;
                  <span class='ui-style-button'><a class='ui-corner-all' href='javascript:fn_nextStep()'><?=$nextbuttontext?></a></span>
            </div>
        </div>
		<div style="width: 210px; float: left;padding-left:10px;">
           <div class="page3_right" style="margin-top: 0;">
              <div class="subheading"><?=$field_caption[11]?></div>
              <br /><br />
              <?=$field_caption[19]?> <?=$actualwidth?>x<?=$actualheight?>cm
              <br /><br />
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="85"><?=$field_caption[20]?></td>
                  <td width="80">
                    <select name="hdnthick" id="hdnthick" style="width:80px;" onchange="changeThickness('L')"  >
                    <?
                    for($i=0;$i<count($arrThickness);$i++)
                    {
						/*
                        $query2 = "select * from m0005woodthickness where thickness=$arrThickness[$i] and lang_code='$defaultlang'";
                        $result2 = mysql_query($query2);
                        $num2=mysql_numrows($result2);
                        $k=0;
                        while ($k < $num2)
                        {
                          $thickness_id = mysql_result($result2,$k,"thickness");
                          $wood_thickness_desc = mysql_result($result2,$k,"thickness_desc");
                          if($thickness_id == "32")
                             $wood_thickness_desc = "3cm/2cm";
                          $k++;
                        }
						*/
						$arrThicknessDesc  = explode("/",$field_caption[291]);
						$wood_thickness_desc = $arrThicknessDesc[$i];
                        if($arrThickness[$i] ==$thickness)
                          echo "<option value=".$arrThickness[$i]." selected>".$wood_thickness_desc."</option>";
                        else
                          echo "<option value=".$arrThickness[$i].">".$wood_thickness_desc."</option>";
                    }
                    ?>
                    </select>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td><?=$field_caption[21]?></td>
                  <td>
                    <select name="hdndepth" id="hdndepth" style="width:80px; " onchange="changeDepth()" >
                    <?
                    for($iRow=0;$iRow<count($arrDepth);$iRow++)
                    {
                        $depthSize = $arrDepth[$iRow];
                        $arrDepthSec = explode("-",$depthSize);
                        if(Count($arrDepthSec) > 1)
                        {
                          for($start=$arrDepthSec[0];$start<=$arrDepthSec[1];$start++)
                          {
                              if($start <=$max_depth)
                              {
                                  if($start ==$depth)
                                     echo "<option value=".$start." selected>".$start." cm</option>";
                                  else
                                     echo "<option value=".$start.">".$start." cm</option>";
                              }
                          }
                        }
                        else
                        {
                            if($depthSize <=$max_depth)
                            {
                                if($depthSize ==$depth)
                                   echo "<option value=".$depthSize." selected>".$depthSize." cm</option>";
                                else
                                   echo "<option value=".$depthSize.">".$depthSize." cm</option>";
                            }
                        }
                    }

                    ?>
                    </select>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <?
                for($i=0;$i<count($arr_wood_type_price);$i++)
                {
                   echo "<input type=hidden name=txtwallthickness".$i." id=txtwallthickness".$i." value='".$arr_wall_thickness[$i]."'>";
                   echo "<input type=hidden name=txtboardthickness".$i." id=txtboardthickness".$i." value='".$arr_board_thickness[$i]."'>";
                   echo "<input type=hidden name=txtwoodprice".$i." id=txtwoodprice".$i." value='".$arr_wood_type_price[$i]."'>";
                   echo "<input type=hidden name=txtwoodfixprice".$i." id=txtwoodfixprice".$i." value='".$arr_fix_price[$i]."'>";
                   echo "<input type=hidden name=txtdoorprice".$i." id=txtdoorprice".$i." value='".$arr_door_price[$i]."'>";
                   echo "<input type=hidden name=txtdoorfixprice".$i." id=txtdoorfixprice".$i." value='".$arr_door_fix_price[$i]."'>";
                   echo "<input type=hidden name=txtbwprice".$i." id=txtbwprice".$i." value='".$arr_bw_price[$i]."'>";
                   echo "<input type=hidden name=txtbwfixprice".$i." id=txtbwfixprice".$i." value='".$arr_bw_fix_price[$i]."'>";
                   echo "<input type=hidden name=txtfixwallprice".$i." id=txtfixwallprice".$i." value='".$arr_fix_wall_price[$i]."'>";
                   echo "<input type=hidden name=txtfixboardprice".$i." id=txtfixboardprice".$i." value='".$arr_fix_board_price[$i]."'>";
                   echo "<input type=hidden name=txtfixaddholeprice".$i." id=txtfixaddholeprice".$i." value='".$arr_fix_add_hole_price[$i]."'>";
                   echo "<input type=hidden name=txtfixsocklecutprice".$i." id=txtfixsocklecutprice".$i." value='".$arr_fix_sockle_cut_price[$i]."'>";
                   echo "<input type=hidden name=txtoneboardontopprice".$i." id=txtoneboardontopprice".$i." value='".$arr_one_board_ontop_price[$i]."'>";

                   echo "<input type=hidden name=txtprodwallthickness".$i." id=txtprodwallthickness".$i." value='".$arr_prod_wall_thickness[$i]."'>";
                   echo "<input type=hidden name=txtprodboardthickness".$i." id=txtprodboardthickness".$i." value='".$arr_prod_board_thickness[$i]."'>";
                   echo "<input type=hidden name=txtprodwoodprice".$i." id=txtprodwoodprice".$i." value='".$arr_prod_wood_type_price[$i]."'>";
                   echo "<input type=hidden name=txtprodwoodfixprice".$i." id=txtprodwoodfixprice".$i." value='".$arr_prod_fix_price[$i]."'>";
                   echo "<input type=hidden name=txtproddoorprice".$i." id=txtproddoorprice".$i." value='".$arr_prod_door_price[$i]."'>";
                   echo "<input type=hidden name=txtproddoorfixprice".$i." id=txtproddoorfixprice".$i." value='".$arr_prod_door_fix_price[$i]."'>";
                   echo "<input type=hidden name=txtprodbwprice".$i." id=txtprodbwprice".$i." value='".$arr_prod_bw_price[$i]."'>";
                   echo "<input type=hidden name=txtprodbwfixprice".$i." id=txtprodbwfixprice".$i." value='".$arr_prod_bw_fix_price[$i]."'>";
                   echo "<input type=hidden name=txtprodfixwallprice".$i." id=txtprodfixwallprice".$i." value='".$arr_prod_fix_wall_price[$i]."'>";
                   echo "<input type=hidden name=txtprodfixboardprice".$i." id=txtprodfixboardprice".$i." value='".$arr_prod_fix_board_price[$i]."'>";

                   for($j=0;$j<count($arr_wood_type_thickness_volume_from[$i]);$j++)
                   {
                     echo "<input type=hidden name='txtwoodprice_volumefrom".$i."_".$j."' id='txtwoodprice_volumefrom".$i."_".$j."' value='".$arr_wood_type_thickness_volume_from[$i][$j]."'>";
                     echo "<input type=hidden name='txtwoodprice_volumeto".$i."_".$j."' id='txtwoodprice_volumeto".$i."_".$j."' value='".$arr_wood_type_thickness_volume_to[$i][$j]."'>";
                     echo "<input type=hidden name='txtwoodthickness_price".$i."_".$j."' id='txtwoodthickness_price".$i."_".$j."' value='".$arr_wood_type_thickness_price[$i][$j]."'>";
                   }
                }
                ?>
                <tr>
                  <td><?=$field_caption[22]?></td>
                  <td>
                    <select name="hdnwoodtype" id="hdnwoodtype" style="width:80px;" onchange="changeWoodType()"  >
                    <?
                    $query1 = "select * from m0003woodtype where lang_code='$defaultlang' order by wood_type_id ";
                    $result1 = mysql_query($query1);
                    $num1=mysql_numrows($result1);
                    $j = 0;
                    while ($j < $num1)
                    {
                      $wood_type_id = mysql_result($result1,$j,"wood_type_id");
                      $wood_type_name = mysql_result($result1,$j,"wood_type_name");
                      if($wood_type_id == $woodtype)
                        echo "<option value=".$wood_type_id." selected>".$wood_type_name."</option>";
                      else
                        echo "<option value=".$wood_type_id.">".$wood_type_name."</option>";
                      $j++;
                    }
                    ?>
                    </select>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td><?=$field_caption[23]?></td>
                  <td>
                  <select name="hdnwoodcolor" id="hdnwoodcolor" style="width:80px;" onchange="changeColor(this.selectedIndex)" >
                  <?
                  $query1 = "select * from m0004woodcolors where lang_code='$defaultlang' order by seq_no ";
                  $result1 = mysql_query($query1);
                  $num1=mysql_numrows($result1);
                  $j = 0;
                  while ($j < $num1)
                  {
                    $wood_color_id = mysql_result($result1,$j,"wood_color_id");
                    $wood_color_value[$j] = mysql_result($result1,$j,"wood_color_value");
                    $wood_color_name = mysql_result($result1,$j,"wood_color_name");
                    if($wood_color_id == $woodcolorid)
                      echo "<option value=".$wood_color_id." selected>".$wood_color_name."</option>";
                    else
                      echo "<option value=".$wood_color_id.">".$wood_color_name."</option>";
                    $j++;
                  }
                  ?>
                  </select>
                  <?
                  for($k=0;$k<Count($wood_color_value);$k++)
                  {
                      echo "<input type=hidden name=txtselwoodcolor_".$k." id=txtselwoodcolor_".$k." value=".$wood_color_value[$k].">";
                  }
                  $query1 = "select * from m0006woodtypecolors where lang_code='$defaultlang'  order by wood_type_id,wood_color_id ";
                  $result1 = mysql_query($query1);
                  $num1=mysql_numrows($result1);
                  $j = 0;
                  while ($j < $num1)
                  {
                    $num_wood_type_id = mysql_result($result1,$j,"wood_type_id");
                    $num_wood_color_id = mysql_result($result1,$j,"wood_color_id");
                    $wood_color_factor = mysql_result($result1,$j,"price_factor");
                    echo "<input type=hidden name=txtselwoodcolorfactor_".$num_wood_type_id."_".$num_wood_color_id." id=txtselwoodcolorfactor_".$num_wood_type_id."_".$num_wood_color_id." value=".$wood_color_factor.">";
                    $j++;
                  }
                  ?>

                  </td>
                </tr>
              </table>
            </div>
            <div class="div_height1"></div>
            <div class="page3_right">
              <div class="subheading"><?=$field_caption[12]?></div>
              <br /><br />
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="10"><input name="txtsockelcut" id="txtsockelcut" type="checkbox" value="1" onclick="fn_calculatePrice();fn_resetErrorMessage();fn_enablesockelheightwidth()" style="border: none;width: 12px;"/></td>
                  <td width="170">
                    <div style="float:left;"><?=$field_caption[24]?></div>
                    <div class="q_mark" style="padding:0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_24')" onmouseover="popUp(event,'tt_24')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                    </div>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="padding-left: 20px;">
                      <tr>
                        <td width="65"><?=$field_caption[25]?></td>
                        <td width="65"><input name="txtsockelheight" id="txtsockelheight" type="text" style="width: 65px;height: 19px;"/></td>
                      </tr>
                      <tr height="8">
                        <td colspan="2"></td>
                      </tr>
                      <tr>
                        <td width="65"><?=$field_caption[26]?></td>
                        <td width="65"><input name="txtsockelwidth" id="txtsockelwidth" type="text" style="width: 65px;height: 19px;"/></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td width="20"><input name="txtaddhole" id="txtaddhole" type="checkbox" value="1" onclick="fn_calculatePrice();fn_resetErrorMessage();" style="border: none;width: 12px;"/></td>
                  <td width="180">
                    <div style="float:left;"><?=$field_caption[27]?></div>
                    <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_27')" onmouseover="popUp(event,'tt_27')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                    </div>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td width="20"><input name="txtbackwall" id="txtbackwall" onclick="fn_calculatePrice()" type="checkbox" value="1" style="border: none;width: 12px;"/></td>
                  <td width="180">
                    <div style="float:left;"><?=$field_caption[28]?></div>
                    <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_28')" onmouseover="popUp(event,'tt_28')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                    </div>
                  </td>
                </tr>
                <tr height="8">
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td width="20"><input name="txtcontinueslab" id="txtcontinueslab" onclick="fn_calculatePrice()"  type="checkbox" value="1" style="border: none;width: 12px;"/></td>
                  <td width="180">
                    <div style="float:left;"><?=$field_caption[110]?></div>
                    <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_110')" onmouseover="popUp(event,'tt_110')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="page3_right_price">
              <table border="0" cellspacing="0" cellpadding="0"  class="table_bg">
                <tr>
                  <td class="tree">
                    <div>
                      <div>
                        <div class="pries_text"><?=$field_caption[29]?></div>
						<?
						if($currency_symbol_position_ind == "P")
							echo "<div class=pries_text id=netprice style='width:120px;' >".$currencysymbol."0</div>";
						else
							echo "<div class=pries_text id=netprice style='width:120px;' >0 ".$currencysymbol."</div>";
						?>
                        <div class="pries_small_text"><?=$field_caption[73]?></div>
                      </div>
                      <br />
                      <div>
					  <!--
                        <div id="totaltress" class="tree_text" ><?=$field_caption[30]?> 30</div>
                        <div style="width:50px;float:right;"><img src="../fabimages/tree1.png" border="0">
                        <a onmouseout="popUp(event,'tt_30')" onmouseover="popUp(event,'tt_30')" onclick="return false">
                        <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                        </a>
                        </div>
					-->
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="config_area">
              <div id="mainarea" class="banner_area" style="width:<?=($divWidth+70)?>px; height:<?=($divHeight+80)?>px;overflow:auto;  white-space:nowrap;"  >
              <table width=90% valign=top align=left cellspacing="0" cellpadding="0" border="0">
                  <tr>
                    <td width="200px">
                        <div style="float:left;"><?=$field_caption[13]?></div>
                        <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_13')" onmouseover="popUp(event,'tt_13')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                        </div>
                    </td>
                    <td width="<?=($width+50)?>">
                        <select name="txtcolumns" id="txtcolumns" onchange="fn_resetErrorMessage();show_hidecolumns(this.value,'C');">
                        <?
                        for($i=$mincolumns;$i<=$maxcolumns;$i++)
                        {
                            ?> <option value=<?=$i?> <?if($i==$noofcolumn) { echo "selected"; } ?> ><?=$i?></option> <?
                        }
                        ?>
                        </select>
                    </td>
                  </tr>
                  <tr height="7">
                      <td colspan="2"></td>
                  </tr>
                  <tr>
                      <td>
                        <div style="float:left;"><?=$field_caption[14]?></div>
                        <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_14')" onmouseover="popUp(event,'tt_14')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                        </div>
                      </td>
                      <td valign=top align=center>
                          <table width=100% height=100% cellspacing="0" cellpadding="0" style="table-layout:fixed;">
                          <tr>
                          <?for($nCol=1;$nCol<=$maxcolumns;$nCol++)
                          {
                          ?>
                            <td id="heightinsidetd<?=$nCol?>" align=center><select name="txtheight<?=$nCol?>" id="txtheight<?=$nCol?>" onfocus="fn_getDefaultHeight(this.value);" onchange="fn_resetErrorMessage();fn_changecolumnheight(this.value,<?=$nCol?>)">
                                <?
                                for($i=$minheight;$i<=$actualheight;$i++)
                                {
                                    if($actualheight == $i)
                                    echo "<option value=".$i." selected>".$i."</option>";
                                    else
                                    echo "<option value=".$i.">".$i."</option>";
                                }
                                ?>
                            </select></td>
                         <?}?>
                         </tr>
                         </table>
                      </td>
                  </tr>
                  <tr height="7">
                      <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td >
                        <div style="float:left;"><?=$field_caption[15]?></div>
                        <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_15')" onmouseover="popUp(event,'tt_15')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                        </div>
                    </td>
                    <td valign=top align=center>
                        <table width=100% height=100% cellspacing="0" cellpadding="0" style="table-layout:fixed;">
                        <tr>
                        <?for($nCol=1;$nCol<=$maxcolumns;$nCol++)
                        {
                        ?><td id="widthinsidetd<?=$nCol?>" align=center><select  name="txtwidth<?=$nCol?>" id="txtwidth<?=$nCol?>" onchange="fn_resetErrorMessage();fn_changecolumnwidth(this.value,this,<?=$nCol?>);"  >
                              <?
                              for($i=$min_wall_distance;$i<=$max_wall_distance;$i++)
                              {
                                  if($width == $i)
                                  echo "<option value=".$i." selected>".$i."</option>";
                                  else
                                  echo "<option value=".$i.">".$i."</option>";

                              }
                              ?>
                          </select></td>
                       <?}?>
                       </tr>
                       </table>
                   </td>
                  </tr>
                  <tr height="7">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td valign="top">
                      <div style="float:left;"><?=$field_caption[16]?></div>
                      <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_16')" onmouseover="popUp(event,'tt_16')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                      </div>
                    </td>
                    <td width=<?=$width?> valign=top align=center >
                        <div id='toolboxes' style="text-align:left;"></div>
                        <table width=100% height=100% cellspacing="0" cellpadding="0" style="table-layout:fixed;" border=0>
                        <tr>
                          <?for($nColumns=1;$nColumns<=$maxcolumns;$nColumns++)
                          {
                              echo "<td id='tdcolumn".$nColumns."' valign=bottom >&nbsp;";
                              if($nColumns == $noofcolumn )
                              {
                                  if(strpos($browser,"Firefox") == true || strpos($browser,"MSIE") == true)
                                  {
                                      echo "<div id='column".$nColumns."' style='width:100%; height:100%' >";
                                      echo "<table cellspacing=0 cellpadding=0 width=100% height=100% style='border:1px;table-layout:fixed;'><tr><td width=100% height=100% class=td_sty id='columninsiderowtd1_".$nColumns."'>&nbsp;</td></tr></table>";
                                      echo "</div>";
                                  }
                                  else
                                  {
                                      echo "<div id='column".$nColumns."' >";
                                      echo "<table cellspacing=0 cellpadding=0 width=100% height=100% style='border:1px;table-layout:fixed;'><tr><td width=100% height=100% class=td_sty id='columninsiderowtd1_".$nColumns."'>&nbsp;</td></tr></table>";
                                      echo "</div>";
                                  }
                              }
                              else
                              {
                                  if(strpos($browser,"Firefox") == true || strpos($browser,"MSIE") == true)
                                  {
                                      echo "<div id='column".$nColumns."' style='width:100%; height:100%' >";
                                      echo "<table cellspacing=0 cellpadding=0 width=100% height=100%  style='border:1px;table-layout:fixed;'><tr><td width=100% height=100% class=td_sty_withoutright id='columninsiderowtd1_".$nColumns."'>&nbsp;</td></tr></table>";
                                      echo "</div>";
                                  }
                                  else
                                  {
                                      echo "<div id='column".$nColumns."' >";
                                      echo "<table cellspacing=0 cellpadding=0 width=100% height=100%  style='border:1px;table-layout:fixed;'><tr><td width=100% height=100% class=td_sty_withoutright id='columninsiderowtd1_".$nColumns."'>&nbsp;</td></tr></table>";
                                      echo "</div>";
                                  }
                              }
                              echo "</td>";
                          }
                          ?>
                        </tr>
                        </table>
                    </td>
                  </tr>
                  <tr height="7">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td >
                      <div style="float:left;"><?=$field_caption[17]?></div>
                      <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_17')" onmouseover="popUp(event,'tt_17')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                      </div>
                    </td>
                    <td valign=top align=center>
                        <table width=100% height=100% cellspacing="0" cellpadding="0" style="table-layout:fixed;">
                        <tr>
                          <?for($nCol=1;$nCol<=$maxcolumns;$nCol++)
                          {
                          ?>
                          <td align=center id="sockelinsidetd<?=$nCol?>" ><input type=checkbox name="txtsockel<?=$nCol?>" id="txtsockel<?=$nCol?>" value="1" onclick="fn_resetErrorMessage();fn_setsockel(<?=$nCol?>,'Y');" checked ></td>
                         <?}?>
                        </tr>
                        </table>
                    </td>
                  </tr>
                  <tr height="7">
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td >
                      <div style="float:left;"><?=$field_caption[18]?></div>
                      <div class="q_mark" style="padding: 0 0 0 5px;">
                         <span align=center>
                               <a onmouseout="popUp(event,'tt_18')" onmouseover="popUp(event,'tt_18')" onclick="return false">
                               <img src="../fabimages/q_mark.png" alt="Tool Tip" border="0"/>
                               </a>
                         </span>
                      </div>
                    </td>
                    <td valign=top align=center>
                        <table width=100% height=100% cellspacing="0" cellpadding="0" style="table-layout:fixed;">
                        <tr>
                        <?for($nCol=1;$nCol<=$maxcolumns;$nCol++)
                        {
                        ?>
                          <td align=center id="rowsinsidetd<?=$nCol?>"><select name="txtrows<?=$nCol?>" id="txtrows<?=$nCol?>" onchange="fn_resetErrorMessage();fn_changecolumn(<?=$nCol?>,this.value)">
                              <?
                              for($i=$minrows;$i<=$maxrows;$i++)
                              {
                                  echo "<option value=".$i.">".$i."</option>";
                              }
                              ?>
                          </select></td>
                       <?}?>
                       </tr>
                       </table>
                    </td>
                  </tr>
                  <tr height="7">
                    <td colspan="2"></td>
                  </tr>
                  <?for($nRow=1;$nRow<=$maxrows;$nRow++)
                  {
                      for($nCol=1;$nCol<=$maxcolumns;$nCol++)
                      {
                      ?>
                        <div id="boardinsidetd<?=$nRow?>_<?=$nCol?>" >
                        <input type=hidden name="txtdefdoortype<?=$nRow?>_<?=$nCol?>" id=txtdefdoortype<?=$nRow?>_<?=$nCol?> value="0">
                        <input type=hidden style="width:25px;" name="txtrowsboarddist<?=$nRow?>_<?=$nCol?>" id=txtrowsboarddist<?=$nRow?>_<?=$nCol?> onblur="fn_resetErrorMessage();fn_changerowcolumnheight(this.value,this,<?=$nRow?>,<?=$nCol?>)">
                        </div>
                     <?}?>
                  <?
                  }
                  ?>
            </table>
        </div>

		</div>
        <div class="button_container">
			<div class="back_button">
				<span class='ui-style-button-disable'><a class='ui-corner-all' href='javascript:fn_prevStep2()'><?=$backbuttontext?></a></span>
			</div>
			<div class="nex_button">
				<span class='ui-style-button-disable'><a href="#dialog3" name="modal" class='ui-corner-all'><?=$saveconfigurationtext?></a></span>&nbsp;&nbsp;
				<span class='ui-style-button'><a class='ui-corner-all' href='javascript:fn_nextStep()'><?=$nextbuttontext?></a></span>
			</div>
         </div>
		</div>

    </div>
    </td><tr>
    <input type=hidden name=txtPrevStep id=txtPrevStep value="3">
    <input type=hidden name=txtnextstep value="41">
    <input type=hidden name=txtnetprice id=txtnetprice>
    <input type=hidden name=txttrees id=txttrees>
    <input type=hidden name=txtgrossprice id=txtgrossprice>
    <input type=hidden name=txtactualgrossprice id=txtactualgrossprice>
    <input type=hidden name=txttotalvolume id=txttotalvolume>
    <input type=hidden name=txtdispheight id=txtdispheight value="<?=$actualheight?>" >
    <input type=hidden name=txtdispwidth id=txtdispwidth value="<?=$actualwidth?>">
</form>
<?
include("toolfooter.php");
?>
<script>

function fn_nextStep()
{
    document.getElementById('txtwoodtypeindex').value =document.getElementById('hdnwoodtype').selectedIndex;
    document.getElementById('txtthicknessindex').value = document.getElementById('hdnthick').selectedIndex;
    fn_validate();
    document.theForm.action='<?=$toolnextpageurl?>';
    document.theForm.submit();
}
function fn_prevStep2()
{
    fn_validate();
    document.theForm.action='<?=$toolprevpageurl?>';
    document.theForm.submit();
}
function fn_prevStep1()
{
    fn_validate();
    document.theForm.action='<?=$toolstep1pageurl?>';
    document.theForm.submit();
}


function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) )  {return false;}
}


document.onkeypress = stopRKey;

var browserName = navigator.appName;
var browserversion = navigator.appVersion;
var browseragent = navigator.userAgent;
var numVatPer = <?=$vat_percentage?>;

var strWoodColor = "<?=$woodcolor?>";
var strShadeColor = "<?=$shadecolor?>";
var strWallThickness = <?=$wall_thickness?>;
var strBoardThickness = <?=$board_thickness?>;
var strMaxRows = <?=$maxrows?>;
var strMinRows = <?=$minrows?>;
var totalthickness = <?=$totalThicknesses?>;
var numSockelHeight = 7;
var numMaxDoorWidth = <?=$max_single_door_width?> * 2;
var numMaxDoorHeight = <?=$max_door_height?>;
var numMaxSingleDoorWidth=<?=$max_single_door_width?>;

var priceRangeVolumeFrom = new Array();
var priceRangeVolumeTo = new Array();
var priceRange = new Array();
var fixPrice = 0;
var doorPrice = 0;
var doorfixPrice = 0;
var bwPrice = 0;
var oneBoardOnTopPrice = 0;

var bwfixPrice = 0;
var fixWallPrice = 0;
var fixBoardPrice = 0;
var fixAddHolePrice = 0;
var fixSockleCutPrice = 0;
var numDoorValue = 0;
var numBackWallValue = 0;

var unitpx = '';
if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
   var unitpx = 'px';

var prodwoodPrice = 0;
var prodfixPrice = 0;
var proddoorPrice = 0;
var proddoorfixPrice = 0;
var prodbwPrice = 0;
var prodbwfixPrice = 0;
var prodfixWallPrice = 0;
var prodfixBoardPrice = 0;
var numprodDoorValue = 0;
var numprodBackWallValue = 0;


var numMutiply = parseFloat(1.2);
if(browserversion.indexOf('MSIE') >= 0 || browseragent.indexOf('Firefox') >= 0) // 'Firefox and Microsoft Internet Explorer 6, 8 and above'
    numMutiply = parseFloat(1.2);
else
    numMutiply = parseFloat(1);

//var numMutiply = parseFloat(1.2);
//if(parseInt(actualdesignheight) <= 300)
//   numMutiply = parseFloat(2);

var setBoardThickness = strBoardThickness + 'px';
var setWallThickness = strWallThickness + 'px';
var setThickness1 = (parseInt(strBoardThickness) + parseInt(numSockelHeight)) + 'px';

var theRules = new Array();
if (document.styleSheets[2].cssRules) //Moz.
    theRules = document.styleSheets[2].cssRules
else if (document.styleSheets[2].rules) // IE
    theRules = document.styleSheets[2].rules

function CSSrules(ruleIndex,boolTop,boolLeft,boolRight,boolBottom,boolSockelThick)
{
  if(boolTop == true)
  {
     theRules[ruleIndex].style.borderTopColor = strWoodColor;
     theRules[ruleIndex].style.borderTopWidth = setBoardThickness;
  }
  if(boolLeft == true)
  {
     theRules[ruleIndex].style.borderLeftColor = strWoodColor;
     theRules[ruleIndex].style.borderLeftWidth = setWallThickness;
  }
  if(boolRight == true)
  {
     theRules[ruleIndex].style.borderRightColor = strWoodColor;
     theRules[ruleIndex].style.borderRightWidth = setWallThickness;
  }
  if(boolBottom == true && boolSockelThick == false)
  {
     theRules[ruleIndex].style.borderBottomColor = strWoodColor;
     theRules[ruleIndex].style.borderBottomWidth = setBoardThickness;
  }
  if(boolBottom == true && boolSockelThick == true)
  {
     theRules[ruleIndex].style.borderBottomColor = strWoodColor;
     theRules[ruleIndex].style.borderBottomWidth = setThickness1;
  }
}

CSSrules(0,true,true,true,true,false);
CSSrules(1,true,true,false,true,false);
CSSrules(2,true,true,false,false,false);
CSSrules(3,true,true,true,false,false);
CSSrules(4,false,true,false,false,false);
CSSrules(5,false,true,true,false,false);
CSSrules(6,false,true,true,true,false);
CSSrules(7,false,true,false,true,false);
CSSrules(8,true,false,false,false,false);
CSSrules(9,true,false,false,true,false);
CSSrules(10,true,false,true,true,false);
CSSrules(11,true,false,true,false,false);
CSSrules(12,false,false,false,true,false);
CSSrules(13,false,false,true,true,false);
CSSrules(14,true,true,true,true,true);
CSSrules(15,true,true,false,true,true);
CSSrules(19,false,true,true,true,true);
CSSrules(16,false,true,false,true,true);
CSSrules(17,true,false,false,true,true);
CSSrules(20,true,false,true,true,true);
CSSrules(18,false,false,false,true,true);
CSSrules(21,false,false,true,true,true);
CSSrules(22,true,true,false,false,true);
CSSrules(23,true,true,true,false,true);
CSSrules(24,true,false,true,false,true);
CSSrules(25,true,false,false,false,true);
CSSrules(26,false,true,true,false,true);

CSSrules(27,false,true,false,false,true);

CSSrules(28,false,false,true,false,true);
CSSrules(29,false,false,true,false,false);
CSSrules(30,false,false,false,false,true);
CSSrules(31,false,false,false,false,false);



var oldWidth = 0;
var oldHeight =0;

//show_hidecolumns(totalcol,'L');
document.getElementById('txtcolumns').value = totalcol;

function show_hidecolumns(nCols,isHeightLoad)
{
  totalcol = nCols;
  var reduceWidth = parseInt(strWallThickness)* (parseInt(nCols) + 1);
  designwidth =  parseInt(actualdesignwidth) - parseInt(reduceWidth);
  eachtdwidth = Math.round(designwidth/nCols);
  var tdwidth = eachtdwidth;
  for(var i=1; i<=maxcols; i++)
  {
    eachcolheight = parseInt(document.getElementById('txtheight'+i).value);
    var nRows = document.getElementById('txtrows'+i).value;
    var reduceHeight = parseInt(strBoardThickness)* (parseInt(nRows) + 1);
    designheight =  parseInt(eachcolheight) - parseInt(reduceHeight) - parseInt(numSockelHeight);
    eachtdheight = Math.round(designheight/nRows);

    if(i > nCols)
    {
        document.getElementById('heightinsidetd'+i).style.visibility ='hidden';
        document.getElementById('widthinsidetd'+i).style.visibility ='hidden';
        document.getElementById('tdcolumn'+i).style.visibility ='hidden';
        document.getElementById('sockelinsidetd'+i).style.visibility ='hidden';
        document.getElementById('rowsinsidetd'+i).style.visibility ='hidden';
        if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
        {
            document.getElementById('heightinsidetd'+i).style.width = 0 + unitpx;
            document.getElementById('widthinsidetd'+i).style.width = 0 + unitpx;
            document.getElementById('tdcolumn'+i).style.width = 0 + unitpx;
            document.getElementById('sockelinsidetd'+i).style.width = 0 + unitpx;
            document.getElementById('rowsinsidetd'+i).style.width = 0 + unitpx;
        }
        else
        {
            document.getElementById('heightinsidetd'+i).width = 0 + unitpx;
            document.getElementById('widthinsidetd'+i).width = 0 + unitpx;
            document.getElementById('tdcolumn'+i).width = 0 + unitpx;
            document.getElementById('sockelinsidetd'+i).width = 0 + unitpx;
            document.getElementById('rowsinsidetd'+i).width = 0 + unitpx;
        }


        for(var j=1;j<=strMaxRows;j++)
        {
            document.getElementById('boardinsidetd'+j+'_'+i).style.display ='none';
            if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
               document.getElementById('boardinsidetd'+j+'_'+i).style.width = 0 + unitpx;
            else
               document.getElementById('boardinsidetd'+j+'_'+i).width = 0 + unitpx;
            document.getElementById('txtrowsboarddist'+j+'_'+i).value = parseInt(eachtdheight);
        }

    }
    else
    {
        if(i == nCols)
           tdwidth = parseInt(designwidth) - getTotalWidth();
        document.getElementById('heightinsidetd'+i).style.visibility ='visible';
        document.getElementById('widthinsidetd'+i).style.visibility ='visible';
        document.getElementById('tdcolumn'+i).style.visibility ='visible';
        document.getElementById('sockelinsidetd'+i).style.visibility ='visible';
        document.getElementById('rowsinsidetd'+i).style.visibility = 'visible';

        if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
        {
            document.getElementById('heightinsidetd'+i).style.width = parseInt(tdwidth * numMutiply)+ unitpx;
            document.getElementById('widthinsidetd'+i).style.width = parseInt(tdwidth * numMutiply)+ unitpx;
            document.getElementById('tdcolumn'+i).style.width = parseInt(tdwidth * numMutiply) + unitpx;
            document.getElementById('tdcolumn'+i).style.height = parseInt(eachcolheight * numMutiply)  + unitpx;
            document.getElementById('sockelinsidetd'+i).style.width = parseInt(tdwidth * numMutiply)+ unitpx;
            document.getElementById('rowsinsidetd'+i).style.width = parseInt(tdwidth * numMutiply)+ unitpx;
        }
        else
        {
            document.getElementById('heightinsidetd'+i).width = parseInt(tdwidth * numMutiply)+ unitpx;
            document.getElementById('widthinsidetd'+i).width = parseInt(tdwidth * numMutiply)+ unitpx;
            document.getElementById('tdcolumn'+i).width = parseInt(tdwidth * numMutiply) + unitpx;
            document.getElementById('tdcolumn'+i).height = parseInt(eachcolheight * numMutiply)  + unitpx;
            document.getElementById('sockelinsidetd'+i).width = parseInt(tdwidth * numMutiply)+ unitpx;
            document.getElementById('rowsinsidetd'+i).width = parseInt(tdwidth * numMutiply)+ unitpx;
        }


        document.getElementById('txtwidth'+i).value = tdwidth;


        for(var j=1;j<=strMaxRows;j++)
        {
            document.getElementById('boardinsidetd'+j+'_'+i).style.display = 'block';
            if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
                document.getElementById('boardinsidetd'+j+'_'+i).style.width = parseInt(tdwidth * numMutiply)+ unitpx;
            else
                document.getElementById('boardinsidetd'+j+'_'+i).width = parseInt(tdwidth * numMutiply)+ unitpx;
        }

        //fn_changetdsockel(i,'N');
        if(nCols == 1) { document.getElementById('txtwidth'+i).disabled = true; }
        else { document.getElementById('txtwidth'+i).disabled = false; }
    }
  }
  fn_resetAllColumnsStyle('N');
  for(var t=1;t<=totalcol;t++)
  {
      fn_changecolumn(t,document.getElementById('txtrows'+t).value);
  }
  fn_calculatePrice();
}


function fn_changetdsockel(strcolumnid,isChkboxChanged)
{
  var isValid = true;
  if(strcolumnid == totalcol && totalcol > 1 )
  {
      if(document.getElementById('txtsockel'+strcolumnid).checked == false && document.getElementById('txtsockel'+(strcolumnid-1)).checked == false )
         isValid = false;
  }
  if(strcolumnid == 1 && totalcol > 1 )
  {
      if(document.getElementById('txtsockel'+strcolumnid).checked == false && document.getElementById('txtsockel'+(strcolumnid+1)).checked == false )
         isValid = false;
  }
  if(strcolumnid != totalcol && totalcol > 1 && strcolumnid > 1)
  {
      if(document.getElementById('txtsockel'+strcolumnid).checked == false && document.getElementById('txtsockel'+(strcolumnid+1)).checked == false )
         isValid = false;
      if(document.getElementById('txtsockel'+strcolumnid).checked == false && document.getElementById('txtsockel'+(strcolumnid-1)).checked == false )
         isValid = false;
  }

  eachtdwidth = document.getElementById('txtwidth'+strcolumnid).value;
  var selValue = document.getElementById('txtrows'+strcolumnid).value;
  var nRows = document.getElementById('txtrows'+strcolumnid).value;
  var colheight = document.getElementById('txtheight'+strcolumnid).value;
  if(parseInt(document.getElementById('txtrowsboarddist'+nRows+'_'+strcolumnid).value) < parseInt(minrow_dist) && document.getElementById('txtsockel'+strcolumnid).checked == true )
  {
      document.getElementById('diverrmessage').style.display ='block';
      document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[10]?>";
      document.getElementById('diverrmessage').scrollIntoView();
      document.getElementById('txtsockel'+strcolumnid).checked = false;
      return;
  }
  else
  {
    if(isValid)
    {
        fillHeightDropDown(strcolumnid);
        var reduceHeight = parseInt(strBoardThickness)* (parseInt(nRows) + 1);
        designheight =  parseInt(colheight) - parseInt(reduceHeight) - parseInt(numSockelHeight);
        //eachtdheight = Math.round(designheight/selValue);
        //var strheight = eachtdheight;
        fn_changeStylesheets(selValue,strcolumnid,'td_sty_withoutrighttopbottom','td_sty_withouttopbottom','td_sty_withoutright','td_sty_withoutrightandtop','td_sty','td_sty_withouttop','td_sty_withoutrightandbottom','td_sty_withoutbottom');
        for(var j=1;j<=strMaxRows;j++)
        {
            if(j <= nRows)
            {
              var strheight = document.getElementById('txtrowsboarddist'+j+'_'+strcolumnid).value;
              if(j == nRows)
              {
                  strheight = parseInt(designheight) - getTotalHeight(strcolumnid);
                  if(document.getElementById('txtsockel'+strcolumnid).checked == false)
                      strheight = parseInt(strheight) + parseInt(strBoardThickness) + parseInt(numSockelHeight);
              }
              document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.display = 'block';
              if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
              {
                  document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.width = parseInt(eachtdwidth * numMutiply) + unitpx;
                  document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).style.height = (parseInt(strheight) * numMutiply)  + unitpx;
              }
              else
              {
                  document.getElementById('boardinsidetd'+j+'_'+strcolumnid).width = parseInt(eachtdwidth * numMutiply) + unitpx;
                  document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).height = (parseInt(strheight) * numMutiply)  + unitpx;
              }
              //document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).innerHTML = parseInt(strheight);
              //document.getElementById('txtnewrowsboarddist'+j+'_'+strcolumnid).value = parseInt(strheight);

              var strTextBox = '<input type=text class=tooltextbox style="font-size:10px;width:18px;height:12px;" name="txtnewrowsboarddist'+j+'_'+strcolumnid+'" id="txtnewrowsboarddist'+j+'_'+strcolumnid+'" value="'+strheight+'" onfocus="this.select();" onblur="fn_resetErrorMessage();fn_updateTextBoxValue(this.value,'+j+','+strcolumnid+');">';

              document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).innerHTML = strTextBox;

              if(nRows == '1')
                  document.getElementById('txtnewrowsboarddist'+j+'_'+strcolumnid).disabled = true;
              else
                  document.getElementById('txtnewrowsboarddist'+j+'_'+strcolumnid).disabled = false;
            }
            else
            {
              document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.display ='none';
              if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
                 document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.width = parseInt(eachtdwidth * numMutiply) + unitpx;
              else
                 document.getElementById('boardinsidetd'+j+'_'+strcolumnid).width = parseInt(eachtdwidth * numMutiply) + unitpx;
            }
        }
     }
     else
     {
         document.getElementById('txtsockel'+strcolumnid).checked = true;
     }
   }
}

function fn_setsockel(strcolumnid,isChkboxChanged)
{
   var selValue = document.getElementById('txtrows'+strcolumnid).value;
   selectedHeight = document.getElementById('txtheight'+strcolumnid).value;
   fn_changetdsockel(strcolumnid,isChkboxChanged)
   fn_resetAllColumnsStyle('N');
   //fn_setSelectedColumnBoardDistance(strcolumnid,selValue);
   fn_calculatePrice();
}

function fn_changecolumn(strcolumnid,selValue)
{
    eachtdwidth = document.getElementById('txtwidth'+strcolumnid).value;
    var selValue = document.getElementById('txtrows'+strcolumnid).value;
    var nRows = document.getElementById('txtrows'+strcolumnid).value;

    var reduceHeight = parseInt(strBoardThickness)* (parseInt(nRows) + 1);
    designheight =  parseInt(actualdesignheight) - parseInt(reduceHeight) - parseInt(numSockelHeight);
    eachtdheight = Math.round(designheight/selValue);
    var strheight = eachtdheight;

    fn_changeStylesheets(selValue,strcolumnid,'td_sty_withoutrighttopbottom','td_sty_withouttopbottom','td_sty_withoutright','td_sty_withoutrightandtop','td_sty','td_sty_withouttop','td_sty_withoutrightandbottom','td_sty_withoutbottom');
    fn_showhiderows(nRows,eachtdwidth,strheight,strcolumnid,designheight);
    fn_setSelectedColumnBoardDistance(strcolumnid,selValue);
    fn_resetAllColumnsStyle('N');
    fn_calculatePrice();

    if(nRows == '1')
        document.getElementById('txtnewrowsboarddist1_'+strcolumnid).disabled = true;
    else
        document.getElementById('txtnewrowsboarddist1_'+strcolumnid).disabled = false;
}

function fn_showhiderows(nRows,eachtdwidth,strheight,strcolumnid,designheight)
{
    var totalusedHeights = 0;
    var firstRowheight = 0;
    for(var j=1;j<=strMaxRows;j++)
    {
        if(j <= nRows)
        {
          if(j == nRows)
          {
              strheight = parseInt(designheight) - getTotalHeight(strcolumnid);
              if(document.getElementById('txtsockel'+strcolumnid).checked == false)
                 strheight = parseInt(strheight) + parseInt(strBoardThickness) + parseInt(numSockelHeight);
          }
          if(j == 1)
             firstRowheight = parseInt(strheight  * numMutiply);
          totalusedHeights =  totalusedHeights + parseInt(strheight  * numMutiply);
          document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.display = 'block';

          if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
          {
              document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.width = parseInt(eachtdwidth * numMutiply) + unitpx;
              document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).style.height = (strheight  * numMutiply) + unitpx;
          }
          else
          {
              document.getElementById('boardinsidetd'+j+'_'+strcolumnid).width = parseInt(eachtdwidth * numMutiply) + unitpx;
              document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).height = (strheight  * numMutiply) + unitpx;
          }

          document.getElementById('columninsiderowtd'+j+'_'+strcolumnid).innerHTML = strheight;
          document.getElementById('txtrowsboarddist'+j+'_'+strcolumnid).value = strheight;
        }
        else
        {
            document.getElementById('boardinsidetd'+j+'_'+strcolumnid).style.display ='none';
        }
    }
    //columnhgt = parseInt(document.getElementById('txtheight'+strcolumnid).value);
    //document.getElementById('columninsiderowtd1_'+strcolumnid).style.height = firstRowheight + (columnhgt * numMutiply) - (totalusedHeights);
}

function fn_changecolumnwidth(objVal,obj,nColumnNo)
{
   var newWidth=objVal;
   var diffWidth = getTotalWidthDiff();
   if(nColumnNo != totalcol)
   {
       nextColumnNo = nColumnNo + 1;
   }
   else
   {
       nextColumnNo = nColumnNo - 1;
   }
   var nextColumnWidth= document.getElementById('txtwidth'+(nextColumnNo)).value;
   nextColumnWidth = parseInt(nextColumnWidth) + parseInt(diffWidth);

   if(nColumnNo == totalcol)
   {
       if(nextColumnWidth < parseInt(mincol_dist))
       {
           document.getElementById('diverrmessage').style.display ='block';
          document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[11]?>";
          document.getElementById('diverrmessage').scrollIntoView();
          document.getElementById('txtwidth'+nColumnNo).value = parseInt(objVal) + parseInt(diffWidth);
          return;
       }
       if(nextColumnWidth > maxcol_dist)
       {
           document.getElementById('diverrmessage').style.display ='block';
          document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[12]?>";
          document.getElementById('diverrmessage').scrollIntoView();
          document.getElementById('txtwidth'+nColumnNo).value = parseInt(objVal) + parseInt(diffWidth);
          return;
       }
   }
   else
   {
       if(nextColumnWidth < parseInt(mincol_dist))
       {
           document.getElementById('diverrmessage').style.display ='block';
          document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[13]?>";
          document.getElementById('diverrmessage').scrollIntoView();
          document.getElementById('txtwidth'+nColumnNo).value = parseInt(objVal) + parseInt(diffWidth);
          return;
       }
       if(nextColumnWidth > maxcol_dist)
       {
           document.getElementById('diverrmessage').style.display ='block';
          document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[14]?>";
          document.getElementById('diverrmessage').scrollIntoView();
          document.getElementById('txtwidth'+nColumnNo).value = parseInt(objVal) + parseInt(diffWidth);
          return;
       }
   }

   if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
   {
       document.getElementById('tdcolumn'+ nColumnNo).style.width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('tdcolumn'+nextColumnNo).style.width = parseInt(nextColumnWidth * numMutiply) + unitpx;
       document.getElementById('txtwidth'+nextColumnNo).value = nextColumnWidth;
       document.getElementById('heightinsidetd'+ nColumnNo).style.width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('heightinsidetd'+nextColumnNo).style.width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       document.getElementById('widthinsidetd'+ nColumnNo).style.width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('widthinsidetd'+nextColumnNo).style.width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       document.getElementById('rowsinsidetd'+ nColumnNo).style.width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('rowsinsidetd'+nextColumnNo).style.width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       document.getElementById('sockelinsidetd'+ nColumnNo).style.width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('sockelinsidetd'+nextColumnNo).style.width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       for(var t=1;t<=strMaxRows;t++)
       {
           document.getElementById('boardinsidetd'+t+'_'+ nColumnNo).style.width = parseInt(newWidth * numMutiply)  + unitpx;
           document.getElementById('boardinsidetd'+t+'_'+nextColumnNo).style.width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       }
   }
   else
   {
       document.getElementById('tdcolumn'+ nColumnNo).width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('tdcolumn'+nextColumnNo).width = parseInt(nextColumnWidth * numMutiply) + unitpx;
       document.getElementById('txtwidth'+nextColumnNo).value = nextColumnWidth;
       document.getElementById('heightinsidetd'+ nColumnNo).width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('heightinsidetd'+nextColumnNo).width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       document.getElementById('widthinsidetd'+ nColumnNo).width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('widthinsidetd'+nextColumnNo).width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       document.getElementById('rowsinsidetd'+ nColumnNo).width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('rowsinsidetd'+nextColumnNo).width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       document.getElementById('sockelinsidetd'+ nColumnNo).width = parseInt(newWidth * numMutiply)  + unitpx;
       document.getElementById('sockelinsidetd'+nextColumnNo).width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       for(var t=1;t<=strMaxRows;t++)
       {
           document.getElementById('boardinsidetd'+t+'_'+ nColumnNo).width = parseInt(newWidth * numMutiply)  + unitpx;
           document.getElementById('boardinsidetd'+t+'_'+nextColumnNo).width = parseInt(nextColumnWidth * numMutiply)  + unitpx;
       }
   }
   fn_calculatePrice();
}

function fn_updateTextBoxValue(strVal,cRow,cCol)
{
    var obj = document.getElementById('txtrowsboarddist'+cRow+'_'+cCol);
    document.getElementById('txtrowsboarddist'+cRow+'_'+cCol).value = document.getElementById('txtnewrowsboarddist'+cRow+'_'+cCol).value;
    fn_changerowcolumnheight(strVal,obj,cRow,cCol);
}

function fn_changerowcolumnheight(objVal,obj,currRow,currCol)
{

   var nRows = document.getElementById('txtrows'+currCol).value;
   var nHgt = objVal;
   var diffhgt = getTotalHeightDiff(currCol);
   if(currRow != nRows)
   {
       nextRow = parseInt(currRow) + 1;
   }
   else
   {
       nextRow = parseInt(currRow) - 1;
   }

   var nextColumnHeight= document.getElementById('txtrowsboarddist'+nextRow+'_'+currCol).value;

   if(document.getElementById('txtsockel'+currCol).checked == false)
       nextColumnHeight = parseInt(nextColumnHeight) + parseInt(diffhgt) + parseInt(strBoardThickness) + parseInt(numSockelHeight);
   else
       nextColumnHeight = parseInt(nextColumnHeight) + parseInt(diffhgt);

   if(objVal < parseInt(minrow_dist))
   {
       document.getElementById('diverrmessage').style.display ='block';
       document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[15]?>";
       document.getElementById('diverrmessage').scrollIntoView();
       document.getElementById('txtrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
       document.getElementById('txtnewrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
       return;
   }
   if(objVal > maxrow_dist)
   {
       document.getElementById('diverrmessage').style.display ='block';
       document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[16]?>";
       document.getElementById('diverrmessage').scrollIntoView();
       document.getElementById('txtrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
       document.getElementById('txtnewrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
       return;
   }

   if(currRow == nRows)
   {
       if(nextColumnHeight < parseInt(minrow_dist))
       {
           document.getElementById('diverrmessage').style.display ='block';
           document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[17]?>";
           document.getElementById('diverrmessage').scrollIntoView();
           document.getElementById('txtrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
           document.getElementById('txtnewrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
           return;
       }
   }
   else
   {
       if(nextColumnHeight < parseInt(minrow_dist))
       {
           document.getElementById('diverrmessage').style.display ='block';
           document.getElementById('diverrmessage').innerHTML = "<?=$field_errmsg[18]?>";
           document.getElementById('diverrmessage').scrollIntoView();
           document.getElementById('txtrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
           document.getElementById('txtnewrowsboarddist'+currRow+'_'+currCol).value = parseInt(objVal) + parseInt(diffhgt);
           return;
       }
   }

   if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
   {
       document.getElementById('columninsiderowtd'+ currRow+'_'+currCol).style.height = (parseInt(nHgt) * numMutiply)  + unitpx;
       document.getElementById('columninsiderowtd'+nextRow+'_'+currCol).style.height = (parseInt(nextColumnHeight)  * numMutiply)  + unitpx;
   }
   else
   {
       document.getElementById('columninsiderowtd'+ currRow+'_'+currCol).height = (parseInt(nHgt) * numMutiply)  + unitpx;
       document.getElementById('columninsiderowtd'+nextRow+'_'+currCol).height = (parseInt(nextColumnHeight)  * numMutiply)  + unitpx;
   }
   document.getElementById('txtrowsboarddist'+nextRow+'_'+currCol).value = nextColumnHeight;
   document.getElementById('txtnewrowsboarddist'+nextRow+'_'+currCol).value = nextColumnHeight;

   document.getElementById('columninsiderowtd'+ currRow+'_'+currCol).innerHTML = nHgt;
   document.getElementById('columninsiderowtd'+ nextRow+'_'+currCol).innerHTML = nextColumnHeight;

   fn_resetAllColumnsStyle('N');
   fn_calculatePrice();

}

function setEachColumnRowHeight(currCol)
{
    var nRows = document.getElementById('txtrows'+currCol).value;
    var numTotalHeight=0;
    for(var j=1; j<= nRows;j++)
    {
       document.getElementById('columninsiderowtd'+ j+'_'+currCol).innerHTML = document.getElementById('txtrowsboarddist'+ j+'_'+currCol).value;
    }

}

function fn_changecolumnheight(objVal,currCol)
{
      fillRows(currCol);
      document.getElementById('txtrows'+currCol).value = 1;
      var setcolheight = document.getElementById('txtheight'+currCol).value;
      var total_height = setcolheight;
      var nRows = 1;
      var reduceHeight = parseInt(strBoardThickness)* (parseInt(nRows) + 1);
      strdesignheight =  parseInt(setcolheight) - parseInt(reduceHeight) - parseInt(numSockelHeight);
      var strheight = Math.round(strdesignheight);

      var eachtdheight = parseInt(strheight);
      if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
         document.getElementById('tdcolumn'+currCol).style.height = (setcolheight * numMutiply)  + unitpx;
      else
         document.getElementById('tdcolumn'+currCol).height = (setcolheight * numMutiply)  + unitpx;


      //selectedHeight = objVal;

      fn_showhiderows(nRows,eachtdwidth,strheight,currCol,strdesignheight);
      fn_resetAllColumnsStyle('N');
      fn_calculatePrice();
}

function fn_resetAllColumnsStyle(isResetHeight)
{
      for(var nCol=1;nCol<=totalcol;nCol++)
      {
          var nRows =document.getElementById('txtrows'+nCol).value;
          var currColHeight = parseInt(document.getElementById('txtheight'+nCol).value);
          var nextColHeight = 0;
          var prevColHeight = 0;
          if(nCol == 1)
          {
              if(totalcol > 1)
              {
                nextColHeight = parseInt(document.getElementById('txtheight'+(nCol+1)).value);
                if(nextColHeight >= currColHeight)
                   fn_changeStylesheets(nRows,nCol,'td_sty_withoutrighttopbottom','td_sty_withouttopbottom','td_sty_withoutright','td_sty_withoutrightandtop','td_sty','td_sty_withouttop','td_sty_withoutrightandbottom','td_sty_withoutbottom');
                else
                   fn_changeStylesheets(nRows,nCol,'td_sty_withouttopbottom','td_sty_withouttopbottom','td_sty','td_sty_withouttop','td_sty','td_sty_withouttop','td_sty_withoutbottom','td_sty_withoutbottom');
              }
              else
                 fn_changeStylesheets(nRows,nCol,'td_sty_withouttopbottom','td_sty_withouttopbottom','td_sty','td_sty_withouttop','td_sty','td_sty_withouttop','td_sty_withoutbottom','td_sty_withoutbottom');
          }
          else
          {
              if(nCol == totalcol)
              {
                  prevColHeight = parseInt(document.getElementById('txtheight'+(nCol-1)).value);
                  if(prevColHeight <= currColHeight)
                     fn_changeStylesheets(nRows,nCol,'td_sty_withoutrighttopbottom','td_sty_withouttopbottom','td_sty_withoutright','td_sty_withoutrightandtop','td_sty','td_sty_withouttop','td_sty_withoutrightandbottom','td_sty_withoutbottom');
                  else
                     fn_changeStylesheets(nRows,nCol,'td_sty_withoutlefttopandbottom','td_sty_withoutlefttopandbottom','td_sty_withoutleft','td_sty_withoutleftandtop','td_sty_withoutleft','td_sty_withoutleftandtop','td_sty_withoutleftandbottom','td_sty_withoutleftandbottom');
              }
              else
              {
                  prevColHeight = parseInt(document.getElementById('txtheight'+(nCol-1)).value);
                  nextColHeight = parseInt(document.getElementById('txtheight'+(nCol+1)).value);
                  if(prevColHeight >= currColHeight && nextColHeight >= currColHeight)
                     fn_changeStylesheets(nRows,nCol,'td_sty_withoutrightlefttopandbottom','td_sty_withoutlefttopandbottom','td_sty_withoutrightandleft','td_sty_withoutrightleftandtop','td_sty_withoutleft','td_sty_withoutleftandtop','td_sty_withoutrightleftandbottom','td_sty_withoutleftandbottom');
                  if(prevColHeight > currColHeight && nextColHeight < currColHeight)
                     fn_changeStylesheets(nRows,nCol,'td_sty_withoutlefttopandbottom','td_sty_withoutlefttopandbottom','td_sty_withoutleft','td_sty_withoutleftandtop','td_sty_withoutleft','td_sty_withoutleftandtop','td_sty_withoutleftandbottom','td_sty_withoutleftandbottom');
                  if(prevColHeight < currColHeight && nextColHeight < currColHeight)
                     fn_changeStylesheets(nRows,nCol,'td_sty_withouttopbottom','td_sty_withouttopbottom','td_sty','td_sty_withouttop','td_sty','td_sty_withouttop','td_sty_withoutbottom','td_sty_withoutbottom');
                  if(prevColHeight <= currColHeight && nextColHeight >= currColHeight)
                     fn_changeStylesheets(nRows,nCol,'td_sty_withoutrighttopbottom','td_sty_withouttopbottom','td_sty_withoutright','td_sty_withoutrightandtop','td_sty','td_sty_withouttop','td_sty_withoutrightandbottom','td_sty_withoutbottom');
                  if(prevColHeight == currColHeight && nextColHeight < currColHeight)
                     fn_changeStylesheets(nRows,nCol,'td_sty_withouttopbottom','td_sty_withouttopbottom','td_sty','td_sty_withouttop','td_sty','td_sty_withouttop','td_sty_withoutbottom','td_sty_withoutbottom');
              }
          }
          if(isResetHeight == 'Y')
             fn_setSelectedColumnBoardDistance(nCol,nRows);
          else
             fn_setBoardDistance(nCol,nRows);
      }
}

function fn_changeStylesheets(nRows,currCol,stylesheet1,stylesheet2,stylesheet3,stylesheet4,stylesheet5,stylesheet6,stylesheet7,stylesheet8)
{
      if(document.getElementById('txtsockel'+currCol).checked == false)
      {
        var strString = '';
        if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
           strString = '<table cellspacing=0 cellpadding=0 border=0 width=100% height=100% valign=bottom style="table-layout:fixed;">';
        else
           strString = '<table cellspacing=0 cellpadding=0 border=0 valign=bottom style="width:100%;height:100%;table-layout:fixed;">';

        for(var i=1;i<=nRows;i++)
        {
            if(currCol != totalcol)
            {
                if(i == 1)
                {
                    if(i==nRows)
                       strString = strString + '<tr><td class='+stylesheet7+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                       strString = strString + '<tr><td class='+stylesheet3+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackDoor('+currCol+','+i+',this)"></td></tr>';
                }
                else
                {
                    if(i==nRows)
                        strString = strString + '<tr><td class='+stylesheet1+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                        strString = strString + '<tr><td class='+stylesheet4+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
            }
            else
            {
                if(i == 1)
                {
                    if(i==nRows)
                        strString = strString + '<tr><td class='+stylesheet8+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                     strString = strString + '<tr><td class='+stylesheet5+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
                else
                {
                    if(i==nRows)
                     strString = strString + '<tr><td class='+stylesheet2+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                     strString = strString + '<tr><td class='+stylesheet6+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)"  onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
            }
            var dVal = document.getElementById('txtdefdoortype'+i+'_'+currCol).value;
            strString = strString + '<input type=hidden id=txtdoortype'+i+'_'+currCol+' name=txtdoortype'+i+'_'+currCol+' value="'+dVal+'">';
        }
        strString = strString + '</table>';
      }
      else
      {
        var strString = '';
        if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
           strString = '<table cellspacing=0 cellpadding=0 border=0 width=100% height=100% valign=bottom style="table-layout:fixed;">';
        else
           strString = '<table cellspacing=0 cellpadding=0 border=0 valign=bottom style="width:100%;height:100%;table-layout:fixed;">';
        for(var i=1;i<=nRows;i++)
        {
            if(currCol != totalcol)
            {
                if(i == 1)
                {
                    if(i==nRows)
                     strString = strString + '<tr><td class='+stylesheet3+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                     strString = strString + '<tr><td class='+stylesheet3+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
                else
                {
                    if(i==nRows)
                    strString = strString + '<tr><td class='+stylesheet4+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                    strString = strString + '<tr><td class='+stylesheet4+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
            }
            else
            {
                if(i == 1)
                {
                    if(i==nRows)
                     strString = strString + '<tr><td class='+stylesheet5+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                     strString = strString + '<tr><td class='+stylesheet5+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
                else
                {
                    if(i==nRows)
                     strString = strString + '<tr><td class='+stylesheet6+'1 id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                    else
                     strString = strString + '<tr><td class='+stylesheet6+' id=columninsiderowtd'+i+'_'+currCol+' onmouseout="fn_setRevertColor('+currCol+','+i+',this)" onmouseover="fn_getToolTip('+currCol+','+i+',this)" onclick="fn_setBackColor('+currCol+','+i+',this)"></td></tr>';
                }
            }
            var dVal = document.getElementById('txtdefdoortype'+i+'_'+currCol).value;
            strString = strString + '<input type=hidden id=txtdoortype'+i+'_'+currCol+' name=txtdoortype'+i+'_'+currCol+' value="'+dVal+'">';
        }
        strString = strString + '</table>';
      }
      document.getElementById('column'+currCol).innerHTML = strString;
}

function fn_setBackColor(strCol,strRow,obj)
{
    fn_setDefaultColor(strCol,strRow,obj);
    document.getElementById('columninsiderowtd'+strRow+'_'+strCol).style.backgroundColor = '#BED38E';
    document.getElementById('txtnewrowsboarddist'+strRow+'_'+strCol).style.backgroundColor = '#BED38E';
    var tRows =document.getElementById('txtrows'+strCol).value;
    if(tRows == '1')
        document.getElementById('txtnewrowsboarddist1_'+strCol).disabled = true;
    document.getElementById('txtnewrowsboarddist'+strRow+'_'+strCol).focus();
}

function fn_setDefaultColor(strCol,strRow,obj)
{
    for(var c=1; c<= totalcol;c++)
    {
          var tRows =document.getElementById('txtrows'+c).value;
          for(var r=1;r<=tRows;r++)
          {
              document.getElementById('columninsiderowtd'+r+'_'+c).style.backgroundColor = 'white';
              document.getElementById('txtnewrowsboarddist'+r+'_'+c).style.backgroundColor = 'white';
          }
    }
}

function fn_setRevertColor(strCol,strRow,obj)
{
    for(var c=1; c<= totalcol;c++)
    {
          var tRows =document.getElementById('txtrows'+c).value;
          for(var r=1;r<=tRows;r++)
          {
              document.getElementById('columninsiderowtd'+r+'_'+c).style.backgroundColor = 'white';
              document.getElementById('txtnewrowsboarddist'+strRow+'_'+strCol).style.backgroundColor = 'white';
          }
    }

}

function fn_getToolTip(strCol,strRow,obj)
{
    fn_setBackColor(strCol,strRow,obj);
    for(var c=1; c<= totalcol;c++)
    {
          var tRows =document.getElementById('txtrows'+c).value;
          for(var r=1;r<=tRows;r++)
          {
              document.getElementById('columninsiderowtd'+r+'_'+c).style.backgroundColor = 'white';
          }
    }
    document.getElementById('columninsiderowtd'+strRow+'_'+strCol).style.backgroundColor = '#BED38E';
}


function fn_setSelectedColumnBoardDistance(currCol,totalRows)
{
  var colheight = document.getElementById('txtheight'+currCol).value;
  var reduceHeight = parseInt(strBoardThickness)* (parseInt(totalRows) + 1);
  strheight =  parseInt(colheight) - parseInt(reduceHeight) - parseInt(numSockelHeight);
  var eachcolumnHeight = Math.round(strheight/totalRows);

  for(var j=1;j<=totalRows;j++)
  {
      if(j == totalRows)
      {
          eachcolumnHeight = parseInt(strheight) - getTotalHeight(currCol);
          if(document.getElementById('txtsockel'+currCol).checked == false)
              eachcolumnHeight = parseInt(eachcolumnHeight) + parseInt(strBoardThickness) + parseInt(numSockelHeight);
      }
      document.getElementById('txtrowsboarddist'+j+'_'+currCol).value = eachcolumnHeight;

      if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
         document.getElementById('columninsiderowtd'+j+'_'+currCol).style.height = (parseInt(eachcolumnHeight) * numMutiply) + unitpx;
      else
         document.getElementById('columninsiderowtd'+j+'_'+currCol).height = (parseInt(eachcolumnHeight) * numMutiply) + unitpx;
      var strTextBox = '<input type=text class=tooltextbox style="font-size:10px;width:18px;height:12px;" name="txtnewrowsboarddist'+j+'_'+currCol+'" id="txtnewrowsboarddist'+j+'_'+currCol+'" value="'+eachcolumnHeight+'" onfocus="this.select();" onblur="fn_resetErrorMessage();fn_updateTextBoxValue(this.value,'+j+','+currCol+');">';
      document.getElementById('columninsiderowtd'+j+'_'+currCol).innerHTML = strTextBox;
  }
}

function fn_setBoardDistance(currCol,totalRows)
{
  var colheight = document.getElementById('txtheight'+currCol).value;
  var reduceHeight = parseInt(strBoardThickness)* (parseInt(totalRows) + 1);
  strheight =  parseInt(colheight) - parseInt(reduceHeight) - parseInt(numSockelHeight);

  for(var j=1;j<=totalRows;j++)
  {
      var eachcolumnHeight = document.getElementById('txtrowsboarddist'+j+'_'+currCol).value;
      if(j == totalRows)
      {
          eachcolumnHeight = parseInt(strheight) - getTotalHeight(currCol);
          if(document.getElementById('txtsockel'+currCol).checked == false)
              eachcolumnHeight = parseInt(eachcolumnHeight) + parseInt(strBoardThickness) + parseInt(numSockelHeight);
      }
      document.getElementById('txtrowsboarddist'+j+'_'+currCol).value = eachcolumnHeight;
      if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
         document.getElementById('columninsiderowtd'+j+'_'+currCol).style.height = (parseInt(eachcolumnHeight) * numMutiply) + unitpx;
      else
         document.getElementById('columninsiderowtd'+j+'_'+currCol).height = (parseInt(eachcolumnHeight) * numMutiply) + unitpx;

      var strTextBox = '<input type=text class=tooltextbox style="font-size:10px;width:18px;height:12px;" name="txtnewrowsboarddist'+j+'_'+currCol+'" id="txtnewrowsboarddist'+j+'_'+currCol+'" value="'+eachcolumnHeight+'" onfocus="this.select();" onblur="fn_resetErrorMessage();fn_updateTextBoxValue(this.value,'+j+','+currCol+');">';
      document.getElementById('columninsiderowtd'+j+'_'+currCol).innerHTML = strTextBox;
  }
}

String.prototype.trim = function() {
  return this.replace(/^\s+|\s+$/g,"");
}
String.prototype.ltrim = function() {
  return this.replace(/^\s+/,"");
}
String.prototype.rtrim = function() {
  return this.replace(/\s+$/,"");
}


function getTotalWidthDiff()
{
    var numTotalWidth=0;
    for(var j=1; j<= totalcol;j++)
    {
        numTotalWidth = numTotalWidth + parseInt(document.getElementById('txtwidth'+j).value);
    }
    var numTotalWidthDiff = parseInt(designwidth) - parseInt(numTotalWidth);
    return numTotalWidthDiff;
}

function getTotalWidth()
{
    var numTotalWidth=0;
    for(var j=1; j< totalcol;j++)
    {
        numTotalWidth = numTotalWidth + parseInt(document.getElementById('txtwidth'+j).value);
    }
    return numTotalWidth;
}

function getTotalHeightDiff(currCol)
{
    var nRows = document.getElementById('txtrows'+currCol).value;
    var numTotalHeight=0;
    for(var j=1; j<= nRows;j++)
    {
        numTotalHeight = numTotalHeight + parseInt(document.getElementById('txtrowsboarddist'+j+'_'+currCol).value);
    }
    var colHeight =  document.getElementById('txtheight'+currCol).value;
    var reduceHeight = parseInt(strBoardThickness)* (parseInt(nRows) + 1);
    strdesignheight =  parseInt(colHeight) - parseInt(reduceHeight)  - parseInt(numSockelHeight);
    var strheight = Math.round(strdesignheight);
    var numTotalHeightDiff = parseInt(strheight) - parseInt(numTotalHeight);
    return numTotalHeightDiff;
}

function getTotalHeight(currCol)
{
    var nRows = document.getElementById('txtrows'+currCol).value;
    var numTotalHeight=0;
    for(var j=1; j< nRows;j++)
    {
        numTotalHeight = numTotalHeight + parseInt(document.getElementById('txtrowsboarddist'+j+'_'+currCol).value);
    }
    return numTotalHeight;
}

function fn_calculatePrice()
{
   var baseHeight = 7;
   var numTotalVolume = 0;
   //var numThickness =parseInt(document.getElementById('hdnthick').value);

   // Added New Section
   var numWallThickness = 0;
   var numBoardThickness = 0;
   strSelVal = document.getElementById('hdnthick').value;
   if(strSelVal.length > 1)
   {
     numWallThickness = parseInt(strSelVal.substring(0,1));
     numBoardThickness = parseInt(strSelVal.substring(1));
   }
   else
   {
     numWallThickness = parseInt(document.getElementById('hdnthick').value);
     numBoardThickness = parseInt(document.getElementById('hdnthick').value);
   }

   // End Added New Section
   var numDepth =parseInt(document.getElementById('hdndepth').value);
   var totalWalls = 0;
   var totalBoards = 0;
   for(var m=1;m<=totalcol;m++)
   {
       var numRows = parseInt(document.getElementById('txtrows'+m).value);
       var numColHeight = parseInt(document.getElementById('txtheight'+m).value);
       var numColWidth  = parseInt(document.getElementById('txtwidth'+m).value);
       var noofvertwall = 1;
       var numColumnVolume = 0;
       if(m == 1)
       {
           if(totalcol > 1)
           {
             var numNextColHeight = parseInt(document.getElementById('txtheight'+(m+1)).value);
             if(numColHeight > numNextColHeight)
                noofvertwall = 2;
           }
           else
             noofvertwall = 2;
       }
       else
       {
           if(m == totalcol)
           {
               var numPrevColHeight = parseInt(document.getElementById('txtheight'+(m-1)).value);
               if(numColHeight >= numPrevColHeight)
                  noofvertwall = 2;
           }
           else
           {
               var numNextColHeight = parseInt(document.getElementById('txtheight'+(m+1)).value);
               var numPrevColHeight = parseInt(document.getElementById('txtheight'+(m-1)).value);
               if(numColHeight >= numPrevColHeight && numColHeight > numNextColHeight)
                  noofvertwall = 2;
               if(numColHeight< numPrevColHeight && numColHeight < numNextColHeight)
                  noofvertwall = 0;

           }
       }
       if(document.getElementById('txtsockel'+m).checked == true)
          numRows = numRows + 1;

       numColumnVolume = parseFloat((numColHeight * noofvertwall * numDepth * numWallThickness) + (numColWidth *  numDepth  * numBoardThickness * numRows));
       if(document.getElementById('txtsockel'+m).checked == true)
         numColumnVolume = numColumnVolume + parseFloat(baseHeight * numColWidth * numBoardThickness);

       numColumnVolume = parseFloat(numColumnVolume)/1000000;
       numTotalVolume = parseFloat(numTotalVolume) + parseFloat(numColumnVolume);

       totalBoards = parseFloat(totalBoards) + parseFloat(numRows);

   }
   totalWalls = parseFloat(totalcol) + 1;

   var totalWallPrices = parseFloat(fixWallPrice) * parseFloat(totalWalls);
   var totalBoardPrices = parseFloat(fixBoardPrice) * parseFloat(totalBoards);

   var totalProdWallPrices = parseFloat(prodfixWallPrice) * parseFloat(totalWalls);
   var totalProdBoardPrices = parseFloat(prodfixBoardPrice) * parseFloat(totalBoards);

   var numNetProdValue = parseFloat(prodfixPrice) + (parseFloat(numTotalVolume) * parseFloat(prodwoodPrice));

   numDoorValue = 0;
   get_BackWallCalculation();

   var numNetValue = parseFloat(fixPrice);
   var numPendingVolume = parseFloat(numTotalVolume);
   var numChargedVolume = 0;
   var numWoodtypevalue = document.getElementById('hdnwoodtype').value;
   var numWoodcolorvalue = document.getElementById('hdnwoodcolor').value;

   var numColorFactor = document.getElementById('txtselwoodcolorfactor_'+numWoodtypevalue+'_'+numWoodcolorvalue).value;
   for(var m=0;m<3;m++)
   {
       if(numPendingVolume > (parseFloat(priceRangeVolumeTo[m])-parseFloat(priceRangeVolumeFrom[m])))
       {
          numPendingVolume = numPendingVolume - (parseFloat(priceRangeVolumeTo[m]) - parseFloat(priceRangeVolumeFrom[m]));
          numChargedVolume = (parseFloat(priceRangeVolumeTo[m]) - parseFloat(priceRangeVolumeFrom[m]));
          numNetValue = numNetValue + (numChargedVolume * parseFloat(priceRange[m]) * numColorFactor);
       }
       else
       {
          numChargedVolume = numPendingVolume;
          numNetValue = numNetValue + (numChargedVolume * parseFloat(priceRange[m]) * numColorFactor);
          break;
       }
   }

   var numFixSockleCutPrice = 0;
   var numFixAddHolePrice = 0;
   var numOneBoardOnTopValue = 0;
   if(document.getElementById('txtsockelcut').checked == true)
   {
       numFixSockleCutPrice = parseFloat(fixSockleCutPrice);
   }
   if(document.getElementById('txtaddhole').checked == true)
   {
       numFixAddHolePrice = parseFloat(fixAddHolePrice);
   }
   if(document.getElementById('txtcontinueslab').checked == true)
   {
       numOneBoardOnTopValue = parseFloat(oneBoardOnTopPrice);
   }

   numNetValue = Math.round(numNetValue*Math.pow(10,2))/Math.pow(10,2);
   numNetProdValue = Math.round(numNetProdValue*Math.pow(10,2))/Math.pow(10,2);
   numNetValue = numNetValue + numDoorValue + numBackWallValue + totalWallPrices + totalBoardPrices + numFixSockleCutPrice + numFixAddHolePrice + numOneBoardOnTopValue;

   // Using Conversion Factor for Each Currency...
   var numCurrencyFactor = document.getElementById('txtexchangerate').value;
   var strCurrencySymbol = document.getElementById('txtcurrencysymbol').value;
   var strCurrencySymbolPosition = document.getElementById('txtcurrencysymbolpositionind').value;
   numNetValueInSelCurr = parseFloat(numNetValue) / parseFloat(numCurrencyFactor);

   numNetValueWithoutVat = numNetValue;
   numNetValueWithoutVatInSelCurr = numNetValueInSelCurr;

   var numVatAmount = parseFloat(numNetValue) * parseFloat(numVatPer)/100;
   var numVatAmountInSelCurr = parseFloat(numNetValueInSelCurr) * parseFloat(numVatPer)/100;

   document.getElementById('txtgrossprice').value = numNetValue;
   document.getElementById('txtactualgrossprice').value = numNetValue;

   numNetValue = parseFloat(numNetValue) + parseFloat(numVatAmount);
   numNetValue = Math.round(numNetValue*Math.pow(10,2))/Math.pow(10,2);

   numNetValueInSelCurr = parseFloat(numNetValueInSelCurr) + parseFloat(numVatAmountInSelCurr);
   numNetValueInSelCurr = Math.round(numNetValueInSelCurr*Math.pow(10,2))/Math.pow(10,2);

   if(strCurrencySymbolPosition == 'P')
	document.getElementById('netprice').innerHTML  = '&nbsp;<strong>'+ strCurrencySymbol + Math.round(numNetValueInSelCurr)+'</strong>';
   else
	document.getElementById('netprice').innerHTML  = '&nbsp;<strong>'+ Math.round(numNetValueInSelCurr)  + ' '+strCurrencySymbol+'</strong>';

   //document.getElementById('totaltress').innerHTML = '<?=$field_caption[30]?> <strong>'+Math.round(numNetValueWithoutVatInSelCurr/200)+'</strong>';

   document.getElementById('txtnetprice').value = numNetValue
   document.getElementById('txttrees').value = Math.round(numNetValueWithoutVat/200)
   var pricem2 = woodprice * strBoardThickness/100;

   document.getElementById('txttotalvolume').value = numTotalVolume;

}

function get_BackWallCalculation()
{
    numBackWallValue = 0;
    numProdBackWallValue = 0;
    var sWidth = document.getElementById('txtdispwidth').value;
    var sHeight = document.getElementById('txtdispheight').value;
    if(document.getElementById('txtbackwall').checked == true)
    {
        numBackWallValue = parseFloat(bwfixPrice) + (parseFloat(sWidth) * parseFloat(sHeight) * parseFloat(bwPrice))/10000;
        numProdBackWallValue = parseFloat(prodbwfixPrice) + (parseFloat(sWidth) * parseFloat(sHeight) * parseFloat(prodbwPrice))/10000;
    }
    else
    {
        numBackWallValue = 0;
        numProdBackWallValue = 0;
    }
}

function changeDepth()
{
  fn_calculatePrice();
}

function changeColor(selInd)
{
  strWoodColor = document.getElementById('txtselwoodcolor_'+selInd).value;
  changeThickness('C');
}

function changeThickness(strOpt)
{
  strSelVal = document.getElementById('hdnthick').value;
  if(strSelVal.length > 1)
  {
    strWallThickness = strSelVal.substring(0,1);
    strBoardThickness = strSelVal.substring(1);
  }
  else
  {
    strWallThickness = document.getElementById('hdnthick').value;
    strBoardThickness = document.getElementById('hdnthick').value;
  }

  //strBoardThickness = document.getElementById('hdnthick').value;
  setBoardThickness = strBoardThickness + 'px';
  setWallThickness = strWallThickness + 'px';
  //setThickness = strBoardThickness + 'px';
  setThickness1 = (parseInt(strBoardThickness) + parseInt(numSockelHeight)) + 'px';

  CSSrules(0,true,true,true,true,false);
  CSSrules(1,true,true,false,true,false);
  CSSrules(2,true,true,false,false,false);
  CSSrules(3,true,true,true,false,false);
  CSSrules(4,false,true,false,false,false);
  CSSrules(5,false,true,true,false,false);
  CSSrules(6,false,true,true,true,false);
  CSSrules(7,false,true,false,true,false);
  CSSrules(8,true,false,false,false,false);
  CSSrules(9,true,false,false,true,false);
  CSSrules(10,true,false,true,true,false);
  CSSrules(11,true,false,true,false,false);
  CSSrules(12,false,false,false,true,false);
  CSSrules(13,false,false,true,true,false);

  CSSrules(14,true,true,true,true,true);
  CSSrules(15,true,true,false,true,true);
  CSSrules(19,false,true,true,true,true);
  CSSrules(16,false,true,false,true,true);
  CSSrules(17,true,false,false,true,true);
  CSSrules(20,true,false,true,true,true);
  CSSrules(18,false,false,false,true,true);
  CSSrules(21,false,false,true,true,true);
  CSSrules(22,true,true,false,false,true);
  CSSrules(23,true,true,true,false,true);
  CSSrules(24,true,false,true,false,true);
  CSSrules(25,true,false,false,false,true);
  CSSrules(26,false,true,true,false,true);
  CSSrules(27,false,true,false,false,true);

  CSSrules(28,false,false,true,false,true);
  CSSrules(29,false,false,true,false,false);

  CSSrules(30,false,false,false,false,true);
  CSSrules(31,false,false,false,false,false);

  show_hidecolumns(totalcol,strOpt);
  var woodtypeindex = document.getElementById('hdnwoodtype').selectedIndex;
  var thickindex = document.getElementById('hdnthick').selectedIndex;
  var arrIndex = (parseInt(woodtypeindex) * parseInt(totalthickness) ) + parseInt(thickindex);
  woodprice = document.getElementById('txtwoodprice'+arrIndex).value;

  fixPrice = document.getElementById('txtwoodfixprice'+arrIndex).value;
  doorPrice = document.getElementById('txtdoorprice'+arrIndex).value;
  doorfixPrice = document.getElementById('txtdoorfixprice'+arrIndex).value;
  bwPrice = document.getElementById('txtbwprice'+arrIndex).value;
  oneBoardOnTopPrice = document.getElementById('txtoneboardontopprice'+arrIndex).value;
  bwfixPrice = document.getElementById('txtbwfixprice'+arrIndex).value;
  fixWallPrice = document.getElementById('txtfixwallprice'+arrIndex).value;
  fixBoardPrice = document.getElementById('txtfixboardprice'+arrIndex).value;
  fixAddHolePrice = document.getElementById('txtfixaddholeprice'+arrIndex).value;
  fixSockleCutPrice = document.getElementById('txtfixsocklecutprice'+arrIndex).value;
  prodwoodPrice = document.getElementById('txtprodwoodprice'+arrIndex).value;
  prodfixPrice = document.getElementById('txtprodwoodfixprice'+arrIndex).value;
  proddoorPrice = document.getElementById('txtproddoorprice'+arrIndex).value;
  proddoorfixPrice = document.getElementById('txtproddoorfixprice'+arrIndex).value;
  prodbwPrice = document.getElementById('txtprodbwprice'+arrIndex).value;
  prodbwfixPrice = document.getElementById('txtprodbwfixprice'+arrIndex).value;
  prodfixWallPrice = document.getElementById('txtprodfixwallprice'+arrIndex).value;
  prodfixBoardPrice = document.getElementById('txtprodfixboardprice'+arrIndex).value;

  for(var m=0;m<3;m++)
  {
    priceRangeVolumeFrom[m] = document.getElementById('txtwoodprice_volumefrom'+arrIndex+'_'+m).value;
    priceRangeVolumeTo[m] = document.getElementById('txtwoodprice_volumeto'+arrIndex+'_'+m).value;
    priceRange[m] = document.getElementById('txtwoodthickness_price'+arrIndex+'_'+m).value;
  }
  fn_calculatePrice();
}

function changeWoodType()
{
  var woodtypeindex = document.getElementById('hdnwoodtype').selectedIndex;
  var thickindex = document.getElementById('hdnthick').selectedIndex;
  var arrIndex = (parseInt(woodtypeindex) * parseInt(totalthickness) ) + parseInt(thickindex);
  woodprice = document.getElementById('txtwoodprice'+arrIndex).value;

  fixPrice = document.getElementById('txtwoodfixprice'+arrIndex).value;
  doorPrice = document.getElementById('txtdoorprice'+arrIndex).value;
  doorfixPrice = document.getElementById('txtdoorfixprice'+arrIndex).value;
  bwPrice = document.getElementById('txtbwprice'+arrIndex).value;
  oneBoardOnTopPrice = document.getElementById('txtoneboardontopprice'+arrIndex).value;
  bwfixPrice = document.getElementById('txtbwfixprice'+arrIndex).value;
  fixWallPrice = document.getElementById('txtfixwallprice'+arrIndex).value;
  fixBoardPrice = document.getElementById('txtfixboardprice'+arrIndex).value;
  fixAddHolePrice = document.getElementById('txtfixaddholeprice'+arrIndex).value;
  fixSockleCutPrice = document.getElementById('txtfixsocklecutprice'+arrIndex).value;
  prodwoodPrice = document.getElementById('txtprodwoodprice'+arrIndex).value;
  prodfixPrice = document.getElementById('txtprodwoodfixprice'+arrIndex).value;
  proddoorPrice = document.getElementById('txtproddoorprice'+arrIndex).value;
  proddoorfixPrice = document.getElementById('txtproddoorfixprice'+arrIndex).value;
  prodbwPrice = document.getElementById('txtprodbwprice'+arrIndex).value;
  prodbwfixPrice = document.getElementById('txtprodbwfixprice'+arrIndex).value;
  prodfixWallPrice = document.getElementById('txtprodfixwallprice'+arrIndex).value;
  prodfixBoardPrice = document.getElementById('txtprodfixboardprice'+arrIndex).value;

  for(var m=0;m<3;m++)
  {
    priceRangeVolumeFrom[m] = document.getElementById('txtwoodprice_volumefrom'+arrIndex+'_'+m).value;
    priceRangeVolumeTo[m] = document.getElementById('txtwoodprice_volumeto'+arrIndex+'_'+m).value;
    priceRange[m] = document.getElementById('txtwoodthickness_price'+arrIndex+'_'+m).value;
  }
  fn_calculatePrice();
}

function fn_enablesockelheightwidth()
{
  if(document.getElementById('txtsockelcut').checked == true)
  {
     document.getElementById('txtsockelwidth').disabled = false;
     document.getElementById('txtsockelheight').disabled = false;
  }
  else
  {
     document.getElementById('txtsockelwidth').disabled = true;
     document.getElementById('txtsockelheight').disabled = true;
  }

}

function fillRows(selectedCol,tRows)
{
  var myselect=document.getElementById('txtrows'+selectedCol);
  for (var i=myselect.options.length-1; i>0; i--)
  {
      myselect.options[myselect.options.length-1] =  null;
  }
  var selHeight = document.getElementById('txtheight'+selectedCol).value;
  var reduceHeight = parseInt(strBoardThickness)* 2;
  var netHeight = selHeight;
  if(document.getElementById('txtsockel'+selectedCol).checked == false)
     netHeight =  Math.round((parseInt(selHeight) - parseInt(reduceHeight)));
  else
     netHeight =  Math.round((parseInt(selHeight) - parseInt(reduceHeight)  - parseInt(numSockelHeight)));
  var minDist = parseInt(minrow_dist) + parseInt(strBoardThickness);
  var maxCol = parseInt(netHeight/minDist);
  for(var i= 2; i<=maxCol; i++)
  {
      if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
         myselect.add(new Option(i, i),(i-1));
      else
         myselect.add(new Option(i, i),myselect.options[i-1]);
  }

}



function fn_validate()
{
  for(var i=1; i<=totalcol; i++)
  {
    if(totalcol == 1)
       document.getElementById('txtwidth'+i).disabled = false;
    nRows = document.getElementById('txtrows'+i).value;
    if(nRows == '1')
        document.getElementById('txtnewrowsboarddist1_'+i).disabled = false;
  }

  if(document.getElementById('txtsockelcut').checked == true)
  {
      if(document.getElementById('txtsockelwidth').value == '')
      {
          document.getElementById('diverrmessage').style.display ='block';
          document.getElementById('diverrmessage').innerHTML = 'Bitte gebe die Tiefe der Fußleiste ein.';
          document.getElementById('diverrmessage').scrollIntoView();
          document.getElementById('txtsockelwidth').focus();
          return false;
      }
      else { if(isNaN(document.getElementById('txtsockelwidth').value)) { alert('Bitte gebe die Tiefe der Fußleiste ein.'); document.getElementById('txtsockelwidth').focus(); return; }  }

      if(document.getElementById('txtsockelheight').value == '') { alert('Bitte gebe die Höhe der Fußleiste ein'); document.getElementById('txtsockelheight').focus(); return; }
      else { if(isNaN(document.getElementById('txtsockelheight').value)) { alert('Bitte gebe die Höhe der Fußleiste ein'); document.getElementById('txtsockelheight').focus(); return;  } }
  }

  fn_calculatePrice();

  //document.getElementById('hdnshadecolor').value = strShadeColor;

  //document.theForm.action='generateImage.php';
  //document.theForm.submit();
}

function fn_resetErrorMessage()
{
  document.getElementById('diverrmessage').style.display ='none';
  document.getElementById('diverrmessage').innerHTML  = '';
}

var selectedHeight = actualdesignheight;

function fn_getDefaultHeight(strVal)
{
    //selectedHeight = strVal;
}

function fillHeightDropDown(selectedCol)
{
  var myselect=document.getElementById('txtheight'+selectedCol);
  seledtedHeight = myselect.value;
  for (var i=myselect.options.length-1; i>=0; i--)
  {
      myselect.options[myselect.options.length-1] =  null;
  }
  var iRow = parseInt(minrow_dist);
  if(document.getElementById('txtsockel'+selectedCol).checked == true)
      iRow = iRow + parseInt(numSockelHeight) + (parseInt(strBoardThickness)* 2)
  else
      iRow = iRow + parseInt(strBoardThickness);

  var j=0;
  for(var i= iRow; i<=actualdesignheight; i++)
  {
      if(browserversion.indexOf('MSIE') >= 0) // 'Microsoft Internet Explorer 6, 8 and above'
         myselect.add(new Option(i, i),j);
      else
         myselect.add(new Option(i, i),myselect.options[j]);
      //myselect.add(new Option(i, i),j);
      j++;
  }
  if(selectedHeight >= iRow && selectedHeight <= actualdesignheight)
     document.getElementById('txtheight'+selectedCol).value = selectedHeight;
  else
     document.getElementById('txtheight'+selectedCol).value = actualdesignheight;

}

function fn_savedesign()
{
  for(var i=1; i<=totalcol; i++)
  {
    if(totalcol == 1)
       document.getElementById('txtwidth'+i).disabled = false;
    nRows = document.getElementById('txtrows'+i).value;
    if(nRows == '1')
        document.getElementById('txtrowsboarddist1_'+i).disabled = false;
  }

  if(document.getElementById('txtsockelcut').checked == true)
  {
      if(document.getElementById('txtsockelwidth').value == '') { alert('Bitte gebe die Tiefe der Fußleiste ein.'); document.getElementById('txtsockelwidth').focus(); return; }
      else { if(isNaN(document.getElementById('txtsockelwidth').value)) { alert('Bitte gebe die Tiefe der Fußleiste ein.'); document.getElementById('txtsockelwidth').focus(); return; }  }

      if(document.getElementById('txtsockelheight').value == '') { alert('Bitte gebe die Höhe der Fußleiste ein'); document.getElementById('txtsockelheight').focus(); return; }
      else { if(isNaN(document.getElementById('txtsockelheight').value)) { alert('Bitte gebe die Höhe der Fußleiste ein'); document.getElementById('txtsockelheight').focus(); return;  } }
  }

  var emailObj =document.getElementById('txtsaveemailadd');
  if(!checkNullAlert(emailObj,"<?=$errMessage[7]?>")) { return;  }
  if(!emailCheckAlert(emailObj.value,"<?=$errMessage[11]?>")) { return; }
  document.theForm.regemailadd.value = emailObj.value;
  document.theForm.action = 'savedesign.php';
  document.theForm.submit();
}


function fn_select()
{
   var emailObj =document.getElementById('txtsaveemailadd');
   if(emailObj.value == '<?=$field_caption[66]?>')
      emailObj.value = '';
}

function fn_blur()
{
   var emailObj =document.getElementById('txtsaveemailadd');
   if(emailObj.value == '')
      emailObj.value = '<?=$field_caption[66]?>';
}

function fn_openVideo()
{
	window.open('regalvideo.php','Video','width=930,height=530,toolbar=0,location=0,directories=0,resizable=0,status=0,menubar=0,scrollbars=0');
}

changeThickness('L');
fn_enablesockelheightwidth();

/*
function backstep(e)
{

    var dont_confirm_leave = 1; //set dont_confirm_leave to 1 when you want the user to be able to leave withou confirmation
    var leave_message = 'You sure you want to leave?'
	if(dont_confirm_leave!==1)
    {
        if(!e) e = window.event;
        //e.cancelBubble is supported by IE - this will kill the bubbling process.
        e.cancelBubble = true;
        e.returnValue = leave_message;
        //e.stopPropagation works in Firefox.
        if (e.stopPropagation)
        {
            e.stopPropagation();
            e.preventDefault();
        }
        //return works for Chrome and Safari
        return leave_message;
    }

	alert('ff');
	return null;
}
window.onbeforeunload=backstep;
*/

</script>
</html>