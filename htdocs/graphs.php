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
				<h2>Total Spending on Different Categories</h2>
				<canvas id="categories" width="610" height="250">
					[No canvas support]
				</canvas>

				<h2>Past 10 Years' Spending : </h2>
				<canvas id="years" width="610" height="250">
							[No canvas support]
				</canvas>
				
				<?php
					$conn = oci_connect('vvaibhav','oceanfury9','oracle.cise.ufl.edu:1521/orcl');
					$user_check=$_SESSION['username'];
					$syear = oci_parse($conn,'select extract(year from date_trans), sum(Amount)
											  from transactions
										      where extract(year from date_trans)>2006 and account_id=(select account_id from account where cust_id=:username)
											  group by extract(year from date_trans)
											  order by 1 desc');
					oci_bind_by_name($syear,":username",$user_check);
					$r=oci_execute($syear);
					$year=array();
					$yearlyamount=array();
					$i=0;
					while(($row = oci_fetch_row($syear)) != false)
					{
					$yearlyamount[$i]=$row[1];
					$year[$i]=$row[0];
					$i++;
					}
					echo "<script>";
					echo "var name1 = ".json_encode($year).";";
					echo "</script>";
					echo "<script>";
					echo "var yamount = ".json_encode($yearlyamount).";";
					echo "var a1 = parseFloat(yamount[0]);";
					echo "var a2 = parseFloat(yamount[1]);";
					echo "var a3 = parseFloat(yamount[2]);";
					echo "var a4 = parseFloat(yamount[3]);";
					echo "var a5 = parseFloat(yamount[4]);";
					echo "var a6 = parseFloat(yamount[5]);";
					echo "var a7 = parseFloat(yamount[6]);";
					echo "var a8 = parseFloat(yamount[7]);";
					echo "var a9 = parseFloat(yamount[8]);";
					echo "var a10 = parseFloat(yamount[9]);";
					echo "</script>";
					echo " <fieldset>";
                echo " <legend>Enter the Year whose details you would like to see</legend>";
				echo " <form method=\"post\" action=\"graphs2.php\">";
				echo " <p><label for=\"yearlabel\">Year:</label>";
				echo " <input name=\"yearvalue\" id=\"yearvalue\" value=\"\" type=\"text\" /></p>";
				echo " <p><input name=\"submit\" style=\"margin-left: 150px;\" class=\"formbutton\" value=\"Get Details\" type=\"submit\" /></p>";
				echo " </form>";
				echo " </fieldset>";
				
				
					$spie = oci_parse($conn,'select trans_category, sum(Amount)
											  from transactions
										      where account_id=(select account_id from account where cust_id=:username)
											  group by trans_category
											  ');
					oci_bind_by_name($spie,":username",$user_check);
					$r=oci_execute($spie);
					$cat=array();
					$catamt=array();
					$i=0;
					while(($row = oci_fetch_row($spie)) != false)
					{
					$cat[$i]=$row[0];
					$catamt[$i]=$row[1];
					$i++;
					}
					echo "<script>";
					echo "var cat = ".json_encode($cat).";";
					echo "</script>";
					echo "<script>";
					echo "var catamt = ".json_encode($catamt).";";
					echo "var c1 = parseFloat(catamt[0]);";
					echo "var c2 = parseFloat(catamt[1]);";
					echo "var c3 = parseFloat(catamt[2]);";
					echo "var c4 = parseFloat(catamt[3]);";
					echo "var c5 = parseFloat(catamt[4]);";
					echo "</script>";
					
					
				?>
				
				<script>
					var data = [4,8,6,3,1,2,5];
					var bar = new RGraph.Bar({
					id: 'years',
					data: [a1,a2,a3,a4,a5,a6,a7,a8,a9,a10],
					options: {
					tooltips: [a1,a2,a3,a4,a5,a6,a7,a8,a9,a10],
					labels: [name1[0],name1[1],name1[2],name1[3],name1[4],name1[5],name1[6],name1[7],name1[8],name1[9]],
					shadowBlur: 0,
					shadowOffsetx: 2,
					shadowOffsety: 2,
					strokestyle: 'rgba(0,0,0,0)',
					backgroundGridVlines: false,
					backgroundGridBorder: true,
					noxaxis: false,
					colors: ['Gradient(#ad0000)']
					}
					}).grow();
					


				
				</script>
				<script>
				var pie1 = new RGraph.Pie({
				id: 'categories',
				data: [c1,c2,c3,c4,c5],
				options: {
                radius: 100,
                tooltips: catamt,
                labels: cat,
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
					window.__pie__ = pie1;
					for (var i=0; i<obj.data.length; ++i) 
					{
						setTimeout('window.__pie__.explodeSegment('+i+',10)', i * 50);
					}
				}
				if (RGraph.ISOLD) {
					pie1.draw();
        
				} 
				else if (navigator.userAgent.toLowerCase().indexOf('firefox') >= 0) {
					pie1.roundRobin();
        
				}
				else {
            /**
            * The RoundRobin callback initiates the exploding
            */
					pie1.roundRobin(null, myExplode);
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