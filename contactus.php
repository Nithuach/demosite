<?php
include "captcha.php";
$success = false;
$failed = "";
$error = "";
$fullnameerr = "";
$emailerr = "";
$phonenoerr = "";
$subjectterr = "";
$captchaerror = "";

$fullname = $email = $mobileno = $subjectt = $address = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) { 
    if (
        isset($_POST['fullname']) && 
        isset($_POST['email']) && 
        isset($_POST['mobile']) && 
        isset($_POST['subject']) && 
        isset($_POST['address']) && 
        isset($_POST['captcha'])
    ) {
        if (empty($_POST['fullname'])) {
            $fullnameerr = "Full Name is required";
        } elseif (preg_match('/^[a-zA-Z\s]+$/', $_POST['confullname'])) {
            $fullname = $_POST['fullname'];
        } else {
            $fullnameerr = "Invalid Full Name";
        }
        
        if (empty($_POST['email'])) {
            $emailerr = "Email Address is required";
        } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST['email'];
        } else {
            $emailerr = "Invalid Email Address";
        }
        
        if (empty($_POST['mobile'])) {
            $phonenoerr = "Phone number is required";
        } elseif (preg_match('/^\+?\d+$/', $_POST['mobile'])) {
            $mobileno = $_POST['mobile'];
        } else {
            $phonenoerr = "Invalid Phone number";
        }
        
       
        if (empty($_POST['consubject'])) {
            $subjectterr = "Subject is required";
        } else {
            $subjectt = $_POST['consubject'];
        }

        // $fullname = htmlspecialchars($_POST['confullname']);
        $email = htmlspecialchars($_POST['conemail']);
        $mobileno = $_POST['conphone'];
        $subjectt = htmlspecialchars($_POST['subject']);
        $address = htmlspecialchars($_POST['address']);
        $submittedCaptcha = $_POST['captcha'];
        $generatedCaptcha = $_SESSION['captcha'];

        if ($submittedCaptcha != $generatedCaptcha) {
            $captchaerror = "Invalid captcha";
            $_SESSION['captcha'] = generateCaptcha(); 
        }

        if (!$fullnameerr && !$emailerr && !$phonenoerr && !$subjectterr && !$captchaerror) {
            $success = true;
            $fullname = $email = $mobileno = $subjectt = $address = "";
            $_SESSION['form_submitted'] = true;
            header("Location: " . $_SERVER['REQUEST_URI']); 
            exit();
        }
    } else {
        $error = "Oops! Something went wrong, please try again.";
    }
} else {
    $_SESSION['captcha'] = generateCaptcha();
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let formSubmitted = <?php echo json_encode(isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']); ?>;
        let captchaError = <?php echo json_encode(!empty($captchaerror)); ?>;
        let error = <?php echo json_encode(!empty($error)); ?>;
        let failed = <?php echo json_encode(!empty($failed)); ?>;
        let fullnameErr = <?php echo json_encode(!empty($fullnameerr)); ?>;
        let emailErr = <?php echo json_encode(!empty($emailerr)); ?>;
        let phonenoErr = <?php echo json_encode(!empty($phonenoerr)); ?>;
        let subjectErr = <?php echo json_encode(!empty($subjectterr)); ?>;

        if (formSubmitted || captchaError || error || failed || fullnameErr || emailErr || phonenoErr || subjectErr) {
            document.getElementById("contact-form").scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>

<script>
    setTimeout(function() {
        document.getElementById('successMessage').style.display = 'none';
        document.getElementById('failMessage').style.display = 'none';
        document.getElementById('errormessages').style.display = 'none';
        document.getElementById('captchaError').style.display = 'none';
        document.getElementById('fullnameerr').style.display = 'none';
        document.getElementById('phonenoerr').style.display = 'none';
        document.getElementById('emailerr').style.display = 'none';
        document.getElementById('subjectterr').style.display = 'none';
    }, 6000); // 6 seconds for display error msg
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get in touch with us for all your interior design needs. Our team is ready to help with your home or office renovation projects.">
    <meta name="keywords" content="interior design, contact us, home decoration, office renovation, design consultation, interior design services">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="INTERIOR DEMO SITE | CONTACT US">
    <meta property="og:description" content="Get in touch with us for all your interior design needs. Our team is ready to help with your home or office renovation projects.">
    <meta property="og:image" content="https://www.yoursite.com/images/og-image.jpg"> 
    <meta property="og:url" content="https://www.yoursite.com/contact-us">
    <meta name="twitter:title" content="INTERIOR DEMO SITE | CONTACT US">
    <meta name="twitter:description" content="Get in touch with us for all your interior design needs. Our team is ready to help with your home or office renovation projects.">
    <meta name="twitter:image" content="https://www.yoursite.com/images/og-image.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="shortcut icon" href="/images/fav-icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>INTERIOR DEMO SITE | CONTACT US</title>
</head>
<body>
  <div class="navigation-bloq">
      <nav class="navbar navbar-expand-lg">
          <div class="container">
              <a class="navbar-brand" href="#">
                  <img src="/images/logo.png" alt="logo" class="w-100">
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav m-auto mb-2 mb-lg-0 mobile-nav">
                      <li class="nav-item">
                          <a class="nav-link" aria-current="page" href="index.html">Home</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="aboutus.html">About Us</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="projects.html">Projects</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="blogs.html">Blog</a>
                      </li>
                  </ul> 
                  <div class="login">
                      <a href="contactus.html"><button class="login-btn">Contact Us</button></a>
                  </div>                       
              </div>
          </div>
      </nav>
  </div>

    <div class="page-header contact-header">
        <div class="container">
            <h3>Contactus</h3>
            <i class="bi bi-house"></i><a href="index.html">Home</a><span>|</span><a href="#">Contactus</a>
        </div>
    </div>

    <div class="contact-bloq">
      <div class="container">
          <div class="row">
            <div class="col-lg-6 left-section">
                <div class="conatct-info">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="contact-card">
                                <div class="con-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="con-info">
                                    <h3>Call Us</h3>
                                    <p>+91 9876543321</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-card">
                                <div class="con-icon">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </div>
                                <div class="con-info">
                                    <h3>Email</h3>
                                    <p>abcdftest@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-card">
                                <div class="con-icon">
                                    <i class="bi bi-geo-fill"></i>
                                </div>
                                <div class="con-info">
                                    <h3>Location</h3>
                                    <p>Udupi Karnataka India 576 101</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-form-bloq">
                    <h3>Contact Us</h3>
                    <form method="POST" id="contact-form">
                        <div style="text-align: center;">
                            <?php echo $failed; ?>
                        </div>
                        <div style="text-align: center;">
                            <?php echo $error; ?>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="fullname" placeholder="Enter your full name" value="<?php echo $fullname; ?>">
                                <div id="fullnameerr" class="alert-danger"  <?php if ($fullnameerr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>><?php echo $fullnameerr; ?></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
                                <div id="emailerr" class="alert-danger"  <?php if ($emailerr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>><?php echo $emailerr; ?></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="mobile">Mobile No</label>
                                <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" value="<?php echo $mobileno; ?>">
                                <div id="phonenoerr" class="alert-danger"  <?php if ($phonenoerr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>><?php echo $phonenoerr; ?></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="subject">Subject</label>
                                <input type="text" id="subject" name="subject" placeholder="Enter the subject" value="<?php echo $subjectt; ?>">
                                <div id="subjectterr" class="alert-danger"  <?php if ($subjectterr) echo 'style="display:block"'; else echo 'style="display:none"'; ?>><?php echo $subjectterr; ?></div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="address">Address</label>
                                <textarea name="address" cols="30" rows="10" placeholder="Enter Address"><?php echo $address; ?></textarea>
                            </div>

                            <div class="col-lg-12 mb-3 d-flex justify-content-center align-items-center">
                                <span class="captcha" id="captchaContainer">
                                    <p class="mb-0"><?php echo $_SESSION['captcha']; ?></p>
                                </span>
                                <div class="captcha-ref mx-2" name="refresh" id="refreshCaptcha" style="cursor: pointer;">
                                    <div class="refresh-btn"><img src="/images/refresh.png" alt="Refresh" class="w-100"></div>
                                </div>
                                <input type="text" id="cap-input" name="captcha" placeholder="Enter captcha">
                                <div id="captchaError" class="alert-danger"<?php if ($captchaerror) echo 'style="display:block"'; else echo 'style="display:none"'; ?>><?php echo $captchaerror; ?></div>
                            </div>

                            <div class="col-lg-12 text-center mt-3">
                                <button type="submit" name="submit" class="btn btn-primary">Send Message</button>
                            </div>
                            <div id="successMessage" class="alert-success"<?php if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted']) { echo 'style="display:block"'; unset($_SESSION['form_submitted']); } else { echo 'style="display:none"'; } ?>>
                                <div style="text-align: center;">
                                Message Sent Successfully.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 right-section">
                <div class="google-map">
                    <h3>We Are Located In</h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d38216.35202117919!2d74.72649161139722!3d13.331849528379742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbcbb69938f41cf%3A0xcccc99e431850143!2sUdupi%2C%20Karnataka!5e1!3m2!1sen!2sin!4v1732773259605!5m2!1sen!2sin"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="conatct-social">
                  <h3>Social Media</h3>
                  <div class="row justify-content-center">
                      <div class="col-lg-3">
                          <div class="social-card">
                              <div class="asocial-icon">
                                <a href="" title="INSTAGRAM"><i class="bi bi-instagram"></i></a> 
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <div class="social-card">
                              <div class="asocial-icon">
                                <a href="" title="FACEBOOK"><i class="bi bi-facebook"></i></a>  
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <div class="social-card">
                              <div class="asocial-icon">
                                <a href="" title="TWITTER"><i class="bi bi-twitter-x"></i></a> 
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="social-card">
                            <div class="asocial-icon">
                              <a href="" title="MESSENGER"><i class="bi bi-messenger"></i></a> 
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
    
    <div class="footer-main">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-lg-0">
          <div class="logo-socials-copy">
            <div class="footer-logo">
                <img src="images/logo.png" alt="Company Logo">
            </div>

            <p class="footer-p">I designed and developed a responsive<strong>&nbsp;INTERIOR DEMO SITE&nbsp;</strong>show casing modern layouts, creative decor ideas, and seamless user navigation. This project highlights my skills in creating visually appealing, functional, and device-friendly web experiences.</p>

            <div class="social-icons">
                <a href="#" aria-label="Instagram" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
                <a href="#" aria-label="WhatsApp" rel="noopener noreferrer"><i class="bi bi-whatsapp"></i></a>
                <a href="#" aria-label="Messenger" rel="noopener noreferrer"><i class="bi bi-messenger"></i></a>
            </div>

            <p class="copyright">
              <small>INTERIOR DEMO SITE © 2025 | <span class="designed-by"> Designed by <a href="https://www.linkedin.com/in/nithin-acharya-0102ab284" target="_blank"><i class="bi bi-linkedin"></i></a></span>
              </small>
            </p>
          </div>
        </div>
        
        <div class="col-lg-4 mb-lg-0">
          <div class="quick-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="aboutus.html">About</a></li>
                <li><a href="projects.html">Projects</a></li>
                <li><a href="blogs.html">Blog</a></li>
                <li><a href="contactus.html">Contact Us</a></li>
            </ul>
          </div>
        </div>

        <div class="col-lg-4 mb-lg-0">
          <div class="address">
            <h3>Address</h3>
            <ul>
                <li><i class="bi bi-geo-fill"></i> India</li>
                <li><i class="bi bi-telephone-fill"></i> +91 9876543210</li>
                <li><i class="bi bi-envelope-at-fill"></i> nithin271ach@gmail.com</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>        <div class="container">
          <div class="row">
            <div class="col-lg-4 mb-lg-0">
              <div class="logo-socials-copy">
                <div class="footer-logo">
                    <img src="images/logo.png" alt="Company Logo">
                </div>
    
                <p class="footer-p">I designed and developed a responsive<strong>&nbsp;INTERIOR DEMO SITE&nbsp;</strong>showcasing modern layouts, creative décor ideas, and seamless user navigation. This project highlights my skills in creating visually appealing, functional, and device-friendly web experiences.</p>
    
                <div class="social-icons">
                    <a href="#" aria-label="Instagram" rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="WhatsApp" rel="noopener noreferrer"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" aria-label="Messenger" rel="noopener noreferrer"><i class="bi bi-messenger"></i></a>
                </div>
    
                <p class="copyright">
                    <small>INTERIOR DEMO SITE © 2025 | <span class="designed-by"> Designed by <a href="https://www.linkedin.com/in/your-profile" target="_blank"><i class="bi bi-linkedin"></i></a></span>
                    </small>
                  </p>
              </div>
            </div>
            
            <div class="col-lg-4 mb-lg-0">
              <div class="quick-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="aboutus.html">About</a></li>
                    <li><a href="projects.html">Projects</a></li>
                    <li><a href="blogs.html">Blog</a></li>
                    <li><a href="contactus.html">Contact Us</a></li>
                </ul>
              </div>
            </div>
    
            <div class="col-lg-4 mb-lg-0">
              <div class="address">
                <h3>Address</h3>
                <ul>
                    <li><i class="bi bi-geo-fill"></i> Udupi, Karnataka, India 576 101</li>
                    <li><i class="bi bi-telephone-fill"></i> +91 9876543210</li>
                    <li><i class="bi bi-envelope-at-fill"></i> abcdftest@gmail.com</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>

<script>
  // Select the navigation wrap element
const navigationWrap = document.querySelector('.navbar');
// Select all anchor tags inside .nav-item
const navLinks = document.querySelectorAll('.nav-item a');

// Function to toggle the 'scrolled' class based on scroll position
function toggleScrolledClass() {
    if (window.scrollY > 0) {
        navigationWrap.classList.add('scrolled');
    } else {
        navigationWrap.classList.remove('scrolled');
    }
}

// Function to toggle link color based on scroll position
function toggleLinkColor() {
    const scrolled = window.scrollY > 0; // Check if scrolled
    navLinks.forEach(link => {
        if (scrolled) {
            link.style.color = '#0000'; // Change color to black
        } else {
            link.style.color = ''; // Revert to default or remove inline style
        }
    });
}
// Add scroll event listeners to window
window.addEventListener('scroll', toggleScrolledClass);
window.addEventListener('scroll', toggleLinkColor);


document.getElementById('refreshCaptcha').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'captcha.php?action=generateCaptcha', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('captchaContainer').innerText = xhr.responseText;
        }
    };
    xhr.send();
    });
</script>
