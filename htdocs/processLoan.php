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
			
				
				$st1 = oci_parse($conn,'select * from loans l where l.loan_id=:lid and l.admin_id=:username and l.loan_type=:ltype');
				oci_bind_by_name($st1,":username",$user_check);
				oci_bind_by_name($st1,":lid",$loanId);
				oci_bind_by_name($st1,":ltype",$selected);
				$r1=oci_execute($st1);
				$row1=oci_fetch_row($st1);
				
				$statement = oci_parse($conn,'select * from account a where a.cust_id=:username');
				oci_bind_by_name($statement,":username",$row1[5]);
				$r=oci_execute($statement);
				$row=oci_fetch_row($statement);
				
				echo "<table>";
				echo "<tr><th> Loan ID</th><th> Customer ID</th><th>Loan Amount</th><th>Loan Type</th><th>Account Balance</th></tr>";
				echo "<tr><td>$row1[0]</td><td>$row[2]</td><td>$row1[2]</td><td>$row1[1]</td><td>$row[4]</td></tr>";
				echo "</table>";
			
			echo "<br>";
			
			echo "<a class='button' href=issueLoan.php?lid=",$loanId,"&sel=",$selected,">Issue</a>";
			echo "\t \t";
			echo "<a class='button' href=denyLoan.php?lid=",$loanId,"&sel=",$selected,">Deny</a>";
			
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