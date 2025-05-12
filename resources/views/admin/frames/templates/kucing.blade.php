<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .photostrip {
            width: 190px;
            height: 500px;
            background-color: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
            align-items: center;
        }

        .photo-slot {
            width: 100%;
            height: 130px;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .photo-slot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .footer {
            padding-top: 10px;
        }

        .footer img {
            width: 90px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <div class="photostrip" id="strip">
        <div class="photo-slot"><img id="photo1" /></div>
        <div class="photo-slot"><img id="photo2" /></div>
        <div class="photo-slot"><img id="photo3" /></div>
        <div class="footer"><img src="logo4.png" alt="Logo" id="logo" /></div>
    </div>
</body>

</html>
