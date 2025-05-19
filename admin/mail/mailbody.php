<?php

echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Company Newsletter</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }
    .container {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .header {
      background-color: #006EC4;
      padding: 20px;
      text-align: center;
    }
    .header img {
      width: 150px;
      height: auto;
    }
    .content {
      padding: 30px 20px;
      color: #333333;
    }
    .content h1 {
      color: #006EC4;
      font-size: 24px;
      margin-bottom: 10px;
    }
    .content p {
      font-size: 16px;
      line-height: 1.6;
    }
    .button {
      display: inline-block;
      padding: 12px 20px;
      background-color: #006EC4;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 20px;
    }
    .footer {
      background-color: #f1f1f1;
      padding: 15px;
      text-align: center;
      font-size: 12px;
      color: #777777;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Header with logo -->
    <div class="header">
      <img src="https://pseudoteam.com/homepage/home/logo.png" alt="Pseudoteam Logo">
    </div>
 
 

    <div class="content">
      <h1>🌟 Dummy Heading: Your Project, Our Priority</h1>
      <p>Hello User,</p>
      <p>
        A quick update!
      </p>
      <p>
        Your project has been uploaded.
      </p>
      <p>
        Our team is working hard to ensure every milestone is completed with precision and on time. You can track progress, review updates, and communicate directly with our team anytime.
      </p>
      <a href="#" class="button">View Project Dashboard</a>
    </div>
 

    <div class="footer">
      © 2025 Pseudoteam. All rights reserved. <br>
      You are receiving this email because you are a valued customer.
    </div>
  </div>
</body>
</html>
';


?>