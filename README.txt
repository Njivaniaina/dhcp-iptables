Cette une projet en codeigniter qui peut gérer les services: 
  -> DHCP
  -> Netfilter

Les contributeurs
// Dans le fichier Participant.odt

INSTALL
  Pour faire l'usage de cette application web, on doit d'abord configurer certaine de notre configuration dans le système.
  C'est-à-dire qu'on doit donner une permission à accéder dans le configuration de Netfilter et du DHCP.
    - Ouvrir le fichier /etc/sudoers avec un permission root 
    - Écrirevez www-data "ALL=(ALL) NOPASSWD: ALL" : permettre de donner à l'utilisateur www-data d'executer n'importe quelle command pour changer les configuration
    - Héberger le site dans une server (Apache, Xamp, .....)
    - Ouvrir votre navigateur et puis tester le site.
