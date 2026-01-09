<html lang="en">
<head>
  <title>Welcome to Hotel Verdania</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel='stylesheet' type='text/css' href='mystyle.css' />
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark justify-content-center" id="nav">
  <a class="navbar-brand" href="Entry_Page.php">
    <img src="site_images/Logo_long.png" alt="logo" style="width:100px;">
  </a>
  
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="Entry_Page.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="View_Rooms.php">Rooms</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">History</a>
    </li>
	<li class="nav-item">
      <a class="nav-link" href="#footer">Contact us</a>
    </li>
  </ul>
</nav>

<div class="container" id="main">
  <div class="jumbotron text-center">
	<h1>Hotel Verdania</h1>
	<p>Come and stay a while!</p> 
  </div>

  <div class="container-fluid">
  <div id="demo" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#demo" data-slide-to="0" class="active"></li>
		<li data-target="#demo" data-slide-to="1"></li>
		<li data-target="#demo" data-slide-to="2"></li>
	</ul>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="site_images/Carousel_1.jpg" alt="Reception" width="600" height="400">
      <div class="carousel-caption">
        <h3>Book a room</h3>
        <p>The reception loves meeting new people!</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="site_images/Carousel_2.jpg" alt="Lounge" width="600" height="400">
      <div class="carousel-caption">
        <h3>Take a seat</h3>
        <p>Make yourself at home</p>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="site_images/Carousel_3.jpg" alt="Hub" width="600" height="400">
      <div class="carousel-caption">
        <h3>Have fun!</h3>
        <p>Meet our other customers and enjoy your stay</p>
      </div>   
    </div>
  </div>
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
  </div>
</div>
<br>
<div class="container text-center my-4">
  <p>
    Nestled in the heart of Serres, Hotel Verdania offers a warm and relaxing
    atmosphere for every guest. Whether you are visiting for leisure or business,
    our comfortable rooms, friendly staff, and inviting spaces ensure a stay
    you’ll remember.
  </p>
  <p>
    Sit back, unwind, and let us take care of the rest.
  </p>
</div>

<div class="text-center my-4">
  <form action="View_Rooms.php">
	<button type="submit" class="btn btn-outline-light btn-lg">View Rooms</button>
  </form>
</div>
<br>
<div class="row bg-dark text-white" id="footer">
	<div class="col-2"></div>
	<div class="col-5">
		<h4 class="footer_header">Contact us at:</h3>
		<p><img id="phone" src="site_images/telephone.png" width="25" height="25"> Phone: 14028195</p>
		<p><img id="email" src="site_images/email.png" width="25" height="25"> Mail: ver@falsemail.com</p>
	</div>
	<div class="col-5">
		<h4 class="footer_header">Find us at:</h3>
		<p><img id="house" src="site_images/house.png" width="25" height="25"> Location: Serres, Greece</p>
		<p><img id="location" src="site_images/location.png" width="25" height="25"> Coordinates: 41°04'28.6"N 23°33'18.6"E</p>
	</div>
</div>
</div>
</body>
</html>