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
<script>
			function clearfn()
			{
				window.location = "loanStats.php?all=true";	
			}
</script>;
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
            <li class="start selected"><a href="userLoans.php">Loans</a></li>
            <li><a href="complaints.php">Complaints</a></li>
			<li><a href="userCharges.php">Charges</a></li>
			<li><a href="userCards.php">Cards</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
			<p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			$sloansapplied = oci_parse($conn,'select count(*) from loans where cust_id=:username');
			oci_bind_by_name($sloansapplied,":username",$user_check);
			$r=oci_execute($sloansapplied);
			if (($row = oci_fetch_row($sloansapplied)) != false)
			{
				$loansapplied=$row[0];
			}
			$samountapplied = oci_parse($conn,'select sum(amount) from loans where cust_id=:username');
			oci_bind_by_name($samountapplied,":username",$user_check);
			$ar=oci_execute($samountapplied);
			if (($arow = oci_fetch_row($samountapplied)) != false)
			{
				$amountapplied=$arow[0];
			}
			echo "Total Number of loans applied is : <u>$loansapplied</u> Total Amount : <u>$amountapplied</u><br>";
			$statusg='Issued';
			$sloansgranted = oci_parse($conn,'select count(*) from loans where cust_id=:username and status=:statusg');
			oci_bind_by_name($sloansgranted,":username",$user_check);
			oci_bind_by_name($sloansgranted,":statusg",$statusg);
			$r=oci_execute($sloansgranted);
			if (($row = oci_fetch_row($sloansgranted)) != false)
			{
				$loansgranted=$row[0];
			}
			$samountgranted = oci_parse($conn,'select sum(amount) from loans where cust_id=:username and status=:statusg');
			oci_bind_by_name($samountgranted,":username",$user_check);
			oci_bind_by_name($samountgranted,":statusg",$statusg);
			$r=oci_execute($samountgranted);
			if (($row = oci_fetch_row($samountgranted)) != false)
			{
				$amountgranted=$row[0];
			}
			echo "Total Number of loans granted is : <u>$loansgranted</u> Total Amount : <u>$amountgranted</u><br>";
			$statusr='Rejected';
			$sloansrejected = oci_parse($conn,'select count(*) from loans where cust_id=:username and status=:statusr');
			oci_bind_by_name($sloansrejected,":username",$user_check);
			oci_bind_by_name($sloansrejected,":statusr",$statusr);
			$r=oci_execute($sloansrejected);
			if (($row = oci_fetch_row($sloansrejected)) != false)
			{
				$loansrejected=$row[0];
			}
			$samountrejected = oci_parse($conn,'select sum(amount) from loans where cust_id=:username and status=:statusr');
			oci_bind_by_name($samountrejected,":username",$user_check);
			oci_bind_by_name($samountrejected,":statusr",$statusr);
			$r=oci_execute($samountrejected);
			if (($row = oci_fetch_row($samountrejected)) != false)
			{
				$amountrejected=$row[0];
			}
			echo "Total Number of loans rejected are : <u>$loansrejected</u> Total Amount : <u>$amountrejected</u><br>";
			$typep='Personal';
			$spersonal = oci_parse($conn,'select count(*) from loans where cust_id=:username and loan_type=:typep');
			oci_bind_by_name($spersonal,":username",$user_check);
			oci_bind_by_name($spersonal,":typep",$typep);
			$r=oci_execute($spersonal);
			if (($row = oci_fetch_row($spersonal)) != false)
			{
				$personal=$row[0];
			}
			$sapersonal = oci_parse($conn,'select sum(amount) from loans where cust_id=:username and loan_type=:typep');
			oci_bind_by_name($sapersonal,":username",$user_check);
			oci_bind_by_name($sapersonal,":typep",$typep);
			$r=oci_execute($sapersonal);
			if (($row = oci_fetch_row($sapersonal)) != false)
			{
				$apersonal=$row[0];
			}
			echo "Total Number of Personal Loans applied are : <u>$personal</u> Total Amount : <u>$apersonal</u><br>";
			$typee='Education';
			$sEducation = oci_parse($conn,'select count(*) from loans where cust_id=:username and loan_type=:typee');
			oci_bind_by_name($sEducation,":username",$user_check);
			oci_bind_by_name($sEducation,":typee",$typee);
			$r=oci_execute($sEducation);
			if (($row = oci_fetch_row($sEducation)) != false)
			{
				$education=$row[0];
			}
			$saEducation = oci_parse($conn,'select sum(amount) from loans where cust_id=:username and loan_type=:typee');
			oci_bind_by_name($saEducation,":username",$user_check);
			oci_bind_by_name($saEducation,":typee",$typee);
			$r=oci_execute($saEducation);
			if (($row = oci_fetch_row($saEducation)) != false)
			{
				$aeducation=$row[0];
			}
			
			echo "Total Number of Education Loans applied are : <u>$education</u> Total Amount : <u>$aeducation</u><br>";
			$typeh='Home';
			$shome = oci_parse($conn,'select count(*) from loans where cust_id=:username and loan_type=:typeh');
			oci_bind_by_name($shome,":username",$user_check);
			oci_bind_by_name($shome,":typeh",$typeh);
			$r=oci_execute($shome);
			if (($row = oci_fetch_row($shome)) != false)
			{
				$home=$row[0];
			}
			$sahome = oci_parse($conn,'select sum(amount) from loans where cust_id=:username and loan_type=:typeh');
			oci_bind_by_name($sahome,":username",$user_check);
			oci_bind_by_name($sahome,":typeh",$typeh);
			$r=oci_execute($sahome);
			if (($row = oci_fetch_row($sahome)) != false)
			{
				$ahome=$row[0];
			}
			echo "Total Number of Home Loans applied are : <u>$home</u> Total Amount : <u>$ahome</u><br>";
			$typec='Car';
			$scar = oci_parse($conn,'select count(*) from loans where cust_id=:username and loan_type=:typec');
			oci_bind_by_name($scar,":username",$user_check);
			oci_bind_by_name($scar,":typec",$typec);
			$r=oci_execute($scar);
			if (($row = oci_fetch_row($scar)) != false)
			{
				$car=$row[0];
			}
			$sacar = oci_parse($conn,'select sum(amount) from loans where cust_id=:username and loan_type=:typec');
			oci_bind_by_name($sacar,":username",$user_check);
			oci_bind_by_name($sacar,":typec",$typec);
			$r=oci_execute($sacar);
			if (($row = oci_fetch_row($sacar)) != false)
			{
				$acar=$row[0];
			}
			echo "Total Number of Car Loans applied are : <u>$car</u> Total Amount : <u>$acar</u><br>";
			
			echo "<br>";
			echo " <h2>Filters</h2>";
			echo " <br>";
			echo " <fieldset>";
            echo " <legend>Enter the filter criteria(s)</legend>";
			echo " <form method=\"post\" action=\"loanStats.php\">";
			echo " <p><label for=\"loanid\">Loan ID</label>";
            echo " <input name=\"loanid\" id=\"loanid\" value=\"\" type=\"text\" /></p>";	
			echo " <p><label for=\"type\">Type</label>";
            echo " <input name=\"type\" id=\"type\" value=\"\" type=\"text\" /></p>";	
			echo " <p><label for=\"amt\">Amount (Range)</label>";
			echo " <input name=\"amountl\" id=\"amountl\" value=\"\" type=\"text\" />  -  <input name=\"amounth\" id=\"amounth\" value=\"\" type=\"text\" /></p>";
			echo " <p><label for=\"status\">Status</label>";
			echo " <input name=\"status\" id=\"status\" value=\"\" type=\"text\" /></p>";
			echo " <p><input name=\"submit\" style=\"margin-left: 150px;\" class=\"formbutton\" value=\"Search\" type=\"submit\" />
				   <input type=\"button\" name=\"clear\" onclick=\"clearfn();\" class=\"formbutton\" value=\"Clear\" /></p>";
			echo " </form>";
			echo " </fieldset>";
			if(isset($_GET['all']))
			{
				$statementall = oci_parse($conn,'select * from loans where cust_id=:username');
				oci_bind_by_name($statementall,":username",$user_check);
				$r1=oci_execute($statementall);
				echo "<table border='1'>\n";
				echo "<tr><th>Loan ID</th><th>Type</th><th>Amount</th><th>Status</th></tr>";
				while (($row = oci_fetch_row($statementall)) != false) 
				{ 
					echo " <tr>\n<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>\n";  
				} 
				echo "</table>\n";
				echo "<br>";
			}
			else
			{
				$typef=$_POST['type']."%";
				if(empty($_POST['amountl']))
				{
					$amountlf=0;
				}
				else
				{
					$amountlf=$_POST['amountl'];
				}
				if(empty($_POST['amounth']))
				{
					$amounthf=999999999;
				}
				else
				{
					$amounthf=$_POST['amounth'];
				}
				$loanidf=$_POST['loanid']."%";
			    $statusf=$_POST['status']."%";
				$statementsome = oci_parse($conn,'select * from loans where cust_id=:username and lower(status) like :statusf and lower(loan_id) like :loanidf and lower(loan_type) like :typef and amount >= :amountlf and amount <= :amounthf');
				oci_bind_by_name($statementsome,":username",$user_check);
				oci_bind_by_name($statementsome,":statusf",$statusf);
				oci_bind_by_name($statementsome,":loanidf",$loanidf);
				oci_bind_by_name($statementsome,":amountlf",$amountlf);
				oci_bind_by_name($statementsome,":amounthf",$amounthf);
				oci_bind_by_name($statementsome,":typef",$typef);
				$r1=oci_execute($statementsome);
				echo "<table border='1'>\n";
				echo "<tr><th>Loan ID</th><th>Type</th><th>Amount</th><th>Status</th></tr>";
				while (($row = oci_fetch_row($statementsome)) != false) 
				{ 
					echo " <tr>\n<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td></tr>\n";  
				} 
				echo "</table>\n";
				echo "<br>";
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