<!DOCTYPE html>
<html>
<head>
	<title>Cricket Games Booking and Management System Dashboard</title>
	<style>
		body {
			background-color: #66BB6A;
		}

		header {
			background-color: #FFFFFF;
			text-align: center;
			padding: 20px;
		}

		nav ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

		nav li {
			display: inline-block;
			margin-right: 20px;
		}

		nav li a {
			color: #FFFFFF;
			text-decoration: none;
		}

		nav li a:hover {
			color: #000000;
		}

		main {
			margin: 20px;
		}

		section {
			margin-bottom: 20px;
			padding: 20px;
			"background-image: url('pexels-tim-gouw-139762.jpg')";
			color:white;
		}

		section h2 {
			margin-top: 0;
		}
	</style>
</head>
<body style="background-image: url('pexels-tim-gouw-139762.jpg')">
	<header>
		<h1>Cricket Games Booking and Management System Dashboard</h1>
	</header>

	<nav>
		<ul>
			<li><a href="#User Profile">User Profile</a></li>
			<li><a href="#Playing Matches Module">Playing Matches Module</a></li>
			<li><a href="#Ticket Booking Module">Ticket Booking Module</a></li>
			<li><a href="#Payment Module">Payment Module</a></li>
      <li><a href="#Logout">Logout</a></li>
		</ul>
	</nav>

	<main>
	<center>
		<section id='User Profile'>
			<h2>User Profile</h2>
			<?php
            include 'server.php';
            // connect to the database
            $db = new mysqli("localhost", "root", "", "authenticate");
            
            // check connection
            if ($db->connect_error) {
              die("Connection failed: " . $db->connect_error);
            }
            
            // retrieve user information from the database
            $user_id = $_SESSION["userid"]; // assuming the user ID is passed as a parameter
            $sql = "SELECT username, email, profile_pic FROM users WHERE id = $user_id";
            $result = $db->query($sql);
            
            // display user information
            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $name = $row["username"];
              $email = $row["email"];
              $profile_pic = $row["profile_pic"];
              
              echo "<h1>$name's Profile</h1>";
              echo "<p>Name: $name</p>";
              echo "<p>Email: $email</p>";
              echo "<img src='$profile_pic' alt='Profile Picture'>";
            } else {
              echo "User not found";
            }
            
            // close database connection
            $db->close();
            ?>
            
		</section>

		<section id='Playing Matches Module'>
			<h2>Playing Matches Module</h2>
			<?php
        // connect to the database
        $db = new mysqli("localhost", "root", "", "authenticate");

        // check connection
        if ($db->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // retrieve upcoming matches from the database
        $sql = "SELECT * FROM matches WHERE date >= CURDATE() ORDER BY date ASC";
        $result = $db->query($sql);

        // display upcoming matches
        if ($result->num_rows > 0) {
          echo "<h1>Upcoming Matches</h1>";
          echo "<table>";
          echo "<tr><th>Date</th><th>Team 1</th><th>Team 2</th><th>Location</th></tr>";
          while ($row = $result->fetch_assoc()) {
            $date = $row["date"];
            $team1 = $row["team1"];
            $team2 = $row["team2"];
            $location = $row["location"];
            
            echo "<tr><td>$date</td><td>$team1</td><td>$team2</td><td>$location</td></tr>";
          }
          echo "</table>";
        } else {
          echo "No upcoming matches";
        }

        // close database connection
        $db->close();
        ?>

		</section>

		<section id='Ticket Booking Module'>
			<h2>Ticket Booking Module</h2>
			<?php


        // check if the user is logged in
        if (!isset($_SESSION["userid"])) {
          header("Location: login.php"); // redirect to the login page if not logged in
          exit();
        }

        // check if the booking form has been submitted
        if (isset($_POST["submit"])) {
          $date = $_POST["date"];
          $team1 = $_POST["team1"];
          $team2 = $_POST["team2"];
          $location = $_POST["location"];
          
          // connect to the database
          $db = new mysqli("localhost", "root", "", "authenticate");

          // check connection
          if ($db->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          // insert the booking into the database
          $user_id = $_SESSION["userid"];
          $sql = "INSERT INTO bookings (user_id, date, team1, team2, location) VALUES ('$user_id', '$date', '$team1', '$team2', '$location')";
          if ($db->query($sql) === TRUE) {
            echo "Booking successful";
          } else {
            echo "Error: " . $sql . "<br>" . $db->error;
          }

          // close database connection
          $db->close();
        }

        // display the booking form
        echo "<h1>Book a Cricket Game</h1>";
        echo "<form method='post'>";
        echo "<label for='date'>Date:</label>";
        echo "<input type='date' id='date' name='date' required><br>";
        echo "<label for='team1'>Team 1:</label>";
        echo "<input type='text' id='team1' name='team1' required><br>";
        echo "<label for='team2'>Team 2:</label>";
        echo "<input type='text' id='team2' name='team2' required><br>";
        echo "<label for='location'>Location:</label>";
        echo "<input type='text' id='location' name='location' required><br>";
		echo "<script>alert('Your Sit Stadium is Booked Successfully');</script>";
        echo "<input type='submit' name='submit' value='Book' >";
        echo "</form>";
        ?>

		</section>

		<section id='Payment Module'>
			<h2>Payment Module</h2>
			<marquee><h2> Pay At The Stadium Entrance</h2></marquee>
			<?php

        // check if the user is logged in and has made a booking
        if (!isset($_SESSION["userid"]) || !isset($_SESSION["booking_id"])) {
          //header("Location: login.php"); // redirect to the login page if not logged in or no booking has been made
          exit();
        }

        // check if the payment form has been submitted
        if (isset($_POST["submit"])) {
          $card_number = $_POST["card_number"];
          $expiry_month = $_POST["expiry_month"];
          $expiry_year = $_POST["expiry_year"];
          $cvv = $_POST["cvv"];
          $amount = $_SESSION["booking_amount"];
          
          // connect to the payment gateway
          $gateway_url = "https://your-payment-gateway.com/pay";
          $gateway_data = array(
            "card_number" => $card_number,
            "expiry_month" => $expiry_month,
            "expiry_year" => $expiry_year,
            "cvv" => $cvv,
            "amount" => $amount,
            "currency" => "USD",
            "merchant_id" => "your_merchant_id",
            "api_key" => "your_api_key"
          );
          $gateway_options = array(
            "http" => array(
              "method" => "POST",
              "header" => "Content-type: application/x-www-form-urlencoded\r\n",
              "content" => http_build_query($gateway_data)
            )
          );
          $gateway_context = stream_context_create($gateway_options);
          $gateway_response = file_get_contents($gateway_url, false, $gateway_context);
          
          // handle the payment response
          if ($gateway_response === "success") {
            echo "Payment successful";
            
            // mark the booking as paid in the database
            $booking_id = $_SESSION["booking_id"];
            $db = new mysqli("localhost", "root", "", "authenticate");
            if ($db->connect_error) {
              die("Connection failed: " . $db->connect_error);
            }
            $sql = "UPDATE bookings SET paid = 1 WHERE id = '$booking_id'";
            if ($db->query($sql) === TRUE) {
              echo "Booking marked as paid";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $db->close();
            
            // clear the session variables for the booking and payment
            unset($_SESSION["booking_id"]);
            unset($_SESSION["booking_amount"]);
          } else {
            echo "Payment failed";
          }
        }

        // retrieve the booking details from the database
        $booking_id = $_GET["booking_id"];
        $db = new mysqli("localhost", "username", "", "authenticate");
        if ($db->connect_error) {
          die("Connection failed: " . $db->connect_error);
        }
        $sql = "SELECT * FROM bookings WHERE id = '$booking_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $date = $row["date"];
          $team1 = $row["team1"];
          $team2 = $row["team2"];
          $location = $row["location"];
          $amount = 50; // assume the price is fixed at $50 per booking
          $_SESSION["booking_id"] = $booking_id;
          $_SESSION["booking_amount"] =$amount;
        } else {
        echo "Booking not found";
        }
        $db->close();
      ?>
		</section>

    <section id='Logout'>
      <h2>Logout</h2>
      <?php
      session_start();
      session_destroy();
      header("Location: login.php"); // Redirect to login page
      exit;
      ?>
	  <p>&copy; 2023 Cricket Games Booking and Management System</p>
    </section>
	</center>
	<footer>
	
    </footer>
	</main>

	
</body>
</html>