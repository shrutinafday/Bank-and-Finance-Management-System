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
            <li class="start selected"><a href="adminComplaints.php">Pending Complaints</a></li>
            <li><a href="adminCard.php">Card Requests</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

	    <article>
				
			
			<h2>Complaints Lodged</h2>
			<h4>Select Category of Complaints to Display</h4>
			<h6>(Click on Account Number for more details)</h6><br>
			<form action="#" method="POST">
			<p><label>Card Complaints</label>
			<input type="checkbox" name="category[]" value="Card"></p>
			<p><label>Transaction Complaints</label>
			<input type="checkbox" name="category[]" value="Transaction"></p>
			<p><label>Payment Complaints</label>
			<input type="checkbox" name="category[]" value="Payment"></p>
			<p><label>Levied Charges Complaints</label>
			<input type="checkbox" name="category[]" value="Charge"></p>
			<input type="submit" style="margin-left: 150px;" class="formbutton" name="submit" value="Display Selected Complaints">
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
						$statement = oci_parse($conn,'select * from complaints c where c.admin_id=:username and c.complaint_type=:ctype');
						oci_bind_by_name($statement,":username",$user_check);
						oci_bind_by_name($statement,":ctype",$selected);
						$r=oci_execute($statement);
						echo "<table border='1'>\n";
						echo "<tr><th>Complaint ID</th><th>Account ID</th><th>Complaint Type</th><th>Ref No</th><th>Description</tr>";
						while($row=oci_fetch_row($statement))
						{
							echo " <tr>\n<td>$row[0]</td><td><a href=processComplaints.php?coid=",$row[0],"&ctype=",$selected,"&acc=",$row[2],"&ref=",$row[4]," class=button>$row[2]</a></td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>\n";  
						}
						echo "</table>\n";
						echo "<br><br>";
						
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
			