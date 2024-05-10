<?php 
    $chain = $rules["chain"];
    $rule = $rules["rules"];
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
    <link rel="stylesheet" href="../css/netfilter_list.css" />
  </head>
  <body>
    <header>
        <div class="logo" id="btn-menu">
          <i class="bx menu-icon"><img src="/assets/menu.svg" alt="menu"></i>
        </div>
        <div class="title">
            <h1>NETFILTER</h1>
        </div>
        <!-- <div class="save">
          <a href="/netfilter/list?save=t">
            <button>Save</button>
          </a>
        </div> -->
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

          <div class="row">
            <div class="list-col">
              <a href=""><button class="list-nav-item page-all page-actif">ALL</button></a>
              <a href=""><button class="list-nav-item page-l1">L1</button></a>
              <a href=""><button class="list-nav-item page-l2">L2</button></a>
              <a href=""><button class="list-nav-item page-l3">L3</button></a>
              <a href=""><button class="list-nav-item page-m1">M1</button></a>
              <a href=""><button class="list-nav-item page-m2">M2</button></a>
            </div>
          </div>

          <div class="row part-list">
            <h1 class="list-title">List of the rules</h1>
            <div class="element">
              <?php foreach($chain as $c): ?>
                <?php if($c[0] === "INPUT" || $c[0] === "OUTPUT" || $c[0] === "FORWARD"): ?>
                  <h2><?php echo $c[0]; ?></h2>
                  <table class="tab" >
                    <tr class="title_line">
                      <td class="target_tab">Target</td>
                      <td class="protocole_tab">Protocole</td>
                      <td class="opt_tab">Opt</td>
                      <td class="source_tab">Source</td>
                      <td class="destination_tab">Destination</td>
                      <td class="descritpiton_tab">Descripition</td>
                      <td class="supprimer_tab">Suppression</td>
                    </tr>
                    <?php if(!empty($rule[$c[0]])): ?>
                      <?php foreach($rule[$c[0]] as $k => $r): ?>
                        <tr class=<?php if($k%2==0) echo "pair";else echo "impair"; ?> class="list-table" >
                          <td class="target_tab"><?php echo $r[0];?></td>
                          <td class="protocole_tab"><?php echo $r[1];?></td>
                          <td class="opt_tab"><?php echo $r[2];?></td>
                          <td class="source_tab"><?php echo $r[3];?></td>
                          <td class="destination_tab"><?php echo $r[4];?></td>
                          <td class="descriptiton_tab"><?php if(!empty($r[5])) echo $r[5]; else echo "--"; ?></td>
                          <?php if( $k > 4 ): ?>
                            <td class="supprimer_tab"><a href=<?php echo "./list?delete=$c[0]&line=$k"; ?>><button>Supprimer</button></a></td>
                          <?php endif;?>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </table>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
    </main>

    <script src="../js/script.js"></script>
  </body>
</html>