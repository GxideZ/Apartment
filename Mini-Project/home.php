<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="home.css"> -->
    <style>
        body {
            background-color: #1a1a1d;
            color: #f8f9fa;
            font-family: 'Lato', sans-serif;
        }

        h1,
        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #f4d03f;
        }

        p.lead {
            font-size: 1.2rem;
            font-weight: 300;
        }

        .carousel-item {
            height: 65vh;
            color: white;

            overflow: hidden;

        }

        .carousel-item img {
            object-fit: cover;
            filter: brightness(70%);
            object-position: bottom;
        }

        /* .carousel-caption {
    background: rgba(0, 0, 0, 0.5);
    padding: 2rem;
    border-radius: 10px;
} */

        .btn-primary {
            background-color: #f4d03f;
            border-color: #f4d03f;
            color: #1a1a1d;
            font-weight: 700;
        }

        .btn-primary:hover {
            background-color: #d4ac0d;
            border-color: #d4ac0d;
        }

        footer {
            background-color: #1a1a1d;
            color: #f8f9fa;
            padding: 3rem 1rem;
        }

        footer p {
            margin: 0;
        }

        .featurette-heading {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .featurette img {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .featurette-divider {
            margin: 5rem 0;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(100%);
        }

        .back-to-top {
            color: #f4d03f;
            text-decoration: none;
        }

        .back-to-top:hover {
            color: #d4ac0d;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-outline-light {
            border: 2px solid #fff;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #1a1a1d;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 4px solid #1a1a1d;
            border-top: 4px solid #f4d03f;
            border-radius: 50%;
            animation: spin 1s linear infinite, glow 1.5s ease-in-out infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 10px #f4d03f, 0 0 20px #f4d03f, 0 0 30px #f4d03f;
            }

            50% {
                box-shadow: 0 0 20px #f4d03f, 0 0 30px #f4d03f, 0 0 50px #f4d03f;
            }
        }
    </style>
</head>

<body>
    <div id="loading-screen">
        <div class="loader"></div>
    </div>
    <?php include_once("navhome.php"); ?>
    <main>
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="num2_2.jpg" alt="Slide 1" class="d-block w-100">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>ห้องพักหรู ลาดกระบัง</h1>
                            <p>ราคาเพียง THB 5,000+ / เดือน</p>
                            <p><a class="btn btn-lg btn-primary" href="login.php">Sign in today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="num1_1.jpg" alt="Slide 2" class="d-block w-100">
                    <div class="container">
                        <div class="carousel-caption text-center">
                            <h1>ห้องพักราคาประหยัด</h1>
                            <p>ราคาเพียง THB 3,500+ / เดือน</p>
                            <p><a class="btn btn-lg btn-primary" href="login.php">Sign in today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="num3_3.jpg" alt="Slide 3" class="d-block w-100">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>หอพัก VIP เหมาะสำหรับคนป่วยใจ</h1>
                            <p>ราคาเพียง THB 9,500+ / เดือน</p>
                            <p><a class="btn btn-lg btn-primary" href="">Don't touch me</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>

        <div class="container marketing">

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">ห้องพักหรู ลาดกระบังชุมพร</h2><br>
                    <p class="lead">• ลดสูงสุด 35% <br> • ลดเพิ่มอีก 15% สำหรับสมาชิก Centara The1 <br> • ราคาเฉพาะห้องพัก หรือห้องพักรวมอาหารเช้า* <br> • สามารถผ่อนชำระ 0% นาน 3 เดือนได้** <br> • เด็กอายุต่ำกว่า 12 ปีพักฟรี*</p>
                </div>
                <div class="col-md-5">
                    <img src="num2.jpg" class="img-fluid" alt="Featurette 1">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading">ห้องพักราคาประหยัด ราคากันเอง</h2>
                    <p class="lead">• ลดสูงสุด 35% <br> • ลดเพิ่มอีก 15% สำหรับสมาชิก Centara The1 <br> • ราคาเฉพาะห้องพัก หรือห้องพักรวมอาหารเช้า* <br> • สามารถผ่อนชำระ 0% นาน 3 เดือนได้** <br> • เด็กอายุต่ำกว่า 12 ปีพักฟรี*</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="num1.jpg" class="img-fluid" alt="Featurette 2">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading">หอพัก VIP เหมาะสำหรับคนป่วยใจ <br> The Place to Be</h2>
                    <p class="lead">• ลดสูงสุด 35% <br> • ลดเพิ่มอีก 15% สำหรับสมาชิก Centara The1 <br> • ราคาเฉพาะห้องพัก หรือห้องพักรวมอาหารเช้า* <br> • สามารถผ่อนชำระ 0% นาน 3 เดือนได้** <br> • เด็กอายุต่ำกว่า 12 ปีพักฟรี*</p>
                </div>
                <div class="col-md-5">
                    <img src="num3.webp" class="img-fluid" alt="Featurette 3">
                </div>
            </div>

            <hr class="featurette-divider">

            <p class="float-end"><a href="#" class="back-to-top">Back to top</a></p>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myCarousel = document.querySelector('#myCarousel');
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 3000,
                wrap: true
            });

            document.querySelector('.carousel-control-prev').addEventListener('click', function() {
                carousel.prev();
            });

            document.querySelector('.carousel-control-next').addEventListener('click', function() {
                carousel.next();
            });
        });
    </script>

</body>
<script>
    window.addEventListener('load', function() {
        // Hide the loading screen when the page has fully loaded
        var loadingScreen = document.getElementById('loading-screen');
        loadingScreen.style.display = 'none';
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>