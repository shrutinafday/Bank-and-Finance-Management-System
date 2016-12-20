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
			<li><a href="userLogin.php">Account Summary</a></li>
            <li><a href="userTransactions.php">Transfers</a></li>
            <li><a href="userLoans.php">Loans</a></li>
            <li class="start selected"><a href="complaints.php">Complaints</a></li>
			<li><a href="userCharges.php">Charges</a></li>
			<li><a href="userCards.php">Cards</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">		

		<section id="content">

	    <article>
				
			
			<h2>Complaints</h2>
			

            <p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			$statement = oci_parse($conn,'select Complaint_ID,Details from account,complaints where account.cust_id=:username and complaints.acc_ID=account.Account_ID');
			oci_bind_by_name($statement,":username",$user_check);
			$r=oci_execute($statement);
			echo "<table border='1'>\n";
			echo "<tr><th>Complaint_ID</th><th>Details</th></tr>";
			while (($row = oci_fetch_row($statement)) != false)
			{
				echo " <tr>\n";
				echo " <td>$row[0]</td><td>$row[1]</td>\n"; // the rows value indicate the column number you need form the select statemennt.
				echo " </tr>\n";
			}
			echo "</table>\n";
			/* insert into Complaints 	(Complaint_ID, Admin_ID, acc_ID, Complaint_Type, Reference_No, Details)
			values (5,'1',1641,'Charge','4','Reportinginvalidchargelevied');
			*/			
					
			?>
			<br>
						
			<a href="makeComplaint.php" class="button">Make a complaint</a>
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