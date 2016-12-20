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
</head>
<body>
<div id="container">
    <header>
    	<h1><a href="/">DBMS<span>BANKING SYSTEM</span></a></h1>
        <h2>Banking Solutions Simplified</h2>
    </header>
    <nav>
    	<ul>
        	<li><a href="adminLogin.php">Administrator Home</a></li>
			<li><a href="adminLoans.php">Loan Requests</a></li>
            <li class="start selected"><a href="adminPenalty.php">Penalties</a></li>
            <li><a href="adminComplaints.php">Pending Complaints</a></li>
            <li><a href="adminCard.php">Card Requests</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Penalties</h2>
			
            <p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			$bal='Insufficient Balance';
			$statement = oci_parse($conn,'select * from account a where a.balance<1500 and a.branch_id=:username and a.account_id not in 
											(select account_id from charges_due c where c.admin_id=:username and c.charge_type=:bal)');
			oci_bind_by_name($statement,":bal",$bal);
			oci_bind_by_name($statement,":username",$user_check);
			$r=oci_execute($statement);
			echo "<form action='#' method='post'>";
			echo "<table border='1'>\n";
			echo "<tr><th>Customer ID</th><th>Account Number</th><th>Balance</th><th>Select to Charge penalty</th></tr>";
			while($row=oci_fetch_row($statement))
			{
				echo " <tr>\n<td>$row[2]</td><td>$row[0]</td><td>$row[4]</td><td><input value=$row[0] name='charge[]' type='checkbox'/></td></tr>\n";  
			}
			echo "</table>\n";
			echo "<br><br>";
			echo "<input type='submit' style='margin-left: 150px;' class='formbutton' name='submit' value='Add Charges'>";
			echo "</form>";
			echo "<br>";
			
			if(isset($_POST['submit']))
			{
				if(!empty($_POST['charge']))
				{
					
					foreach($_POST['charge'] as $selected)
					{
						$max=oci_parse($conn,'select max(to_number(trim(charge_id)))+1
												from charges_due
												where account_id=:selected');
						oci_bind_by_name($max,":selected",$selected);
						oci_execute($max);
						if (($row = oci_fetch_row($max)) != false)
						{
							$cid=$row[0];							
						}
						echo "$cid";
						$ctype='Insufficient Balance';
						$cdesc='Minimum Balance for account not met';
						$amt=20;
						$ins=oci_parse($conn,'insert into charges_due(charge_id,account_id,admin_id,charge_type,charge_description,charge_amount) values
												(:cid,:selected,:usercheck,:ctype,:cdesc,:amt)');
						oci_bind_by_name($ins,":cid",$cid);
						oci_bind_by_name($ins,":selected",$selected);
						oci_bind_by_name($ins,":usercheck",$user_check);
						oci_bind_by_name($ins,":ctype",$ctype);
						oci_bind_by_name($ins,":cdesc",$cdesc);
						oci_bind_by_name($ins,":amt",$amt);
						$r=oci_execute($ins);
						echo "<script type=\"text/javascript\">
									alert(\"Charge Successfully Added\");
									window.location=\"adminPenalty.php\";
								</script>";
						
												
					}
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