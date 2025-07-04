<style>
.carousel-item {
  height: 100vh;
  position: relative;
}

.carousel-item .overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background: rgba(0, 0, 0, 0.4); 
  z-index: 1;
}

.carousel-caption {
  position: absolute;
  top: 20%; 
  left: 50%;
  transform: translateX(-50%); 
  text-align: center;
  z-index: 2;
}

.carousel-caption h2, 
.carousel-caption h4 {
  text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
}

.carousel-caption h2 b,
.carousel-caption h4 b {
  color: var(--main-purple2);
}

.carousel-caption p a {
  margin-top: 10px;
}

.carousel-caption p a.btn {
  background-color: transparent; 
  border: 2px solid white; 
  color: white; 
  padding: 10px 20px; 
  text-transform: uppercase;
  font-weight: bold;
  transition: background-color 0.3s ease, color 0.3s ease; 
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

.carousel-caption p a.btn:hover {
  background-color: var(--main-purple2); 
  color: white; 
  border-color: var(--main-purple2);
  box-shadow: 0 5px 20px var(--main-purple2);
}

@media (max-width: 768px) {
  .carousel-caption {
    top: 30%;
  }

  .carousel-caption h2 {
    font-size: 1.2rem;
  }

  .carousel-caption h4 {
    font-size: 1rem;
  }

  .carousel-caption p a {
    font-size: 0.5rem;
  }
}

@media (min-width: 769px) and (max-width: 1200px) {
  .carousel-caption h2 {
    font-size: 2.5rem;
  }

  .carousel-caption h4 {
    font-size: 1.8rem;
  }

  .carousel-caption p a {
    font-size: 1.1rem;
  }
}
</style>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  
  <div class="carousel-inner">
    <!-- Slide 1 -->
    <div class="carousel-item active" style="background-image: url('images/slider/slider1.jpg'); background-size: cover; background-position: center;">
      <div class="carousel-caption d-md-block">
        <h2 class="text-white">Selamat Datang ke Sistem Cetakan Atas Talian <b>MPP</b> KVKS</h2>
        <h4 class="text-white">"Young <b>Leaders</b> Creates New <b>Generations</b>"</h4><br>
        <h4 class="text-white">Sebarang Pertayaan <b>Sila Hubungi</b> 013-755-8636 <b> & </b>013-328-6664</h4>
        <br>
        <p><a href="reservations.php" class="btn btn-success">Tempah Sekarang!</a></p>
      </div>
      <div class="overlay"></div>
    </div>
    <!-- Slide 2 -->
    <div class="carousel-item" style="background-image: url('images/slider/slider2.jpg'); background-size: cover; background-position: center;">
      <div class="carousel-caption d-md-block">
        <h2 class="text-white">Selamat Datang ke Sistem Cetakan Atas Talian <b>MPP</b> KVKS</h2>
        <h4 class="text-white">"Young <b>Leaders</b> Creates New <b>Generations</b>"</h4><br>
        <h4 class="text-white">Sebarang Pertayaan <b>Sila Hubungi</b> 013-755-8636 <b> & </b>013-328-6664</h4>
        <br>
        <p><a href="reservations.php" class="btn btn-success">Tempah Sekarang!</a></p>
      </div>
      <div class="overlay"></div>
    </div>
    <!-- Slide 3 -->
    <div class="carousel-item" style="background-image: url('images/slider/slider3.jpg'); background-size: cover; background-position: center;">
      <div class="carousel-caption d-md-block">
        <h2 class="text-white">Selamat Datang ke Sistem Cetakan Atas Talian <b>MPP</b> KVKS</h2>
        <h4 class="text-white">"Young <b>Leaders</b> Creates New <b>Generations</b>"</h4><br>
        <h4 class="text-white">Sebarang Pertayaan <b>Sila Hubungi</b> 013-755-8636 <b> & </b>013-328-6664</h4>
        <br>
        <p><a href="reservations.php" class="btn btn-success">Tempah Sekarang!</a></p>
      </div>
      <div class="overlay"></div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Custom interval
  var carouselElement = document.querySelector('#carouselExampleIndicators');
  var carousel = new bootstrap.Carousel(carouselElement, {
    interval: 3000, 
    ride: 'carousel'
  });

  // Optional: You can control the carousel manually using the methods provided by Bootstrap Carousel
  // Example: Move to the next slide every 1 second
  setInterval(function() {
    carousel.next();
  }, 3000);
</script>
