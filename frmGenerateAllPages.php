<?
include('admintop.php');
include('frmGenerateHomePage.php');
$indexslides = "";
$homepageind = 0;
include('frmGenerateAccessoriesPage.php');
include('frmGenerateProductPage.php');
include('frmGenerateCategoryPages.php');
include('frmGenerateServicePages.php');
include('frmGenerateContentPages.php');

include('frmGenerateFAQPages.php');
include('frmGenerateGalleryPage.php');
include('frmGenerateShowRoomPage.php');

include('frmGenerateSustainPage.php');
include('frmGenerateWoodSamplePage.php');

include('frmGenerateTableCategoryPages.php');
include('frmGenerateTableGalleryPage.php');
include('frmGenerateTableProductPage.php');
include('frmGenerateTableWoodSample.php');
?>
<tr height=98% align=center>
    <td bgcolor="#FFFFFF" valign=top>
        <table width=100%  border="0" cellspacing="0" cellpadding="0" align=center>
               <tr height=20><td >&nbsp;</td></tR>
               <tr>
                   <td align=center ><table width="98%" border="2" cellpadding="0" cellspacing="0" bordercolor="#2F6AA4" align=center>
                       <tr><td>
                             <form name=theForm action="frmDiscountVoucherUpdate.php" method="post">
                             <table border=0 width=100% cellpadding="0" cellspacing="0">
                               <tr>
                               <td class="title" width=100% align=center>All Pages Generated Successfully</tD>
                               </tR>
                               <tr>
                               <td height="20">&nbsp;</tD>
                               </tR>
                               <tr>
                               <td align="center" style="font-size:15px;"><?=$message?></tD>
                               </tR>
                               <tr>
                               <td height="20">&nbsp;</tD>
                               </tR>
                             </table>
                             </form>
                       </td></tr>
                   </table></td>
               </tr>
        </table>
    </td>
</tr>
<?
include('adminbottom.php');
?>


