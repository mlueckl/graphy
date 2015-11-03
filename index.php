<!DOCTYPE html>
<html>
	<head>
		<title>Sheldon - Be noisy</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<script type="text/javascript" src="js/jquery-latest.min.js"></script>
	</head>
	<body>
		<div class="main">
			<div class="head">
				<header>
					<img src="img/logo.png" alt="Logo">
					<h1>WS Monitoring</h1>
					<ul>
						<li><a href="index.php">Check</a></li>
						<li><a href="chart.php">Graph</a></li>
					</ul>
					<span><?php echo date("G:i:s m.d.y");?></span>
				</header>
			</div>
			<div class="content">
				<table></table>
				<div class="table-footer">
					<img id="loadingimg" src="img/load.gif" alt="loading">
					<p id="count"></p>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		window.onload = Init;
		var count = 0;
		var totalLength = 0;

		function Init(){
			LoadData();
		}

		function LoadData(){
			jQuery.get("data.json", function(data) {
			   console.log("=> Load file and parse to JSON");
			   for(var i=0; i < data.length; i++){
				    totalLength = data.length;
			   		Request(data[i]["db"], data[i]["url"]);
			   }
			});
		}

		function Request(db, url){
			$.ajax({
				type: "POST",
			    url: "curl.php",
			    dataType: "json",
			    data: {
			        url: url,
			        param: "q%5B0%5D=9bd597d291349d24cfaaa1372ce061c9&q%5B1%5D=a78d43db809c1b816b1ece087ef176cd&q%5B2%5D=72ade56f8df948a55dce90878d65ed68&q%5B3%5D=9bacef70ee59f7b6ec0fe8f379b3ecf3&q%5B4%5D=a4aad8bdbde7573305b26d0e048339af&q%5B5%5D=73f3349731c05ea293ea0827a7d5dc4b&q%5B6%5D=1bdd0aacde59bbb69da2bc7ac1b08ae3&q%5B7%5D=6fa120615afa4b0cbb8de1be8d20756b&q%5B8%5D=497972b55aa390b4f4fff937a2e6d412&q%5B9%5D=772e5ef21cd037e1b3b3e77bf5cfb3dc",
			        db: [db]
			    },
				success: function(data){
					HandleResponse(data);
					count++;
					$("#count").text(count + "/" + totalLength);

					if( count == totalLength ){
						$("#loadingimg").hide();
					}
				}
			});
		}

		function HandleResponse(data){

			if(data[1] != undefined){
				if(typeof data[1] == "string"){
					if(data[1].toLowerCase().indexOf("error") > -1 || data[1].toLowerCase().indexOf("forbidden") > -1){
						Append({"data": data});
					}else{
						var json = jQuery.parseJSON(data[1]);
						var arrayIndex = Math.floor(Math.random() * 9) + 1;

						if(json[arrayIndex]["md5"]){
							if(json == ""){
								status = "red";
							}else if(data[2] < 1){
								status = "green";
							}else if(data[2] < 5){
								status = "orange";
							}else{
								status = "red";
							}

							Append({"status": status, "data": data, "json": json, "index": arrayIndex});
						}else{
							Append({"data": data});
						}
					}
				}else{
					Append({"data": data});
				}
			}else{
				//console.log("Undefined");
				//console.log(data);
			}
		}

		function Append(object){
			if(object["json"]){
				$("table").append("<tr><td><img src='img/" + object["status"] + ".png' alt='statusImage'></td><td>" + object["data"][0] + "</td><td class='td-data'>" + object["data"][2] + "s</td><td class='td-data'>" + object["json"][object["index"]]["md5"] + "</td><td class='td-data'>" + object["json"][object["index"]]["status"] + "</td></tr>");

			}else{
				$("table").append("<tr><td><img src='img/red.png' alt='statusImage'></td><td>" + object["data"][0] + "</td><td class='td-data'>" + object["data"][2] + "s</td><td class='td-data'>Response</td><td>" + object["data"][1] + "</td></tr>");
			}
		}
		</script>

	</body>
</html>
