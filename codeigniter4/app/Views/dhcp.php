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
                  <a href="/" class="nav-link">
                    <span class="link">
						<div class="img">⌂</div>
					</span>
                  </a>
                </li>
                <li class="list">
                  <a href="#" class="nav-link">
                    <span class="link">Home</span>
                  </a>
                </li>
                <li class="list">
                  <a href="./globale" class="nav-link">
                    <span class="link">Configuration globale</span>
                  </a>
                </li>
                <li class="list">
                  <a href="./specific" class="nav-link">
                    <span class="link">Configuration pour chaque machine</span>
                  </a>
                </li>

              </ul>
            </div>
        </div>
      
    </nav>
    <section class="overlay"></section>
    

    <main>
    <div class='main-left'>
          <img src="./assets/Dchp.svg" alt="">  
      </div> 
    <div class='main-right'>
        <h1>Bienvenue , vous pouvez configurer ici la DHCP globale et la DHCP spécifique pour chaque machine</h1>
      </div>
     
    </main>

    <script src="./js/script.js"></script>
  </body>
</html>
