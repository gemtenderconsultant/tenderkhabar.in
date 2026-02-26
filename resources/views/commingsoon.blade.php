<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TenderBidAlert | Coming Soon</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        .comingpage {
            background: conic-gradient(from 0.15deg at 46.94% 100%, rgba(71, 161, 217, 0.2) 0deg, rgba(206, 6, 149, 0.1) 135.46deg, rgba(71, 161, 217, 0.2) 360deg), #FFFFFF url(./assets/comingsoon.png) no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .comingpage .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .comingpage .content img {
            height: 50vh;
        }

        .comingpage .content button {
            background-color: #265285;
            color: white;
            padding: 10px 30px;
            border: none;
            outline: none;
            border-radius: 10px;
            font-size: 18px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .inqpopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            padding: 50px;
            background: url(./assets/inqbg.png), conic-gradient(from 0.15deg at 46.94% 100%, rgba(71, 161, 217, 0.2) 0deg, rgba(206, 6, 149, 0.1) 135.46deg, rgba(71, 161, 217, 0.2) 360deg), #FFFFFF;
            display: none;
            flex-direction: column;
            gap: 10px;
            border: 10px;
            background-position: bottom;
            background-repeat: no-repeat;
        }

        .inqpopup.show {
            display: flex;
        }

        .inqpopup .det {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .inqpopup .det img {
            width: 50px;
            font-family: poppins;
        }

        .inqpopup .det a {
            color: #265285;
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-size: 30px;
            text-decoration: none;
        }

        .inqpopup hr {
            background-color: #265285;
            outline: none;
            border: none;
            width: 100%;
            height: 2px;
        }

        .fxdbtn {
            position: fixed;
            top: 300px;
            right: 0;
            padding: 10px 20px;
            background-color: #265285;
            color: white;
            outline: none;
            border: none;
            transform: rotate(90deg) translateY(-30px);
            cursor: pointer;
        }

        .inqpopup .inqcls{
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #265285;
            color: white;
            width: 20px;
            height: 20px;
            display: grid;
            place-content: center;
            cursor: pointer;
            border-radius: 100%;
        }
    </style>

</head>

<body class="comingpage">
    <div class="content">
        <img src="{{ asset('coming-soon.png') }}" alt="">
        <!--<button><i class="fa-solid fa-angle-left"></i> Back</button>-->
    </div>


    <!-- put this code in footer  -->

    <!-- contact button & popup  -->

    <!--<button class="fxdbtn">-->
    <!--    Contact-->
    <!--</button>-->

    <div class="inqpopup">
        <div class="inqcls">x</div>
        <div class="det">
            <img src="./assets/call1.png" alt=""><a href="#">+91 7383934054</a>
        </div>
        <hr>
        <div class="det">
            <img src="./assets/msg1.png" alt=""> <a href="#">info@nationaltenders.in</a>
        </div>
    </div>
    <!-- contact button & popup  -->

    <script>
        const inqbtn = document.querySelector('.fxdbtn')
        const inqpopup = document.querySelector('.inqpopup')
        const clsinq = document.querySelector('.inqcls')

        inqbtn.addEventListener("click", openinq);

        function openinq() {
            inqpopup.classList.add('show');
        }

        clsinq.addEventListener("click", closeinq);

        function closeinq() {
            inqpopup.classList.remove('show');
        }


    </script>

</body>

</html>