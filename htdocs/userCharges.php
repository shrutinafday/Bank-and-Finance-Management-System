<?php
session_start();
?>
<!doctype html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Banking template</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--
brio, a free CSS web template by ZyPOP (zypopwebtemplates.com/)

Download: http://zypopwebtemplates.com/

License: Creative Commons Attribution
//-->
<script type="text/javascript">
	function reload()
	{
		 window.location="userCharges.php";
	}
</script>
	
</head>
<body>
<div id="container">
    <header>
    	<h1><a href="/">DBMS<span>BANKING SYSTEM</span></a></h1>
        <h2>Banking Solutions Simplified</h2>
    </header>
    <nav>
    	<ul>
        	<li><a href="userLogin.php">Account Summary</a></li>
            <li><a href="userTransfers.php">Transfers</a></li>
            <li><a href="userLoans.php">Loans</a></li>
            <li><a href="complaints.php">Complaints</a></li>
			<li class="start selected"><a href="userCharges.php">Charges</a></li>
			<li><a href="userCards.php">Cards</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Charges Due</h2>
			
			<a href="userPayments.php" class="button">View Payment History</a>

            <p>
			<?php
			
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			$statement = oci_parse($conn,'select * from charges_due c,account a where a.cust_id=:username and a.account_id=c.account_id order by c.charge_id asc' );
			oci_bind_by_name($statement,":username",$user_check);
			$r=oci_execute($statement);
			echo "<form action='#' method='post'>";
			echo "<table border='1'>\n";
			echo "<tr><th>Charge ID</th><th>Charge Type</th><th>Charge Description</th><th>Amount</th><th>Select</th></tr>";
			
			while (($row = oci_fetch_row($statement)) != false) 
			{ 				
				echo " <tr>\n<td>$row[0]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td><input value=$row[0] name='Charge_checked[]' type='checkbox'/></td></tr>\n"; 
				 
			} 
			echo "</table>\n";
			echo "<input type='submit' style='margin-left: 150px;' class='formbutton' name='submit' value='Make Payments'>";
			echo "</form>";
			
			if(isset($_POST['submit']))
			{
				if(!empty($_POST['Charge_checked']))
				{
					
					foreach($_POST['Charge_checked'] as $selected)
					{

						$redBal=oci_parse($conn,'update account set balance = balance - (Select charge_amount from charges_due c, 
						account a where a.cust_id=:username and a.account_id=c.account_id and c.charge_id =:cid) where account_id= (Select account_id from account 
						where cust_id = :username)');
						oci_bind_by_name($redBal,":username",$user_check);
						oci_bind_by_name($redBal,":cid",$selected);						
						oci_execute($redBal);							
					
						$pid=oci_parse($conn, 'Select max(to_number(trim(pay_id)))+1 from payments');
						$r1=oci_execute($pid);
						if (($row = oci_fetch_row($pid)) != false)
						{
							$payid=$row[0];
						}
						
						
						$aid = oci_parse($conn,'select * from account a where a.cust_id=:username');
						oci_bind_by_name($aid,":username",$user_check);
						$r2=oci_execute($aid);
						if (($row = oci_fetch_row($aid)) != false)
						{
							$aid=$row[0];
							$bid=$row[2];
						}
						
						
						$payamt = oci_parse($conn, 'Select charge_amount from charges_due c, account a where a.cust_id=:username and 
						a.account_id=c.account_id and c.charge_id =:cid');
						oci_bind_by_name($payamt,":username",$user_check);
						oci_bind_by_name($payamt,":cid",$selected);
						oci_execute($payamt);
						if (($row = oci_fetch_row($payamt)) != false)
						{
							$zid=$row[0];							
						}
						
															
						
						$addPay=oci_parse($conn,'insert into payments (pay_id, account_id, cust_id, amount)values 
						(:payid, :aid, :bid, :payamt)');
						oci_bind_by_name($addPay, ":payid", $payid);
						oci_bind_by_name($addPay, ":aid", $aid);
						oci_bind_by_name($addPay, ":bid", $bid);
						oci_bind_by_name($addPay, ":payamt", $zid);
						oci_execute($addPay);
						
						$delSt=oci_parse($conn,'delete from charges_due where charge_id=:cid');
						oci_bind_by_name($delSt,":cid",$selected);
						oci_execute($delSt);
							
					}
						
		
				}
				
				echo "<script> reload(); 	
				</script>";
				
			}
			?>			
						
			</p>
			
						

		</article>
	
        </section>
        
        <aside class="sidebar">
	
            <ul>	
               <li>
                    <h4>My Profile</h4>
                    <ul>
                        <li>Change password</li>
                        <li>Edit personal Information</li>
                        
                    </ul>
                </li>
				<li>
                    <h4>Locations</h4>
                    <ul>
                        <li>Gainesville</li>
                        <li>Orlando</li>
                        <li>Jacksonville</li>
                        
                    </ul>
                </li>
             
                
            </ul>
		
        </aside>
    	<div class="clear"></div>
    </div>
    <footer>
        <div class="footer-content">
            <ul>
            	<li><h4>Jobs</h4></li>
                <li><a href="#">Apply for jobs</a></li>
                <li><a href="#">Internship Opportunities</a></li>
                
            </ul>
            
            <ul>
            	<li><h4>Contact Us</h4></li>
                <li><a href="#">Branch Locator</a></li>
                <li><a href="#">Talk to online customer assistant</a></li>
                
            </ul>
            
            
            
            <div class="clear"></div>
        </div>
        <div class="footer-bottom">
            <p>&copy; BankingSystem 2016.</p>
         </div>
    </footer>
    
</div>
</body>
</html>