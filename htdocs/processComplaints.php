<?php
session_start();
$coid=$_GET['coid'];
$ctype=$_GET['ctype'];
$ref=$_GET['ref'];
$acc=$_GET['acc'];
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
            <li><a href="adminPenalty.php">Penalties</a></li>
            <li class="start selected"><a href="adminComplaints.php">Pending Complaints</a></li>
            <li><a href="adminCard.php">Card Requests</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
		<h2>Complaint Type : <?php echo "$ctype"; ?></h2>
		<h2>Contact Details for Account : <?php echo "$acc"; ?></h2>
		<p>
		<?php
		$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
		$user_check=$_SESSION['username'];
		$astatement = oci_parse($conn,'select street,city,zip
										from customers
										where cust_id = (select a.cust_id from account a where a.account_id=:acc)');
		oci_bind_by_name($astatement,":acc",$acc);
		$r=oci_execute($astatement);
		while($rowa=oci_fetch_row($astatement))
		{
			$street=$rowa[0];
			$city=$rowa[1];
			$zip=$rowa[2];
		}
		
		
		$statement = oci_parse($conn,'select fname,lname,dob
										from customers
										where cust_id = (select a.cust_id from account a where a.account_id=:acc)');
		oci_bind_by_name($statement,":acc",$acc);
		$r=oci_execute($statement);
		echo "<table border='1'>\n";
		echo "<tr><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Address</th></tr>";
		while($row=oci_fetch_row($statement))
		{
			echo " <tr>\n<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$street $city ZIP-$zip</td></tr>\n";  
		}
		echo "</table>\n";
		echo "<br><br>";	
		$pstatement = oci_parse($conn,'select cus_ph
										from cust_phone
										where cust_id = (select a.cust_id from account a where a.account_id=:acc)');
		oci_bind_by_name($pstatement,":acc",$acc);
		$r=oci_execute($pstatement);
		$ph=array();
		$i=0;
		while($row=oci_fetch_row($pstatement))
		{
			$ph[$i]=$row[0];
			$i++;
		}
		echo "You may contact the customer to verify the details at : <b>$ph[0]</b> or <b>$ph[1]</b>";
		
		echo "<a href=resolveComplaints.php?coid=",$coid,"&ctype=",$ctype,"&acc=",$acc,"&ref=",$ref," class=button>Resolve Issue</a> <a href=deleteComplaints.php?coid=",$coid,"&ctype=",$ctype,"&acc=",$acc,"&ref=",$ref," class=button>Delete Complaint</a>";
		
		
?>
		
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
			