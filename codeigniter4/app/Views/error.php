
<!DOCTYPE html>
<html>
    <head>
        <title>error adding</title>
        <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 bg-secondary">
                    <H2 class="text-center"> Whoops !!! </H2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2 card">
                    <div class="card-header">
                        Error found
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Attention</h5>
                        <p class="card-text">error: <?= $msg ?></p>
                        <a href="addData" class="btn btn-primary">return</a>
                    </div>
                    <div class="card-footer text-muted">
                        press return
                    </div>
                </div>
            </div>
        </div>
    </body>
<!--
    <body>
        <div class=" bg-secondary justify-content-center p-2 bd-highlight" >
            <H2>ATTENTION !!</H2>
        </div>

            <H2> error: <!?= $msg ?></H2>
            <div>
                <a href="addData"><button type="button" class="btn btn-primary">return</button></a>
        
            </div>
        </div>
    </body>
-->

</html>