<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
      .card .checkmark {
    border-radius: 6px;
    position: relative;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
         background-color: #f8faf5 !important;
}
    </style>
    <body>
      <div class="card" style="margin: 5% auto;">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5;  margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
        <?php
  header('Refresh:5; url= '. base_url().'my-account'); 
  echo "You will be redirected in 5 seconds...";
?>
      </div>
    </body>
</html>