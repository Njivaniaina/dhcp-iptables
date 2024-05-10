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
             <div class="form-group m-2">
                <label for="networkAddress" class="m-2">Adresse IP du réseau</label>
                <input type="text" class="form-control" name="subnet" id="subnet" placeholder="" value='<?=$subnet["subnet"] ?>' required> 
            </div>
            <p id='error-ip' style='color:#ff0000;'>Veuillez entrer une adresse ip privée</p>
            <div class="form-group m-2">
                <label for="networkAddress" class="m-2">Masque de sous-réseau</label>
                <input type="text" class="form-control" name="netmask" id="netmask" placeholder="" value='<?=$subnet["netmask"] ?>' readonly>
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


    <script>
      const subnet = document.querySelector('#subnet');
      const netmask = document.querySelector('#netmask');
      const startRange = document.querySelector('#startRange');
      const endRange = document.querySelector('#endRange');
      const errorIp = document.querySelector('#error-ip');  
      const form = document.querySelector('#ipForm');

      errorIp.style.display = "none"; 
      
      subnet.addEventListener('input', () => {
            const re = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){0,3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)?$/;
            
            if (re.test(subnet.value)) {
                const octets = subnet.value.split('.').map(Number);
                if (octets.length === 4 && octets[3] !== 0) {
                  subnet.value = subnet.value.substring(0, subnet.value.length - 1);
                }
                
            } else {
              subnet.value = subnet.value.substring(0, subnet.value.length - 1);
            }
            
            if(subnet.value.split('.')[3][1]) subnet.value = subnet.value.substring(0, subnet.value.length - 1);
            
            const octets = subnet.value.split('.').map(Number);
            
            if(getNetmask(octets[0]) === "") errorIp.style.display = "block";
            else errorIp.style.display = "none"; 

            netmask.value = getNetmask(octets[0]);

        });
        
        startRange.addEventListener('input' , () => {
          const re = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){0,3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)?$/;
            if (!re.test(startRange.value)) {
              const octets = startRange.value.split('.').map(Number);
              startRange.value = startRange.value.substring(0, startRange.value.length - 1);  
            }
        })

        endRange.addEventListener('input' , () => {
            const re = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){0,3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)?$/;
            if (!re.test(endRange.value)) {
              const octets = endRange.value.split('.').map(Number);
              endRange.value = endRange.value.substring(0, endRange.value.length - 1);  
            }
        })

        form.addEventListener('submit' , () =>{
          if(!subnet.value || !netmask.value || !startRange.value || !endRange.value){
            alert('Veuillez saisir des entrées valides');
          }
          if(!isInNetwork(startRange.value , subnet.value)) alert('Ip de debut invalide');
          if(!isInNetwork(endRange.value , subnet.value)) alert('Ip de fin invalide');
          if(compareIP(startRange.value , endRange.value)==0) alert("L'ip de début et de fin sont les mêmes");
          if(compareIP(startRange.value , endRange.value)==-1) alert("L'ip de début de plage doit être inférieure à la fin de plage");

          })

        function compareIP(ip1, ip2) {
          // Convertir les adresses IP en tableaux d'octets
          const ip1Octets = ip1.split('.').map(Number);
          const ip2Octets = ip2.split('.').map(Number);

          // Comparaison des octets pour déterminer l'ordre
          for (let i = 0; i < 4; i++) {
              if (ip1Octets[i] < ip2Octets[i]) {
                  return 1; // ip1 est inférieure à ip2
              } else if (ip1Octets[i] > ip2Octets[i]) {
                  return -1; // ip1 est supérieure à ip2
              }
          }
          
          return 0; // Les adresses IP sont égales
      }

        function isInNetwork(adresseIP, reseau) {
          const ipOctets = adresseIP.split('.').map(Number);
          const reseauOctets = reseau.split('.').map(Number);
          
          // Vérification des entrées (assurez-vous que les adresses IP, réseau et les masques sont valides)
          if (ipOctets.length !== 4 || reseauOctets.length !== 4) {
              return 'Entrées invalides. Veuillez fournir des adresses IP, réseau et des masques valides.';
          }

          // Calcul de l'adresse réseau
          const adresseReseauOctets = [];
          for (let i = 0; i < 4; i++) {
              adresseReseauOctets.push(ipOctets[i] & reseauOctets[i]);
          }
          
          console.log(adresseReseauOctets);
          console.log(reseauOctets);
          // Comparaison avec l'adresse IP fournie
          for (let i = 0; i < 4; i++) {
              if (adresseReseauOctets[i] !== reseauOctets[i]) {
                  return false; // L'adresse IP n'appartient pas au réseau
              }
          }

        return true; // L'adresse IP appartient au réseau
    }


      function getNetmask(firstOctet) {
          if (firstOctet >= 1 && firstOctet <= 126) {
              return "255.0.0.0"; // Classe A
          } else if (firstOctet >= 128 && firstOctet <= 191) {
              return "255.255.0.0"; // Classe B
          } else if (firstOctet >= 192 && firstOctet <= 223) {
              return "255.255.255.0"; // Classe C
          } else {
              return ""; // Adresse IP invalide ou hors de gamme
          }
      }
    </script>
    <script src="./js/script.js"></script>
  </body>
</html>
