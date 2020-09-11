<script type="text/javascript">
  function showOrHide(cb, cat) {
    cb = document.getElementById(cb);
    cat = document.getElementById(cat);
    if (cb.checked) cat.style.display = "block";
    else cat.style.display = "none";
  }
  
    function Hide(cb, cat) {
    cb = document.getElementById(cb);
    cat = document.getElementById(cat);
    if (cb.checked) cat.style.display = "none";
  }
</script>
<?php
//ini_set ('display_errors',1);
//ini_set ('error_reporting', E_ALL);
?><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" background="/_pic/tes_titlebg.gif">
	<TR>
		<TD width="13"><IMG src="/_pic/tes_titleleft.gif" width="13" height="35" /></TD>
		<TD class="stitle"><?=$thisRecord->ElementName;?></TD>
		<TD width="13"><IMG src="/_pic/tes_titleright.gif" width="13" height="35" /></TD>
	</TR>
</TABLE>
<DIV style="height:8px;"></DIV>
<?
$cache = Array();
$errors = array();
$formData = array();
$hideForm = false;
$citySQL = getChildren("filial","46","2");
while($city = sql_a($citySQL))
{
	$cache[$city['ElementID']] = $city;
}
if(isset($_POST['act']) && $_POST['act'] == 1)
{
	$formData = $_POST;
	
	if(strlen($formData['departure_name']) < 4)
		$errors['departure_name'] = '�� �������� ����������������';
	
	if(strlen($formData['arrival_name']) < 4)
		$errors['arrival_name'] = '�� �������� ���������������';
	
	if(strlen($formData['departure_fio']) < 4)
		$errors['departure_fio'] = '�� ��������� ���������� ���� ����������������';
	
	if(strlen($formData['arrival_fio']) < 4)
		$errors['arrival_fio'] = '�� ��������� ���������� ���� ���������������';
	
	if(strlen($formData['departure_phone']) < 4)
		$errors['departure_phone'] = '�� �������� ���������� ������� ����������������';
	
	if(strlen($formData['arrival_phone']) < 4)
		$errors['arrival_phone'] = '�� �������� ���������� ������� ���������������';
	
	if(!preg_match("/[-a-z0-9\._]+@[-a-z0-9\._]+\.[a-z]{2,4}/",$formData['sender_email']))
		$errors['sender_email'] = '������� ������ ���������� E-mail';
	
	if(($_POST['strah']==1) and (strlen($formData['platelshik'])<1))
	{
		$errors['platelshik'] = '�� ��������� ���� ��������� ����� (�����������)';
	}
	
	if(($_POST['autodost_departure']==3) and (strlen($formData['autodost_departure3'])<1))
	{
		$errors['autodost_departure3'] = '�� ��������� ���� ���� �������� �� ������ ���������������� ������ ����';
	}
	
	if(($_POST['transfer']==3) and (strlen($formData['transfer_3'])<1))
	{
		$errors['transfer_3'] = '�� ��������� ���� ��������� � �. ���������� ������ ����';
	}
	
	if(($_POST['autodost_arrival']==3) and (strlen($formData['autodost_arrival_3'])<1))
	{
		$errors['autodost_arrival_3'] = '�� ��������� ���� �������� �� ������ ��������������� ������ ����';
	}
	
	if(($_POST['departure_expedition']==1) and (strlen($formData['departure_addr'])<1))
	{
		$errors['departure_addr'] = '�� ��������� ���� ���� �������� �� ������ ����������������';
	}	
	
	if(($_POST['arrival_expedition']==1) and (strlen($formData['arrival_addr'])<1))
	{
		$errors['arrival_addr'] = '�� ��������� ���� ���� �������� �� ������ ���������������';
	}
	
	if(($_POST['cargo_type']==4) and (strlen($formData['okpo'])<1))
	{
		$errors['okpo'] = '�� ��������� ���� ���� ����������';
	}

	if (($_POST['cargo_type']==4)and($_POST['cargo_type_4']==0))
	{
		$errors['cargo_type_4'] = '�� ������ ��� ����������';
	}
	if ($_POST['cargo_type']==0)
	{
		$errors['cargo_type'] = '�� ������ ��� ���������� �������';
	}
	
	if (strlen($_POST['customer_name'])<2)
	{
		$errors['customer_name'] = '�� ��������� ���� �������� ����������� ��������';
	}
	
	if (strlen($_POST['customer_contact'])<2)
	{
		$errors['customer_contact'] = '�� ��������� ���� ���������� ���� ��������';
	}

	if (strlen($_POST['customer_phone'])<2)
	{
		$errors['customer_phone'] = '�� ��������� ���� �������� ��������';
	}
	
	if (strlen($_POST['dat'])<2)
	{
		$errors['dat'] = '�� ��������� ���� ���� �������� ��������';
	}
	
	if ($_POST['departure_expedition']==0)
	{
		$errors['departure_expedition'] = '�� ������� ���� �������� �� ������ ����������������';
	}
	
	if ($_POST['arrival_expedition']==0)
	{
		$errors['arrival_expedition'] = '�� ������� ���� �������� �� ������ ���������������';
	}
		
	if (($_POST['autodost_departure']==0) and ($_POST['departure_expedition']<>2))
	{
		$errors['autodost_departure'] = '�� ������� ���� �������� �� ������ ����������������';
	}	

	if ($_POST['transfer']==0)
	{
		$errors['transfer'] = '�� ������� ��������� � �. ����������';
	}	
	
	if (($_POST['autodost_arrival']==0) and ($_POST['arrival_expedition']<>2))
	{
		$errors['autodost_arrival'] = '�� ������� �������� �� ������ ���������������';
	}	
	
	if ($_POST['cargo_hardpack']==0)
	{
		$errors['cargo_hardpack'] = '�� ������� ������������ ������� ��������';
	}	
	
	if(sizeOf($errors) == 0)
	{
		$createChild = New createChild;
		$now = time();
		$numSQL = sql("SELECT count(*) AS cnt FROM zayavka");
		$num = sql_a($numSQL);
		$real_count = sprintf("%05d",($num['cnt']+1));
		$name = '�'.$real_count;
		
		
		ob_start();
		?>
		<H1 align="center">� <?=$name?></H1>
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="5">
			<TR>
				<th colspan="6">1.��������</th>
			</TR>
			<TR>
				<TD width="20%">��������</TD>
				<TD width="30%"><?=mysql_real_escape_string(proverka_simvolov($_POST['customer_name']));?></TD>
				<TD width="20%">���������� ���� </TD>
				<TD width="30%"><?=mysql_real_escape_string($_POST['customer_contact'])?></TD>
			</TR>
			<TR>
				<TD>��������</TD>
				<TD><?=mysql_real_escape_string($_POST['customer_phone'])?></TD>
				<TD>���� ��������</TD>
				<TD><?=mysql_real_escape_string($_REQUEST['dat'])?></TD>
			</TR>
		</TABLE>
		<BR>
		<TABLE width="100%" border="1" cellpadding="0" cellspacing="5">
			<TR>
				<th colspan="2">2. ����� ����������� </th>
				<th colspan="2">3. ����� ���������� </th>
			</TR>
			<TR>
				<TD width="20%">����� ����������� </TD>
				<TD width="30%"><?=$cache[mysql_real_escape_string($_POST['departure_city'])]['ElementName']?>
				</TD>
				<TD width="20%">����� ���������� </TD>
				<TD width="30%"><?=$cache[mysql_real_escape_string($_POST['arrival_city'])]['ElementName']?></TD>
			</TR>
			<TR>
				<TD>���������������� </TD>
				<TD><?=mysql_real_escape_string(proverka_simvolov($_POST['departure_name']))?></TD>
				<TD>��������������� </TD>
				<TD><?=mysql_real_escape_string(proverka_simvolov($_POST['arrival_name']))?></TD>
			</TR>
			<TR>
				<TD>��� </TD>
				<TD><?=mysql_real_escape_string($_POST['departure_office'])?></TD>
				<TD>��� </TD>
				<TD><?=mysql_real_escape_string($_POST['arrival_office'])?></TD>
			</TR>
			<TR> 
				<TD>���������� ���� </TD> 
				<TD><?=mysql_real_escape_string($_POST['departure_fio'])?></TD> 
				<TD>���������� ���� </TD> 
				<TD><?=mysql_real_escape_string($_POST['arrival_fio'])?></TD> 
			</TR> 
			<TR> 
				<TD>���������� ������� </TD> 
				<TD><?=mysql_real_escape_string($_POST['departure_phone'])?></TD> 
				<TD>���������� �������</TD> 
				<TD><?=mysql_real_escape_string($_POST['arrival_phone'])?></TD> 
			</TR> 
		<TR valign="top">
			<TD >���� �������� �� ������ ���������������� </TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD><INPUT id = "cb_departure_expedition1" name="departure_expedition" type="radio" value="1" <?=mysql_real_escape_string($_POST['departure_expedition'])==1?'checked':''?> />
							��</TD>
						<TD width="50%"><INPUT name="departure_expedition" type="radio" value="2" <?=mysql_real_escape_string($_POST['departure_expedition'])==2?'checked':''?> id = "cb_departure_expedition2"/>
							��� (����������)</TD>
					</TR>
				</TABLE>
				<div id = "cat_cb_departure_addr" >
				����� ������ ���������� ��� ��������:<BR />
				<textarea cols="20" rows="4" name="departure_addr" class="brd wide mandatory" id="departure_addr"><?=mysql_real_escape_string($formData['departure_addr']);?></textarea>
				</div></TD>
				
			<TD >���� �������� �� ������ ���������������</TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<tr>
						<TD><INPUT id = "arrival_expedition1" name="arrival_expedition" type="radio" value="1" <?=mysql_real_escape_string($_POST['arrival_expedition'])==1?'checked':''?> />
							��</TD>
						<TD width="50%"><INPUT id = "cb_arrival_expedition2" name="arrival_expedition" type="radio" value="2" <?=mysql_real_escape_string($_POST['arrival_expedition'])==2?'checked':''?> />
							��� (���������)</TD>
					</tr>
				</TABLE>
				<div id = "cat_cb_arrival_addr">
				����� ������ ���������� ��� ���������:<BR />
				<textarea name="arrival_addr" class="brd wide mandatory" cols="20" rows="4" id="arrival_addr"><?=mysql_real_escape_string($formData['arrival_addr']);?></textarea>
				</div></TD>
		</TR>
			<TR valign="top">
				<TD>����� ������ </TD>
				<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
						<TR>
							<TD width="50%" >�
								<INPUT name="departure_workfrom" class="brd wide" type="text" id="departure_workfrom" style="width:50px;"  value="<?=mysql_real_escape_string($_POST['departure_workfrom'])?>" /></TD>
							<TD > ��
								<INPUT name="departure_workto" class="brd wide" type="text" id="departure_workto" style="width:50px;"  value="<?=mysql_real_escape_string($_POST['departure_workto'])?>" /></TD>
						</TR>
					</TABLE>
					<BR />
					������� �� ����<BR />
					<INPUT name="departure_lanch" class="brd wide" type="text" id="departure_lanch"  value="<?=mysql_real_escape_string($_POST['departure_lanch'])?>" /></TD>
				<TD>����� ������ </TD>
				<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
						<TR>
							<TD width="50%" >�
								<INPUT name="arrival_workfrom" class="brd wide" type="text" id="arrival_workfrom" style="width:50px;" value="<?=mysql_real_escape_string($_POST['arrival_workfrom'])?>" /></TD>
							<TD > ��
								<INPUT name="arrival_workto" class="brd wide" type="text" id="arrival_workto" style="width:50px;" value="<?=mysql_real_escape_string($_POST['arrival_workto'])?>" /></TD>
						</TR>
					</TABLE>
					<BR />
					������� �� ����<BR />
					<INPUT name="arrival_lanch" class="brd wide" type="text" id="arrival_lanch" value="<?=mysql_real_escape_string($_POST['arrival_lanch'])?>" /></TD>
			</TR>
		</TABLE>
		<BR />
		<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
			<TR>
				<th>4. �������� ����� </th>
			</TR>
			<TR>
				<TD><TABLE width="100%" border="1" cellspacing="0" cellpadding="5">
						<TR>
							<th>������������ ����� </th>
							<th>��� (������), �� </th>
							<th>����� ����� (�<sup>3</sup>) </th>
							<th>���-�� ���� </th>
						</TR>
						<?
						for($i = 0; $i < sizeOf($_POST['cargo_name']);$i++)
						{
						?> 
						<TR> 
							<TD><?=mysql_real_escape_string($_POST['cargo_name'][$i])?></TD> 
							<TD><?=mysql_real_escape_string($_POST['cargo_kg'][$i])?></TD> 
							<TD><?=mysql_real_escape_string($_POST['cargo_kub'][$i])?></TD> 
							<TD><?=mysql_real_escape_string($_POST['cargo_mest'][$i])?></TD> 
						</TR> 
						<?}?> 
					</TABLE>
					<TABLE width="100%" border="1" cellpadding="0" cellspacing="5" class="nobrd">
						<TR>
							<TD nowrap>��������� ��� ���������� ������� </TD>
							<TD><TABLE border="0" cellpadding="0" cellspacing="0" class="nobrd">
							<TR>
								<TD nowrap>��������� ��� ���������� ������� </TD>
								<TD><TABLE border="0" cellpadding="0" cellspacing="0" class="nobrd">
								<TR>
								<?=array_key_exists('cargo_type',$errors)?'<div class="error">'.$errors['cargo_type'].'</div>' :''?>
									<TD><INPUT name="cargo_type" id="cb_cargo_type1" type="radio" <?=mysql_real_escape_string($_POST['cargo_type'])==1?'checked':''?> value="1" />
										�����</TD>
									<TD><INPUT name="cargo_type" id="cb_cargo_type2" <?=mysql_real_escape_string($_POST['cargo_type'])==2?'checked':''?> type="radio" value="2" />
										������</TD>
									<TD><INPUT name="cargo_type" id="cb_cargo_type3" <?=mysql_real_escape_string($_POST['cargo_type'])==3?'checked':''?> type="radio" value="3" />
										����</TD>
									<TD><INPUT name="cargo_type" id="cb_cargo_type5" <?=mysql_real_escape_string($_POST['cargo_type'])==5?'checked':''?> type="radio" value="5" />
										����</TD>
									<TD><INPUT name="cargo_type" id="cb_cargo_type4" <?=mysql_real_escape_string($_POST['cargo_type'])==4?'checked':''?> type="radio" value="4" />
										���������</TD>			
									<TD>
									
									<INPUT name="cargo_type_4" type="radio" <?=mysql_real_escape_string($_POST['cargo_type_4'])==1?'checked':''?> value="1" /><font size="1">3��</font>
									<INPUT name="cargo_type_4" type="radio" <?=mysql_real_escape_string($_POST['cargo_type_4'])==2?'checked':''?> value="2" /><font size="1">5��</font>
									<INPUT name="cargo_type_4" type="radio" <?=mysql_real_escape_string($_POST['cargo_type_4'])==3?'checked':''?> value="3" /><font size="1">20��</font>
									<INPUT name="cargo_type_4" type="radio" <?=mysql_real_escape_string($_POST['cargo_type_4'])==4?'checked':''?> value="4" /><font size="1">40��</font>
									<br>���� ����������:<INPUT name="okpo" class="brd wide mandatory" type="text" value="<?=mysql_real_escape_string($formData['okpo']);?>" />
									
									</TD>
								</TR>
							</TABLE></TD>
					</TR>
								</TABLE></TD>
						</TR>
						<TR>
							<TD nowrap>������������ ������� �������� </TD>
							<TD width="90%"><TABLE border="0" cellpadding="0" cellspacing="0" class="nobrd">
										<TR> 
										<TD><INPUT name="cargo_hardpack" type="radio" <?=mysql_real_escape_string($_POST['cargo_hardpack'])==2?'checked':''?> value="2" />  ���</TD> 
										<TD><INPUT name="cargo_hardpack" type="radio" <?=mysql_real_escape_string($_POST['cargo_hardpack'])==1?'checked':''?> value="1" /> ��</TD>
										
									</TR> 
								</TABLE></TD>
						</TR>
						<TR>
							<TD>������������ ���������� ������� ������ ����� (�) </TD>
							<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
									<TR>
										<TD>�����:<B><?=mysql_real_escape_string($_POST['cargo_lenght'])?></B></TD> 
										<TD>������:<B><?=mysql_real_escape_string($_POST['cargo_width'])?></B></TD> 
										<TD>������:<B><?=mysql_real_escape_string($_POST['cargo_height'])?></B></TD> 
									</TR>
								</TABLE></TD>
						</TR>
						<TR>
							<TD>������ ������� </TD>
							<TD><?=mysql_real_escape_string($_POST['cargo_spec'])?></TD>
						</TR>
					</TABLE></TD>
			</TR>
		</TABLE>
		<BR />
		<TABLE width="100%" border="1" cellspacing="0" cellpadding="5">
			<TR>
				<th>5. ������ ����� (������� ������������) </th>
			</TR>
			<TR>
				<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
						<TR>
							<TD valign="top" style="border-bottom:1px solid #E4E4E4" nowrap>���� �������� �� ������ ���������������� </TD>
							<TD width="90%" style="border-bottom:1px solid #E4E4E4" valign="top"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
									<TR valign="top">
										<TD><INPUT name="autodost_departure" type="radio" <?=mysql_real_escape_string($_POST['autodost_departure'])==1?'checked':''?> value="1" />
											���������������� </TD>
										<TD><INPUT name="autodost_departure" type="radio" <?=mysql_real_escape_string($_POST['autodost_departure'])==2?'checked':''?> value="2" />
											���������������</TD>
										<TD width="40%"><INPUT name="autodost_departure" type="radio" value="3" id = "cb_autodost_departure" <?=mysql_real_escape_string($_POST['autodost_departure'])==3?'checked':''?> />
										������ ����<BR />
											<DIV name="autodost_departure3" style="width:90%;border:1px solid #333333;overflow:none;"><?=mysql_real_escape_string(proverka_simvolov($_POST['autodost_departure3']))?></DIV ></TD>
									</TR>
								</TABLE></TD>
						</TR>
						<TR>
							<TD style="border-bottom:1px solid #E4E4E4" valign="top">��������� � �. ���������� </TD>
							<TD style="border-bottom:1px solid #E4E4E4" valign="top"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
									<TR valign="top">
										<TD><INPUT name="transfer" type="radio" value="1" <?=mysql_real_escape_string($_POST['transfer'])==1?'checked':''?> />
											���������������� </TD>
										<TD><INPUT name="transfer" type="radio" value="2" <?=mysql_real_escape_string($_POST['transfer'])==2?'checked':''?> />
											���������������</TD>
										<TD width="40%">
										<INPUT name="transfer" type="radio" value="3" <?=mysql_real_escape_string($_POST['transfer'])==3?'checked':''?> id = "transfer"/>
										������ ����<BR>
											<DIV  name="transfer_3" style="width:90%;border:1px solid #333333;"><?=mysql_real_escape_string(proverka_simvolov($_POST['transfer_3']))?></DIV ></TD>
									</TR>
								</TABLE></TD>
						</TR>
						<TR>
							<TD style="border-bottom:1px solid #E4E4E4" valign="top">�������� �� ������ ��������������� </TD>
							<TD style="border-bottom:1px solid #E4E4E4" valign="top"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
									<TR valign="top">
										<TD><INPUT name="autodost_arrival" type="radio" <?=mysql_real_escape_string($_POST['autodost_arrival'])==1?'checked':''?> value="1" />
											���������������� </TD>
										<TD><INPUT name="autodost_arrival" type="radio" <?=mysql_real_escape_string($_POST['autodost_arrival'])==2?'checked':''?> value="2" />
											���������������</TD>
										<TD width="40%">
										<INPUT name="autodost_arrival" type="radio" value="3" <?=mysql_real_escape_string($_POST['autodost_arrival'])==3?'checked':''?> id = "autodost_arrival"/>
										������ ����<BR>
											<DIV  name="autodost_arrival_3" style="width:90%;border:1px solid #333333;"><?=mysql_real_escape_string(proverka_simvolov($_POST['autodost_arrival_3']))?></DIV ></TD>
									</TR>
								</TABLE></TD>
						</TR>
						<TR>
							<TD valign="top">����������� 0.2% �� ����������<BR>
								��������� �����<BR>
								(����������). ����������� ��������� ����������� - 1000�.</TD>
							<TD valign="top"><?=mysql_real_escape_string($_POST['platelshik'])?></TD>
						</TR>
					</TABLE><BR>
					<TABLE width="100%" border="1" cellpadding="0" cellspacing="5" class="nobrd">
						<TR>
							<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
									<TR>
									<TD>���� ������: </TD> 
									<TD><INPUT disabled name="last_podpis_data" class="brd wide" type="text" id="last_podpis_data" value="<? echo date('d.m.y',time()) ; ?> " /></TD> 
									<TD>��� ���������:</TD> 
									<TD><INPUT name="last_podpis_ras" class="brd wide" type="text" id="last_podpis_ras" value="<?=mysql_real_escape_string($_POST['last_podpis_ras'])?>" /></TD>
									<TD></TD>
									</TR>
								</TABLE></TD>
						</TR>
						
					</TABLE></TD>
			</TR>
		</TABLE>
		<BR>
		<TABLE width="100%" border="1" cellspacing="0" cellpadding="5">
			<TR>
				<th>6. ����������� ������������ </th>
			</TR>
			<TR>
				<TD><TABLE width="100%" border="1" cellpadding="0" cellspacing="5" class="nobrd">
						<TR>
							<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
									<TR>
										<TD>E-mail �����������: </TD> 
										<TD><INPUT name="sender_email" class="brd wide" type="text" id="sender_email" value="<?=mysql_real_escape_string($_POST['sender_email'])?>" /></TD>
										<TD><SMALL>������� ����������� �����, �� ������� ��� ����� ������ ����� ������</SMALL></TD>
									</TR>
								</TABLE></TD>
						</TR>
						
					</TABLE></TD>
			</TR>
		</TABLE>
		<BR>
		<?
		$zayavka = ob_get_contents();
		ob_end_clean();
		
		
		$insid = $createChild->createLink($name,'27','25','0');
		$sql = "INSERT INTO zayavka VALUES (".$insid.",'27','0','".$name."','".$now."','".$now."','1','".$zayavka."')";
		//echo $sql;
		//$sql = mysql_real_escape_string($sql);
		//echo $sql;
		
$query_detail ="INSERT INTO zayavka_detail VALUES (
		'".""."',
		'".$insid."',
		'".time()."',
		'".mysql_real_escape_string(proverka_simvolov($_POST['customer_name']))."',
		'".mysql_real_escape_string($_POST['customer_phone'])."',
		'".mysql_real_escape_string($_POST['customer_contact'])."',
		'".mysql_real_escape_string($_REQUEST['dat'])."',
		'".mysql_real_escape_string($_POST['departure_city'])."',
		'".mysql_real_escape_string(proverka_simvolov($_POST['departure_name']))."',
		'".mysql_real_escape_string($_POST['departure_office'])."',
		'".mysql_real_escape_string($_POST['departure_fio'])."',
		'".mysql_real_escape_string($_POST['departure_phone'])."',
		'".mysql_real_escape_string($_POST['departure_expedition'])."',
		'".mysql_real_escape_string($formData['departure_addr'])."',
		'".mysql_real_escape_string($_POST['departure_workfrom'])."',
		'".mysql_real_escape_string($_POST['departure_workto'])."',
		'".mysql_real_escape_string($_POST['departure_lanch'])."',
		'".mysql_real_escape_string($_POST['arrival_city'])."',
		'".mysql_real_escape_string(proverka_simvolov($_POST['arrival_name']))."',
		'".mysql_real_escape_string($_POST['arrival_office'])."',
		'".mysql_real_escape_string($_POST['arrival_fio'])."',
		'".mysql_real_escape_string($_POST['arrival_phone'])."',
		'".mysql_real_escape_string($_POST['arrival_expedition'])."',
		'".mysql_real_escape_string($formData['arrival_addr'])."',
		'".mysql_real_escape_string($_POST['arrival_workfrom'])."',
		'".mysql_real_escape_string($_POST['arrival_workto'])."',
		'".mysql_real_escape_string($_POST['arrival_lanch'])."',
		'".mysql_real_escape_string($_POST['cargo_type'])."',
		'".mysql_real_escape_string($_POST['cargo_type_4'])."',
		'".mysql_real_escape_string($formData['okpo'])."',
		'".mysql_real_escape_string($_POST['cargo_hardpack'])."',
		'".mysql_real_escape_string($_POST['cargo_lenght'])."',
		'".mysql_real_escape_string($_POST['cargo_width'])."',
		'".mysql_real_escape_string($_POST['cargo_height'])."',
		'".mysql_real_escape_string($_POST['cargo_spec'])."',	
		'".mysql_real_escape_string($_POST['autodost_departure'])."',
		'".mysql_real_escape_string($_POST['transfer'])."',
		'".mysql_real_escape_string($_POST['autodost_arrival'])."',
		'".mysql_real_escape_string(proverka_simvolov($_POST['autodost_departure3']))."',
		'".mysql_real_escape_string(proverka_simvolov($_POST['transfer_3']))."',
		'".mysql_real_escape_string(proverka_simvolov($_POST['autodost_arrival_3']))."',
		'".mysql_real_escape_string($_POST['last_podpis_ras'])."',
		'".mysql_real_escape_string($_POST['sender_email'])."',
		'".mysql_real_escape_string($_POST['strah'])."',
		'".mysql_real_escape_string($_POST['platelshik'])."'
		)";
		
		for($i = 0; $i < sizeOf($_POST['cargo_name']);$i++)
			{
			$cargo_query="INSERT INTO zayavka_cargo_info VALUES (
			'".""."',
			'".$insid."',
			'".mysql_real_escape_string($_POST['cargo_name'][$i])."',
			'".mysql_real_escape_string($_POST['cargo_kg'][$i])."',
			'".mysql_real_escape_string($_POST['cargo_kub'][$i])."',
			'".mysql_real_escape_string($_POST['cargo_mest'][$i])."'
			)";		
			sql($cargo_query);
			}		
		sql($query_detail);
		if (sql($sql))
		{
		 $vseprokatilo=true;
		}
		
		//mailer::send("zyablik@web-robots.ru","������ � �����",$zayavka);
		if(strlen($cache[$_POST['departure_city']]['notifyMail'])>0)
			mailer::send($cache[$_POST['departure_city']]['notifyMail'],"������ � �����",$zayavka);
		if(strlen($cache[$_POST['departure_city']]['notifyMail2'])>0)
			mailer::send($cache[$_POST['departure_city']]['notifyMail2'],"������ � �����",$zayavka);
		mailer::send($_POST['sender_email'],"������ � �����",$zayavka);
		//echo '<b>������ ���������� � ���������.<br>������� �� ��������������!</b>';
		
		echo '<p>����� ����� ��������������� ������ <b>'.$name.'</b>, ��� ��������� ������� ������ ����������� ����������� �� ������ (495) 290-30-15 � ������ ������ ������</p>';
		echo '<a href="http://tesgroup.ru">�����</a>';
	}
}
if ($vseprokatilo==false)
{
if(!$hideForm)
{
	//print_r($errors);
?><SCRIPT src="/_inc/zayavka.js"></SCRIPT>

<FORM id="zayavka" name="zayavka" method="post" action="/clients/zayavka/?action=done">
<IMG src="/_pic/icons/mandatory.gif" alt="" border="0"><font color="red">- ���� ������������ ��� ����������</font><br>
	<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
		<TR>
			<th colspan="6">1.��������</th>
		</TR>
		<TR>
			<TD width="20%">��������</TD>
			<TD width="30%"><INPUT name="customer_name" class="brd wide mandatory" type="text" id="customer_name" value="<?=mysql_real_escape_string(proverka_simvolov($_POST['customer_name']));?>" />
			<?=array_key_exists('customer_name',$errors)?'<div class="error">'.$errors['customer_name'].'</div>' :''?>
			</TD>
			<TD width="20%">���������� ���� </TD>
			<TD width="30%"><INPUT name="customer_contact" class="brd wide mandatory" type="text" id="customer_contact" value="<?=$formData['customer_contact'];?>" />
			<?=array_key_exists('customer_contact',$errors)?'<div class="error">'.$errors['customer_contact'].'</div>' :''?></TD>
		</TR>
		<TR>
			<TD>��������</TD>
			<TD><INPUT name="customer_phone" class="brd wide mandatory" type="text" id="customer_phone" value="<?=$formData['customer_phone'];?>" />
			<?=array_key_exists('customer_phone',$errors)?'<div class="error">'.$errors['customer_phone'].'</div>' :''?></TD>
			<TD>���� ��������</TD>
			<TD><INPUT class="brd wide mandatory" type="text" name="dat" value="<?=$_REQUEST['dat'] ? $_REQUEST['dat'] : date("d.m.Y",time())?>"  format="dd.MM.yyyy" millis="<?=(time()*1000)?>" />
			<?=array_key_exists('dat',$errors)?'<div class="error">'.$errors['dat'].'</div>' :''?>
			</TD>
		</TR>
	</TABLE>
	<BR>
	<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
		<TR>
			<th colspan="2">2. ����� ����������� </th>
			<th colspan="2">3. ����� ���������� </th>
		</TR>
		<TR>
			<TD width="20%">����� ����������� </TD>
			<TD><SELECT class="wide" name="departure_city" id="departure_city"><?
			foreach($cache as $id=>$city)
			{
				echo '<option';
				if($id == $formData['departure_city'])
					echo ' selected ';
				echo ' value="'.$id.'">'.$city['ElementName'];
			}?></SELECT>
			</TD>
			<TD width="20%">����� ���������� </TD>
			<TD><SELECT class="wide" name="arrival_city" id="arrival_city"><?
			foreach($cache as $id=>$city)
			{
				echo '<option';
				if($id == $formData['arrival_city'])
					echo ' selected ';
				echo ' value="'.$id.'">'.$city['ElementName'];
			}?></SELECT></TD>
		</TR>
		<TR>
			<TD>���������������� </TD>
			<TD><INPUT name="departure_name" class="brd wide mandatory" type="text" id="departure_name2" value="<?=mysql_real_escape_string(proverka_simvolov($_POST['departure_name']));?>" />
			<?=array_key_exists('departure_name',$errors)?'<div class="error">'.$errors['departure_name'].'</div>' :''?></TD>
			<TD>��������������� </TD>
			<TD><INPUT name="arrival_name" class="brd wide mandatory" type="text" id="arrival_name2" value="<?=mysql_real_escape_string(proverka_simvolov($_POST['arrival_name']));?>" />
			<?=array_key_exists('arrival_name',$errors)?'<div class="error">'.$errors['arrival_name'].'</div>' :''?></TD>
		</TR>
		<TR>
			<TD>��� </TD>
			<TD><INPUT name="departure_office" class="brd wide" type="text" id="departure_office2" maxlength="12" value="<?=$formData['departure_office'];?>" /></TD>
			<TD>��� </TD>
			<TD><INPUT name="arrival_office" class="brd wide" type="text" id="arrival_office2" maxlength="12" value="<?=$formData['arrival_office'];?>" /></TD>
		</TR>
		<TR>
			<TD>���������� ���� </TD>
			<TD><INPUT name="departure_fio" class="brd wide mandatory" type="text" id="departure_fio2" value="<?=$formData['departure_fio'];?>" />
			<?=array_key_exists('departure_fio',$errors)?'<div class="error">'.$errors['departure_fio'].'</div>' :''?></TD>
			<TD>���������� ���� </TD>
			<TD><INPUT name="arrival_fio" class="brd wide mandatory" type="text" id="arrival_fio2" value="<?=$formData['arrival_fio'];?>" />
			<?=array_key_exists('arrival_fio',$errors)?'<div class="error">'.$errors['arrival_fio'].'</div>' :''?></TD>
		</TR>
		<TR>
			<TD>�������� </TD>
			<TD><INPUT name="departure_phone" class="brd wide mandatory" type="text" id="departure_phone2" value="<?=$formData['departure_phone'];?>" />
			<?=array_key_exists('departure_phone',$errors)?'<div class="error">'.$errors['departure_phone'].'</div>' :''?>
			</TD>
			<TD>��������</TD>
			<TD><INPUT name="arrival_phone" class="brd wide mandatory" type="text" id="arrival_phone2" value="<?=$formData['arrival_phone'];?>" />
			<?=array_key_exists('arrival_phone',$errors)?'<div class="error">'.$errors['arrival_phone'].'</div>' :''?></TD>
		</TR>
		<!--<TR valign="top">
			<TD>����������</TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD><INPUT name="departure_delivery" type="radio" value="1" />
							��</TD>
						<TD width="50%"><INPUT name="departure_delivery" type="radio" value="2" />
							���</TD>
					</TR>
				</TABLE>
				<TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD width="50%" >����� �������� </TD>
						<TD ><INPUT name="departure_delivery_time" class="brd wide" type="text" id="departure_delivery_time" style="width:50px;" value="<?//=$formData['departure_delivery_time'];?>" /></TD>
					</TR>
				</TABLE></TD>
			<TD>���������</TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD><INPUT name="arrival_delivery" type="radio" value="1" />
							��</TD>
						<TD width="50%"><INPUT name="arrival_delivery" type="radio" value="2" />
							���</TD>
					</TR>
				</TABLE></TD>
		</TR>-->
		<TR valign="top">
			<TD >���� �������� �� ������ ���������������� </TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd" style="border:1px solid #e68e0b">
					<TR>
					<?=array_key_exists('departure_expedition',$errors)?'<div class="error">'.$errors['departure_expedition'].'</div>' :''?>
						<TD>
						<INPUT id = "cb_departure_expedition1" name="departure_expedition" type="radio" value="1" <?=$_POST['departure_expedition']==1?'checked':''?> onClick = 'showOrHide("cb_departure_expedition1", "cat_cb_departure_addr");'/>
							��</TD>
						<TD width="50%"><INPUT name="departure_expedition" type="radio" value="2" <?=$_POST['departure_expedition']==2?'checked':''?> id = "cb_departure_expedition2" onClick = 'Hide("cb_departure_expedition2", "cat_cb_departure_addr");'/>
							��� (����������)</TD>
					</TR>
				</TABLE>
				<div id = "cat_cb_departure_addr" <?=$_POST['departure_expedition']<>1?'style = "display: none;"':''?> >
				����� ������ ���������� ��� ��������:<BR />
				<textarea cols="20" rows="4" name="departure_addr" class="brd wide mandatory" id="departure_addr"><?=$formData['departure_addr'];?></textarea>
				<?=array_key_exists('departure_addr',$errors)?'<div class="error">'.$errors['departure_addr'].'</div>' :''?></div></TD>
				
			<TD >���� �������� �� ������ ���������������</TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd" style="border:1px solid #e68e0b">
					<tr>
					<?=array_key_exists('arrival_expedition',$errors)?'<div class="error">'.$errors['arrival_expedition'].'</div>' :''?>
						<TD><INPUT id = "arrival_expedition1" name="arrival_expedition" type="radio" value="1" <?=$_POST['arrival_expedition']==1?'checked':''?> onClick = 'showOrHide("arrival_expedition1", "cat_cb_arrival_addr");'/>
							��</TD>
						<TD width="50%"><INPUT id = "cb_arrival_expedition2" name="arrival_expedition" type="radio" value="2" <?=$_POST['arrival_expedition']==2?'checked':''?> onClick = 'Hide("cb_arrival_expedition2", "cat_cb_arrival_addr");'/>
							��� (���������)</TD>
					</tr>
				</TABLE>
				<div id = "cat_cb_arrival_addr" <?=$_POST['arrival_expedition']<>1?'style = "display: none;"':''?> >
				����� ������ ���������� ��� ���������:<BR />
				<textarea name="arrival_addr" class="brd wide mandatory" cols="20" rows="4" id="arrival_addr"><?=$formData['arrival_addr'];?></textarea>
				<?=array_key_exists('arrival_addr',$errors)?'<div class="error">'.$errors['arrival_addr'].'</div>' :''?></div></TD>
		</TR>
		<TR valign="top">
			<TD>����� ������ </TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD width="50%" >�
							<INPUT name="departure_workfrom" class="brd wide" type="text" id="departure_workfrom" style="width:50px;" value="<?=$formData['departure_workfrom'];?>" /></TD>
						<TD > ��
							<INPUT name="departure_workto" class="brd wide" type="text" id="departure_workto" style="width:50px;" value="<?=$formData['departure_workto'];?>" /></TD>
					</TR>
				</TABLE>
				<BR />
				������� �� ����<BR />
				<INPUT name="departure_lanch" class="brd wide" type="text" id="departure_lanch" value="<?=$formData['departure_lanch'];?>" /></TD>
			<TD>����� ������ </TD>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD width="50%" >�
							<INPUT name="arrival_workfrom" class="brd wide" type="text" id="arrival_workfrom" style="width:50px;" value="<?=$formData['arrival_workfrom'];?>" /></TD>
						<TD > ��
							<INPUT name="arrival_workto" class="brd wide" type="text" id="arrival_workto" style="width:50px;" value="<?=$formData['arrival_workto'];?>" /></TD>
					</TR>
				</TABLE>
				<BR />
				������� �� ����<BR />
				<INPUT name="arrival_lanch" class="brd wide" type="text" id="arrival_lanch" value="<?=$formData['arrival_lanch'];?>" /></TD>
		</TR>
	</TABLE>
	<BR />
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
		<TR>
			<th>4. �������� ����� </th>
		</TR>
		<TR>
			<TD><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
					<TR>
						<th>������������ ����� </th>
						<th>��� (������), �� </th>
						<th>����� ����� (�<sup>3</sup>) </th>
						<th>���-�� ���� </th>
						<th>&nbsp;</th>
					</TR>
					<?
					//print_r($formData);
					if(sizeOf($formData['cargo_name']) > 0)
					{
						for($i = 0; $i < sizeOf($formData['cargo_name']);$i++)
						{
							
							echo '<TR>';
							echo '<TD><INPUT name="cargo_name[]" class="brd wide mandatory" type="text" id="cargo_name" style="width:95%" value="'.$formData['cargo_name'][$i].'"></TD>';
							echo '<TD><INPUT name="cargo_kg[]" class="brd wide mandatory" type="text" id="cargo_name" style="width:95%" value="'.$formData['cargo_kg'][$i].'"></TD>';
							echo '<TD><INPUT name="cargo_kub[]" class="brd wide mandatory" type="text" id="cargo_name" style="width:95%" value="'.$formData['cargo_kub'][$i].'"></TD>';
							echo '<TD><INPUT name="cargo_mest[]" class="brd wide mandatory" type="text" id="cargo_mest" style="width:95%" value="'.$formData['cargo_mest'][$i].'"></TD>';
							echo '<TD style="border:none;"><INPUT type="button" '.($i==0 ?' disabled':'' ).' name="drop" value=" &minus; " onClick="dropFile(this);">&nbsp;<INPUT type="button" value=" + " onClick="addFileBtn(this);"></TD>';
							echo '</TR>';
						}
					} else {
						?><TR>
						<TD><INPUT name="cargo_name[]" class="brd wide mandatory" type="text" id="cargo_name" style="width:95%"></TD>
						<TD><INPUT name="cargo_kg[]" class="brd wide mandatory" type="text" id="cargo_kg" value=""></TD>
						<TD><INPUT name="cargo_kub[]" class="brd wide mandatory" type="text" id="cargo_kub" value=""></TD>
						<TD><INPUT name="cargo_mest[]" class="brd wide mandatory" type="text" id="cargo_mest" value=""></TD>
						<TD style="border:none;"><INPUT type="button" name="drop" disabled value=" &minus; " onClick="dropFile(this);">&nbsp;<INPUT type="button" value=" + " onClick="addFileBtn(this);"></TD>
					</TR><?
					}
					?>
					
				</TABLE>
				<TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD >��������� ��� ���������� �������
			<?=array_key_exists('cargo_type',$errors)?'<div class="error">'.$errors['cargo_type'].'</div>' :''?>
						</TD>
						<TD><TABLE style="border:1px solid #e68e0b" cellpadding="0" cellspacing="0">
								<TR>
									<TD><INPUT onClick = 'Hide("cb_cargo_type1", "cat_cargo_type");' name="cargo_type" id="cb_cargo_type1" type="radio" <?=$_POST['cargo_type']==1?'checked':''?> value="1" />
										�����</TD>
									<TD><INPUT onClick = 'Hide("cb_cargo_type2", "cat_cargo_type");' name="cargo_type" id="cb_cargo_type2" <?=$_POST['cargo_type']==2?'checked':''?> type="radio" value="2" />
										������</TD>
									<TD><INPUT onClick = 'Hide("cb_cargo_type3", "cat_cargo_type");' name="cargo_type" id="cb_cargo_type3" <?=$_POST['cargo_type']==3?'checked':''?> type="radio" value="3" />
										����</TD>
									<TD><INPUT onClick = 'Hide("cb_cargo_type5", "cat_cargo_type");' name="cargo_type" id="cb_cargo_type5" <?=$_POST['cargo_type']==5?'checked':''?> type="radio" value="5" />
										����</TD>
									<TD><INPUT name="cargo_type" id="cb_cargo_type4" <?=$_POST['cargo_type']==4?'checked':''?> type="radio" value="4" onclick = 'showOrHide("cb_cargo_type4", "cat_cargo_type");'/>
										���������</TD>			
									<TD><div id = "cat_cargo_type" <?=$_POST['cargo_type']<>4?'style = "display: none;"':''?> >
									<?=array_key_exists('cargo_type_4',$errors)?'<div class="error">'.$errors['cargo_type_4'].'</div>' :''?>
									<INPUT name="cargo_type_4" type="radio" <?=$_POST['cargo_type_4']==1?'checked':''?> value="1" /><font size="1">3��</font>
									<INPUT name="cargo_type_4" type="radio" <?=$_POST['cargo_type_4']==2?'checked':''?> value="2" /><font size="1">5��</font>
									<INPUT name="cargo_type_4" type="radio" <?=$_POST['cargo_type_4']==3?'checked':''?> value="3" /><font size="1">20��</font>
									<INPUT name="cargo_type_4" type="radio" <?=$_POST['cargo_type_4']==4?'checked':''?> value="4" /><font size="1">40��</font>
									<br>���� ����������:<INPUT name="okpo" size="0.5" class="brd wide mandatory" type="text" value="<?=$formData['okpo'];?>" />
									<?=array_key_exists('okpo',$errors)?'<div class="error">'.$errors['okpo'].'</div>' :''?>
									</div></TD>
								</TR>
							</TABLE></TD>
					</TR>
					<TR>
						<TD nowrap>������������ ������� ��������
						<?=array_key_exists('cargo_hardpack',$errors)?'<div class="error">'.$errors['cargo_hardpack'].'</div>' :''?>
						</TD>
						<TD width="90%"><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd" style="border:1px solid #e68e0b">
								<TR>
									<TD><INPUT name="cargo_hardpack" class="radiomandatory" <?=$_POST['cargo_hardpack']==1?'checked':''?> type="radio" value="1" /> ��</TD>
									<TD><INPUT name="cargo_hardpack" class="radiomandatory" <?=$_POST['cargo_hardpack']==2?'checked':''?> type="radio" value="2" /> ���</TD>
									
									<TD align="left" width="90%"></TD>
								</TR>
							</TABLE></TD>
					</TR>
					<TR>
						<TD>������������ ���������� ������� ������ ����� (�) </TD>
						<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
								<TR>
									<TD>�����
										<INPUT name="cargo_lenght" class="brd wide" type="text" id="cargo_lenght" value="<?=$formData['cargo_lenght'];?>"></TD>
									<TD>������
										<INPUT name="cargo_width" class="brd wide" type="text" id="cargo_width" value="<?=$formData['cargo_width'];?>"></TD>
									<TD>������
										<INPUT name="cargo_height" class="brd wide" type="text" id="cargo_height" value="<?=$formData['cargo_height'];?>"></TD>
								</TR>
							</TABLE></TD>
					</TR>
					<TR>
						<TD>������ ������� </TD>
						<TD><TEXTAREA name="cargo_spec" class="brd wide" id="cargo_spec"><?=$formData['cargo_spec'];?></TEXTAREA></TD>
					</TR>
				</TABLE></TD>
		</TR>
	</TABLE>
	<BR />
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
		<TR>
			<th>5. ������ ����� (������� ������������)</th>
		</TR>
		<TR>
			<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
					<TR>
						<TD valign="top" style="border-bottom:1px solid #E4E4E4" nowrap>���� �������� �� ������ ���������������� </br> (���� ���� �������������� � ������ �����������)
						<?=array_key_exists('autodost_departure',$errors)?'<div class="error">'.$errors['autodost_departure'].'</div>' :''?>
						</TD>
						<TD width="90%" style="border:1px solid #e68e0b" valign="top"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
								<TR valign="top">
									<TD><INPUT name="autodost_departure" type="radio" <?=$_POST['autodost_departure']==1?'checked':''?> value="1" id = 'cb_autodost_departure1' onClick = 'Hide("cb_autodost_departure1", "cat_cb_autodost_departure");'/>
										���������������� </TD>
									<TD><INPUT name="autodost_departure" type="radio" <?=$_POST['autodost_departure']==2?'checked':''?> value="2" id = 'cb_autodost_departure2' onClick = 'Hide("cb_autodost_departure2", "cat_cb_autodost_departure");'/>
										���������������</TD>
									<TD width="40%"><INPUT name="autodost_departure" type="radio" value="3" id = 'cb_autodost_departure' <?=$_POST['autodost_departure']==3?'checked':''?> onClick = 'showOrHide("cb_autodost_departure", "cat_cb_autodost_departure");' />
									������ ����<BR />
									<div id = "cat_cb_autodost_departure" <?=$_POST['autodost_departure']<>3?'style = "display: none;"':''?> >
										<TEXTAREA name="autodost_departure3" class="brd wide mandatory"><?=$_POST['autodost_departure3']?></TEXTAREA>
										<?=array_key_exists('autodost_departure3',$errors)?'<div class="error">'.$errors['autodost_departure3'].'</div>' :''?></div>
										</TD>
								</TR>
							</TABLE></TD>
					</TR>
					<TR>
						<TD style="border-bottom:1px solid #E4E4E4" valign="top">��������� � �. ���������� 
						<?=array_key_exists('transfer',$errors)?'<div class="error">'.$errors['transfer'].'</div>' :''?>
						</TD>
						<TD style="border:1px solid #e68e0b" valign="top"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
								<TR valign="top">
									<TD><INPUT name="transfer" type="radio" <?=$_POST['transfer']==1?'checked':''?> value="1" id = 'cb_transfer1' onClick = 'Hide("cb_transfer1", "cat_cb_transfer");'/>
										���������������� </TD>
									<TD><INPUT name="transfer" type="radio" <?=$_POST['transfer']==2?'checked':''?> value="2" id = 'cb_transfer2' onClick = 'Hide("cb_transfer2", "cat_cb_transfer");'/>
										���������������</TD>
									<TD width="40%"> 
									<INPUT name="transfer" type="radio" value="3" <?=$_POST['transfer']==3?'checked':''?> id = 'transfer' onClick = 'showOrHide("transfer", "cat_cb_transfer");'/>
									������ ����<BR>
									<div id = "cat_cb_transfer" <?=$_POST['transfer']<>3?'style = "display: none;"':''?> >
										<TEXTAREA name="transfer_3" class="brd wide mandatory"><?=$_POST['transfer_3']?></TEXTAREA>
										<?=array_key_exists('transfer_3',$errors)?'<div class="error">'.$errors['transfer_3'].'</div>' :''?></div>
										</TD>
								</TR>
							</TABLE></TD>
					</TR>
					<TR>
						<TD style="border-bottom:1px solid #E4E4E4" valign="top">�������� �� ������ ��������������� </br> (���� ���� �������������� � ������ ����������)
						<?=array_key_exists('autodost_arrival',$errors)?'<div class="error">'.$errors['autodost_arrival'].'</div>' :''?>
						</TD>
						<TD style="border:1px solid #e68e0b" valign="top"><TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
								<TR valign="top">
									<TD><INPUT name="autodost_arrival" type="radio" <?=$_POST['autodost_arrival']==1?'checked':''?> value="1" id = 'cb_autodost_arrival1' onClick = 'Hide("cb_autodost_arrival1", "cat_cb_autodost_arrival");'/>
											���������������� </TD>
									<TD><INPUT name="autodost_arrival" type="radio" <?=$_POST['autodost_arrival']==2?'checked':''?> value="2" id = 'cb_autodost_arrival2' onClick = 'Hide("cb_autodost_arrival2", "cat_cb_autodost_arrival");'/>
										���������������</TD>
									<TD width="40%">
									<INPUT name="autodost_arrival" type="radio" value="3" <?=$_POST['autodost_arrival']==3?'checked':''?> id = 'autodost_arrival'  onClick = 'showOrHide("autodost_arrival", "cat_cb_autodost_arrival");'/>
									������ ����<BR>
									<div id = "cat_cb_autodost_arrival" <?=$_POST['autodost_arrival']<>3?'style = "display: none;"':''?> >
										<TEXTAREA name="autodost_arrival_3" class="brd wide mandatory"><?=$_POST['autodost_arrival_3']?></TEXTAREA>
										<?=array_key_exists('autodost_arrival_3',$errors)?'<div class="error">'.$errors['autodost_arrival_3'].'</div>' :''?></div>
										</TD>
								</TR>
							</TABLE></TD>
					</TR>
					<TR>
						<TD style="border-bottom:1px solid #E4E4E4" valign="top">����������� 0.2% �� ���������� <input type = 'checkbox' id = 'cb1' value="1" <?=$_POST['strah']==1?'checked':''?> name="strah" onclick = 'showOrHide("cb1", "cat1");'/> <BR>
							��������� �����(����������)
							 <br />
						</TD>
						<TD style="border-bottom:1px solid #E4E4E4" valign="top"><div id = "cat1" <?=$_POST['strah']==0?'style = "display: none;"':''?> >
						<font size="1px">���������� ��������� �����:</font>
						<INPUT class="brd wide mandatory" type="text" name="platelshik" value="<?=$_POST['platelshik']?>"/>
						<?=array_key_exists('platelshik',$errors)?'<div class="error">'.$errors['platelshik'].'</div>' :''?></div>
						</TD>
					</TR>
					<TR>
						<TD valign="top" colspan="2"><BR>�������� ��������� ����������� � ����������� ������� ������ ����� ������������� ����������� � ���������� ����������� ����������� �� ����(�������-����������� ��������� �� ����, �����������, ����-�������). ���������� ���������� ������� ������-������, � ��������� �������� ������������ �����������, ��������� ��������� ��������� ������� �������� �������� �����������. � ��������� �������� �����������-�������������� ����� ��������.</TD>
					</TR>
				</TABLE>
				<BR>
				<TABLE width="100%" border="1" cellpadding="0" cellspacing="5" class="nobrd">
					<TR>
						<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
								<TR>
									<TD>���� ������: </TD> 
									<TD><INPUT size="80" disabled name="last_podpis_data" class="brd wide" type="text" id="last_podpis_data" value="<? echo date('d.m.y',time()) ; ?> " /></TD> 
									<TD>��� ���������:</TD> 
									<TD><INPUT size='200' name="last_podpis_ras" class="brd wide" type="text" id="last_podpis_ras" value="<?=$_POST['last_podpis_ras']?>" /></TD>
									<TD></TD>
									<TD width="20%"></TD>
									<!--<TD>������� ���������</TD>
									<TD width="25%"><INPUT name="last_podpis_data1" class="brd wide" type="text" id="last_podpis_data1" /></TD>-->  
								</TR>
							</TABLE></TD>
					</TR>
					
				</TABLE></TD>
		</TR>
	</TABLE>
	<BR>
	<!--
	<TABLE width="100%" border="1" cellspacing="0" cellpadding="5">
		<TR>
			<th>6. ����������� ������������ </th>
		</TR>
		<TR>
			<TD><TABLE width="100%" border="1" cellpadding="0" cellspacing="5" class="nobrd">
					<TR>
						<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
								<TR>
									<TD width="20%">���� ��������� ������: </TD> 
									<TD><INPUT disabled name="zayavka_date" class="brd wide" type="text" id="arrival_office2" /></TD> 
									<TD width="20%">����� ��������� ������</TD> 
									<TD><INPUT disabled name="zayavka_time" class="brd wide" type="text" id="arrival_office2" /></TD>  
								</TR>
								<TR>
									<TD>������ �������: </TD> 
									<TD><INPUT disabled name="zayavka_poluchil" class="brd wide" type="text" id="arrival_office2" /></TD> 
									<TD>����������� �������</TD> 
									<TD><INPUT disabled name="zayavka_signature" class="brd wide" type="text" id="arrival_office2" /></TD>  
								</TR>
							</TABLE></TD>
					</TR>
					
				</TABLE></TD>
		</TR>
	</TABLE>-->
	<BR><TABLE width="100%" border="1" cellspacing="0" cellpadding="5">
		<TR>
			<th>6. ����������� ������������ </th>
		</TR>
		<TR>
			<TD><TABLE width="100%" border="1" cellpadding="0" cellspacing="5" class="nobrd">
					<TR>
						<TD><TABLE width="100%" border="0" cellpadding="0" cellspacing="0" class="nobrd">
								<TR>
									<TD>E-mail �����������: </TD> 
									<TD><INPUT name="sender_email" class="brd wide mandatory" type="text" id="sender_email" value="<?=$_POST['sender_email']?>" /></TD>
									<TD><SMALL>������� ����������� �����, �� ������� ��� ����� ������ ����� ������</SMALL>
									<?=array_key_exists('sender_email',$errors)?'<div class="error">'.$errors['sender_email'].'</div>' :''?></TD>
								</TR>
							</TABLE></TD>
					</TR>
					
				</TABLE></TD>
		</TR>
	</TABLE><BR>
	<DIV align="center">
		<INPUT type="hidden" name="act" id="act" value="1">
		<INPUT name="submit" type="submit" class="nobrd" value="��������� ������">
	</DIV>
</FORM>
<?}}?>