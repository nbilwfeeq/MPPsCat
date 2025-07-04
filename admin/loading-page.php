<?php 
include 'database/config.php';
include 'session/security.php';

$page = 'sCat | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Sistem Cetakan Atas Talian - MPP CatS">
    <meta name="description" content="Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar, Kolej Vokasional Kuala Selangor">
    <link rel="shortcut icon" href="images/icon-mpp.png" type="image/x-icon">

    <title><?php echo $page; ?></title>

  <style>
    /* Center the loading container */
    .loading {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Size of the loading animation */
    #loading-container {
      width: 150px;
      height: 150px;
    }

    /* Keyframes for the spinner animation */
    @keyframes spinnerAnimation {
      0% {
        stroke-dasharray: 1 150;
        stroke-dashoffset: 0;
        transform: rotate(0deg);
      }
      50% {
        stroke-dasharray: 120 30;
        stroke-dashoffset: -120;
        transform: rotate(180deg);
      }
      100% {
        stroke-dasharray: 1 150;
        stroke-dashoffset: -280;
        transform: rotate(360deg);
      }
    }

    /* Spinner animation settings */
    #spinner {
      transform-origin: center;
      animation: spinnerAnimation 2s cubic-bezier(0.47, 0, 0.745, 0.715) infinite;
      filter: url(#shadow);
    }

    /* Text styling */
    .text {
      text-align: center;
      margin-top: 20px;
      font-family: 'Arial', sans-serif;
      font-size: 1vh;
      color: #c7b3f2;
    }

    /* Smooth fade-in effect for the loading text */
    @keyframes textFadeIn {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }

    .text h2, .text p {
      animation: textFadeIn 1s ease-in-out forwards;
    }
</style>

</head>
<body>
  <div class="loading" id="loading-container">
      <svg viewBox="0 0 100 100">
          <defs>
              <filter id="shadow">
                  <feDropShadow dx="0" dy="0" stdDeviation="3" flood-color="#c7b3f2" />
              </filter>
          </defs>
          <!-- Spinner circle -->
          <circle id="spinner" style="fill:transparent; stroke:#c7b3f2; stroke-width: 7px; stroke-linecap: round;" cx="50" cy="50" r="45"/>
      </svg>
      <div class="text">
          <h2>Loading, please wait...</h2>
          <p>You will be redirected shortly.</p>
      </div>
  </div>

  <script>
          const urlParams = new URLSearchParams(window.location.search);
          const target = urlParams.get('target');

          setTimeout(function() {
              window.location.href = target ? target : 'dashboard.php?status=loggedIn';
              window.location.href = target ? target : 'index.php?status=registered';
              window.location.href = target ? target : 'index.php?status=loggedOut';
              window.location.href = target ? target : '';
              window.location.href = target ? target : '';
          }, 2000);
  </script>
</body>
</html>
