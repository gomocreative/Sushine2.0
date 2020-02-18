<!doctype html>
<html class="no-js" lang="zxx">

<head>
   <meta charset="utf-8">
   <meta name="author" content="@_andress.mm">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Title -->
   <title>SUNSHINESOLAR-CATÁLOGO</title>
   <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="imgdw/icon/logo.ico" />
   <!-- Plugin-CSS -->
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="css/linearicons.css">
   <link rel="stylesheet" href="css/magnific-popup.css">
   <link rel="stylesheet" href="css/animate.css">
   <!-- Main-Stylesheets -->
   <link rel="stylesheet" href="css/normalize.css">
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="css/responsive.css">
   <script src="js/vendor/modernizr-2.8.3.min.js"></script>
   <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
</head>

<body data-spy="scroll" data-target=".mainmenu-area">
   <!-- Preloader-content -->
   <div class="preloader">
      <span><i class="lnr lnr-sun"></i></span>
   </div>
   <!-- MainMenu-Area -->
   <nav class="mainmenu-area" data-spy="affix" data-offset-top="200">
      <div class="container-fluid">
         <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primary_menu">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="index"><img src="imgdw/logo1.png" alt="Logo"></a>
         </div>
         <div class="collapse navbar-collapse" id="primary_menu">
         <ul class="nav navbar-nav mainmenu">
                  <li class=""><a href="index#home_page">INICIO</a></li>
                  <li><a href="index#about_page">NOSOTROS</a></li>
                  <li class="active"><a href="index#gallery_page">PRODUCTOS</a></li>
                  <!-- <div class="dark-color hidden-lg hidden-md hidden-sm show-xs">
                     <li>
                           <a href="#">CATÁLOGO</a>
                     </li>
                  </div> -->
                  <li><a href="index#info_page">INFORMACIÓN</a></li>
                  <li><a href="index#contact_page">CONTACTO</a></li>
                  <!-- <li><a href="#questions_page">FAQ</a></li>
                  <li><a href="blog.html">Blog</a></li>
                  <li><a href="#contact_page">Contacts</a></li> -->
               </ul>
         </div>
      </div>
   </nav>
   <!-- MainMenu-Area-End -->

   <header class="site-header">
      <div class="container">
         <div class="row">
               <div class="col-xs-12 text-center">
                  <h1 class="white-color">Catálogo</h1>
               </div>
         </div>
      </div>
   </header>
   <div class="section-padding">
      <div class="container">
         <div class="row">
               <!-- <div class="col-xs-12">
                  <article class="post-single sticky">
                     <figure class="post-media">
                           <img src="images/sticky-image.jpg" alt="">
                     </figure>
                     <div class="post-body">
                           <div class="post-meta">
                              <div class="post-tags"><a href="#">People</a></div>
                              <div class="post-date">01.02.2017</div>
                           </div>
                           <h4 class="dark-color"><a href="single.html">5 tips for those, who need to make more room in their closet</a></h4>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiing elit, sed do eiusmod tempor incididunt ut labore et laborused sed do eiusmod tempor incididunt ut labore et laborused.</p>
                           <a href="single.html" class="read-more">View Article</a>
                     </div>
                  </article>
                  <div class="space-100"></div>
               </div> -->
         </div>
         
         <div class="row">

            <?php 
            require('_products_area.php');
            
            // Paneles
               for ($p=1; $p<=8; $p++) { 
                  printProduct($p, $imgProducts[$p], $nameProducts[$p], $catProducts[1], $descProducts[$p]);
               }
            // Inversores
               for ($i=9; $i<=9; $i++) { 
                  printProduct($i, $imgProducts[$i], $nameProducts[$i], $catProducts[2], $descProducts[$i]);
               }
            // Controladores
               for ($c=10; $c<=10; $c++) { 
                  printProduct($c, $imgProducts[$c], $nameProducts[$c], $catProducts[3], $descProducts[$c]);
               }
            // Lamparas
               for ($slp=11; $slp<=12; $slp++) { 
                  printProduct($slp, $imgProducts[$slp], $nameProducts[$slp], $catProducts[4], $descProducts[$slp]);
               }
            // Baterias
               for ($bt=13; $bt<=15; $bt++) { 
               printProduct($bt, $imgProducts[$bt], $nameProducts[$bt], $catProducts[5], $descProducts[$bt]);
               }
            // Luces
               for ($l=16; $l<=18; $l++) { 
                  printProduct($l, $imgProducts[$l], $nameProducts[$l], $catProducts[6], $descProducts[$l]);
               }
            ?>


         <!-- <div class="row">
               <div class="col-xs-12">
                  <div class="pagination">
                     <div class="nav-links">
                           <a href="#" class="prev page-numbers"><i class="lnr lnr-chevron-left"></i></a>
                           <a href="#" class="page-numbers">1</a>
                           <span class="page-numbers current">2</span>
                           <a href="#" class="page-numbers">3</a>
                           <a href="#" class="page-numbers">4</a>
                           <a href="#" class="page-numbers">5</a>
                           <a href="#" class="page-numbers">6</a>
                           <a href="#" class="next page-numbers"><i class="lnr lnr-chevron-right"></i></a>
                     </div>
                  </div>
               </div>
         </div> -->
      </div>
   </div>

   <!-- Subscribe-Form -->
   <div class="subscribe-area section-padding">
      <div class="container">
         <div class="row">
               <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                  <div class="subscribe-form text-center">
                     <h3 class="blue-color">Subscribe for More Features</h3>
                     <div class="space-20"></div>
                     <form id="mc-form">
                        <input type="email" class="control" placeholder="Enter your email" required="required" id="mc-email">
                        <button class="bttn-white active" type="submit"><span class="lnr lnr-location"></span> Subscribe</button>
                        <label class="mt10" for="mc-email"></label>
                     </form>
                  </div>
               </div>
         </div>
      </div>
   </div>
   <!-- Subscribe-Form-Area -->
   <!-- Footer-Area -->
   <?php require('_footer.php') ?>               
   <!-- Footer-Bootom-End -->
   </footer>
   <!-- Footer-Area-End -->
   <!--Vendor-JS-->
   <script src="js/vendor/jquery-1.12.4.min.js"></script>
   <script src="js/vendor/jquery-ui.js"></script>
   <script src="js/vendor/bootstrap.min.js"></script>
   <!--Plugin-JS-->
   <script src="js/owl.carousel.min.js"></script>
   <script src="js/contact-form.js"></script>
   <script src="js/ajaxchimp.js"></script>
   <script src="js/scrollUp.min.js"></script>
   <script src="js/magnific-popup.min.js"></script>
   <script src="js/wow.min.js"></script>
   <!--Main-active-JS-->
   <script src="js/main.js"></script>
</body>

</html>
