<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id=$_SESSION['user_id'];
$order_id=$_REQUEST['order_id'];

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

//Get user data, path of this function (get_user_data) admin/include/functions.php
$user_data = get_user_data($user_id);

require_once(CP_ROOT_PATH."/libraries/BarcodeQR.php");

// set BarcodeQR object
$qr = new BarcodeQR();

$margin='3';

$qr->text($order_id);
$qr->draw(100,SITE_URL.'images/qrcode.png',$margin);

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:20px;
  font-weight:bold;
}
</style>
EOF;

$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">
  <tr>
    <td colspan="3" class="small-text">Please refer to Posting Instructions</td>
  </tr>
  <tr>
    <td class="block small-text">
      Option 1 Label - Print at 100% (actual size)
    </td>
    <td class="divider"></td>
    <td class="block small-text">
      Option 2 Label - Print at 100% (actual size)
    </td>
  </tr>
  <tr>
    <td class="block-border" width="45%";><table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px; border:1px solid #333">
        <tr>
          <td class="title" style="border:1px solid #333">Tracked 48</td>
        </tr>
        <tr>
          <td style="border:1px solid #333;">Delivered by ROYAL MAIL Postage paid GB</td>
        </tr>
        <tr>
          <td style="border:1px solid #333; text-align:center;"><img src="'.SITE_URL.'images/qrcode.png"></td>
        </tr>
        <tr>
          <td class="small-text" style="border:1px solid #333; text-align:center;">
          <b>'.$general_setting_data['company_name'].'</b><br>
          '.$general_setting_data['company_address'].',<br>
		  '.$general_setting_data['company_country'].', '.$general_setting_data['company_state'].', '.$general_setting_data['company_city'].' '.$general_setting_data['company_zipcode'].'<br>
          '.$general_setting_data['company_phone'].'
          </td>
        </tr>
        <tr>
          <td class="small-text" style="border:1px solid #333; text-align:center;">
          <b>Sender</b><br />
          '.$user_data['name'].'<br>
          '.$user_data['address'].',<br>
          '.$user_data['address2'].',<br>
          '.($user_data['country']?$user_data['country'].', ':'').$user_data['state'].', '.$user_data['city'].' '.$user_data['postcode'].'<br>
          '.$user_data['phone'].'
          </td>
        </tr>
        <tr>
          <td style="border:1px solid #333; text-align:center;">Customer reference: <b>'.$order_id.'</b></td>
        </tr>
      </table>
    </td>
    <td class="divider" width="10%"></td>
    <td class="block-border" width="45%"><table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px; border:1px solid #333">
        <tr>
          <td class="title">Special Delivery</td>
        </tr>
        <tr>
          <td style="border:1px solid #333;">POSTAGE TO BE PAID BY SENDER</td>
        </tr>
        <tr>
          <td class="small-text" style="border:1px solid #333;">
          <b>'.$general_setting_data['company_name'].'</b><br>
          '.$general_setting_data['company_address'].',<br>
		  '.$general_setting_data['company_country'].', '.$general_setting_data['company_state'].', '.$general_setting_data['company_city'].' '.$general_setting_data['company_zipcode'].'<br>
          '.$general_setting_data['company_phone'].'
          </td>
        </tr>
        <tr>
          <td class="small-text" style="border:1px solid #333;">
          <b>Sender</b><br />
          '.$user_data['name'].'<br>
          '.$user_data['address'].',<br>
          '.$user_data['address2'].',<br>
          '.($user_data['country']?$user_data['country'].', ':'').$user_data['state'].', '.$user_data['city'].' '.$user_data['postcode'].'<br>
          '.$user_data['phone'].'
          </td>
        </tr>
        <tr>
          <td style="border:1px solid #333;">
            Customer reference: <b>'.$order_id.'</b>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
';
require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information
$pdf->SetCreator($general_setting_data['from_name']);
$pdf->SetAuthor($general_setting_data['from_name']);
$pdf->SetTitle($general_setting_data['from_name']);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// add a page
$pdf->AddPage();

$pdf->writeHtml($html);

ob_end_clean();

$pdf->Output('pdf/free_post_label-'.date('Y-m-d-H-i-s').'.pdf', 'I');
?>
