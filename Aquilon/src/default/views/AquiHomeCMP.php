<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TEST</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid introduce-block">
        <div class="row" >
            <div class="col-md-2 col-lg-2 col-xl-2 col-sm-12">
                <div class="row">
                    <div class="col-12">
                        <img style="width: 150px; height: 150px; margin-left: calc(50% - 75px)" src="Aquilon/asset/AquLOGO640.svg" alt="">
                    </div>
                    <div class="col-12" style="text-align: center; color: #00d3bb">
                        <h3 style="letter-spacing: 2px">Aquilon<span style="font-size: 15px; "> v0.0.1</span></h3>
                    </div>
                    <div class="col-12" style="text-align: center">
                        <a class="info" href="d">Git</a>
                        <a class="info" href="s">Documentation</a>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-lg-10 col-xl-10 col-sm-12 desc" style="margin-top: 70px; ">
                <p class="info desc" style="font-size: 20px">Make of site building easier</p>
                <p class="info desc" style="font-size: 55px; margin-top: -30px">TOGETHER</p>
            </div>
        </div>
    </div>
</body>

</html>


<style>
    body {
        background-color: #2e2e2e;
    }

    .info {
        color: white;
        text-decoration: none;
    }

    .info:hover {
        transition: 0.5s;
        text-decoration: whitesmoke;
    }

    .introduce-block {
        width: 90vw;
        height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding-top: 40vh;
        margin-left: 10vw;
    }

    @media screen and (max-width: 770px) {
        .desc {
            text-align: center
        }
        .introduce-block {
            padding-top: 20vh;
            margin-left: 0;
        }
    }
</style>