<?php
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_trade.blackmarketbilling.lang.php';
//in dieser datei werden die billing-infos angezeigt
//kreditkarte
if($_REQUEST["use"]=='1')
{
}
//lastschrift
elseif($_REQUEST["use"]=='2')
{
}
//�berweisung
elseif($_REQUEST["use"]=='3')
{
  rahmen_oben($tradeblackmarketbilling_lang[cperueb].' <a href="trade.php?viewmode=blackmarket&showpcs=1">('.$tradeblackmarketbilling_lang[zurueck].')</a>');
  echo '<table width="580">';
  echo '<tr class="cl"><td>
	'.$tradeblackmarketbilling_lang[msg_1_1].'
	<br>"'.$ums_spielername.' - '.getDefaultVariable('sv_server_tag').$ums_user_id.'"</b><br>
  	'.$tradeblackmarketbilling_lang[msg_1_2].'
  </td></tr>';
  echo '</table>';
  rahmen_unten();
}
//sms
elseif($_REQUEST["use"]=='4')
{
  rahmen_oben($tradeblackmarketbilling_lang[cpersms].' <a href="trade.php?viewmode=blackmarket&showpcs=1">('.$tradeblackmarketbilling_lang[zurueck].')</a>');
  echo '<table width="580">';
  echo '<tr class="cl"><td>
  '.$tradeblackmarketbilling_lang[msg_2_1].' '.getDefaultVariable('sv_pcs_id').$ums_user_id.'</b>'.$tradeblackmarketbilling_lang[msg_2_2].'<br><br>
  <img src="smilies/de.gif" alt="Deutschland"> <b>46645</b><br>
  '.$tradeblackmarketbilling_lang[msg_2_4].'
  <br><br><img src="smilies/at.gif" alt="&Ouml;sterreich"> <b>0930 700 900</b><br>
  '.$tradeblackmarketbilling_lang[msg_2_3].'<br><br><b>'.$tradeblackmarketbilling_lang[smsleerzeichen].'</b>
  </td></tr></table>';
  //86566
  //0930 700 900
  rahmen_unten();
}
//telefon
elseif($_REQUEST["use"]=='5')
{
  rahmen_oben($tradeblackmarketbilling_lang[cpertel].' <a href="trade.php?viewmode=blackmarket&showpcs=1">('.$tradeblackmarketbilling_lang[zurueck].')</a>');
  echo '<table width="580">';
  echo '<tr class="cl"><td><b>'.$tradeblackmarketbilling_lang[msg_3].'</b><br><br>
  <img src="smilies/de.gif" alt="Deutschland"> <b>0900 33 666 544</b> (1,99 '.$tradeblackmarketbilling_lang[eurmin].')<br><br>
  <img src="smilies/at.gif" alt="&Ouml;sterreich"> <b>0900 544 711</b> (3,63 '.$tradeblackmarketbilling_lang[eurmin].')<br><br>
  '.$tradeblackmarketbilling_lang[telid].': '.getDefaultVariable('sv_pcs_id').$ums_user_id.'
  </td></tr></table>';
  rahmen_unten();
  //0900 33 666 544
  //0900 544 711
}
//paypal
elseif($_REQUEST["use"]=='6')
{
  rahmen_oben('Credits per PayPal <a href="trade.php?viewmode=blackmarket&showpcs=1">(zur&uuml;ck)</a>');
  echo '<table width="580">';
  echo '<tr class="cl"><td align="center">';
echo '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" >
   <input type="hidden" name="cmd" value="_xclick">
   <input type="hidden" name="business" value="issomad@die-ewigen.com">
   <input type="hidden" name="item_name" value="EWIGEN '.getDefaultVariable('sv_pcs_id').$ums_user_id.'">
   <input type="hidden" name="item_number" value="1">
   <input type="hidden" name="no_shipping" value="2">
   <input type="hidden" name="no_note" value="1">
   <input type="hidden" name="currency_code" value="EUR">
   <input type="hidden" name="bn" value="IC_Beispiel">
<select name="amount">';

//auswahlfeld bauen
for($i=1;$i<=20;$i++)
{
  $credits=round(($i-($i/100*1.9)-0.35)*173);
  if($i==10)$selected='selected';else $selected='';
  echo '<option value="'.$i.'.00" '.$selected.'>'.$i.',00 Euro - '.$credits.' Credits</option>';
}

for($i=25;$i<=100;$i=$i+5)
{
  $credits=round(($i-($i/100*1.9)-0.35)*173);
  if($i==10)$selected='selected';else $selected='';
  echo '<option value="'.$i.'.00" '.$selected.'>'.$i.',00 Euro - '.$credits.' Credits</option>';
}




echo '</select></div>
   <input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but01.gif" style="width:70px;height:31px;border:0;margin-top:8px" name="submit" alt="Bezahlen Sie mit PayPal - schnell, einfach und sicher!">
</div>
   <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>';
echo '<br>'.$tradeblackmarketbilling_lang[msg_4_2].'<br><br>';
  echo '</td></tr>';
  echo '</table>';
  rahmen_unten();
}


//wenn nichts ausgew�hlt wurde, dann einfach alle m�glichen zahlungswege aufzeigen
//tabelle mit 2 spalten um die sachen nebeneinander anzeigen zu k�nnen
if(!isset($_REQUEST["use"]))
{
  echo '<table width=600>';
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  //linke seite
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////

  echo '<tr align="center"><td valign="top">';
  $hoehe=120;
  /*
  //kreditkarte
  rahmen_oben('Kreditkarte (DE & International)');
  echo '<table width="250">';
  echo '<tr height="'.$hoehe.'"><td class="cell" align="center"><a href="trade.php?viewmode=blackmarket&showpcs=1&use=1"><img src="smilies/visa.gif" border="0"><img src="smilies/mastercard.gif" border="0"><br><br>weiter</a></td></tr>';
  echo '</table>';
  rahmen_unten();*/

  //�berweisung
  rahmen_oben($tradeblackmarketbilling_lang[uebdeint]);
  echo '<table width="250">';
  echo '<tr height="'.$hoehe.'"><td class="cell" align="center"><a href="trade.php?viewmode=blackmarket&showpcs=1&use=3"><img src="smilies/ueberweisung.gif" border="0"><br><br>'.$tradeblackmarketbilling_lang[weiter].'</a></td></tr>';
  echo '</table>';
  rahmen_unten();

  //telefon
  rahmen_oben($tradeblackmarketbilling_lang[teldeat]);
  echo '<table width="250">';
  echo '<tr height="'.$hoehe.'"><td class="cell" align="center"><a href="trade.php?viewmode=blackmarket&showpcs=1&use=5"><img src="smilies/telefon.gif" border="0"><br><br>'.$tradeblackmarketbilling_lang[weiter].'</a></td></tr>';
  echo '</table>';
  rahmen_unten();

  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  //rechte seite
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  echo '</td><td valign="top">';
  /*
  //lastschrift
  rahmen_oben('Lastschrift (DE)');
  echo '<table width="250">';
  echo '<tr height="'.$hoehe.'"><td class="cell" align="center"><a href="trade.php?viewmode=blackmarket&showpcs=1&use=2"><img src="smilies/lastschrift.gif" border="0"><br><br>weiter</a></td></tr>';
  echo '</table>';
  rahmen_unten();*/

  //sms
  rahmen_oben($tradeblackmarketbilling_lang[smsdeat]);
  echo '<table width="250">';
  echo '<tr height="'.$hoehe.'"><td class="cell" align="center"><a href="trade.php?viewmode=blackmarket&showpcs=1&use=4"><img src="smilies/handy.gif" border="0"><br><br>'.$tradeblackmarketbilling_lang[weiter].'</a></td></tr>';
  echo '</table>';
  rahmen_unten();

  //paypal
  rahmen_oben($tradeblackmarketbilling_lang[ppaldeat]);
  echo '<table width="250">';
  echo '<tr height="'.$hoehe.'"><td class="cell" align="center"><a href="trade.php?viewmode=blackmarket&showpcs=1&use=6"><img src="smilies/paypal.gif" border="0"><br><br>'.$tradeblackmarketbilling_lang[weiter].'</a></td></tr>';
  echo '</table>';
  rahmen_unten();

  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  //gro�e anzeigetabelle zu
  echo '</td></tr></table>';
}

echo '<span class="info_box"><span class="text3">'.$tradeblackmarketbilling_lang[paysafecardavailable].'</span></span>';


//disclaimer
rahmen_oben($tradeblackmarketbilling_lang[information]);
echo '<table width=580>';
echo '<tr class="cl"><td>'.$tradeblackmarketbilling_lang[msg_5].'</td></tr></table>';
rahmen_unten('');



die('</body></html>');

function rahmen_oben($text)
{
  echo '<table border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td width="13" height="37" class="rol">&nbsp;</td>
        <td align="center" class="ro">'.$text.'</td>
        <td width="13" class="ror">&nbsp;</td>
        </tr>
        <tr>
        <td class="rl">&nbsp;</td><td>';
}

function rahmen_unten()
{
  echo '</td><td width="13" class="rr">&nbsp;</td>
        </tr>
        <tr>
        <td width="13" class="rul">&nbsp;</td>
        <td class="ru">&nbsp;</td>
        <td width="13" class="rur">&nbsp;</td>
        </tr>
        </table><br>';
}
?>
