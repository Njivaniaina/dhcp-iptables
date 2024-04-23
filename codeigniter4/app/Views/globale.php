<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DHCP</title>
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
                  <a href="../specific" class="nav-link">
                    <span class="link">Configuration pour chaque machine</span>
                  </a>
                </li>

              </ul>
            </div>
        </div>
      
    </nav>
    <section class="overlay"></section>
    
    <div class="container">
        <form id="ipForm" action="/globale">
            <h2 style="text-align: center;" class="m-4">Configuration globale</h2>
            <input type="hidden" class="form-control" name="netmask" id="networkAddress" placeholder="" value='<?=$subnet["netmask"] ?>' required>
            <div class="form-group m-2">
                <label for="networkAddress" class="m-2">Adresse IP du réseau</label>
                <input type="text" class="form-control" name="subnet" id="networkAddress" placeholder="" value='<?=$subnet["subnet"] ?>' required> 
            </div>
            <div class="form-group m-2">
                <label for="startRange" class="m-2">Début de la plage</label>
                <input type="text" class="form-control" name="debut" id="startRange" placeholder="" value='<?=$subnet["range"][0] ?>' required>
            </div>
            <div class="form-group m-2">
                <label for="endRange" class="m-2">Fin de la plage</label>
                <input type="text" class="form-control" name="fin" id="endRange" placeholder="" value='<?=$subnet["range"][1] ?>' required>
            </div>
            <button type="submit" class="btn btn-dark mt-3" style="width: 40%;">Valider</button>
        </form>
    </div>
    <script src="./js/script.js"></script>
  </body>
</html>
