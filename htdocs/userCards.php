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
		 window.location="userCards.php";
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
			<li><a href="userCharges.php">Charges</a></li>
			<li class="start selected"><a href="userCards.php">Cards</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Active Cards</h2>

            <p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			$status1='Issued';
			$statement = oci_parse($conn,'select * from card c, account a where a.cust_id=:username and c.account_id=a.account_id and 
			c.card_status=:status');
			oci_bind_by_name($statement,":username",$user_check);
			oci_bind_by_name($statement,":status",$status1);
			$r=oci_execute($statement);
			echo "<table border='1'>\n";
			echo "<tr><th>Card Number</th><th>Card_Type</th><th>Card_Status</th></tr>";
			while (($row = oci_fetch_row($statement)) != false) 
			{ 
				echo " <tr>\n<td>$row[0]</td><td>$row[3]</td><td>$row[4]</td></tr>\n";  
			} 
			echo "</table>\n";
			echo "<br>";
			
			function histview()
			{
				echo "<br>";
				echo " <h2>Card History</h2>";
				echo "<br>";
				$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
				$user_check=$_SESSION['username'];
				$status2='Issued';
				$statement1 = oci_parse($conn,'select * from card c, account a where a.cust_id=:username and c.account_id=a.account_id and 
				c.card_status!=:status order by c.card_status');
				oci_bind_by_name($statement1,":username",$user_check);
				oci_bind_by_name($statement1,":status",$status2);
				$r1=oci_execute($statement1);
				echo "<table border='1'>\n";
				echo "<tr><th>Card Number</th><th>Card Type</th><th>Card Status</th></tr>";
				while (($row = oci_fetch_row($statement1)) != false) 
				{ 
					echo " <tr>\n<td>$row[0]</td><td>$row[3]</td><td>$row[4]</td></tr>\n";  
				} 
				echo "</table>\n";
				echo "<br>";
			}
			
			function cardapply()
			{				
				echo " <br>";
				echo " <h2>Card Details</h2>";
				echo " <br>";
				echo " <fieldset>";
                echo " <legend>Enter the type of Card you wish to issue</legend>";
				echo " <form method=\"post\" action=\"userCards.php?apply=true\">";
				echo " <p><label for=\"type1\">Type:</label>";
                echo " <select name=\"type\">
								<option value=\"Credit\">Credit</option>
								<option value=\"Debit\">Debit</option>
								<option value=\"Silver\">Silver</option>
								<option value=\"Gold\">Gold</option>
								<option value=\"Platinum\">Platinum</option>
						</select>";
				echo " <p><input name=\"submit\" style=\"margin-left: 150px;\" class=\"formbutton\" value=\"Apply\" type=\"submit\" /></p>";
				echo " </form>";
				echo " </fieldset>";
			}
			if (isset($_GET['history'])) 
			{
				histview();
			}
			if (isset($_GET['apply'])) 
			{
				cardapply();
				
				$capp = oci_parse($conn,'select * from account a where a.cust_id=:username');
				oci_bind_by_name($capp,":username",$user_check);
				$r=oci_execute($capp);
				if (($row = oci_fetch_row($capp)) != false)
				{
					$aid=$row[0];
					$bid=$row[1];
				}
				
				$carno = oci_parse($conn,'select max(card_number)+1 from card');				
				$r=oci_execute($carno);
				if (($row = oci_fetch_row($carno)) != false)
				{
					$cardno=$row[0];
				}
				
				$status='Pending';
				
				$type=$_POST['type'];
								
				$appCard=oci_parse($conn,'insert into card (card_number, account_id, admin_id, card_type, card_status)
				values (:cardno, :aid, :bid, :type, :status)');
				oci_bind_by_name($appCard,":cardno",$cardno);
				oci_bind_by_name($appCard,":aid",$aid);
				oci_bind_by_name($appCard,":bid",$bid);
				oci_bind_by_name($appCard,":type",$type);
				oci_bind_by_name($appCard,":status",$status);
				
				if (isset($_POST['submit']))
				{
					oci_execute($appCard);
				}
										
				
				

			}
			
			
			
			?>
			<br>Click for more details.
			
			<a href="userCards.php?history=true" class="button">View History</a>
			<a href="userCards.php?apply=true" class="button">Apply for Card</a>
						
			
			<br><br><br>If you have any complaints, register them at <a href="complaints.php">Complaints</a><br>
			<h6>(Please provide us with the Card Number)</h6>
			
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