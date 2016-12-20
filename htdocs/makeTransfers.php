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
function transferSuccess()
{
	window.location="transferSuccess.php";
}
function transferFailed()
{
	window.location="transferFailed.php";
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
            <li class="start selected"><a href="userTransfers.php">Transfers</a></li>
            <li><a href="userLoans.php">Loans</a></li>
            <li><a href="complaints.php">Complaints</a></li>
			<li><a href="userCharges.php">Charges</a></li>
			<li><a href="userCards.php">Cards</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Transfers</h2>
			
			
			<nav class="subnavigation">
			
			<ul>
				<li><a href="userTransfers.php">Incoming Transfers</a></li>
				<li><a href="userTransfersOut.php">Outgoing Transfers</a></li>
				<li class="start selected"><a href="#">Make New Transfer</a></li>
				
			</ul>
			
			</nav>
			
            <p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			
			
			
			echo "<form method='post' action=''>";
            echo "<p><label for='toAcc'>Recipient Account Number:</label>";
            echo "<input name='toAcc' id='toAcc' value='' type='text' /></p>";
            echo "<p><label for='amt'>Amount:</label>";
            echo "<input name='amt' id='amt' value='' type='text' /></p>";
			echo "<p><input name='submit' style='margin-left: 150px;' class='formbutton' value='Transfer Money' type='submit' /></p>";
            echo "</form>";
            
			if(isset($_POST['submit']))
			{
					$st1 = oci_parse($conn,'select * from account a where a.account_id=:toAcc');
					oci_bind_by_name($st1,":toAcc",$_POST['toAcc']);
					$r=oci_execute($st1);
					if(($row=oci_fetch_row($st1))!=false)
					{
						$st3 = oci_parse($conn,'select * from account a where a.cust_id=:username');
						oci_bind_by_name($st3,":username",$user_check);
						$r3=oci_execute($st3);
						$row3=oci_fetch_row($st3);
						if($row3[4]-$_POST['amt']<=0)
						{
								echo "<script type=\"text/javascript\">
								transferFailed();
								</script>";
						}
						$st2=oci_parse($conn,'insert into transfer_money values(:fromAcc,:toAcc,:amt)');
						oci_bind_by_name($st2,":toAcc",$_POST['toAcc']);
						oci_bind_by_name($st2,":fromAcc",$row3[0]);
						oci_bind_by_name($st2,":amt",$_POST['amt']);
						oci_execute($st2);
						
						$st4=oci_parse($conn,'update account set balance=balance - :amt where account_id=:fromAcc');
						oci_bind_by_name($st4,":fromAcc",$row3[0]);
						oci_bind_by_name($st4,":amt",$_POST['amt']);
						oci_execute($st4);
						
						$st5=oci_parse($conn,'update account set balance=balance + :amt where account_id=:toAcc');
						oci_bind_by_name($st5,":toAcc",$_POST['toAcc']);
						oci_bind_by_name($st5,":amt",$_POST['amt']);
						oci_execute($st5);
						echo "<script type=\"text/javascript\">
								transferSuccess();
								</script>";
					}
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