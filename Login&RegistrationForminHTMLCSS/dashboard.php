<!DOCTYPE html>
<html>
<head>
<title>Cricket Game Management System Dashboard</title>
<style>
body {
background-color: green;
color: white;
font-family: Arial, sans-serif;
}
h1 {
text-align: center;
font-size: 48px;
margin-top: 50px;
margin-bottom: 50px;
}
.container {
display: flex;
flex-wrap: wrap;
justify-content: center;
align-items: center;
}
.card {
background-color: white;
color: black;
width: 300px;
height: 200px;
margin: 20px;
border-radius: 10px;
box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
text-align: center;
font-size: 24px;
font-weight: bold;
text-decoration: none;
transition: all 0.2s ease-in-out;
}
.card:hover {
transform: scale(1.1);
box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
}
.card:hover h2 {
color: green;
}
.card:hover p {
color: black;
}
.card:hover img {
transform: scale(1.1);
}
img {
width: 100px;
height: 100px;
margin-bottom: 20px;
transition: all 0.2s ease-in-out;
}
</style>
</head>
<body>
<h1>Cricket Game Management System Dashboard</h1>
<div class="container">
<a href="#" class="card">
<img src="players.png">
<h2>Players</h2>
<p>View and manage players</p>
</a>
<a href="#" class="card">
<img src="matches.png">
<h2>Matches</h2>
<p>View and manage matches</p>
</a>
<a href="#" class="card">
<img src="venues.png">
<h2>Venues</h2>
<p>View and manage venues</p>
</a>
<a href="#" class="card">
<img src="tickets.png">
<h2>Tickets</h2>
<p>View and manage tickets</p>
</a>
</div>
</body>
</html>