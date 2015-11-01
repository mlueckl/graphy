<!DOCTYPE html>
<html>
	<head>
		<title>Sheldon - Be noisy</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	</head>
	<body>
		<div class="content">
			<header>
				<div class="logo">
					<h1>Sheldon</h1>
					<p>Be annoying on <b id="count"></b></p>
				</div>
				<span><?php echo date("G:i:s m.d.y");?></span>
			</header>
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
					Append(data);
					count++;
					$("#count").text(count + "/" + totalLength);
				}
			});
		}

		function Append(data){

			if(data[1] != undefined){
				if(typeof data[1] == "string"){
					if(data[1].toLowerCase().indexOf("error") > -1 || data[1].toLowerCase().indexOf("forbidden") > -1){
						var status = "red";

						$(".content").append("<div class='row'><header class='" + status + "'><p>" + data[0] + "</p><p class='right'><b>" + data[2] + "s</b></p></header><div class='example'><p>Response:</p><p>" + data[1] + "</p></div></div>");
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

							$(".content").append("<div class='row'><header class='" + status + "'><p>" + data[0] + "</p><p class='right'><b>" + data[2] + "s</b></p></header><div class='example'><p><b>MD5: </b>" + json[0]["md5"] + "</p><p><b>Status: </b>" + json[0]["status"] + "</div></div>");
						}else{
							var status = "red";

							$(".content").append("<div class='row'><header class='" + status + "'><p>" + data[0] + "</p><p class='right'><b>" + data[2] + "s</b></p></header><div class='example'><p>Response:</p><p>" + data[1] + "</p></div></div>");
						}
					}
				}else{
					var status = "red";

					$(".content").append("<div class='row'><header class='" + status + "'><p>" + data[0] + "</p><p class='right'><b>" + data[2] + "s</b></p></header><div class='example'><p>Response:</p><p>" + data[1] + "</p></div></div>");
				}
			}else{
				//console.log("Undefined");
				//console.log(data);
			}
		}
		</script>
	</body>
</html>
