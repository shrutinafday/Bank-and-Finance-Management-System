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
            <li><a href="adminPenalty.php">Penalties</a></li>
            <li><a href="adminComplaints.php">Pending Complaints</a></li>
            <li class="start selected"><a href="adminCard.php">Card Requests</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Pending Card Requests</h2>
			<h4>Select Category of Cards to Display</h4>
			
			<form action="#" method="POST">
			<p><label>Credit Card</label>
			<input type="checkbox" name="category[]" value="Credit"></p>
			<p><label>Debit Card</label>
			<input type="checkbox" name="category[]" value="Debit"></p>
			<p><label>Silver Card</label>
			<input type="checkbox" name="category[]" value="Silver"></p>
			<p><label>Gold Card</label>
			<input type="checkbox" name="category[]" value="Gold"></p>
			<p><label>Platinum Card</label>
			<input type="checkbox" name="category[]" value="Platinum"></p>
			<input type="submit" style="margin-left: 150px;" class="formbutton" name="submit" value="Display Card Requests">
			</form>
			
            <p>
			<?php
			$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
			$user_check=$_SESSION['username'];
			
			if(isset($_POST['submit']))
			{
				if(!empty($_POST['category']))
				{
					
					foreach($_POST['category'] as $selected)
					{	
						echo "<h2>$selected Card Requests</h2>";
						echo "<table border='1'>\n";
						$status1='Pending';
						$statement = oci_parse($conn,'select * from card where card_status=:status and admin_id=:username and card_type=:ctype');
						oci_bind_by_name($statement,":username",$user_check);
						oci_bind_by_name($statement,":status",$status1);
						oci_bind_by_name($statement,":ctype",$selected);
						$r=oci_execute($statement);
						echo "<tr><th>Card Number</th><th>Account ID</th><th>Card Type</th><th>Status</th></tr>";
						while (($row = oci_fetch_row($statement)) != false) 
						{ 
							echo " <tr>\n<td><a href=processCard.php?cid=",$row[0],"&sel=",$selected,">$row[0]</a></td><td> $row[1]</td><td>$row[3]</td><td>$row[4]</td></tr>\n";  
						} 
						echo "</table>\n";
						echo "<br>";
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