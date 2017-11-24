<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <title>404 - Page Not Found </title>
  <meta name="description" content="<?php echo $message; ?>">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,600' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" />
<style>
/*
404 Template - V1.1
Team - Mine Web Design
Developed @ 23-12-2015
follow us @minewebdesignn (twitter)	
*/

html {
  font-size: 62.5%; 
}

body {
  font-size: 1.5em;
  line-height: 1.6;
  font-weight: 400;
  font-family: "Roboto", Arial, sans-serif;
      color: #0F3E5A;
    text-shadow: 1px 1px 1px rgba(255, 255, 255, .5);
  background-color: #3C8DBC;
  padding:3rem 0rem 7rem 0rem; 

}

h1, h2, h3, h4, h5, h6 {
  margin-top: 0;
  margin-bottom: 1rem;
  font-weight: 300; }
h1 { font-size: 4.0rem; line-height: 1.2;  letter-spacing: -.1rem;}
h2 { font-size: 3.6rem; line-height: 1.25; letter-spacing: -.1rem; }
h3 { font-size: 3.0rem; line-height: 1.3;  letter-spacing: -.1rem; }
h4 { font-size: 2.4rem; line-height: 1.35; letter-spacing: -.08rem; }
h5 { font-size: 1.8rem; line-height: 1.5;  letter-spacing: -.05rem; }
h6 { font-size: 1.5rem; line-height: 1.6;  letter-spacing: 0; }


@media (min-width: 550px) {
  .container {
    width: 80%; }
  h1 { font-size: 5.0rem; }
  h2 { font-size: 4.2rem; }
  h3 { font-size: 3.6rem; }
  h4 { font-size: 2.2rem; }
  h5 { font-size: 2.0rem; }
  h6 { font-size: 1.5rem; }	

}

@media (max-width: 900px) {
 form{
  	display: none;
  }
}
button,
.button {
  margin-bottom: 1rem; }
input,
textarea,
select,
fieldset {
  margin-bottom: 1.5rem; }
pre,
blockquote,
dl,
figure,
table,
p,
ul,
ol,
form {
  margin-bottom: 2.5rem; }

.container:after,
.row:after
{
  content: "";
  display: table;
  clear: both; }
  
 /* 404 Style */
.row {
	 
text-align: center;
margin-top: 10%;
	 }  
 
.container {
  position: relative;
  width: 100%;
  max-width: 960px;
  margin: 0 auto;
  padding: 0 ;
  box-sizing: border-box; }
 
.title {
	font-weight: bold;
	text-align:center; }

.sub-heading {
	font-size: 1.5rem;
	text-align:center;
	
	margin: 10px 0; }

hr.hr-style-404 {
    border: 0;
    height: 1px;
	width: 150px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(255, 255, 255, 0.65), rgba(0, 0, 0, 0)); }
.redirect-style-404{
	text-align: center;
}
.redirect-style-404 p
{
	text-align: center;
}


</style>
</head>
<body>
<div class="row">
	<div class="container">
		<h1 class="title animated bounceInDown"><?php echo $message; ?></h1>
		<p class="sub-heading animated zoomIn"> <?php echo $heading; ?></p>
		
		

		

	</div>


</div>


</body>
</html>