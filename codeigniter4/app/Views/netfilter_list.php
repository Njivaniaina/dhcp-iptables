<?php 
  $chain = $rules["chain"];

  if(!empty($rules["rules"]))
    $rule = $rules["rules"];

  if($rules_c["rules"])
    $rule_c = $rules_c["rules"];
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
                  <a href="#" class="nav-link">
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
              <a href="/netfilter/list?page=1"><button class="list-nav-item page-all <?php if($page === 1) echo "page-actif" ?>">ALL</button></a>
              <a href="/netfilter/list?page=2"><button class="list-nav-item page-l1 <?php if($page === 2) echo "page-actif" ?>">L1</button></a>
              <a href="/netfilter/list?page=3"><button class="list-nav-item page-l2 <?php if($page === 3) echo "page-actif" ?>">L2</button></a>
              <a href="/netfilter/list?page=4"><button class="list-nav-item page-l3 <?php if($page === 4) echo "page-actif" ?>">L3</button></a>
              <a href="/netfilter/list?page=5"><button class="list-nav-item page-m1 <?php if($page === 5) echo "page-actif" ?>">M1</button></a>
              <a href="/netfilter/list?page=6"><button class="list-nav-item page-m2 <?php if($page === 6) echo "page-actif" ?>">M2</button></a>
            </div>
          </div>

          <div class="row part-list">
            <h1 class="list-title">List of the rules <?= ($page===2)?"L1":(($page===3)?"L2":(($page===4)?"L3":(($page===5)?"M1":(($page===6)?"M2":"")))) ?></h1>
            <div class="element">

            <nav class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-link  active" id="nav-INPUT-tab" data-bs-toggle="tab" href="#INPUT" role="tab" aria-controls="INPUT" aria-selected="true">INPUT</a>
              <a class="nav-link" id="nav-OUTPUT-tab" data-bs-toggle="tab" href="#OUTPUT" role="tab" aria-controls="OUTPUT" aria-selected="false">OUTPUT</a>
              <a class="nav-link" id="nav-FORWARD-tab" data-bs-toggle="tab" href="#FORWARD" role="tab" aria-controls="FORWARD" aria-selected="false">FORWARD</a>
            </nav>
              <div class="tab-content" id="nav-tabContent">
              <?php foreach($chain as $c): ?>                       
                <?php if($c[0] === "INPUT" || $c[0] === "OUTPUT" || $c[0] === "FORWARD"): ?>
                  <!h2><!?php echo $c[0]; ?><!/h2>
                  <div class="tab-pane fade <?php if($c[0] == "INPUT")echo "show active"; ?>" id="<?php echo $c[0]; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $c[0]; ?>-tab">
                    <table class="tab" >
                      <tr class="title_line">
                        <td class="target_tab">Target</td>
                        <td class="protocole_tab">Protocole</td>
                        <td class="opt_tab">Opt</td>
                        <td class="source_tab">Source</td>
                        <td class="destination_tab">Destination</td>
                        <td class="descritpiton_tab">Descripition</td>
                        <td class="supprimer_tab">Delete</td>
                      </tr>
                      <?php if(!empty($rule[$c[0]])): ?>
                        <?php foreach($rule[$c[0]] as $k => $r): ?>
                          <?php if(in_array($r, $rule_c[$c[0]])):?>
                            <tr class=<?php if($k%2==0) echo "pair";else echo "impair"; ?> class="list-table" >
                              <td class="target_tab"><?php echo $r[0];?></td>
                              <td class="protocole_tab"><?php echo $r[1];?></td>
                              <td class="opt_tab"><?php echo $r[2];?></td>
                              <td class="source_tab"><?php echo $r[3];?></td>
                              <td class="destination_tab"><?php echo $r[4];?></td>
                              <td class="descriptiton_tab"><?php if(!empty($r[5])) echo $r[5]; else echo "--"; ?></td>
                              <?php if( $k > 4 ): ?>
                                <td class="supprimer_tab"><a href=<?php echo "./list?delete=$c[0]&line=$k"; ?>><button>Delete</button></a></td>
                              <?php endif;?>
                              <!-- <td><?= var_dump($rule_c[$c[0]]) ?></td> -->
                            </tr>
                          <?php endif;?>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </table>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
    </main>

    <script src="../js/script.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
