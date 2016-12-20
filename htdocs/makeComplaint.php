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
				
			
			<h2>Register complaint:-</h2>
			

            <p>
			<?php
			$connection = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');			
			
			$user_check=$_SESSION['username'];			
			//$statement = oci_parse($connection,'select * from account a where a.cust_id=:username');
			//oci_bind_by_name($statement,":username",$user_check);
			//$r=oci_execute($statement);
			/*
			echo "<table border='1'>\n";
			echo "<tr><th>Account Number</th><th>Balance Available</th></tr>";
			while (($row = oci_fetch_row($statement)) != false) 
			{ 
				echo " <tr>\n"; 
				echo " <td>$row[0]</td><td>$row[4]</td>\n"; 
				echo " </tr>\n";
			} 
			echo "</table>\n";
			*/
			
			echo " <br>";
			echo " <h2>Complaint Details</h2>";
			echo " <br>";
			echo " <fieldset>";
            echo " <legend>Enter the type of complaint and the details of the issue</legend>";
			echo " <form method=\"post\" action=\"\">";
			echo " <p><label for=\"type1\">Purpose:</label>";
            echo " <select name=\"complainType\">
							<option value=\"Card\">Card</option>
							<option value=\"Charge\">Charge</option>
							<option value=\"Payment\">Payment</option>
							<option value=\"Transactions\">Transactions</option>
					</select>";
			echo " <p><label for=\"ref\">Reference Number</label>";
			echo " <input name=\"ref\" id=\"ref\" value=\"\" type=\"text\" /></p>";
			echo " <p><label for=\"details\">Details</label>";
			echo " <input name=\"details\" id=\"details\" value=\"\" type=\"text\" /></p>";
			echo " <p><input name=\"submit\" style=\"margin-left: 150px;\" class=\"formbutton\" value=\"Send\" type=\"submit\" /></p>";
			echo " </form>";
			echo " </fieldset>";
			
			
			
			// Define variables for insert
			$complainType=$_POST['complainType'];
			$details=$_POST['details'];
			$ref=$_POST['ref'];
			
			$complaintID = oci_parse($connection,'select max(to_number(trim(Complaint_ID)))+1 from Complaints');
			
			$r=oci_execute($complaintID);
			if (($row = oci_fetch_row($complaintID)) != false)
			{
				$comID=$row[0];
			}
			//echo "$comID\n";
			
			$statement1 = oci_parse($connection,'select distinct * from complaints c,account a where a.cust_id=:username and c.acc_ID=a.Account_ID');
			oci_bind_by_name($statement1,":username",$user_check);
			
			$r=oci_execute($statement1);
			
			if (($row = oci_fetch_row($statement1)) != false)
			{
				$admID=$row[1];
				$accID=$row[2];			
			}		
			//echo "$admID\n";		
			//echo "$accID\n";		
			//echo "$refNo\n";		
			//echo "$details\n";	
			//echo "$complainType\n";				
			
			//check conditions on send and insert into DB		
		
			
			if (isset($_POST['submit']))
			//function complaintapply()
			{
				
				if (empty($_POST['details']))
				{
					echo '<script language="javascript">';
					echo 'alert("Enter details!")';
					echo '</script>';
				}
				else
				{
					$statement = oci_parse($connection,'insert into Complaints (Complaint_ID, Admin_ID, acc_ID, Complaint_Type, Reference_No, Details)
					values (:comID,:admID, :accID, :complainType, :refNo, :details)');
										
					oci_bind_by_name($statement,":comID",$comID);
					oci_bind_by_name($statement,":admID",$admID);
					oci_bind_by_name($statement,":accID",$accID);
					oci_bind_by_name($statement,":complainType",$complainType);
					oci_bind_by_name($statement,":refNo",$ref);
					oci_bind_by_name($statement,":details",$details);
					$r=oci_execute($statement);
					
					echo "<script type=\"text/javascript\">
								window.location = \"complaints.php\";
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