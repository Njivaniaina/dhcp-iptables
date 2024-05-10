<?php
     
     $chainAll =$rules["chain"];
     $chainL1 =$rules["chainL1"];
     $chainL2 =$rules["chainL2"];
     $chainL3 =$rules["chainL3"];
     $chainM1 =$rules["chainM1"];
     $chainM2 =$rules["chainM2"];
  

    $All = "chain";
    $L1 = "chainL1";
    $L2 = "chainL2";
    $L3 = "chainL3";
    $M1 = "chainM1";
    $M2 = "chainM2";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NETFILTER</title>
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/netfilter_police.css" />
  </head>
  <body>
    <header>
        <div class="logo" id="btn-menu">
          <i class="bx menu-icon"><img src="/assets/menu.svg" alt="menu"></i>
        </div>
        <div class="title">
            <h1>NETFILTER</h1>
        </div>
        
    </header>
    <div style="display:none;">
            <div id="All">
                <p><?php echo $chainAll[0][1] ?></p>
                <p><?php echo $chainAll[1][1]?></p>
                <p><?php echo $chainAll[2][1]?></p>
            </div>
            <div id="L1">
                <p><?php echo $chainL1[0][1] ?></p>
                <p><?php echo $chainL1[1][1] ?></p>
                <p><?php echo $chainL1[2][1] ?></p>
            </div>
            <div id="L2">
                <p><?php echo $chainL2[0][1] ?></p>
                <p><?php echo $chainL2[1][1] ?></p>
                <p><?php echo $chainL2[2][1] ?></p>
            </div>
            <div id="L3">
                <p><?php echo $chainL3[0][1] ?></p>
                <p><?php echo $chainL3[1][1] ?></p>
                <p><?php echo $chainL3[2][1] ?></p>
            </div>
            <div id="M1">
                <p><?php echo $chainM1[0][1] ?></p>
                <p><?php echo $chainM1[1][1] ?></p>
                <p><?php echo $chainM1[2][1] ?></p>
            </div>
            <div id="M2">
                <p><?php echo $chainM2[0][1] ?></p>
                <p><?php echo $chainM2[1][1] ?></p>
                <p><?php echo $chainM2[2][1] ?></p>
            </div>
          </div>

    <nav>
      <div class="sidebar">
        <div></div>
        <div class="sidebar-content">
          <ul class="lists">
            <li class="list">
              <a href="/netfilter" class="nav-link">
                <span class="link">Home</span>
              </a>
            </li>
            <li class="list">
              <a href="/netfilter/list" class="nav-link">
                <span class="link">List</span>
              </a>
            </li>
            <li class="list">
              <a href="/netfilter/add" class="nav-link">
                <span class="link">Add</span>
              </a>
            </li>
            <li class="list">
              <a href="#" class="nav-link">
                <span class="link">Policy</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <section class="overlay"></section>

    <main>
      <div class="content">
        <div class="content-item">
          <div class="policy">
            <div class="row">
              <div class="policy-col">
                <button class="list-nav-item page-all page-actif">ALL</button>
                <button class="list-nav-item page-l1" >L1</button>
                <button class="list-nav-item page-l2" >L2</button>
                <button class="list-nav-item page-l3" >L3</button>
                <button class="list-nav-item page-m1" >M1</button>
                <button class="list-nav-item page-m2" >M2</button>

              </div>
            </div>

            <div class="row">
              <div class="col-md-8 offset-md-2 card">
                <div class="card-header">
                  <h2 class="policy-title">The Policy All</h2>
                </div>
                <div class="card-body">
                  <form action="./police" method="post">
                    <input type="hidden" name="level" id="level" value="all"/>
                    <div class="row align-self-end p-2 bd-highlight">
                      <label for="input">INPUT </label>
                      <select class="form-select form-select-lg" name="input" id="input">
                          <option value="ACCEPT" <?php if($chainAll[0][1]==="ACCEPT") echo "selected";?>>ACCEPT</option>
                          <option value="DROP" <?php if($chainAll[0][1]==="DROP") echo "selected";?>>DROP</option>
                          <option value="REJECT" <?php if($chainAll[0][1]==="REJECT") echo "selected";?>>REJECT</option>
                      </select><br><br>
                    </div>
                    <div class="row align-self-end p-2 bd-highlight">
                      <label for="forward">FORWARD </label>
                      <select class="form-select form-select-lg" name="forward" id="forward">
                          <option value="ACCEPT" <?php if($chainAll[1][1]==="ACCEPT") echo "selected";?>>ACCEPT</option>
                          <option value="DROP" <?php if($chainAll[1][1]==="DROP") echo "selected";?>>DROP</option>
                          <option value="REJECT" <?php if($chainAll[1][1]==="REJECT") echo "selected";?>>REJECT</option>
                      </select><br><br>
                    </div>
                    <div class="row align-self-end p-2 bd-highlight">
                      <label for="output">OUTPUT </label>
                      <select class="form-select form-select-lg" name="output" id="output" value=<?php echo trim($chainAll[2][1]);?>>
                          <option value="ACCEPT" <?php if($chainAll[2][1]==="ACCEPT") echo "selected";?>>ACCEPT</option>
                          <option value="DROP" <?php if($chainAll[2][1]==="DROP") echo "selected";?>>DROP</option>
                          <option value="REJECT" <?php if($chainAll[2][1]==="REJECT") echo "selected";?>>REJECT</option>
                      </select><br><br>
                    </div>
                    <div class="row align-self-end p-5 bd-highlight">
                      <input class="float-end btn btn-success" type="submit" value="Modifier"/>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <?php
      function processusIndex($valeurIndex) {
        // Stocker la valeur de l'index dans une variable
        $chain = $valeurIndex;

        echo "o";
        print_r($chain);
        echo "i";
      }
    ?>
    <script src="../js/script.js"></script>
    <script src="../js/netfilter.js"></script>
    <script>
        function sendData(index) {
          eval('processusIndex(' + index + ')');
        }
    </script>
  </body>
</html>
