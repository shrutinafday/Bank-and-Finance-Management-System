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
			<li class="start selected"><a href="adminLoans.php">Loan Requests</a></li>
            <li><a href="adminPenalty.php">Penalties</a></li>
            <li><a href="adminComplaints.php">Pending Complaints</a></li>
            <li><a href="adminCard.php">Card Requests</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Pending Loans</h2>

            <p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			$loanId=$_GET['lid'];
			$selected=$_GET['sel'];
			$st1=oci_parse($conn,'update loans set status= :stat where loan_id=:lid and admin_id=:username');
			$status1='Pending';
			$status2='Issued';
			oci_bind_by_name($st1,":username",$user_check);
			oci_bind_by_name($st1,":stat",$status2);
			oci_bind_by_name($st1,":lid",$loanId);
			$r1=oci_execute($st1);
			
			commit;
			$statement = oci_parse($conn,'select * from loans where status=:status and admin_id=:username and branch_id=:username and loan_id != :lid and loan_type=:ltype');
			oci_bind_by_name($statement,":username",$user_check);
			oci_bind_by_name($statement,":status",$status1);
			oci_bind_by_name($statement,":lid",$loanId);
			oci_bind_by_name($statement,":ltype",$selected);
			$r=oci_execute($statement);
			
			
			echo "<table border='1'>\n";
			echo "<tr><th>Loan ID</th><th>Type</th><th>Amount</th><th>Status</th><th>Customer ID</th></tr>";
			while (($row = oci_fetch_row($statement)) != false) 
			{ 
				echo " <tr>\n<td><a href=processLoan.php?lid=",$row[0],"&sel=",$selected,">$row[0]</a></td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td> $row[5]</td></tr>\n";  
			} 
			echo "</table>\n";
			echo "<br>";
			
			function histview()
			{
				echo "<br>";
				echo " <h2>Loan History</h2>";
				echo "<br>";
				$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
				$user_check=$_SESSION['username'];
				$status2='Pending';
				$statement1 = oci_parse($conn,'select * from loans where cust_id=:username and status!=:status');
				oci_bind_by_name($statement1,":username",$user_check);
				oci_bind_by_name($statement1,":status",$status2);
				$r1=oci_execute($statement1);
				echo "<table border='1'>\n";
				echo "<tr><th>Loan ID</th><th>Type</th><th>Amount</th><th>Status</th></tr>";
				while (($row = oci_fetch_row($statement1)) != false) 
				{ 
					echo " <tr>\n<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>\n";  
				} 
				echo "</table>\n";
				echo "<br>";
			}
			
			function loanapply()
			{
				include('loancheck.php');
				echo " <br>";
				echo " <h2>Loan Details</h2>";
				echo " <br>";
				echo " <fieldset>";
                echo " <legend>Enter the Purpose of Loan and the Amount that ou wish to borrow</legend>";
				echo " <form method=\"post\" action=\"\">";
				echo " <p><label for=\"type1\">Purpose:</label>";
                echo " <select name=\"type\">
								<option value=\"Personal\">Personal</option>
								<option value=\"Education\">Education</option>
								<option value=\"Home\">Home</option>
								<option value=\"Car\">Car</option>
						</select>";
				echo " <p><label for=\"amt\">Amount</label>";
				echo " <input name=\"amount\" id=\"amount\" value=\"\" type=\"text\" /></p>";
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
				loanapply();
			}
			
			
			
			?>
			<br>Click for more details.
			
			<a href="userLoans.php?history=true" class="button">View History</a>
			<a href="userLoans.php?apply=true" class="button">Apply for Loan</a>
			<a href="loanStats.php?all=true" class="button">View Statistics</a>
			
			
			<br><br><br>If you have any complaints, register them at <a href="complaints.php">Complaints</a><br>
			<h6>(Please provide us with the loan id)</h6>
			
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