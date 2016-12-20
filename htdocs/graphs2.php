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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="Rgraph/libraries/RGraph.common.core.js"></script>
<script src="Rgraph/libraries/RGraph.common.dynamic.js"></script>
<script src="Rgraph/libraries/RGraph.common.resizable.js"></script>
<script src="Rgraph/libraries/RGraph.bar.js"></script>
<script src="Rgraph/libraries/RGraph.common.tooltips.js"></script>
<script src="RGraph/libraries/RGraph.common.effects.js"></script>
<script src="RGraph/libraries/RGraph.common.key.js"></script>
<script src="RGraph/libraries/RGraph.drawing.rect.js"></script>



<script src="RGraph/libraries/RGraph.pie.js"></script>



</head>
<body>
<div id="container">
    <header>
    	<h1><a href="/">DBMS<span>BANKING SYSTEM</span></a></h1>
        <h2>Banking Solutions Simplified</h2>
    </header>
    <nav>
    	<ul>
        	<li class="start selected"><a href="userLogin.php">Account Summary</a></li>
            <li><a href="userTransfers.php">Transfers</a></li>
            <li><a href="userLoans.php">Loans</a></li>
            <li><a href="complaints.php">Complaints</a></li>
			<li><a href="userCharges.php">Charges</a></li>
			<li><a href="userCards.php">Cards</a></li>
            <li class="end"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div id="body">

		

		<section id="content">

			<article>
			<?php
			$yearselected=$_POST['yearvalue'];
				echo "<h2>Spending in $yearselected</h2>";
				?>
				<canvas id="mon" width="610" height="250">
					[No canvas support]
				</canvas>
				<br>
				<br>
				<a href="graphs.php" class="button">Back</a>
				<?php
					$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
					$user_check=$_SESSION['username'];
					$smonth = oci_parse($conn,'select trans_category, sum(Amount)
											  from transactions
										      where account_id=(select account_id from account where cust_id=:username) and extract(year from date_trans)=:year
											  group by trans_category
											  ');
					oci_bind_by_name($smonth,":username",$user_check);
					oci_bind_by_name($smonth,":year",$yearselected);
					$r=oci_execute($smonth);
					$cats=array();
					$catamts=array();
					$i=0;
					while(($row = oci_fetch_row($smonth)) != false)
					{
					$cats[$i]=$row[0];
					$catamts[$i]=$row[1];
					$i++;
					}
					echo "<script>";
					echo "var cats = ".json_encode($cats).";";
					echo "</script>";
					echo "<script>";
					echo "var catamts = ".json_encode($catamts).";";
					echo "var label = catamts;";
					echo "for ( var i=0;i<catamts.length;i++)
					{
						label[i]=parseFloat(catamts[i]);
					}";
					echo "var cs1 = parseFloat(catamts[0]);";
					echo "var cs2 = parseFloat(catamts[1]);";
					echo "</script>";
					
					
					
				?>
				<script>
				var pie = new RGraph.Pie({
				id: 'mon',
				data: label,
				options: {
                radius: 100,
                tooltips: catamts,
                labels: cats,
                strokestyle: 'black',
                linewidth: 1,
                shadowBlur: 20,
                shadowOffsetx: 0,
                shadowOffsety: 0,
                shadowColor: '#ad0000',
                textColor: 'black'
				}
				})
        
				var explode = 20;
				function myExplode (obj)
				{
					window.__pie__ = pie;
					for (var i=0; i<obj.data.length; ++i) 
					{
						setTimeout('window.__pie__.explodeSegment('+i+',10)', i * 50);
					}
				}
				if (RGraph.ISOLD) {
					pie.draw();
        
				} 
				else if (navigator.userAgent.toLowerCase().indexOf('firefox') >= 0) {
					pie.roundRobin();
        
				}
				else {
            /**
            * The RoundRobin callback initiates the exploding
            */
					pie.roundRobin(null, myExplode);
				};
				</script>
				
				
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