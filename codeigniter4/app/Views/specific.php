
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TODO APP</title>
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./bootstrap.min.css">
    <link rel="stylesheet" href="./css/dhcp.css" />
  </head>
  <body>
    <header>
        <div class="logo" id="btn-menu">
            <i class="bx bx-menu menu-icon"></i>
        </div>
        <div class="title">
            <h1>DHCP</h1>
        </div>
    </header>
    
    <nav>
        <div class="sidebar">
            <div></div>
            <div class="sidebar-content">
              <ul class="lists">
                <li class="list">
                  <a href="../dhcp" class="nav-link">
                    <span class="link">Home</span>
                  </a>
                </li>
                <li class="list">
                  <a href="../globale" class="nav-link">
                    <span class="link">Configuration globale</span>
                  </a>
                </li>

              </ul>
            </div>
        </div>
      
    </nav>
    <section class="overlay"></section>
    

    <div class="container">
        <form action="/specific" method="get">
        <h2 style="text-align: center;" class="m-4">Configuration spécifique</h2>
            <div class="form-group m-2">
                <label for="networkAddress" class="m-2">Nom d'hôte</label>
                <input type="text" class="form-control" name="nom_hote" id="networkAddress" placeholder="">
            </div>
            <div class="form-group m-2">
                <label for="startRange" class="m-2">Adresse mac</label>
                <input type="text" class="form-control" name="mac" id="startRange" placeholder="">
            </div>
            <div class="form-group m-2">
                <label for="startRange" class="m-2">Adresse ip</label>
                <input type="text" class="form-control" name="ip" id="startRange" placeholder="">
            </div>
            <button type='submit' class='btn btn-dark m-4'>Fixer</button>
        </form>
        <h4 style='margin:10px;'>Voici la liste des machines avec les IP fixés</h4>
    <?php if (!empty($host)) : ?>
        <table class="table table-dark table-striped">
        <thead>
            <tr>
            <th scope="col">N°</th>
            <th scope="col">Nom d'hôte</th>
            <th scope="col">Adresse mac</th>
            <th scope="col">Adresse ip</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;?>
            <?php foreach ($host as $m) : ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?=$m['nom_hosts'] ?></td>
                        <td><?=$m['mac'] ?></td>
                        <td><?=$m['ip'] ?></td>
                         <?php
                               echo "<td><a href='/specific?supprimer=$i'>$i</a></td>"
                            ?>
                    </tr>
                <?php $i++;?>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <?php else : ?>
        <h2 style="margin:4vw;">Aucune machine fixer pour l'instant</h2>
    <?php endif; ?>
    <form action='./create' method='get'>
        <button type="submit" class='btn btn-primary'>Fixer l'ip de'une nouvelle machine</button>
    </form>
    </div>
    <script src="./js/script.js"></script>
  </body>
</html>
