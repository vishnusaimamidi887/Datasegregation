<?php 
error_reporting(0);
function companycodefn($isin)
{
	$con=mysqli_connect("localhost","user","user","test");
	$cod1=mysqli_query($con,"select companycode as CC from company_master where isin='$isin'");
	$a1=(mysqli_fetch_assoc($cod1));
	// extract($a1);
	return $a1['CC'];
}

function fillzero($x)
{
	$str="";
	$len=strlen($x);
	for($i=0;$i<4-$len;$i++)
	{
		$str.="0";
	}
	$str.=$x;
	return $str;
}

 ?>

<?php 
$con=mysqli_connect("localhost","user","user","test");

$a=file_get_contents($_FILES['x']['tmp_name']);
// $a=explode("##",$a);
// print_r($a);
$handle=fopen($_FILES['x']['tmp_name'],"r");
$b=array();

while(!feof($handle))
{
	$str=fgetcsv($handle);
	if(count($str)>0)
	{
	$b[]=implode("",$str);
//$b[]=explode('"',$str);
	}
}	

//print_r($b);	


for($i=0;$i<count($b)-1;$i++){
	//echo count($b);
	//echo "$b[$i] <br> <br> <br>";
	$b[$i]=str_replace('\#', '#', $b[$i]);
	//$b[$i]=str_replace('#\\', '#', $b[$i]);
	$b[$i]=str_replace('"', '', $b[$i]);	
	//echo "$b[$i] <br> <br> <br>";
}

// foreach ($b as $cha){
// 	//echo "$cha <br> <br> <br>";
// 	str_replace('"', '', $cha);
// 	echo "$cha <br> <br> <br>";
	
// }


$c=array();

for($i=0;$i<count($b);$i++)
{
	$str=explode("##",$b[$i]);
	//str_replace('"', '', $a);
	//$str=explode('"',$b[$i]);
	//$str=explode('"',$b[$i]);
	// echo "<br>";
	$c[]=$str;
	// print_r($str);

}
$ISIN=$c[0][1];
$DATADATE=$c[0][2];
$CC=companycodefn($ISIN);
$sql1="";
$sql2="";
$sql3="";
//for($i=1;$i<3;$i++)
for($i=1;$i<count($c)-1;$i++)
{
//echo "$i <br>";

$RECTYPE="";
$LINE="";
$BENTYP="";
$LOCKIND="";
$LOCKRES="";


	$DPID=$c[$i][2];
	$CLID=$c[$i][3];
	$FREEHOL=$c[$i][47];
	$HOLLCK=$c[$i][48];
	$HOLBLOCK=$c[$i][49];
	$HOLPLD=$c[$i][50];
	$HOLPLDLCK=$c[$i][51];
	$HOLPLDUNC=$c[$i][52];
	$HOLPLDLCKU=$c[$i][53];
	$HOLREM=$c[$i][54];
	$HOLREMLCK=$c[$i][55];
	$HOLCMIDD=$c[$i][56];
	$HOLCMPOOL=$c[$i][57];
	$HOLSET=$c[$i][58];
	$NDUPOSHOLD=$c[$i][70];
	$NDULOCKHOL=$c[$i][71];
	$NDUUNCPOS=$c[$i][72];
	$NDUUNCLOCK=$c[$i][73];
	$HOL=($c[$i][47]+$c[$i][48]+$c[$i][49]+$c[$i][50]+$c[$i][51]+$c[$i][52]+$c[$i][53]+$c[$i][54]+$c[$i][55]+$c[$i][56]+$c[$i][57]+$c[$i][58]+$c[$i][70]+$c[$i][71]+$c[$i][72]+$c[$i][73]);


	// custom assumption starts
	$LOCKDT="";
	$LOCKCOD ="";
	$PLDGCOD  ="";
	
	// custom assumption ends
	// hodling ends
	// print_r($c[$i]);	
	// demat address starts



	$DPID=$c[$i][2];
	$CLID=$c[$i][3];
	$STATUSCODE=$c[$i][4];
	$SUBSTATUSCODE=$c[$i][5];
	$ACCAT=$c[$i][6];
	$OCCUP=$c[$i][7];
	$NAME=$c[$i][8];
	$FNAME=$c[$i][9];
	$AD1=$c[$i][10];
	$AD2=$c[$i][11];
	$AD3=$c[$i][12];
	$AD4=$c[$i][13];
	$PIN=$c[$i][14];
	$PHONE=$c[$i][15];
	$FAX=$c[$i][16];
	$JT1=$c[$i][17];
	$FJT1=$c[$i][18];
	$JT2=$c[$i][19];
	$FJT2=$c[$i][20];
	$PAN1=$c[$i][23];
	$PAN2=$c[$i][24];
	$PAN3=$c[$i][25];
	$NOM=$c[$i][26];
	$NOMNAME=$c[$i][27];
	$NAD1=$c[$i][28];
	$NAD2=$c[$i][29];
	$NAD3=$c[$i][30];
	$NAD4=$c[$i][31];
	$NPIN=$c[$i][32];
	$DBMINOR=$c[$i][33];
	$MIND=$c[$i][34];
	$ACNO=$c[$i][35];
	$BANKNAME=$c[$i][36];
	$BANKAD1=$c[$i][37];
	$BANKAD2=$c[$i][38];
	$BANKAD3=$c[$i][39];
	$BANKAD4=$c[$i][40];
	$BANKPIN=$c[$i][41];
	$RBIREF=$c[$i][42];
	$RBIDATE=$c[$i][43];
	$SEBIREGNO=$c[$i][44];
	$BTAX=$c[$i][45];
	$STATUS=$c[$i][46];
	$MICRCD=$c[$i][59];
	$IFSC=$c[$i][60];
	$ACTYPE=$c[$i][61];
	$NAMEMAPIN=$c[$i][62];
	$JT1MAPIN=$c[$i][63];
	$JT2MAPIN=$c[$i][64];
	$EMAIL1=$c[$i][66];
	$EMAIL2=$c[$i][67];
	$EMAIL3=$c[$i][68];
	$RGSFLG=$c[$i][69];
	$ANREPFLG=$c[$i][70];
// query for patmaster getting patcode starts
	$STATUSCODE1=$STATUSCODE;   // status code - 2 digits	
	$SUBSTATUSCODE1=fillzero($SUBSTATUSCODE); // status 
	$r=mysqli_query($con,"select patcode from patmaster where STATUSCODE='$STATUSCODE1' and SUBSTATUSCODE='$SUBSTATUSCODE1' and deptype='NSD'");
	$pat_code_from_fill_zero_check=mysqli_fetch_assoc($r);

// 	$c="select patcode from patmaster where STATUSCODE='$STATUSCODE1' and SUBSTATUSCODE='$SUBSTATUSCODE1' and deptype='NSD'";

	// echo "<br>c <br>";
	// echo "$c";
	// echo "<br>c <br>";

// query for patmaster getting patcode ends


	$UIDISTHOL="";
	$UID2NDHOL="";
	$UID3RDHOL="";
	$PANGAR="";
	$UIDGAR="";
	$PATST=$pat_code_from_fill_zero_check['patcode'];
	$K="";
	// $DATADATE=$date;
	$DOB="";

	$p1=1;


	$qsql1="Select * from dematholding where CC = \"".$CC."\" AND DPID = \"".$DPID."\" AND CLID = \"".$CLID."\" AND ISIN = \"".$ISIN."\" AND DATADATE = \"".$DATADATE."\";";	
	$result1 =  mysqli_query($con,$qsql1);
	

	if (mysqli_num_rows($result1) > 0) {
		$psql1="update dematholding set HOL= \"".$HOL."\" ,  FREEHOL= \"".$FREEHOL."\" ,  HOLLCK= \"".$HOLLCK."\" ,  HOLBLOCK= \"".$HOLBLOCK."\" ,  HOLPLD= \"".$HOLPLD."\" ,  HOLPLDLCK= \"".$HOLPLDLCK."\" , HOLPLDUNC= \"".$HOLPLDUNC."\" , HOLPLDLCKU= \"".$HOLPLDLCKU."\" , HOLREM= \"".$HOLREM."\" , HOLREMLCK= \"".$HOLREMLCK."\"  , HOLCMIDD= \"".$HOLCMIDD."\"  , HOLCMPOOL= \"".$HOLCMPOOL."\"  , HOLSET= \"".$HOLSET."\"  , NDUPOSHOLD= \"".$NDUPOSHOLD."\" , NDULOCKHOL= \"".$NDULOCKHOL."\"  , NDUUNCPOS= \"".$NDUUNCPOS."\"  , NDUUNCLOCK= \"".$NDUUNCLOCK."\"  , LOCKDT= \"".$LOCKDT."\" , LOCKCOD= \"".$LOCKCOD."\" , PLDGCOD= \"".$PLDGCOD."\" where CC = \"".$CC."\" AND DPID = \"".$DPID."\" AND CLID = \"".$CLID."\" AND ISIN = \"".$ISIN."\" AND DATADATE = \"".$DATADATE."\";";
		mysqli_query($con,$psql1);
	} 
	else {
		$sql1="INSERT INTO dematholding values (\"".$CC."\",\"".$HOL."\",\"".$FREEHOL."\",\"".$HOLLCK."\",\"".$HOLBLOCK."\",\"".$HOLPLD."\",\"".$HOLPLDLCK."\",\"".$HOLPLDUNC."\",\"".$HOLPLDLCKU."\",\"".$HOLREM."\",\"".$HOLREMLCK."\",\"".$HOLCMIDD."\",\"".$HOLCMPOOL."\",\"".$HOLSET."\",\"".$NDUPOSHOLD."\",\"".$NDULOCKHOL."\",\"".$NDUUNCPOS."\",\"".$NDUUNCLOCK."\",\"".$DPID."\",\"".$CLID."\",\"".$ISIN."\",\"".$DATADATE."\",\"".$LOCKDT."\",\"".$LOCKCOD."\",\"".$PLDGCOD."\");";
		mysqli_query($con,$sql1);
	}
	
	
	
	$qsql2="Select * from demataddress where DPID = \"".$DPID."\" AND CLID = \"".$CLID."\";";	
	$result2 =  mysqli_query($con,$qsql2);
	

	if (mysqli_num_rows($result2) > 0) {

	
		$psql2="
		update demataddress set 
		
		statuscode = \"".$STATUSCODE."\" ,  
		substatuscode= \"".$SUBSTATUSCODE."\" ,  
		ACCAT= \"".$ACCAT."\" ,  
		OCCUP= \"".$OCCUP."\" ,  
		NAME= \"".$NAME."\" ,  
		FNAME= \"".$FNAME."\" , 
		AD1= \"".$AD1."\" , 
		AD2= \"".$AD2."\" , 
		AD3= \"".$AD3."\" , 
		AD4= \"".$AD4."\"  , 
		PIN= \"".$PIN."\"  , 
		PHONE= \"".$PHONE."\"  , 
		FAX= \"".$FAX."\"  , 
		JT1= \"".$JT1."\" , 
		FJT1= \"".$FJT1."\"  , 
		JT2= \"".$JT2."\"  , 
		FJT2= \"".$FJT2."\"  , 
		PAN1= \"".$PAN1."\" , 
		PAN2= \"".$PAN2."\" , 
		PAN3= \"".$PAN3."\" ,  
		NOM= \"".$NOM."\" ,  
		NOMNAME= \"".$NOMNAME."\" ,  
		NAD1= \"".$NAD1."\" ,  
		NAD2= \"".$NAD2."\" ,  
		NAD3= \"".$NAD3."\" , 
		NAD4= \"".$NAD4."\" , 
		NPIN= \"".$NPIN."\" , 
		DBMINOR= \"".$DBMINOR."\" , 
		MIND= \"".$MIND."\"  , 
		ACNO= \"".$ACNO."\"  , 
		BANKNAME= \"".$BANKNAME."\"  , 
		BANKAD1= \"".$BANKAD1."\"  , 
		BANKAD2= \"".$BANKAD2."\" , 
		BANKAD3= \"".$BANKAD3."\"  , 
		BANKAD4= \"".$BANKAD4."\"  , 
		BANKPIN= \"".$BANKPIN."\"  , 
		RBIREF= \"".$RBIREF."\" , 
		RBIDATE= \"".$RBIDATE."\" , 
		SEBIREGNO= \"".$SEBIREGNO."\"  , 
		BTAX= \"".$BTAX."\" , 
		STATUS= \"".$STATUS."\"  , 
		MICRCD= \"".$MICRCD."\"  , 
		IFSC= \"".$IFSC."\"  , 
		ACTYPE= \"".$ACTYPE."\" , 
		NAMEMAPIN= \"".$NAMEMAPIN."\" , 
		JT1MAPIN= \"".$JT1MAPIN."\" , 
		JT2MAPIN= \"".$JT2MAPIN."\"  , 
		EMAIL1= \"".$EMAIL1."\" , 
		EMAIL2= \"".$EMAIL2."\"  , 
		EMAIL3= \"".$EMAIL3."\"  , 
		RGSFLG= \"".$RGSFLG."\"  , 
		ANREPFLG= \"".$ANREPFLG."\" , 
		UIDISTHOL= \"".$UIDISTHOL."\"  , 
		UID2NDHOL= \"".$UID2NDHOL."\" , 
		UID3RDHOL= \"".$UID3RDHOL."\"  , 
		PANGAR= \"".$PANGAR."\"  , 
		UIDGAR= \"".$UIDGAR."\"  , 
		PATST= \"".$PATST."\" , 
		K= \"".$K."\" , 
		DATADATE= \"".$DATADATE."\"  , 
		DOB= \"".$DOB."\" 

		where 

		DPID = \"".$DPID."\" AND 
		CLID = \"".$CLID."\";";
		mysqli_query($con,$psql2);
	} 
	else {
		$sql2="INSERT INTO demataddress (DPID,CLID,statuscode,substatuscode,ACCAT,OCCUP,NAME,FNAME,AD1,	AD2,AD3,AD4,PIN,PHONE,FAX,JT1,FJT1,JT2,FJT2,PAN1,PAN2,PAN3,NOM,NOMNAME,NAD1,NAD2,NAD3,NAD4,NPIN,DBMINOR,MIND,ACNO,BANKNAME,BANKAD1,BANKAD2,BANKAD3,BANKAD4,BANKPIN,RBIREF,RBIDATE,SEBIREGNO,BTAX,STATUS,MICRCD,IFSC,ACTYPE,NAMEMAPIN,JT1MAPIN,JT2MAPIN,EMAIL1,EMAIL2,EMAIL3,RGSFLG,ANREPFLG,UIDISTHOL,UID2NDHOL,UID3RDHOL,PANGAR,UIDGAR,PATST,K,DATADATE,DOB)
		values (\"".$DPID."\",\"".$CLID."\",\"".$STATUSCODE."\",\"".$SUBSTATUSCODE."\",\"".$ACCAT."\",\"".$OCCUP."\",\"".$NAME."\",\"".$FNAME."\",\"".$AD1."\",\"".$AD2."\",\"".$AD3."\",\"".$AD4."\",\"".$PIN."\",\"".$PHONE."\",\"".$FAX."\",\"".$JT1."\",\"".$FJT1."\",\"".$JT2."\",\"".$FJT2."\",\"".$PAN1."\",\"".$PAN2."\",\"".$PAN3."\",\"".$NOM."\",\"".$NOMNAME."\",\"".$NAD1."\",\"".$NAD2."\",\"".$NAD3."\",\"".$NAD4."\",\"".$NPIN."\",\"".$DBMINOR."\",\"".$MIND."\",\"".$ACNO."\",\"".$BANKNAME."\",\"".$BANKAD1."\",\"".$BANKAD2."\",\"".$BANKAD3."\",\"".$BANKAD4."\",\"".$BANKPIN."\",\"".$RBIREF."\",\"".$RBIDATE."\",\"".$SEBIREGNO."\",\"".$BTAX."\",\"".$STATUS."\",\"".$MICRCD."\",\"".$IFSC."\",\"".$ACTYPE."\",\"".$NAMEMAPIN."\",\"".$JT1MAPIN."\",\"".$JT2MAPIN."\",\"".$EMAIL1."\",\"".$EMAIL2."\",\"".$EMAIL3."\",\"".$RGSFLG."\",\"".$ANREPFLG."\",\"".$UIDISTHOL."\",\"".$UID2NDHOL."\",\"".$UID3RDHOL."\",\"".$PANGAR."\",\"".$UIDGAR."\",\"".$PATST."\",\"".$K."\",\"".$DATADATE."\",\"".$DOB."\");";		
mysqli_query($con,$sql2);	
}


	$qsql3="Select * from lockdt where CC = \"".$CC."\" AND DPID = \"".$DPID."\" AND CLID = \"".$CLID."\" AND ISIN = \"".$ISIN."\" AND LOCKDT = \"".$LOCKDT."\"  AND DATADATE = \"".$DATADATE."\" AND LOCKRES = \"".$LOCKRES."\";";	
	$result3 =  mysqli_query($con,$qsql3);
	

	if (mysqli_num_rows($result3) > 0) {
		$psql3="update lockdt set 
		RECTYPE= \"".$RECTYPE."\" ,  
		LINE= \"".$LINE."\" ,  
		BENTYP= \"".$BENTYP."\" ,  
		HOLDING= \"".$HOL."\" ,  
		LOCKIND= \"".$LOCKIND."\" 
		
		where 
		
		CC = \"".$CC."\" AND 
		DPID = \"".$DPID."\" AND 
		CLID = \"".$CLID."\" AND 
		ISIN = \"".$ISIN."\" AND  
		LOCKDT = \"".$LOCKDT."\" AND  
		LOCKRES = \"".$LOCKRES."\" AND 
		DATE = \"".$DATADATE."\";";
		mysqli_query($con,$psql3);
	} 
	else {
		$sql3="INSERT INTO lockdt values (\"".$RECTYPE."\",\"".$LINE."\",\"".$DPID."\",\"".$CLID."\",\"".$BENTYP."\",\"".$HOL."\",\"".$LOCKIND."\",\"".$LOCKRES."\",\"".$LOCKDT."\",\"".$CC."\",\"".$ISIN."\",\"".$DATADATE."\");";
		mysqli_query($con,$sql3);
	}
	




	// if($i==1 || $i%2000==1){
	// $sql1="INSERT INTO dematholding values (\"".$CC."\",\"".$HOL."\",\"".$FREEHOL."\",\"".$HOLLCK."\",\"".$HOLBLOCK."\",\"".$HOLPLD."\",\"".$HOLPLDLCK."\",\"".$HOLPLDUNC."\",\"".$HOLPLDLCKU."\",\"".$HOLREM."\",\"".$HOLREMLCK."\",\"".$HOLCMIDD."\",\"".$HOLCMPOOL."\",\"".$HOLSET."\",\"".$NDUPOSHOLD."\",\"".$NDULOCKHOL."\",\"".$NDUUNCPOS."\",\"".$NDUUNCLOCK."\",\"".$DPID."\",\"".$CLID."\",\"".$ISIN."\",\"".$DATADATE."\",\"".$LOCKDT."\",\"".$LOCKCOD."\",\"".$PLDGCOD."\")";
	// $sql2="INSERT INTO demataddress (DPID,CLID,statuscode,substatuscode,ACCAT,OCCUP,NAME,FNAME,AD1,	AD2,AD3,AD4,PIN,PHONE,FAX,JT1,FJT1,JT2,FJT2,PAN1,PAN2,PAN3,NOM,NOMNAME,NAD1,NAD2,NAD3,NAD4,NPIN,DBMINOR,MIND,ACNO,BANKNAME,BANKAD1,BANKAD2,BANKAD3,BANKAD4,BANKPIN,RBIREF,RBIDATE,SEBIREGNO,BTAX,STATUS,MICRCD,IFSC,ACTYPE,NAMEMAPIN,JT1MAPIN,JT2MAPIN,EMAIL1,EMAIL2,EMAIL3,RGSFLG,ANREPFLG,UIDISTHOL,UID2NDHOL,UID3RDHOL,PANGAR,UIDGAR,PATST,K,DATADATE,DOB)
	// values (\"".$DPID."\",\"".$CLID."\",\"".$STATUSCODE."\",\"".$SUBSTATUSCODE."\",\"".$ACCAT."\",\"".$OCCUP."\",\"".$NAME."\",\"".$FNAME."\",\"".$AD1."\",\"".$AD2."\",\"".$AD3."\",\"".$AD4."\",\"".$PIN."\",\"".$PHONE."\",\"".$FAX."\",\"".$JT1."\",\"".$FJT1."\",\"".$JT2."\",\"".$FJT2."\",\"".$PAN1."\",\"".$PAN2."\",\"".$PAN3."\",\"".$NOM."\",\"".$NOMNAME."\",\"".$NAD1."\",\"".$NAD2."\",\"".$NAD3."\",\"".$NAD4."\",\"".$NPIN."\",\"".$DBMINOR."\",\"".$MIND."\",\"".$ACNO."\",\"".$BANKNAME."\",\"".$BANKAD1."\",\"".$BANKAD2."\",\"".$BANKAD3."\",\"".$BANKAD4."\",\"".$BANKPIN."\",\"".$RBIREF."\",\"".$RBIDATE."\",\"".$SEBIREGNO."\",\"".$BTAX."\",\"".$STATUS."\",\"".$MICRCD."\",\"".$IFSC."\",\"".$ACTYPE."\",\"".$NAMEMAPIN."\",\"".$JT1MAPIN."\",\"".$JT2MAPIN."\",\"".$EMAIL1."\",\"".$EMAIL2."\",\"".$EMAIL3."\",\"".$RGSFLG."\",\"".$ANREPFLG."\",\"".$UIDISTHOL."\",\"".$UID2NDHOL."\",\"".$UID3RDHOL."\",\"".$PANGAR."\",\"".$UIDGAR."\",\"".$PATST."\",\"".$K."\",\"".$DATADATE."\",\"".$DOB."\")";
	// $sql3="INSERT INTO lockdt (DPID,CLID,HOLDING,LOCKDT,CC,ISIN,DATE)
	// values (\"".$DPID."\",\"".$CLID."\",\"".$HOL."\",\"".$LOCKDT."\",\"".$CC."\",\"".$ISIN."\",\"".$DATADATE."\")";	
	// }else{
	// $sql1.=",(\"".$CC."\",\"".$HOL."\",\"".$FREEHOL."\",\"".$HOLLCK."\",\"".$HOLBLOCK."\",\"".$HOLPLD."\",\"".$HOLPLDLCK."\",\"".$HOLPLDUNC."\",\"".$HOLPLDLCKU."\",\"".$HOLREM."\",\"".$HOLREMLCK."\",\"".$HOLCMIDD."\",\"".$HOLCMPOOL."\",\"".$HOLSET."\",\"".$NDUPOSHOLD."\",\"".$NDULOCKHOL."\",\"".$NDUUNCPOS."\",\"".$NDUUNCLOCK."\",\"".$DPID."\",\"".$CLID."\",\"".$ISIN."\",\"".$DATADATE."\",\"".$LOCKDT."\",\"".$LOCKCOD."\",\"".$PLDGCOD."\")";
	// $sql2.=",(\"".$DPID."\",\"".$CLID."\",\"".$STATUSCODE."\",\"".$SUBSTATUSCODE."\",\"".$ACCAT."\",\"".$OCCUP."\",\"".$NAME."\",\"".$FNAME."\",\"".$AD1."\",\"".$AD2."\",\"".$AD3."\",\"".$AD4."\",\"".$PIN."\",\"".$PHONE."\",\"".$FAX."\",\"".$JT1."\",\"".$FJT1."\",\"".$JT2."\",\"".$FJT2."\",\"".$PAN1."\",\"".$PAN2."\",\"".$PAN3."\",\"".$NOM."\",\"".$NOMNAME."\",\"".$NAD1."\",\"".$NAD2."\",\"".$NAD3."\",\"".$NAD4."\",\"".$NPIN."\",\"".$DBMINOR."\",\"".$MIND."\",\"".$ACNO."\",\"".$BANKNAME."\",\"".$BANKAD1."\",\"".$BANKAD2."\",\"".$BANKAD3."\",\"".$BANKAD4."\",\"".$BANKPIN."\",\"".$RBIREF."\",\"".$RBIDATE."\",\"".$SEBIREGNO."\",\"".$BTAX."\",\"".$STATUS."\",\"".$MICRCD."\",\"".$IFSC."\",\"".$ACTYPE."\",\"".$NAMEMAPIN."\",\"".$JT1MAPIN."\",\"".$JT2MAPIN."\",\"".$EMAIL1."\",\"".$EMAIL2."\",\"".$EMAIL3."\",\"".$RGSFLG."\",\"".$ANREPFLG."\",\"".$UIDISTHOL."\",\"".$UID2NDHOL."\",\"".$UID3RDHOL."\",\"".$PANGAR."\",\"".$UIDGAR."\",\"".$PATST."\",\"".$K."\",\"".$DATADATE."\",\"".$DOB."\")";	
	// $sql3.=",(\"".$DPID."\",\"".$CLID."\",\"".$HOL."\",\"".$LOCKDT."\",\"".$CC."\",\"".$ISIN."\",\"".$DATADATE."\")";	
	// }

	//mysqli_query($con,$sql2);
	//echo "$sql2<br><br><br><br>";


// echo "<p>";
	// echo $sql1;
	// echo $sql2;
	// echo "<p>";
	// print_r(mysqli_error_list($con));
	// echo "<p style='background:red'>".$pat_code_from_fill_zero_check['patcode']."</p>";
	// demat address ends
	
	// if($i%500==0){
	// 	// $sql1.=";";
	// 	// $sql2.=";";
	// 	// $sql3.=";";

	// 	//echo $sql2;		
		
	// 	// mysqli_multi_query($con,$sql1);
	// 	// mysqli_multi_query($con,$sql2);
	// 	// mysqli_multi_query($con,$sql3);
	// 	// mysqli_multi_query($con,$psql1);
	// 	// mysqli_multi_query($con,$psql2);
	// 	// mysqli_multi_query($con,$psql3);

	// 	$total= $sql1 . $sql2 . $sql3 . $psql1 . $psql2 . $psql3 ;
	// 	mysqli_multi_query($con,$total);

 	// 	$sql1 = "";
	// 	$sql2 = "";
	// 	$sql3 = "";
	// 	$psql1 = "";
	// 	$psql2 = "";
	// 	$psql3 = "";

	// 	$total = "";
	// }
}


// echo "$sql1 <br> <br>";
// echo "$sql2 <br> <br>";
// echo "$sql3 <br> <br>";
// echo "$psql1 <br> <br>";
// echo "$psql2 <br> <br>";
// echo "$psql3 <br> <br>";


// $total= $sql1 . $sql2 . $sql3 . $psql1 . $psql2 . $psql3 ;

// if($total!=null){
// 	mysqli_multi_query($con,$total);
// }


// if($sql1!=null||$sql1!=""){
// 	mysqli_multi_query($con,$sql1);
// }
// if($sql2!=null||$sql2!=""){
// 	mysqli_multi_query($con,$sql2);
// }
// if($sql3!=null||$sql3!=""){
// 	mysqli_multi_query($con,$sql3);
// }
// if($psql1!=null||$psql1!=""){
// 	mysqli_multi_query($con,$psql1);
// }
// if($psql2!=null||$psql2!=""){
// 	mysqli_multi_query($con,$psql2);
// }
// if($psql3!=null||$psql3!=""){
// 	mysqli_multi_query($con,$psql3);
// }


// if($sql2!=null||$sql2!=""||$sql1!=null||$sql1!=""||$sql3!=null||$sql3!=""){
	
// 	// $sql1.=";";
// 	// $sql2.=";";
// 	// $sql3.=";";

// 	mysqli_multi_query($con,$sql1);
// 	mysqli_multi_query($con,$sql2);
// 	mysqli_multi_query($con,$sql3);
// }


//$wsql=$sql1.$sql2;
//echo $sql1;
	
	//echo $sql2;
	//$sql2.=";";
	//echo $sql1;
	
	//$ws=$sql1.$sql2;
//echo $ws;
	//mysqli_query($con,$sql2);
	//mysqli_close($con);
   //mysqli_query($con,$sql1);
	//mysqli_query($con,$sql2);
	
	//mysqli_multi_query($con,$ws);
	//mysqli_multi_query($con,$sql2);
	
// print_r($c[0]);

echo "<h1 align='center'> <img style='margin-bottom:-100px' src='done.gif'> <br> <span 'margin-top:-100px'> DONE </span> </h1>";
// $cod1=mysqli_query($con,"select companycode from company_master where isin='$isin'");
// $a1=(mysqli_fetch_assoc($cod1));
// extract($a1);
// echo "<h1>isin $isin</h1>";
// echo "<h2>date $DATADATE</h2>";
// echo "<h2>company code $companycode</h2>";

 ?>


