<?php
    $chain = $rules["chain"];
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
    <link rel="stylesheet" href="../css/netfilter_police.css" />
  </head>
  <body>
    <header>
        <div class="logo" id="btn-menu">
            <i class="bx bx-menu menu-icon"></i>
        </div>
        <div class="title">
            <h1>NETFILTER</h1>
        </div>
    </header>
    
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
                  <a href="/netfilter/police" class="nav-link">
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
            <h1>The Policy</h1>
                <div class="policy">
                <!--<h2>The Policy</h2>-->
                    <form action="./police" method="post">
                        <label for="input">INPUT </label><br>
                        <select name="input" id="input">
                            <option value="ACCEPT" <?php if($chain[0][1]==="ACCEPT") echo "selected";?>>ACCEPT</option>
                            <option value="DROP" <?php if($chain[0][1]==="DROP") echo "selected";?>>DROP</option>
                            <option value="REJECT" <?php if($chain[0][1]==="REJECT") echo "selected";?>>REJECT</option>
                        </select><br>

                        <label for="forward">FORWARD </label><br>
                        <select name="forward" id="forward">
                            <option value="ACCEPT" <?php if($chain[1][1]==="ACCEPT") echo "selected";?>>ACCEPT</option>
                            <option value="DROP" <?php if($chain[1][1]==="DROP") echo "selected";?>>DROP</option>
                            <option value="REJECT" <?php if($chain[1][1]==="REJECT") echo "selected";?>>REJECT</option>
                        </select><br>
                        
                        <label for="output">OUTPUT </label><br>
                        <select name="output" id="output" value=<?php echo trim($chain[2][1]);?>>
                            <option value="ACCEPT" <?php if($chain[2][1]==="ACCEPT") echo "selected";?>>ACCEPT</option>
                            <option value="DROP" <?php if($chain[2][1]==="DROP") echo "selected";?>>DROP</option>
                            <option value="REJECT" <?php if($chain[2][1]==="REJECT") echo "selected";?>>REJECT</option>
                        </select><br>
                        <input type="submit" class="button_change" value="Modifier"/>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/script.js"></script>
  </body>
</html>
