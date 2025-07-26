<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
 

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="generator" content="">
  <title>PseudoTeam - Sign In</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">



  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Basic favicon -->
  <link rel="icon" href="../favicons/favicon.ico" type="image/x-icon">

  <!-- Optional for PNG -->
  <link rel="icon" href="../favicons/favicon.png" type="image/png">

  <!-- Optional for SVG -->
  <link rel="icon" href="../favicons/favicon.svg" type="image/svg+xml">



  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }

    /* Ensure the entire background is white */
    body,
    html {
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: white !important;
      /* Full white background */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-signin {
      width: auto !important;
      /* Allow it to expand */
      max-width: none !important;
      padding: 0 !important;
      margin: 0 auto !important;
      /* Ensure it is centered */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }


    /* Styling the login box as a square */
    .login-box {
      width: 600px !important;
      /* Make it a square */
      height: 500px !important;
      /* Same as width to keep it square */
      padding: 30px;
      background: rgba(255, 255, 255, 0.9);
      /* Almost white, blends with background */
      border-radius: 10px;
      /* Slight rounded edges */
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
      /* Soft shadow effect */
      display: flex;
      flex-direction: column;
      justify-content: center;
      /* Center content inside */
      align-items: center;
      /* Align items inside */
    }

    /* Reduce the size of form elements to fit in the square */
    .login-box img {
      width: 150px;
      height: auto;
      margin-bottom: 10px;
    }

    .login-box h1 {
      font-size: 18px;
      text-align: center;
    }

    .form-floating {
      width: 100%;
      margin-bottom: 10px;
    }

    .btn {
      width: 100%;
    }

    /* Responsive adjustments for tablets */
    @media (max-width: 768px) {
      .login-box {
        width: 90%;
        /* Adjust width for smaller screens */
        height: auto;
        /* Allow height to adjust */
        padding: 20px;
        /* Reduce padding */
      }
    }

    /* Ensure the form adjusts when resizing the window */
    @media (max-width: 1024px) {
      .login-box {
        width: 80%;
        height: auto;
        /* Adjust height automatically */
        padding: 25px;
      }
    }

    @media (max-width: 768px) {
      .login-box {
        width: 90%;
        height: auto;
        padding: 20px;
      }
    }

    @media (max-width: 480px) {
      .login-box {
        width: 95% !important;
        /* Almost full width on small screens */
        height: auto;
        padding: 15px;
        border-radius: 5px;
        /* Slightly reduce border radius */
      }

      .login-box img {
        width: 120px;
        /* Adjust logo size */
      }

      .login-box h1 {
        font-size: 16px;
        /* Reduce heading size for mobile */
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4">
 




  <main class="form-signin">
    <div class="login-box">
      <form method="POST" action="../methods/process-sign-in">
        <img src="../images/logo_pt.png" alt="Logo" width="200" height="65" class="d-block mx-auto">
        <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

        <div class="form-floating mb-3">
          <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>

        <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Remember me
          </label>
        </div>

        <button class="btn btn-primary w-100 py-2" name="sign-in-btn" type="submit">Sign in</button>
        <p class="mt-4 mb-0 text-center text-body-secondary">www.pseudoteam.com</p>
      </form>
    </div>
  </main>

  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>